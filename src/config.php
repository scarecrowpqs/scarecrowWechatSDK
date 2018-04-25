<?php
return [
	//微信分配的公众账号ID（企业号corpid即为此appId）必填
	'app_id'			=>	'',
	//商户号	必填
	'mch_id'		=>	'',
	//签名类型
	'sign_type'		=>	'MD5',
	//商户密匙
	'private_key'			=>	'',
	//是否开启debug
	'is_debug'		=>	'false',
	//异步回调地址
	'notify_url'	=>	'',
	//退款通知地址
	'refund_notify_url'	=>	'',
	//网站地址
	'wap_url'		=>	'',
	//网站名称
	'wap_name'		=>	'',
];