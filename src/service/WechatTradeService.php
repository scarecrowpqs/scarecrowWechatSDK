<?php
namespace ScarecrowWechatpay\service;

use ScarecrowWechatpay\request\WechatpayTradeCloseRequest;
use ScarecrowWechatpay\request\WechatpayTradeNativePayRequest;
use ScarecrowWechatpay\request\WechatpayTradeShortUrlRequest;
use ScarecrowWechatpay\request\WechatpayTradeWapPayRequest;
use ScarecrowWechatpay\request\WechatpayTradeQueryRefundRequest;
use ScarecrowWechatpay\request\WechatpayTradeQueryRequest;
use ScarecrowWechatpay\request\WechatpayTradeRefundRequest;

class WechatTradeService {

	//微信网关地址
	public $gateway_url = "https://api.mch.weixin.qq.com/";

	//商户密匙
	public $private_key;

	//应用id
	public $appid;

	//商户号
	public $mch_id;

	//签名方式
	public $signType = "MD5";

	//是否开启DEBUG
	private $debug;

	//同步回调地址
	private $redirect_url;

	public function __construct($wechat_config){
		$this->gateway_url = isset($wechat_config['gatewayUrl']) ? $wechat_config['gatewayUrl'] : $this->gateway_url;
		$this->signType=isset($wechat_config['sign_type']) ? $wechat_config['sign_type'] : $this->signType;
		$this->appid = $wechat_config['app_id'];
		$this->mch_id = $wechat_config['mch_id'];
		$this->private_key = $wechat_config['private_key'];
		$this->debug = is_bool($wechat_config['is_debug']) ? $wechat_config['is_debug'] : false;
		$this->redirect_url = isset($wechat_config['redirect_url']) ? $wechat_config['redirect_url'] : "";
		if(empty($this->appid)||trim($this->appid)==""){
			throw new \Exception("appid should not be NULL!");
		}
		if(empty($this->mch_id)||trim($this->mch_id)==""){
			throw new \Exception("mch_id should not be NULL!");
		}
		if(empty($this->private_key)||trim($this->private_key)==""){
			throw new \Exception("private_key should not be NULL!");
		}
		if(empty($this->gateway_url)||trim($this->gateway_url)==""){
			throw new \Exception("gateway_url should not be NULL!");
		}
	}

	/**
	 * 数据请求
	 * @param $request
	 * @return mixed
	 */
	public function aopclientRequestExecute($request) {
		$tool = new WechatTool();
		$tool->appId = $this->appid;
		$tool->signType = $this->signType;
		$tool->private_key = $this->private_key;
		$tool->gateway_url = $this->gateway_url;
		$tool->mch_id = $this->mch_id;
		$tool->debugInfo = $this->debug;
		$result = $tool->execute($request);
		return $result;
	}

	/**
	 * H5支付
	 * wechat.trade.pay.unifiedorder
	 * @param $builder 业务参数，使用buildmodel中的对象生成。
	 * @return $response 支付宝返回的信息
 	*/
	public function WapPay($builder) {
		$biz_content=$builder->getBizContent();
		$request = new WechatpayTradeWapPayRequest();
		$request->setBizContent ( $biz_content );
		// 首先调用支付api
		$response = $this->aopclientRequestExecute ($request);
		if (isset($response['mweb_url']) && !empty($this->redirect_url)) {
			$params = $builder->getParams();
			$httpUrl = "";
			foreach ($params as $k => $v) {
				$httpUrl .= $k . '=' . $v . '&';
			}
			$httpUrl = trim($httpUrl, '&');
			if (!empty($httpUrl)) {
				$response['mweb_url'] .= '&redirect_url=' . urlencode($this->redirect_url . '?' . $httpUrl);
			}
		}
		return $response;
	}


	/**
	 * 扫码支付
	 * @param $builder 业务参数，使用buildmodel中的对象生成。
	 */
	public function NativePay($builder)
	{
		$biz_content=$builder->getBizContent();
		$request = new WechatpayTradeNativePayRequest();
		$request->setBizContent ( $biz_content );
		// 首先调用支付api
		$response = $this->aopclientRequestExecute ($request);
		return $response;
	}

	/**
	 * 长URL转换为短URL
	 * @param $builder
	 * @return mixed
	 */
	public function UrlLongToShort($builder)
	{
		$biz_content=$builder->getBizContent();
		$request = new WechatpayTradeShortUrlRequest();
		$request->setBizContent ( $biz_content );
		// 首先调用支付api
		$response = $this->aopclientRequestExecute ($request);
		return $response;
	}


	/**
	 * wechat.trade.query (统一收单线下交易查询)
	 * @param $builder 业务参数，使用buildmodel中的对象生成。
	 * @return $response 支付宝返回的信息
 	*/
	public function Query($builder){
		$biz_content=$builder->getBizContent();
		$request = new WechatpayTradeQueryRequest();
		$request->setBizContent ( $biz_content );
		$response = $this->aopclientRequestExecute ($request);
		return $response;
	}
	
	/**
	 * alipay.trade.refund (统一收单交易退款接口)
	 * @param $builder 业务参数，使用buildmodel中的对象生成。
	 * @return $response 支付宝返回的信息
	 */
	public function Refund($builder){
		$biz_content=$builder->getBizContent();
		$request = new WechatpayTradeRefundRequest();
		$request->setBizContent ( $biz_content );
		$response = $this->aopclientRequestExecute ($request);
		return $response;
	}

	/**
	 * alipay.trade.close (统一收单交易关闭接口)
	 * @param $builder 业务参数，使用buildmodel中的对象生成。
	 * @return $response 支付宝返回的信息
	 */
	public function Close($builder){
		$biz_content=$builder->getBizContent();
		$request = new WechatpayTradeCloseRequest();
		$request->setBizContent( $biz_content );
		$response = $this->aopclientRequestExecute($request);
		return $response;
	}
	
	/**
	 * 退款查询   alipay.trade.fastpay.refund.query (统一收单交易退款查询)
	 * @param $builder 业务参数，使用buildmodel中的对象生成。
	 * @return $response 支付宝返回的信息
	 */
	public function QueryRefund($builder){
		$biz_content=$builder->getBizContent();
		$request = new WechatpayTradeQueryRefundRequest();
		$request->setBizContent ( $biz_content );
		$response = $this->aopclientRequestExecute ($request);
		return $response;
	}

	/**
	 * 验签方法
	 * @param $arr
	 * @return boolean
	 */
	public function check($arr){
		$tool = new WechatTool();
		$tool->private_key = $this->private_key;
		return $tool->checkSign($arr);
	}
	
	//请确保项目文件有可写权限，不然打印不了日志。
	function writeLog($text) {
		file_put_contents ( dirname ( __FILE__ ).DIRECTORY_SEPARATOR."./../../log.txt", date ( "Y-m-d H:i:s" ) . "  " . $text . "\r\n", FILE_APPEND );
	}

	/**
	 * 获取加密内容
	 * @param $content  微信加密的内容
	 */
	public function encryptXMLSource($content)
	{
		$tool = new WechatTool();
		$tool->private_key = $this->private_key;
		return $tool->encryptXMLSource($content);
	}
}

?>