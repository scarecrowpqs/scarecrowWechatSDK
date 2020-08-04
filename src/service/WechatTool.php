<?php
namespace ScarecrowWechatpay\service;

class WechatTool{
	//微信网关地址
	public $gateway_url = "https://api.mch.weixin.qq.com/";
	//商户密匙
	public $private_key;
	//应用id
	public $appId;
	//商户号
	public $mch_id;

	// 表单提交字符集编码
	public $postCharset = "UTF-8";

	public $debugInfo = false;

	private $fileCharset = "UTF-8";

	//签名类型
	public $signType = "MD5";

	//加密密钥和类型
	public $encryptKey;

	public $encryptType = "AES";

	//V 获取签名
	public function generateSign($params, $signType = "MD5") {
		return $this->sign($this->getSignContent($params), $signType);
	}

	//V 获取需要签名的内容
	public function getSignContent($params) {
		ksort($params);

		$stringToBeSigned = "";
		$i = 0;
		foreach ($params as $k => $v) {
			if (false === $this->checkEmpty($v)) {
				// 转换成目标字符集
				$v = $this->characet($v, $this->postCharset);
				if ($i == 0) {
					$stringToBeSigned .= "$k" . "=" . "$v";
				} else {
					$stringToBeSigned .= "&" . "$k" . "=" . "$v";
				}
				$i++;
			}
		}

		unset ($k, $v);
		return $stringToBeSigned;
	}

	//V 签名
	protected function sign($data, $signType = "MD5") {
		$sign = "";
		$data = $data . "&key=" . $this->private_key;
		if (strcasecmp($signType, 'MD5') == 0) {
			$sign = md5($data);
		}
		if (strcasecmp($signType, 'SHA256') == 0) {
			$sign = hash_hmac('sha256', $data, $this->private_key);
		}
		return strtoupper($sign);
	}

