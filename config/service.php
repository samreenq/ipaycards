<?php

return [
	/**
	 * Mintroute Configurations
	 */
	'MINT_ROUTE' => [
		'endpoint_url' => 'https://sandbox.mintroute.com/voucher/api/',
		// credentials
		'username' => 'junaid.altaf',
		'password' => 'jMgS2K7V',
		// keys
		'pvt_key' => 'ed1eb1ed6357371a5980381b68feb81e',
		'pub_key' => base64_encode('gak6JaoI'),
		// encryption bits
		'enc_bits' => 256,
		// other
		'pos_identification' => 'iPay4All'
	],
	
	/**
	 * OnePrepay Configurations
	 */
	'ONE_PREPAY' => [
		'endpoint_url' => 'https://test.nexu.cloud:444/Web/GetXml',
		// credentials
		'terminal_id' => 'IP4ALL-1',
		'password' => 'IP123456',
		'mode' => 'sandbox'
	],
	
	
	/**
	 * Simbox Configurations
	 */
	'SIMBOX_PREPAY' => [
		'endpoint_url' => 'http://ipay1060.pointto.us:8088/api/',
		// auth
		'username' => 'iPay1060USER',
		'password' => '6sVpSjHu%MZssCPScqu+',
		// credentials
		'port' => 2,
		'sim_id' => '102762',
		'pin_id' => '3152',
	],

];
