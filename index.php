<?php
include_once 'vendor/autoload.php';
//配置可以在接口类初始化时传入也可以在src/config.php中配置
$wechatPay = new \ScarecrowWechatpay\WechatSdk();
//H5支付
$wechatPay->WapPay('订单名称','123456789','10');
//扫码支付
$wechatPay->NativePay('订单名称', '订单号', '支付金额');
//更多的API请到src/WechatSdk类中查看，你也可以自己封装尚未封装的接口