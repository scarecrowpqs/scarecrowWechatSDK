<?php
namespace ScarecrowWechatpay;

use ScarecrowWechatpay\buildermodel\WechatpayTradeCloseContentBuilder;
use ScarecrowWechatpay\buildermodel\WechatpayTradeNativePayContentBuilder;
use ScarecrowWechatpay\buildermodel\WechatpayTradeQueryContentBuilder;
use ScarecrowWechatpay\buildermodel\WechatpayTradeQueryRefundContentBuilder;
use ScarecrowWechatpay\buildermodel\WechatpayTradeRefundContentBuilder;
use ScarecrowWechatpay\buildermodel\WechatpayTradeShortUrlContentBuilder;
use ScarecrowWechatpay\buildermodel\WechatpayTradeWapPayContentBuilder;
use ScarecrowWechatpay\service\WechatTradeService;

class WechatSdk{
	private $config;

	public function __construct($config=[])
	{
		if (empty($config)) {
			$this->config = require_once "config.php";
		}else{
			$this->config=$config;
		}
	}

	/**
	 * 手机网站支付接口
	 * @param $subject 订单名称，必填
	 * @param $out_trade_no 商户订单号，商户网站订单系统中唯一订单号，必填
	 * @param $total_amount 付款金额，必填
	 * @param $nonce_str (随机字符串)
	 * @param $returnUrlParams (回调页面的URL参数 array)
	 * @return mixed
	 */
	public function WapPay($subject, $out_trade_no, $total_amount, $nonce_str="", $returnUrlParams = [])
	{
		$payRequestBuilder = new WechatpayTradeWapPayContentBuilder();
		$payRequestBuilder->setBody($subject);
		$payRequestBuilder->setOutTradeNo($out_trade_no);
		$payRequestBuilder->setTotalFee($total_amount);
		$payRequestBuilder->setSceneInfo($this->config['wap_url'], $this->config['wap_name']);
		$payRequestBuilder->setNotifyUrl($this->config['notify_url']);
		$payRequestBuilder->setNonceStr($nonce_str);
		$payRequestBuilder->setParams($returnUrlParams);
		$payResponse = new WechatTradeService($this->config);
		$result=$payResponse->WapPay($payRequestBuilder);
		return $result;
	}

	/**
	 * 扫码支付接口
	 * @param $subject 订单名称，必填
	 * @param $out_trade_no 商户订单号，商户网站订单系统中唯一订单号，必填
	 * @param $total_amount 付款金额，必填
	 * @param $nonce_str (随机字符串)
	 * @param $returnUrlParams (回调页面的URL参数 array)
	 * @return mixed
	 */
	public function NativePay($subject, $out_trade_no, $total_amount, $nonce_str="")
	{
		$payRequestBuilder = new WechatpayTradeNativePayContentBuilder();
		$payRequestBuilder->setBody($subject);
		$payRequestBuilder->setOutTradeNo($out_trade_no);
		$payRequestBuilder->setTotalFee($total_amount);
		$payRequestBuilder->setNotifyUrl($this->config['notify_url']);
		$payRequestBuilder->setNonceStr($nonce_str);
		$payResponse = new WechatTradeService($this->config);
		$result=$payResponse->NativePay($payRequestBuilder);
		return $result;
	}

	/**
	 * 长URL转换为短URL
	 * @param string $url
	 * @param string $nonce_str
	 * @return mixed
	 */
	public function UrlLongToShort($url = "", $nonce_str = "")
	{
		$toolRequestBuilder = new WechatpayTradeShortUrlContentBuilder();
		$toolRequestBuilder->setNonceStr($nonce_str);
		$toolRequestBuilder->setLongUrl($url);
		$response = new WechatTradeService($this->config);
		$result=$response->UrlLongToShort($toolRequestBuilder);
		return $result;
	}

