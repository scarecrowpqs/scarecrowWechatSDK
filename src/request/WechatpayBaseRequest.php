<?php
namespace ScarecrowWechatpay\request;

class WechatpayBaseRequest{

	//开启证书验证 (不需要验证的接口不需要设置，默认为不开启)
	public $isSSLCheck = false;

	/**
	 * @return bool
	 */
	public function getIsSSLCheck()
	{
		return $this->isSSLCheck;
	}

	/**
	 * @param bool $isSSLCheck
	 */
	public function setIsSSLCheck($isSSLCheck)
	{
		$this->isSSLCheck = $isSSLCheck;
	}




	/**
	 * 获取客户端的IP
	 * @return array|false|string
	 */
	public function getClientIp()
	{
		$cip = "";
		if ($_SERVER['REMOTE_ADDR']) {
			$cip = $_SERVER['REMOTE_ADDR'];
		} else if (getenv('REMOTE_ADDR')) {
			$cip = getenv('REMOTE_ADDR');
		}
		return $cip;
	}

	/**
	 * 产生一个随机字符串
	 * @return string
	 */
	public function createNonceStr()
	{
		return md5(mt_rand(0,1000000) . "QLYWLKJ" . time());
	}

	/**
	 * 过滤数组中的空字符串
	 * @param array $arr
	 * @return array
	 */
	public function filterEmptyValue($arr = [])
	{
		$temp = [];
		foreach ($arr as $k => $v) {
			if (empty($v)) {
				continue;
			}
			$temp[$k] = $v;
		}
		return $temp;
	}

}