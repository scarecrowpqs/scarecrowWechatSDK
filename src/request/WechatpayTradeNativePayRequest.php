<?php
namespace ScarecrowWechatpay\request;
/**
 * WECHAT API: wechat.trade.wap.pay request
 *
 */
class WechatpayTradeNativePayRequest extends WechatpayBaseRequest
{
	/**
	 * 手机网站支付接口
	 **/
	private $bizContent = [];

	private $apiParams = [];

	//设备号
	private $device_info;
	//随机字符串
	private $nonce_str;
	//商户订单号
	private $out_trade_no;
	//商品描述
	private $body;
	//附加字段，在回调时微信会原样返回
	private $attach;
	//货币类型
	private $fee_type = 'CNY';
	//总金额
	private $total_fee;
	//终端IP
	private $spbill_create_ip;
	//交易起始时间
	private $time_start;
	//交易结束时间
	private $time_expire;
	//商品标记
	private $goods_tag;
	//通知地址
	private $notify_url;
	//交易类型
	private $trade_type;
	//商品ID
	private $product_id;
	//指定支付方式
	private $limit_pay;
	//用户标识
	private $openid;
	//场景信息
	private $scene_info;

	public function getApiMethodName()
	{
		return "pay/unifiedorder";
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
		$times = time();
        $this->apiParams['nonce_str'] = isset($this->bizContent['nonce_str']) ? $this->bizContent['nonce_str'] : (isset($this->apiParams['nonce_str']) ? $this->apiParams['nonce_str'] : $this->createNonceStr());
        $this->apiParams['spbill_create_ip'] = isset($this->bizContent['spbill_create_ip']) ? $this->bizContent['spbill_create_ip'] : (isset($this->apiParams['spbill_create_ip']) ? $this->apiParams['spbill_create_ip'] : $this->getClientIp());
        $this->apiParams['time_start'] = isset($this->bizContent['time_start']) ? $this->bizContent['time_start'] : (isset($this->apiParams['time_start']) ? $this->apiParams['time_start'] : date("YmdHis", $times));
        $this->apiParams['time_expire'] = isset($this->bizContent['time_expire']) ? $this->bizContent['time_expire'] : (isset($this->apiParams['time_expire']) ? $this->apiParams['time_expire'] : date("YmdHis", $times+(60 * 60 * 2)));
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
	public function getDeviceInfo()
	{
		return $this->device_info;
	}

	/**
	 * @param mixed $device_info
	 */
	public function setDeviceInfo($device_info)
	{
		$this->device_info = $device_info;
		$this->apiParams['device_info'] = $this->device_info;
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
		$this->apiParams['body'] = $this->body;
	}

	/**
	 * @return mixed
	 */
	public function getAttach()
	{
		return $this->attach;
	}

	/**
	 * @param mixed $attach
	 */
	public function setAttach($attach)
	{
		$this->attach = $attach;
		$this->apiParams['attach'] = $this->attach;
	}

	/**
	 * @return string
	 */
	public function getFeeType()
	{
		return $this->fee_type;
	}

	/**
	 * @param string $fee_type
	 */
	public function setFeeType(string $fee_type)
	{
		$this->fee_type = $fee_type;
		$this->apiParams['fee_type'] = $this->fee_type;
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
		$this->apiParams['total_fee'] = $this->total_fee;
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
		$this->apiParams['spbill_create_ip'] = $this->spbill_create_ip;
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
		$this->apiParams['time_start'] = $this->time_start;
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
		$this->apiParams['time_expire'] = $this->time_expire;
	}

	/**
	 * @return mixed
	 */
	public function getGoodsTag()
	{
		return $this->goods_tag;
	}

	/**
	 * @param mixed $goods_tag
	 */
	public function setGoodsTag($goods_tag)
	{
		$this->goods_tag = $goods_tag;
		$this->apiParams['goods_tag'] = $this->goods_tag;
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
		$this->apiParams['notify_url'] = $this->notify_url;
	}

	/**
	 * @return mixed
	 */
	public function getTradeType()
	{
		return $this->trade_type;
	}

	/**
	 * @param mixed $trade_type
	 */
	public function setTradeType($trade_type)
	{
		$this->trade_type = $trade_type;
		$this->apiParams['trade_type'] = $this->trade_type;
	}

	/**
	 * @return mixed
	 */
	public function getProductId()
	{
		return $this->product_id;
	}

	/**
	 * @param mixed $product_id
	 */
	public function setProductId($product_id)
	{
		$this->product_id = $product_id;
		$this->apiParams['product_id'] = $this->product_id;
	}

	/**
	 * @return mixed
	 */
	public function getLimitPay()
	{
		return $this->limit_pay;
	}

	/**
	 * @param mixed $limit_pay
	 */
	public function setLimitPay($limit_pay)
	{
		$this->limit_pay = $limit_pay;
		$this->apiParams['limit_pay'] = $this->limit_pay;
	}

	/**
	 * @return mixed
	 */
	public function getOpenid()
	{
		return $this->openid;
	}

	/**
	 * @param mixed $openid
	 */
	public function setOpenid($openid)
	{
		$this->openid = $openid;
		$this->apiParams['openid'] = $this->openid;
	}

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
		if (is_array($this->scene_info)) {
			$this->apiParams['scene_info'] = json_encode($this->scene_info, JSON_UNESCAPED_UNICODE);
		} else {
			$this->apiParams['scene_info'] = $this->scene_info;
		}
	}

}
