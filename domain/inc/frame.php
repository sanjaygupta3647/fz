<?php  
	////print_r($items);die; 	 
	putenv("TZ=Asia/Calcutta");	 
 	if(count($items) >= 1)
	{		
		$page = $items[0].".php";
	} 
	if($items[0]!="" && file_exists("site/".$page)){
		$loadpage=$page;
	}else{		
		$loadpage="index.php";
		
	}
 	   $loadpage="site/".$loadpage;  
ob_start();
$host = $_SERVER['HTTP_HOST'];
$hostArr = explode(".",$host); 
$base = $hostArr[0]; 
$store_url = $cms->getSingleresult("SELECT store_url FROM fz_store_detail WHERE store_domain ='".str_replace("www.","",$host)."' and status='Active'"); 
if($store_url == "")
{
	$store_url = $cms->getSingleresult("SELECT store_url FROM fz_store_detail WHERE store_url ='".$base."' and status='Active'");  
	$current_store_user_id = $cms->getSingleresult("select store_user_id from #_store_detail where store_url ='".$base."' and status='Active'"); 
	$re_noOfDays=$cms->daysLeft($current_store_user_id); 
	if($base!=$store_url || $re_noOfDays<0){
		$die = 1; 
		if($loadpage!="site/index.php") header("Location:".SITE_PATH);
	} 
}
else
{
	$base=$store_url;
} 
$current_store_id = $cms->getSingleresult("SELECT pid FROM fz_store_detail WHERE store_url ='".$base."' and status='Active'");  
$current_store_user_id = $cms->getSingleresult("select store_user_id from #_store_detail where store_url = '".$base."' and status='Active'");  
$current_plan_id = $cms->getSingleresult("select plan_id from #_store_detail where store_url = '".$base."' and status='Active'"); 
$current_store_type = $cms->getSingleresult("select type from #_store_user where pid = '$current_store_user_id' and status='Active'"); 
$themeId  = $cms->getSingleresult("select themeId from #_theme_store where store_id = '".$current_store_id."' "); 
if(!$themeId) $themeId  = $cms->getSingleresult("select pid from #_themes  where status = 'Active' limit 0,1 "); 
$theme_color  = $cms->db_query("select * from #_themes where pid = '".$themeId."'");
if(mysql_num_rows($theme_color)){
	$colres = $cms->db_fetch_array($theme_color); 
 }
$cms->pageView($current_store_user_id);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://dublincore.org/documents/dcq-html/">
<title>%%title%% Fizzkart</title>
<link rel="schema.DC" href="http://purl.org/dc/elements/1.1/" />
<link rel="schema.DCTERMS" href="http://purl.org/dc/terms/" />
<!-- Start: Meta Info -->
<meta property="og:image" content="%%proimages%%" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="DC.title" content="%%title%%" />
<meta name="DC.creator" content="Fizzkart CDI" />
<meta name="DC.subject" content="Meta-data" />
<meta name="DC.description" content="%%description%%" />
<meta name="DC.publisher" content="Fizzkart CDI" />
<meta name="DC.contributor" content="Fizzkart CDI" />
<meta name="DC.date" content="%%datetime%%" scheme="DCTERMS.W3CDTF" />
<meta name="DC.type" content="Text" scheme="DCTERMS.DCMIType" />
<meta name="DC.format" content="text/html" scheme="DCTERMS.IMT" />
<meta name="DC.identifier" content="%%uri%%" scheme="DCTERMS.URI" />
<meta name="DC.source" content="http://www.w3.org/TR/html401/struct/global.html#h-7.4.4" scheme="DCTERMS.URI" />
<meta name="DC.language" content="%%lang%%" scheme="DCTERMS.RFC3066" />
<meta name="DC.relation" content="http://dublincore.org/" scheme="DCTERMS.URI" />
<meta name="DC.coverage" content="Fizzkart CDI" scheme="DCTERMS.TGN" />
<meta name="DC.rights" content="All rights reserved" />
<meta name="author" content="Fizzkart CDI" />
<meta name="keywords" content="%%keywords%%" />
<meta name="description" content="%%description%%" />
<!-- End: Meta Info -->
<!--favicon-->
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>
<link rel="icon" href="<?=SITE_PATH_M?>images/favicon.ico" />
<link rel="shortcut icon" href="<?=SITE_PATH_M?>images/favicon.ico" />
<?php include_once "common_css.php"; ?>
</head>
<body>
<div id="test-popup" class="white-popup mfp-with-anim mfp-hide">You may put any HTML here. This is dummy copy. It is not meant to be read. It has been placed here solely to demonstrate the look and feel of finished, typeset text. Only for show. He who searches for meaning here will be sorely disappointed.</div>
<div id="hader2" style="background-color:#<?=$colres[header_strip]?>">
  <div style="display:none;" class="logo_top" align="left"> <a href="<?=MAIN_SITE?>" ><img src="<?=SITE_PATH_M?>images/logo_top.png" style="padding-left:5px;" width="120" height="34" border="0" /></a> </div>
  <div class="topbookmark" id="trigger">
    <div style="float:left; margin:0 20px 0 0; line-height:35px;">
      <?php if($_SESSION[fname]){ ?>
      Welcome,
      <?php } ?>
      <span style="margin:0 0 0 10px;"><a href="<?=SITE_PATH?>profile" style="color:#fff; text-decoration: none;
