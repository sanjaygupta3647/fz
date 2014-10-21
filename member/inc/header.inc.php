<?php //echo $_SESSION["uid"];
if(!$_SESSION["uid"]){$cms->redir(SITE_PATH);}
 ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Welcome</title>
<link rel="icon" href="<?=SITE_PATH_M?>images/favicon.ico" />
<link rel="shortcut icon" href="<?=SITE_PATH_M?>images/favicon.ico" />
<link rel="stylesheet" href="<?=SITE_PATH_MEM?>css/style.css" type="text/css">
<!--[if IE]> <script type="text/javascript" src="js/html5.js"></script><![endif]-->
<!--[if lte IE 7]><script defer type="text/javascript" src="js/pngfix.js"></script><![endif]--> 
<script language="javascript" src="<?=SITE_PATH_MEM?>js/validate.js"></script>
<script type="text/javascript" src="<?=SITE_PATH?>js/jquery-1.4.4.min.js" ></script> 
<script type="text/javascript" src="<?=SITE_PATH_MEM?>js/jscolor.js" ></script>
<script type="text/javascript" src="<?=SITE_PATH_MEM?>js/jquery.popupWindow.js.js" ></script> 
<script type="text/javascript" src="<?=SITE_PATH?>lib/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?=SITE_PATH?>lib/ckfinder/ckfinder.js"></script>
<!-- for color picker-->
<link href="<?=SITE_PATH_MEM?>js/syronex-colorpicker.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?=SITE_PATH_MEM?>js/syronex-colorpicker.js"></script>
<!-- for color picker--> 
  <!-- caleder start  -->
<link rel="stylesheet" type="text/css" media="all" href="<?=SITE_PATH?>calender/calendar-blue2.css" title="summer" />
<script type="text/javascript" src="<?=SITE_PATH?>calender/calendar.js"></script>
<script type="text/javascript" src="<?=SITE_PATH?>calender/calendar-en.js"></script>
<script type="text/javascript" src="<?=SITE_PATH?>calender/calendar-setup.js"></script>

<!--Table shorter-->
<link rel="stylesheet" href="<?=SITE_PATH_MEM?>css/default.css" type="text/css">

<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> 
<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.9.1/jquery.tablesorter.min.js"></script>

<script>
$(function(){
	$("#myTable").tablesorter( {sortList: [[0,0]]} ); 
 });
</script>
<!--Table shorter-->
<!-- caleder end  -->
<?php include(SITE_FS_PATH.'/'.ADMIN_DIR."js/calc.php")?>
</head> 
<body>

<?=$cms->sform((($mode)?'onsubmit="return formvalid(this)"':'onsubmit="return formvalid(this)"'));?>
<?php
	$theme = $cms->getSingleresult("select theme from #_store_detail where `store_user_id` = '".$_SESSION[uid]."'");
	$store_url = $cms->getSingleresult("select store_url from #_store_detail where `store_user_id` = '".$_SESSION[uid]."'");
	$type = $cms->getSingleresult("select type from #_store_user where `pid` = '".$_SESSION[uid]."'");
	$name = $cms->getSingleresult("select name from #_store_user where `pid` = '".$_SESSION[uid]."'"); 
	?>
