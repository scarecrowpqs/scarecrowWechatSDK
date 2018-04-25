<?php
namespace ScarecrowWechatpay\request;
/**
 * WECHAT API: wechat.trade.wap.query request
 *
 */
class WechatpayTradeQueryRequest extends WechatpayBaseRequest
{
	private $bizContent = [];

	private $apiParams = [];

	//随机字符串
	private $nonce_str;
	//商户订单号 (与微信订单号二选一)
	private $out_trade_no;
	//微信订单号 (与商户订单号二选一)
	private $transaction_id;

	public function getApiMethodName()
	{
		return "pay/orderquery";
	}

	/**
	 * @return array
	 */
	public function getApiParams() : array
	{
		return $this->apiParams;
	}

	/**
	 * @return mixed
	 */
	public function getBizContent()
	{
		$this->apiParams['nonce_str'] = $this->bizContent['nonce_str'] ?? $this->apiParams['nonce_str'] ?? $this->createNonceStr();
		return $this->filterEmptyValue(array_merge($this->apiParams, $this->bizContent));
	}

	/**
	 * @param mixed $bizContent
	 */
	public function setBizContent(array $bizContent)
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

	/**
	 * @return mixed
	 */
	public function getTransactionId()
	{
		return $this->transaction_id;
	}

	/**
	 * @param mixed $transaction_id
	 */
	public function setTransactionId($transaction_id)
	{
		$this->transaction_id = $transaction_id;
		$this->apiParams['transaction_id'] = $this->transaction_id;
	}


}
