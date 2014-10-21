<?php
	@session_start(); 
	$qry=$_GET['q']; 
	 $items=explode("/",$qry); 
	if(count($items)!=0){
		if($items[(count($items)-1)]==""){
			array_pop($items);
		}
	}  
	set_time_limit (0);
	@extract($_POST);
	@extract($_GET);
	@extract($_SERVER);
	@extract($_SESSION); 
	@error_reporting(E_ALL ^ E_NOTICE);
	//ini_set('display_errors', '1'); 
	ini_set('register_globals', 'on');	
	ini_set('memory_limit', '800M');
	ini_set(max_upload_filesize,"300M");	
	if ($HTTP_HOST == "127.0.0.1" || $HTTP_HOST == "localhost") {
		define('LOCAL_MODE', true);
	} else {
		define('LOCAL_MODE', false);
	}	
	$tmp = dirname(__FILE__);
	$tmp = str_replace('\\' ,'/',$tmp);
	$tmp = substr($tmp, 0, strrpos($tmp, '/'));
	define('SITE_FS_PATH', $tmp); 	
	define('_JEXEC', $tmp); 	
	require_once(SITE_FS_PATH."/lib/config.inc.php");
 	require_once(SITE_FS_PATH."/lib/funcs_lib.inc.php");
	require_once(SITE_FS_PATH."/lib/funcs_extra.inc.php");
	require_once(SITE_FS_PATH."/lib/simplexlsx.class.php");
	require_once(SITE_FS_PATH."/lib/class.phpmailer.php");

	//require_once(SITE_FS_PATH."/lib/class.smtp.php");
	if(stristr($_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"], 'member') === FALSE) {
    require_once(SITE_FS_PATH."/lib/adminfunction.inc.php");
  	}else {require_once(SITE_FS_PATH."/lib/memberfunction.inc.php");}
	require_once(SITE_FS_PATH."/lib/messages.php");
	
	$cms = new DAL(); //Class Start
	$cms_CUR = new DAL_CUR(); //Class Start
	$adm = new ADMIN_DAL(); //Class Start

	if(strtolower($_SERVER['HTTPS'])=='on') {
		define('IN_SSL', true);
		define('HTTP_OR_HTTPS_PATH', SITE_SSL_PATH);
	} else {
		define('IN_SSL', false);
		define('HTTP_OR_HTTPS_PATH', SITE_WS_PATH);
	}
	define('SCRIPT_START_TIME', $cms->getmicrotime());
	if(get_magic_quotes_runtime()) {
		set_magic_quotes_runtime(0);
	}
	
	if(basename($_SERVER[PHP_SELF], ".php")=='index'){
		$tbl = 'index';	
	}else{
		$tbl = basename($_SERVER['REQUEST_URI'], ".html");		
	}
	$pageinfo = $cms->pageinfo($tbl);	
	$pagen = (($tbl)?$tbl:'index'); 
	define('SITE_MAIL', $cms->getSingleresult("select email from #_setting where `id`='1'"));
	define('SITE_PHONE', $cms->getSingleresult("select phone from #_setting where `id`='1'"));
	define('SITE_ADDR', $cms->getSingleresult("select address from #_setting where `id`='1'")); 
	$month = array (1=>"January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");

	$pages = array ("Header Text","About Us", "Contact Us", "Terms of Use", "Privacy policy", "Refund policy", "Payment Options", "Delivery policy","Review");

	$metapage = array ("Home","About Us", "Contact Us","Category Page","Brand Page", "Terms of Use", "Privacy policy", "Refund policy", "Payment Options", "Delivery policy", "Dealers","Hot Deals","Period Offers","Combo Offers","compare","Search","Login","Join Store","Registration","Order Track","Shipping Area","F.A.Qs","Product Reviews","Profile","My Transaction","My Fabourite Store","Profile Edit");

	$maisite_metapage = array ("Home","Contact Us","About us","F.A.Qs","Renew", "Tarrif Plans", "Member Login","Member Sign Up","Profile","Updates");

	$folder_array = explode("/", $_SERVER['REQUEST_URI']);
	define("CPAGE",$folder_array[sizeof($folder_array)-2]);
	$SITE_conts = $cms->db_query("select * from ".tb_Prefix."setting where id='1'");
	$SITE_CONTF = $cms->db_fetch_array($SITE_conts); 
	$mails_template = array ("User Registration","Store Registration","Main Site Query", "Sub Domain Site Query", "Join Store","Success Shopping","Failure Shopping","Cancle Shopping","Order Cancelation","Product Query","News Letter","Add or update product of barands","Active Product","Inactive Product","Product Delete","Active Site User","Inactive Site User","Brand Request Active","Brand Cancel Request","Brand Inactive Request","Store Request Active","Store Cancel Request","Store Inactive Request","Forgot Password","Renewal Hosting","Registration Update Link","Renewal SMS");

	$textpage = array ("tariff","user-login", "store-registration", "renewal-account", "contact-us", "about-us"); 
	$allpage = array ("User Settings","My Profile","Manage Pages", "Manage Seo Content", "Updates", "Site Stats","Store Detail","Users Detail","Manage Theme Color","Manage Mail Template","SMS Management","Coupon Management","User Management","Faq Manager","E-mail Alerts","Manage Country","Manage City","Manage Market","Manage Plan","Category","Manage Site Page View","Shipping City","Shipping Area","Banner","Advertisement Management","Slide Banner","Default Slide Banner","Announcement Management");
?>