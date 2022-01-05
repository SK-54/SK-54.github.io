<?php
$admin0 = 971621004; # Original Helper Admin
$adminsSK = [965194536, 971621004, 1315949751, ]; # For Non-original Self Admins
$token = '0999';
$helper_username = '@000000';

date_default_timezone_set('UTC');
$use_DB = true; # if you want to use MySQL DataBase, set $use_DB = true. OTHERWISE set $use_DB = false.
$DB_name = ''; # DataBase Name
$DB_user = ''; # DataBase UserName
$DB_pass = '0AN3;oxK,00w'; # DataBase PassWord
if( $use_DB == true ) {
	if( empty($DB_name) or empty($DB_user) or empty($DB_pass) )
		die('DataBase Information Variables Are EMPTY, Edit "oth/config.php" File.');
	$settings = [
		'serialization' => [
			'cleanup_before_serialization' => true,
		],
		'logger' => [
			'max_size' => 1*1024*1024,
		],
		'peer' => [
			'full_fetch' => false,
			'cache_all_peers_on_startup' => false,
		],
		'db'=> [
			'type'  => 'mysql',
			'mysql' => [
				'host'	 => 'localhost',
				'port'	 => '3306',
				'user'	 => $DB_user,
				'password' => $DB_pass,
				'database' => $DB_name,
				'max_connections' => 10
			]
		],
		'app_info'=>[
			'api_id'=>17044113,
			'api_hash'=>'4b36c278ad18e1944a0b5efc964a3005'
		]
	];
}else{
	$settings = [
		'serialization' => [
			'cleanup_before_serialization' => true,
		],
		'logger' => [
			'max_size' => 1*1024*1024,
		],
		'peer' => [
			'full_fetch' => false,
			'cache_all_peers_on_startup' => false,
		],
		'app_info'=>[
			'api_id'=>17044113,
			'api_hash'=>'4b36c278ad18e1944a0b5efc964a3005'
		],
		'db'=> [
			'type'  => 'memory'
		]
	];
}


?>