	//V  POST方式上传XML
	protected function curl($url, $data, $isSsl = true) {
		$ch = curl_init();
		$timeout = 600;
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
		curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type:text/xml; charset=utf-8"));
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		if ($isSsl) {
//			curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,1);//证书检查
			curl_setopt($ch,CURLOPT_SSLCERTTYPE,'pem');
			curl_setopt($ch,CURLOPT_SSLCERT,dirname(__FILE__).'/../cert/apiclient_cert.pem');
			curl_setopt($ch,CURLOPT_SSLCERTTYPE,'pem');
			curl_setopt($ch,CURLOPT_SSLKEY,dirname(__FILE__).'/../cert/apiclient_key.pem');
			curl_setopt($ch,CURLOPT_SSLCERTTYPE,'pem');
			curl_setopt($ch,CURLOPT_CAINFO,dirname(__FILE__).'/../cert/cacert.pem');
		} else {
//			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		}

		$reponse = curl_exec($ch);
		if (curl_errno($ch)) {
			throw new \Exception(curl_error($ch), 0);
		} else {
			$httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if (200 !== $httpStatusCode) {
				throw new \Exception($reponse, $httpStatusCode);
			}
		}
		curl_close($ch);
		return $reponse;
	}

	//V
	//记录错误日志
	protected function logCommunicationError($apiName, $requestUrl, $errorCode, $responseTxt) {
		$localIp = isset ($_SERVER["SERVER_ADDR"]) ? $_SERVER["SERVER_ADDR"] : "CLI";
		$logger["log_file"] = rtrim(AOP_SDK_WORK_DIR, '\\/') . '/' . "logs/aop_comm_err_" . $this->appId . "_" . date("Y-m-d") . ".log";
		$logger["separator"] = "^_^";
		$logData = array(
			date("Y-m-d H:i:s"),
			$apiName,
			$this->appId,
			$localIp,
			PHP_OS,
			$requestUrl,
			$errorCode,
			str_replace("\n", "", $responseTxt)
		);
		$this->writeFile(array_merge($logger, $logData));
	}

	//执行请求
	public function execute($request) {
		$this->setupCharsets($request);
		//		//  如果两者编码不一致，会出现签名验签或者乱码
		if (strcasecmp($this->fileCharset, $this->postCharset)) {
			// writeLog("本地文件字符集编码与表单提交编码不一致，请务必设置成一样，属性名分别为postCharset!");
			throw new Exception("文件编码：[" . $this->fileCharset . "] 与表单提交编码：[" . $this->postCharset . "]两者不一致!");
		}
		$iv = null;
		//组装系统参数
		$sysParams["appid"] = $this->appId;
		$sysParams["mch_id"] = $this->mch_id;
		$sysParams['sign_type'] = $this->signType;
		//获取业务参数
		$apiParams = $request->getBizContent();
		//整合所有参数
		$sysParams = array_merge($sysParams, $apiParams);
		//签名
		$sysParams["sign"] = $this->generateSign($sysParams, $this->signType);
		//生成请求地址
		$requestUrl = $this->gateway_url . $request->getApiMethodName();
		//是否进行证书验证
		$isSSL = (boolean)@$request->getIsSSLCheck();
		//发起HTTP POST请求
		try {
			$sendData = $this->arrayToXml($sysParams);
			$resp = $this->curl($requestUrl, $sendData, $isSSL);
		} catch (Exception $e) {
			$this->logCommunicationError($request->getApiMethodName(), $requestUrl, "HTTP_ERROR_" . $e->getCode(), $e->getMessage());
			return false;
		}
		$relData = $this->xmlToArr($resp);
		return $relData;
	}

	/**
	 * 将XML转换为ARRAY
	 * @param $xml
	 * @return mixed
	 */
	public function xmlToArr($xml)
	{
		$xmlObj = simplexml_load_string($xml,'SimpleXMLElement', LIBXML_NOCDATA);
		return json_decode(json_encode($xmlObj,JSON_UNESCAPED_UNICODE), true);
	}

	//V
	/**
	 * 将传ARRAY转换成XML
	 * @param $arr
	 * @return string
	 */
	public function arrayToXml($arr) {
		$rel = '<xml>';
		foreach ($arr as $key => $value) {
			$rel .= '<' . $key . '>' . $value . '</' . $key . '>';
		}
		$rel .= '</xml>';
		return $rel;
	}

	//V
	/**
	 * 转换字符集编码
	 * @param $data
	 * @param $targetCharset
	 * @return string
	 */
	function characet($data, $targetCharset) {
		if (!empty($data)) {
			$fileType = $this->fileCharset;
			if (strcasecmp($fileType, $targetCharset) != 0) {
				$data = mb_convert_encoding($data, $targetCharset, $fileType);
			}
		}
		return $data;
	}

	//V
	/**
	 * 校验$value是否非空
	 *  if not set ,return true;
	 *    if is null , return true;
	 **/
	protected function checkEmpty($value) {
		if (!isset($value))
			return true;
		if ($value === null)
			return true;
		if (trim($value) === "")
			return true;
		return false;
	}

	/**
	 * 验签
	 * @param $arr
	 * @return bool
	 */
	public function checkSign($arr)
	{
		$sign = $arr['sign'];
		unset($arr['sign']);
		$data = $this->getSignContent($arr);
		return $this->verify($data, $sign);
	}

	/**
	 * 验签核心函数
	 * @param $data
	 * @param $sign
	 * @param string $signType
	 * @return bool
	 */
	private function verify($data, $sign, $signType = 'MD5') {
		return strcasecmp($this->sign($data, $signType), $sign) == 0 ? true : false;
	}

	/**
	 * 检测编码
	 * @param $request
	 */
	private function setupCharsets($request) {
		if ($this->checkEmpty($this->postCharset)) {
			$this->postCharset = 'UTF-8';
		}
		$str = preg_match('/[\x80-\xff]/', $this->appId) ? $this->appId : print_r($request, true);
		$this->fileCharset = mb_detect_encoding($str, "UTF-8, GBK") == 'UTF-8' ? 'UTF-8' : 'GBK';
	}

	/**
	 * 获取加密内容
	 * @param $content
	 * @return mixed|string
	 */
	public function encryptXMLSource($content) {
		$tempStr = base64_decode($content, true);
		$tempKey = strtolower(md5($this->private_key));
		$contents = openssl_decrypt($tempStr, 'AES-256-ECB', $tempKey,OPENSSL_RAW_DATA);
		if ($contents) {
			$contents = $this->xmlToArr($contents);
		}
		return $contents;
	}

	function echoDebug($content) {
		if ($this->debugInfo) {
			echo "<br/>" . $content;
		}
	}

	//将数组写入文件
	public function writeFile($data=[], $fileName="", $fenge="")
	{
		if (!is_array($data)) {
			$data = [$data];
		}

		$basePath = "./";
		if (empty($fileName)) {
			$fileName = date('Ymd', time()) . '.log';
		}
		if (!file_exists($basePath)) {
			mkdir($basePath, '666',true);
		}
		$filePath = $basePath . '/' . $fileName;
		$f = fopen($filePath,'a+');

		foreach ($data as $item => $value) {
			if (is_array($value)) {
				$value = json_encode($value, JSON_UNESCAPED_UNICODE);
			}
			fwrite($f, $item . "=>" . $value. "\n");
		}

		if (!empty($fenge)) {
			$fengeStr = "\n".$fenge."\n";
			fwrite($f, $fengeStr);
		}

		fclose($f);
	}
}