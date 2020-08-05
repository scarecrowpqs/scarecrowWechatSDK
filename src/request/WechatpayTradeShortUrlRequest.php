<?php
namespace ScarecrowWechatpay\request;
/**
 * WECHAT API: wechat.trade.wap.query request
 *
 */
class WechatpayTradeShortUrlRequest extends WechatpayBaseRequest
{
	private $bizContent = [];

	private $apiParams = [];

	//随机字符串
	private $nonce_str;
	//URL连接
	private $long_url;

	public function getApiMethodName()
	{
		return "tools/shorturl";
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
		$this->apiParams['nonce_str'] = isset($this->bizContent['nonce_str']) ? $this->bizContent['nonce_str'] : (isset($this->apiParams['nonce_str']) ? $this->apiParams['nonce_str'] : $this->createNonceStr());
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
	public function getLongUrl()
	{
		return $this->long_url;
	}

	/**
	 * @param mixed $long_url
	 */
	public function setLongUrl($long_url)
	{
		$this->long_url = $long_url;
		$this->apiParams['long_url'] = $this->long_url;
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
}
