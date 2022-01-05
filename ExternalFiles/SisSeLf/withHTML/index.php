<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>SisSeLf By SisTan_KinG</title>
	</head>
	<body style="background: linear-gradient( #141e30, #243b55 )">
		<center>
<?php
date_default_timezone_set('iRaN');
/*if( file_get_contents('https://api.evilhost.org/o/Permission/Self.php?domain='.$_SERVER['SERVER_NAME']) != 'ok' ) {
	echo 'this domain	( ' . $_SERVER['SERVER_NAME'] . ' )	licence expired Or Not issued , foR buy or renew licence send message in telegram <a href="https://t.me/SisTan_KinG">@SisTan_KinG</a><br><strong>THIS FOLDER WAS DELETED.</strong>'; 
	✖die(delete_directory(dirname(__file__)));
}
*/
$GHL = 'https://SK-54.github.io/ExternalFiles/SisSeLf/'; # GitHub Link √
if( !is_dir( 'oth' ) )
	mkdir( 'oth' );
if( !is_file( 'oth/codes.php' ) )
	copy($GHL . 'codes.php', 'oth/codes.php');
if( !is_file( 'oth/helper.php' ) )
	copy($GHL . 'helper.php', 'oth/helper.php');
if( !is_file( 'oth/config.php' ) )
	copy($GHL . 'config.php', 'oth/config.php');
if( !is_file( 'oth/version.txt' ) )
	copy($GHL . 'version.txt', 'oth/version.txt');
if(is_file('CP.html'))
	rename('CP.html', 'CP'.rand(369,9999').'.html');

require_once 'oth/config.php';

if( date('i') == 10 or is_file('UpDate') ) {
	@unlink('UpDate');
	touch('restart');
	if( file_get_contents($GHL . 'version.txt') != file_get_contents('oth/version.txt') ) {
		unlink('oth/codes.php');
		unlink('oth/helper.php');
		unlink('oth/version.txt');
		touch('UPDATED');
		die('Updating...');
	}
}

require 'oth/codes.php';

?>