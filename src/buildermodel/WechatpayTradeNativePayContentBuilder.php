<?php
namespace ScarecrowWechatpay\buildermodel;

/**
 * 扫码支付
 * Class WechatpayTradeNativePayContentBuilder
 * @package ScarecrowWechatpay\buildermodel
 */
class WechatpayTradeNativePayContentBuilder{

	// 订单描述，可以对交易或商品进行一个详细地描述，比如填写"购买商品2件共15.00元"
	private $body;
	//商户订单号
	private $out_trade_no;
	//总金额
	private $total_fee;
	//终端IP
	private $spbill_create_ip;
	//交易起始时间
	private $time_start;
	//交易结束时间
	private $time_expire;
	//通知地址
	private $notify_url;
	//交易类型
	private $trade_type = 'NATIVE';
	//随机字符串
	private $nonce_str;
	//场景信息
	private $scene_info;

	private $bizContent = [];

	/**
	 * @return mixed
	 */
	public function getSceneInfo()
	{
		return $this->scene_info;
	}

	/**
	 * @param mixed $scene_info
	 */
	public function setSceneInfo($scene_info)
	{
		$this->scene_info = $scene_info;
		$this->bizContent['scene_info'] = json_encode($this->scene_info, JSON_UNESCAPED_UNICODE);
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
	public function getBody()
	{
		return $this->body;
	}

	/**
	 * @param mixed $body
	 */
	public function setBody($body)
	{
		$this->body = $body;
		$this->bizContent['body'] = $this->body;
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
	public function getSpbillCreateIp()
	{
		return $this->spbill_create_ip;
	}

	/**
	 * @param mixed $spbill_create_ip
	 */
	public function setSpbillCreateIp($spbill_create_ip)
	{
		$this->spbill_create_ip = $spbill_create_ip;
		$this->bizContent['spbill_create_ip'] = $this->spbill_create_ip;
	}

	/**
	 * @return mixed
	 */
	public function getTimeStart()
	{
		return $this->time_start;
	}

	/**
	 * @param mixed $time_start
	 */
	public function setTimeStart($time_start)
	{
		$this->time_start = $time_start;
		$this->bizContent['time_start'] = $this->time_start;
	}

	/**
	 * @return mixed
	 */
	public function getTimeExpire()
	{
		return $this->time_expire;
	}

	/**
	 * @param mixed $time_expire
	 */
	public function setTimeExpire($time_expire)
	{
		$this->time_expire = $time_expire;
		$this->bizContent['time_expire'] = $this->time_expire;
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

	/**
	 * @return string
	 */
	public function getTradeType(): string
	{
		return $this->trade_type;
	}

	/**
	 * @param string $trade_type
	 */
	public function setTradeType(string $trade_type)
	{
		$this->trade_type = $trade_type;
		$this->bizContent['trade_type'] = $this->trade_type;
	}

	/**
	 * @return null
	 */
	public function getBizContent()
	{
		$this->bizContent['trade_type'] = $this->trade_type;
		$temp = [];
		foreach ($this->bizContent as $k => $v) {
			if (empty($v)) {
				continue;
			}
			$temp[$k] = $v;
		}
		return $temp;
	}

}