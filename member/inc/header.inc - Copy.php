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
<!-- caleder end  -->
<?php include(SITE_FS_PATH.'/'.ADMIN_DIR."js/calc.php")?>
</head> 
<body>

<?=$cms->sform((($mode)?'onsubmit="return formvalid(this)"':'onsubmit="return formvalid(this)"'));?>
<div class="wrap wrap2">
  <div class="admin-bar">
    <div class="logout"> <a href="<?=SITE_PATH_MEM?>logout.php">Logout</a> </div>
 <span id="big-nav">   
 <ul class="nav admin-settings" id="nav" style="display:none;">
      <li > <a href="" class="st"  ><img src="<?=SITE_PATH_MEM?>images/admin.png"   class="gear" alt="" width="18" height="18" /></a>
        <ul>
          <li> <a href="<?=SITE_PATH_MEM?>setting.php?mode=true">My Profile</a> </li> 
          <li> <a href="<?=SITE_PATH_MEM?>catalog/add-store.php">User Settings</a> </li>
        </ul>
      </li>
    </ul>
	<?php
	$theme = $cms->getSingleresult("select theme from #_store_detail where `store_user_id` = '".$_SESSION[uid]."'");
	$store_url = $cms->getSingleresult("select store_url from #_store_detail where `store_user_id` = '".$_SESSION[uid]."'");
	?>
	<div class="welcome"><a href="http://<?=$store_url?>.fizzkart.com" target="_blank">Go To Your Store </a></div>
    <div class="welcome"> Welcome To <?=$cms->getSingleresult("select name from #_store_user where `pid` = '".$_SESSION[uid]."'")?> Store</div>
	</span>
     <div class="logo"> <a href="<?=SITE_PATH_MEM?>"><img src="<?=SITE_PATH_MEM?>images/logo.png" alt=""></a></div>
    
  </div>
  <div class="aside">
    <ul class="nav2">  
		
	  <li><a href="#">Content</a>
      <div class="ul-arrow">
          <ul> 
			<li><a href="<?=SITE_PATH_MEM?>content">View Content</a></li>
			<li><a href="<?=SITE_PATH_MEM?>content/?mode=add">Add Content</a> </li>  
			<li><a href="<?=SITE_PATH_MEM?>seo">Manage Seo Content</a> </li>
		  </ul>
        </div>
	 </li>
	
	<li><a href="#">Catalog</a>
      <div class="ul-arrow">
          <ul> 
		    <li><a href="<?=SITE_PATH_MEM?>catalog/theme-color.php">Store/Brand Theme Color</a> </li>
			<li><a href="<?=SITE_PATH_MEM?>combo">Manage Combo Product</a> </li>
			<li><a href="<?=SITE_PATH_MEM?>color">Manage Color</a> </li>
			<li><a href="<?=SITE_PATH_MEM?>dimension">Manage Dimension</a> </li>
			<li><a href="<?=SITE_PATH_MEM?>product-dimension">Manage Product Dimension</a> </li>
		    <li><a href="<?=SITE_PATH_MEM?>template">Mail Template</a> </li>
			<li><a href="<?=SITE_PATH_MEM?>profile">Personal Profile</a> </li>
	  		<li><a href="<?=SITE_PATH_MEM?>catalog/add-store.php">Store Profile</a> </li>  
			<li><a href="<?=SITE_PATH_MEM?>catalog/manage-menue.php">Store Top Menu</a> </li>   
			<li><a href="<?=SITE_PATH_MEM?>coupon">Coupon Management</a> </li> 
			<li><a href="<?=SITE_PATH_MEM?>shipping">Shipping Management</a> </li>  
			<li><a href="<?=SITE_PATH_MEM?>discount">Discount Management</a> </li>
			<li><a href="<?=SITE_PATH_MEM?>faq">Faq Management</a> </li>
		</ul>
      </div>
	 </li>
	  
	  <li><a href="<?=SITE_PATH_MEM?>catalog/manage-orders.php">Manage Orders</a></li>
	  <li><a href="<?=SITE_PATH_MEM?>users">Manage Members</a></li>
	  
	  <li><a href="#">Query Manager</a>
      <div class="ul-arrow">
          <ul> 
			<li><a href="<?=SITE_PATH_MEM?>sitequery">Site Query Manager</a> </li>
	  		<li><a href="<?=SITE_PATH_MEM?>productquery">Product Query Manager</a> </li>          
		</ul>
        </div>
	 </li> 
	   
	  <li><a href="#">Manage Product</a>
      <div class="ul-arrow">
          <ul> 
            <li><a href="<?=SITE_PATH_MEM?>product/?mode=add">Add Product</a></li>
            <li><a href="<?=SITE_PATH_MEM?>product/">Manage Product</a></li>
			<li><a href="<?=SITE_PATH_MEM?>catalog/price-list.php">Product Price List</a></li>
          </ul>
        </div>
	 </li> 
	 <?php if($_SESSION[usertype]=='brand'){?><li><a href="<?=SITE_PATH_MEM?>catalog/store-list-brand.php">Requested Stores</a>
	  <?php }else{?>
	 
	 <li><a href="#">Admin Product & Brands</a>
	 <div class="ul-arrow"><ul>
	 <li><a href="<?=SITE_PATH_MEM?>product-adm/">Admin Product</a> </li>
	 <li><a href="<?=SITE_PATH_MEM?>brands-prod/">Brands Product</a> </li>
	 <li><a href="<?=SITE_PATH_MEM?>catalog/brands-list.php">All Brands</a> </li>
	 <li><a href="<?=SITE_PATH_MEM?>catalog/my-brands-list.php">My Brands</a> </li>
	 </ul></div>	 
	 </li> 
	 
	 <?php }?>
     <li><a href="<?=SITE_PATH_MEM?>announcement/">Admin Announcement</a>  </li>
	  <li><a href="<?=SITE_PATH_MEM?>newsletter/">Newsletter</a> 
      <div class="ul-arrow">
          <ul>
            <li><a href="<?=SITE_PATH_MEM?>newsletter/?mode=add">Add Newsletter</a></li>
            <li><a href="<?=SITE_PATH_MEM?>newsletter/">Manage Newsletter</a></li>
          </ul>
        </div> 
      </li>  
     <li><a href="<?=SITE_PATH_MEM?>slider">Slide Banner </a>
	 <div class="ul-arrow">
          <ul>
            <li><a href="<?=SITE_PATH_MEM?>slider">Slide Banner </a></li>
            <li><a href="<?=SITE_PATH_MEM?>slider-offer/">Manage offer Banner</a></li>
          </ul>
        </div>
	 
	 </li>  
	 <li><a href="<?=SITE_PATH_MEM?>catalog/export-xls.php">Upload XLS</a></li>  
	  <li><a href="#">Others</a>
      <div class="ul-arrow">
          <ul> 
            <li><a href="<?=SITE_PATH_MEM?>hotdeal/?mode=add">Add Hotdeal Offer</a></li>
            <li><a href="<?=SITE_PATH_MEM?>hotdeal/">Manage Hotdeal Offer</a></li>
			<li><a href="<?=SITE_PATH_MEM?>period_offer/?mode=add">Add Period Offer</a></li>
            <li><a href="<?=SITE_PATH_MEM?>period_offer/">Manage Period Offer</a></li>
			<li><a href="<?=SITE_PATH_MEM?>shipareacity">Shipping City Manager</a> </li>
	  		<li><a href="<?=SITE_PATH_MEM?>shiparea">Shipping Area Manager</a> </li>  
			<li><a href="<?=SITE_PATH_MEM?>sitecomments">Site comments Manager</a> </li>  
			<li><a href="<?=SITE_PATH_MEM?>productcomments">Product comments Manager</a> </li>
			<li><a href="<?=SITE_PATH_MEM?>catalog/my-site-pageview.php">My Store Page View</a> </li> 
          </ul>
        </div>
	 </li> 
    </ul>
</div>
<div class="cl"></div>