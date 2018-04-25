<?php
namespace ScarecrowWechatpay\buildermodel;

class WechatpayTradeQueryContentBuilder{

	//随机字符串
	private $nonce_str;
	//商户订单号 (与微信订单号二选一)
	private $out_trade_no;
	//微信订单号 (与商户订单号二选一)
	private $transaction_id;

	private $bizContent = [];

	/**
	 * @return null
	 */
	public function getBizContent()
	{
		$temp = [];
		foreach ($this->bizContent as $k => $v) {
			if (empty($v)) {
				continue;
			}
			$temp[$k] = $v;
		}
		return $temp;
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
		$this->bizContent['nonce_str'] = $this->nonce_str;
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
		$this->bizContent['out_trade_no'] = $this->out_trade_no;
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
		$this->bizContent['transaction_id'] = $this->transaction_id;
	}
}