<div class="wrap wrap2">
  <div class="admin-bar">  
     <div class="logo"> <a href="<?=SITE_PATH_MEM?>"><img src="<?=SITE_PATH?>image/logo/final.png" alt=""></a></div>
    <ul class="nav">
		<!--<li id="settings">
			<a href="#"><img src="images/settings.png" /></a>
		</li>-->
		<li>
			<a href="<?=SITE_PATH_MEM?>profile">Welcome to Your <?=ucwords($name)?> Store</a>
		</li>
		<li id="options">
			<a href="#">Options</a>
			<ul class="subnav">
				<li><a href="http://<?=$store_url?>.fizzkart.com" target="_blank">Go to Your Store</a></li>
				<li><a href="<?=SITE_PATH_MEM?>profile">Profile</a></li>
				<li><a href="<?=SITE_PATH_MEM?>catalog/add-store.php">Settings</a></li>
				<li><a href="<?=SITE_PATH_MEM?>logout.php">Logout</a></li>
			</ul>
		</li>
	</ul>
  </div>
  
    <div class="container_for-domain">
  <ul>
    <li>
      <a href="Javascript:void(0)">Content</a>
      <ul>
        <li><a href="<?=SITE_PATH_MEM?>content">View Content</a></li> 
        <li><a href="<?=SITE_PATH_MEM?>content/?mode=add">Add Content</a></li>
        <li><a href="<?=SITE_PATH_MEM?>seo">Manage Seo Content</a></li>
        <li><a href="<?=SITE_PATH_MEM?>announcement/">Admin&nbsp;Announcement</a></li>
		 <li><a href="<?=SITE_PATH_MEM?>catalog/offer-title.php">offer Title</a></li>
      </ul>
    </li>
    <li>
      <a href="Javascript:void(0)">Catalog</a>
      <ul>
        <li><a href="<?=SITE_PATH_MEM?>catalog/theme-color.php">Store/Brand Theme Color</a> </li> 
		    <li><a href="<?=SITE_PATH_MEM?>template">Mail Template</a> </li>
			<li><a href="<?=SITE_PATH_MEM?>profile">Personal Profile</a> </li>
	  		<li><a href="<?=SITE_PATH_MEM?>catalog/add-store.php">Store Profile</a> </li>  
			<li><a href="<?=SITE_PATH_MEM?>catalog/manage-menue.php">Store Top Menu</a> </li>   
			<li><a href="<?=SITE_PATH_MEM?>coupon/?log=coupon">Coupon Management</a> </li> 
			<li><a href="<?=SITE_PATH_MEM?>shipping">Shipping Management</a> </li>  
			<li><a href="<?=SITE_PATH_MEM?>discount">Discount Management</a> </li>
			<li><a href="<?=SITE_PATH_MEM?>faq">Faq Management</a> </li>
      </ul>
    </li>
    <li><a href="Javascript:void(0)">Manage</a>
   	 <ul>
    	<li><a href="<?=SITE_PATH_MEM?>users">Manage&nbsp;Members</a></li>
    	<li><a href="<?=SITE_PATH_MEM?>catalog/manage-orders.php">Manage&nbsp;Orders</a></li>
        <li><a href="<?=SITE_PATH_MEM?>sitequery">Contact Us Query </a></li>
	  	<li><a href="<?=SITE_PATH_MEM?>productquery">Product Query </a></li>
        <li><a href="<?=SITE_PATH_MEM?>product/">Manage Product</a></li>
		<!--<li><a href="<?=SITE_PATH_MEM?>catalog/price-list.php">Product Price List</a></li>-->
        <li><a href="<?=SITE_PATH_MEM?>newsletter/">Manage Newsletter</a></li>
        <li><a href="<?=SITE_PATH_MEM?>color">Manage Color</a></li>
		<li><a href="<?=SITE_PATH_MEM?>dimension">Manage Dimension</a></li>
        <li><a href="<?=SITE_PATH_MEM?>slider">Manage Slide Banner</a></li>
        <li><a href="<?=SITE_PATH_MEM?>slider-offer/">Manage offer Banner</a></li>
     </ul>
    </li>
    
    
    
   <?php if($_SESSION[usertype]=='brand'){?><li><a href="<?=SITE_PATH_MEM?>catalog/store-list-brand.php">Requested&nbsp;Stores</a>
	  <?php }else{?>
    <li>
      <a href="Javascript:void(0)">Admin&nbsp;Product&nbsp;&&nbsp;Brands</a>
      <ul>
   <!--  <li><a href="<?=SITE_PATH_MEM?>product-adm/">Admin Product</a> </li> -->
	 <li><a href="<?=SITE_PATH_MEM?>brands-prod/">Brands Product</a> </li>
	 <li><a href="<?=SITE_PATH_MEM?>catalog/brands-list.php">All Brands</a> </li>
	 <li><a href="<?=SITE_PATH_MEM?>catalog/my-brands-list.php">My Brands</a> </li>
      </ul>
    </li>
    <?php }?> 
    <li><a href="<?=SITE_PATH_MEM?>catalog/export-xls.php">Upload&nbsp;XLS </a></li>
    <li>
      <a href="Javascript:void(0)">Others</a>
      <ul> 
	    <li><a href="<?=SITE_PATH_MEM?>catalog/price-list.php">Price List</a> </li> 
	    <li><a href="<?=SITE_PATH_MEM?>combo">Manage Combo Product</a> </li> 
		<li><a href="<?=SITE_PATH_MEM?>period_offer/?mode=add">Add Period Offer</a></li>
        <li><a href="<?=SITE_PATH_MEM?>period_offer/">Manage Period Offer</a></li>
<?php if($_SESSION[usertype]=='brand'){?>
		<li><a href="<?=SITE_PATH_MEM?>catalog/dealer-reports.php">Dealer Report</a></li>
	<?php  } ?>	
	  	<li><a href="<?=SITE_PATH_MEM?>shiparea">Shipping Area Manager</a> </li>  
		<li><a href="<?=SITE_PATH_MEM?>sitecomments">Site comments Manager</a> </li>  
		<li><a href="<?=SITE_PATH_MEM?>productcomments">Product comments Manager</a> </li>
		<li><a href="<?=SITE_PATH_MEM?>catalog/my-site-pageview.php">My Store Page View</a> </li>
		<?php if($type=='brand'){?>
		<li><a href="<?=SITE_PATH_MEM?>catalog/product-view-main.php">Product View By Store</a> </li>
		<li><a href="<?=SITE_PATH_MEM?>catalog/product-main-sells.php">Product Sells By Store</a> </li>
		<?php } ?>
      </ul>
    </li>
  </ul>
</div>

<div class="cl"></div>