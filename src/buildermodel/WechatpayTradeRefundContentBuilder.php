<?php
namespace ScarecrowWechatpay\buildermodel;

class WechatpayTradeRefundContentBuilder{

	//随机字符串
	private $nonce_str;
	//商户订单号 (与微信订单号二选一)
	private $out_trade_no;
	//微信订单号 (与商户订单号二选一)
	private $transaction_id;
	//商户退款号
	private $out_refund_no;
	//订单金额
	private $total_fee;
	//退款金额
	private $refund_fee;
	//退款原因
	private $refund_desc;
	//退款结果通知url
	private $notify_url;

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

	/**
	 * @return mixed
	 */
	public function getOutRefundNo()
	{
		return $this->out_refund_no;
	}

	/**
	 * @param mixed $out_refund_no
	 */
	public function setOutRefundNo($out_refund_no)
	{
		$this->out_refund_no = $out_refund_no;
		$this->bizContent['out_refund_no'] = $this->out_refund_no;
	}

	/**
	 * @return mixed
	 */
	public function getTotalFee()
	{
		return $this->total_fee;
	}

	/**
	 * @param mixed $total_fee
	 */
	public function setTotalFee($total_fee)
	{
		$this->total_fee = $total_fee;
		$this->bizContent['total_fee'] = $this->total_fee;
	}

	/**
	 * @return mixed
	 */
	public function getRefundFee()
	{
		return $this->refund_fee;
	}

	/**
	 * @param mixed $refund_fee
	 */
	public function setRefundFee($refund_fee)
	{
		$this->refund_fee = $refund_fee;
		$this->bizContent['refund_fee'] = $this->refund_fee;
	}

	/**
	 * @return mixed
	 */
	public function getRefundDesc()
	{
		return $this->refund_desc;
	}

	/**
	 * @param mixed $refund_desc
	 */
	public function setRefundDesc($refund_desc)
	{
		$this->refund_desc = $refund_desc;
		$this->bizContent['refund_desc'] = $this->refund_desc;
	}

	/**
	 * @return mixed
	 */
	public function getNotifyUrl()
	{
		return $this->notify_url;
	}

	/**
	 * @param mixed $notify_url
	 */
	public function setNotifyUrl($notify_url)
	{
		$this->notify_url = $notify_url;
		$this->bizContent['notify_url'] = $this->notify_url;
	}



}