	/**
	 * 查询订单
	 * @param $out_trade_no (商户订单号(与微信订单号二选一))
	 * @param $transaction_id (微信订单号(与商户订单号二选一))
	 * @param string $nonce_str (随机字符串)
	 * @return mixed
	 */
	public function Query($out_trade_no = "", $transaction_id = "", $nonce_str = "")
	{
		$queryRequestBuilder = new WechatpayTradeQueryContentBuilder();
		$queryRequestBuilder->setNonceStr($nonce_str);
		$queryRequestBuilder->setOutTradeNo($out_trade_no);
		$queryRequestBuilder->setTransactionId($transaction_id);
		$response = new WechatTradeService($this->config);
		$result=$response->Query($queryRequestBuilder);
		return $result;
	}


	/**
	 * 退款订单查询
	 * @param $out_trade_no (商户订单号(四个单号四选一))
	 * @param $transaction_id (微信订单号(四个单号四选一))
	 * @param string $out_refund_no (商户退款单号(四个单号四选一))
	 * @param string $refund_id (微信退款单号(四个单号四选一))
	 * @param string $offset (偏移量)
	 * @param string $nonce_str (随机字符串)
	 * @return mixed
	 */
	public function QueryRefund($out_trade_no = "", $transaction_id = "", $out_refund_no = "", $refund_id = "", $offset = "", $nonce_str = "")
	{
		$queryRefundRequestBuilder = new WechatpayTradeQueryRefundContentBuilder();
		$queryRefundRequestBuilder->setNonceStr($nonce_str);
		$queryRefundRequestBuilder->setOutTradeNo($out_trade_no);
		$queryRefundRequestBuilder->setTransactionId($transaction_id);
		$queryRefundRequestBuilder->setOutRefundNo($out_refund_no);
		$queryRefundRequestBuilder->setRefundId($refund_id);
		$queryRefundRequestBuilder->setOffset($offset);
		$response = new WechatTradeService($this->config);
		$result=$response->QueryRefund($queryRefundRequestBuilder);
		return $result;
	}


	/**
	 * 申请退款
	 * @param string $out_trade_no 商户订单号
	 * @param string $transaction_id 微信订单号
	 * @param $out_refund_no 商户退款单号
	 * @param $total_fee 订单金额
	 * @param $refund_fee 退款金额
	 * @param string $refund_desc 退款原因
	 * @param $notify_url 退款成功回调地址
	 * @param string $nonce_str 随机数
	 * @return mixed
	 */
	public function Refund($out_trade_no ="", $transaction_id = "", $out_refund_no, $total_fee, $refund_fee, $refund_desc = "", $notify_url, $nonce_str = "")
	{
		$refundRequestBuilder = new WechatpayTradeRefundContentBuilder();
		$refundRequestBuilder->setNonceStr($nonce_str);
		$refundRequestBuilder->setOutTradeNo($out_trade_no);
		$refundRequestBuilder->setTransactionId($transaction_id);
		$refundRequestBuilder->setOutRefundNo($out_refund_no);
		$refundRequestBuilder->setNotifyUrl($notify_url);
		$refundRequestBuilder->setTotalFee($total_fee);
		$refundRequestBuilder->setRefundDesc($refund_desc);
		$refundRequestBuilder->setRefundFee($refund_fee);
		$response = new WechatTradeService($this->config);
		$result=$response->Refund($refundRequestBuilder);
		return $result;
	}

	/**
	 * 关闭订单
	 * @param $out_trade_no 商户订单号
	 * @param string $nonce_str 随机字符串
	 * @return mixed
	 */
	public function Close($out_trade_no, $nonce_str = "")
	{
		$closeRequestBuilder = new WechatpayTradeCloseContentBuilder();
		$closeRequestBuilder->setNonceStr($nonce_str);
		$closeRequestBuilder->setOutTradeNo($out_trade_no);
		$response = new WechatTradeService($this->config);
		$result=$response->Close($closeRequestBuilder);
		return $result;
	}

	/**
	 * 把微信加密的内容进行解密
	 * @param $str 需要进行解密的字符串
	 * @return mixed
	 */
	public function encryptXMLSource($str)
	{
		$tool = new WechatTradeService($this->config);
		return $tool->encryptXMLSource($str);
	}

	/**
	 * 验签函数
	 * @param $arr
	 * @return bool
	 */
	public function checkSign($arr)
	{
		$tool = new WechatTradeService($this->config);
		return $tool->check($arr);
	}

	public function author()
	{
		echo "Scarecrow";
	}
}