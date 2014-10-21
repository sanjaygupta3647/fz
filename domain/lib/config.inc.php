<?php 
	if(!defined('LOCAL_MODE')) {
		die('<span style="font-family: tahoma, arial; font-size: 11px">config file cannot be included directly');
	}
	if ( 1|| LOCAL_MODE || $HTTP_HOST =='sanjay') {
		$ARR_CFGS["db_host"] = 'localhost';
		$ARR_CFGS["db_name"] = 'fizz'; 
    	$ARR_CFGS["db_user"] = 'root';
		$ARR_CFGS["db_pass"] = '';
		define('SITE_SUB_PATH', '/');		
	} else { 
		$ARR_CFGS["db_host"] = 'localhost';
		$ARR_CFGS["db_name"] = 'fizzkart'; 
    	$ARR_CFGS["db_user"] = 'fizz';
		$ARR_CFGS["db_pass"] = 'demodemo';
		define('SITE_SUB_PATH', '/');
	}
	
	$tmp = dirname(__FILE__);
	$tmp = str_replace('\\' ,'/',$tmp);
	$tmp = str_replace('/lib' ,'',$tmp);
	define('SITE_FS_PATH', $tmp);

	define('tb_Prefix', 'fz_');
	define('ADMIN_DIR', 'tools/');
	define('MEMBER_DIR', 'member/');
	define('MAIN_SITE', 'http://fizzkart.com'); 
	define('SITE_PATH_M', 'http://fizzkart.com/'); 
	define('SITE_PATH', 'http://'.$HTTP_HOST.SITE_SUB_PATH); 
	define('SITE_PATH_ADM', 'http://'.$HTTP_HOST.SITE_SUB_PATH.ADMIN_DIR); 
	define('SITE_PATH_MEM', 'http://'.$HTTP_HOST.SITE_SUB_PATH.MEMBER_DIR); 
	
	define('THUMB_CACHE_DIR', 'thumb_cache');
	define('PLUGINS_DIR', 'lib/plugins');
	define('UP_FILES_FS_PATH', SITE_FS_PATH.'/uploaded_files');
	define('UP_FILES_FS_PATHPC', SITE_FS_PATH.'/uploads');
	define('UP_FILES_WS_PATH', SITE_WS_PATH.'/uploaded_files'); 
	define('SITE_NAME', 'Fizzkart'); 
	define('CUR', ' Rs. ');
	define('SITE_TITLE', SITE_NAME.' Fizzkart 2'); 
	define('DEF_PAGE_SIZE', 25);
	define('SHIPPING_COST', 50);
	define('FRO_PAGE_SIZE', 10);
	define('PRO_CAT_SIZE', 8);
	define('PRO_COMBO_SIZE', 6);
	$adminToolBar = array();
	 
?>