">
      <?=ucwords($_SESSION[fname])?>
      </a>
      <?php if($_SESSION[fname]){ ?>
      !
      <?php } ?>
      </span></div>
   
    
    <div class="top_bookmark_link">
      <?php if(!$_SESSION[userid]){ ?>
      <img src="<?=SITE_PATH_M?>images/customer_login.png" style="float:left;" width="15" height="20" />
      <?php } ?>
      <?php
  if($_SESSION[userid]){ ?>
      <img src="<?=SITE_PATH_M?>images/Account.png" style="float:left;" width="17" height="20" /> <a href="<?=SITE_PATH?>profile" class="top_link">Account</a>&nbsp;&nbsp; <img src="<?=SITE_PATH_M?>images/Logout.png" style="float:left;"  width="17" height="20" /> <a href="<?=SITE_PATH?>logout" class="top_link">Logout</a>&nbsp;&nbsp;
      <?php 
  }else {?>
      <a href="<?=SITE_PATH?>user-login" rel="popuprel" class="top_link"> Customer Login </a>
      <?php 
  }?>
    </div>
    <?php
	 if(!$_SESSION[userid]){ ?>
    <div class="top_bookmark_link"> <img src="<?=SITE_PATH_M?>images/user_signup.png" style="float:left;" width="22" height="20" />&nbsp;&nbsp;<a href="<?=SITE_PATH.'registration-user'?>" class="top_link" >User Sign Up</a></div>
    <?php } ?>
    <div id="cart" style="float: left;">
    <?php
	$cartCnt = $cms->getSingleresult("select count(*) from #_cart where  ssid = '".session_id()."' and  store_user_id = '".$current_store_user_id."'");
	if($cartCnt){ ?>
    <div class="top_bookmark_link"> <img src="<?=SITE_PATH_M?>images/cart_icon.png" id="showrightpannel" width="24" style="float:left;" height="20" />&nbsp;&nbsp;
	<a href="<?=SITE_PATH?>cart" class="top_link cd-img-replace"  id="cd-cart-trigger2">Cart(<?=$cartCnt?>)</a></div>
    <?php }
	?>
    </div> </div>
</div>
<?php include"right_cart.php";?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin:25px 0 0 0;">
  <tr> 
    <!--<td align="left" valign="top">&nbsp;</td>-->
    <td width="100%" align="center" class="main_body"><header class="main_site_header">
        <?php include"header.php";?>
        <?php include"header2.php";?>
      </header>
      <?php include_once $loadpage; ?></td>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top" class="enq_text_fild"></td>
    <!--<td align="left" valign="top">&nbsp;</td>--> 
  </tr>
</table>
<?php include "footer.php"; ?>
<?php include_once "common_js.php"; ?>
</body>
</html>
<?
	//---- this script to parse all content and parse to replace keys


	$templateContent = ob_get_contents();
	ob_end_clean();
	$templateContent = str_replace("%%title%%",$metaTitle,$templateContent);
	if($items[0]=="detail" || $items[0]=="event" || $items[0]=="article" || $items[0]=="page" || $items[0]=="partner_detail"){
		$templateContent = str_replace("%%pagetitle%%",$metaTitle . " - ",$templateContent);
	}else{
		$templateContent = str_replace("%%pagetitle%%","",$templateContent);
	}
	$templateContent = str_replace("%%description%%",$metaIntro,$templateContent);
	$templateContent = str_replace("%%proimages%%",$proimages,$templateContent);
	$metaDate=str_replace(' ','TO',$metaDate) . '+00:00';
	$templateContent = str_replace("%%datetime%%",$metaDate,$templateContent);
	$metaURI="http://www." . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	$templateContent = str_replace("%%uri%%",$metaURI,$templateContent);
	$templateContent = str_replace("%%lang%%",$_SESSION['lang'],$templateContent);
	$templateContent = str_replace("%%keywords%%",$metaKeyword,$templateContent);
	echo $templateContent;
	
?>
