
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Core Config File
 */

// Site Details
$config['connection'] = array(
	'default' => array(
		'driver'    => 'mysql',

		// NOTE : LIVE DATABASE
		// 'host'      => '103.137.111.6',
		// 'database'  => 'sipta',
		// 'username'  => 'sa',
		// 'password'  => 'Mgb654321',

		// NOTE : LOCAL DATABASE
		'host'      => 'localhost',
		'database'  => 'sipta_live',
		'username'  => 'root',
		'password'  => '',

		// NOTE : TEST DATABASE
		// 'host'      => '192.168.100.116',
		// 'database'  => 'ekspedisi_erp',
		// 'username'  => 'it-mt',
		// 'password'  => 'musnimda',

		'charset'   => 'utf8',
		'collation' => 'utf8_general_ci',
		'prefix'    => '',
	),
);
