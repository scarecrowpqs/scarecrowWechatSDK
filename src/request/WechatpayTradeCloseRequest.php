<?php
namespace ScarecrowWechatpay\request;
/**
 * WECHAT API: wechat.trade.wap.close request
 *
 */
class WechatpayTradeCloseRequest extends WechatpayBaseRequest
{
	private $bizContent = [];

	private $apiParams = [];

	//随机字符串
	private $nonce_str;
	//商户订单号
	private $out_trade_no;

	public function getApiMethodName()
	{
		return "pay/closeorder";
	}

	/**
	 * @return array
	 */
	public function getApiParams()
	{
		return $this->apiParams;
	}

	/**
	 * @return mixed
	 */
	public function getBizContent()
	{
		$this->apiParams['nonce_str'] = isset($this->bizContent['nonce_str']) ? $this->bizContent['nonce_str'] :  (isset($this->apiParams['nonce_str']) ? $this->apiParams['nonce_str'] : $this->createNonceStr());
		return $this->filterEmptyValue(array_merge($this->apiParams, $this->bizContent));
	}

	/**
	 * @param mixed $bizContent
	 */
	public function setBizContent($bizContent)
	{
		$this->bizContent = array_merge($this->bizContent, $bizContent);
	}

	/**
	 * @return mixed
	 */
	public function getNonceStr()
	{
		return $this->nonce_str;
	}

	/**
	 * @param mixed $nonce_str
	 */
	public function setNonceStr($nonce_str)
	{
		$this->nonce_str = $nonce_str;
		$this->apiParams['nonce_str'] = $this->nonce_str;
	}

	/**
	 * @return mixed
	 */
	public function getOutTradeNo()
	{
		return $this->out_trade_no;
	}

	/**
	 * @param mixed $out_trade_no
	 */
	public function setOutTradeNo($out_trade_no)
	{
		$this->out_trade_no = $out_trade_no;
		$this->apiParams['out_trade_no'] = $this->out_trade_no;
	}

}
