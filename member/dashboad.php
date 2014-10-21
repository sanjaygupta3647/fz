<!-- <link rel="stylesheet" href="<?=SITE_PATH_ADM?>css/demos.css" type="text/css" media="screen" /> -->
<?php  
$getproduct= $cms->db_query("select prod_id from #_barnds_product where brand_id = '".$_SESSION[uid]."'");
	$prod_arr = array();
	if(mysql_num_rows($getproduct)){
		  while($res=$cms->db_fetch_array($getproduct)){
			$prod_arr[] = $res[prod_id];
		  }
	}
    $start = intval($start);
	$pagesize = 10;
	$columns = "select * ";
	$sql = " from #_order_summary where store_id = '".$_SESSION[store_id]."' and status = 'pending' ";
	$order_by == '' ? $order_by = 'orderid' : true;
	$order_by2 == '' ? $order_by2 = 'desc' : true;
	$sql_count = "select count(*) ".$sql; 
	$sql .= "order by $order_by $order_by2 ";
	$sql .= "limit $start, $pagesize ";
	$sql = $columns.$sql;
	$result = $cms->db_query($sql);
	$reccnt = $cms->db_scalar($sql_count); 
?>
</div>
</div>

<div class="quick_links" style="margin-bottom:25px;">
  <div class="quick_link-box ten ">
    <?php $totalkey  = $cms->getSingleresult("SELECT count(*) FROM #_member_access WHERE store_id ='".$_SESSION[store_id]."'")?>
    <div class="quick_link-box_detail"><a href="http://fizzkart.com/member/users/">Total Members(<?=$totalkey?>)</a></div>
  </div>
  <div class="quick_link-box ten ">
    <?php $totalkey  = $cms->getSingleresult("SELECT count(*) from  #_products_inquery where store_id = '".$_SESSION[store_id]."' ")?>
    <div class="quick_link-box_detail"><a href="http://fizzkart.com/member/productquery/">Product Query(<?=$totalkey?>)</a></div>
  </div>
  <div class="quick_link-box ten ">
    <?php $totalkey  = $cms->getSingleresult("SELECT count(*) from  #_contact where store_id = '".$_SESSION['store_id']."' ")?>
    <div class="quick_link-box_detail"><a href="http://fizzkart.com/member/sitequery/">Contact Query(<?=$totalkey?>)</a></div>
  </div>
  
  <div class="quick_link-box one">
    <div class="quick_link-box_detail"><a href="http://fizzkart.com/member/content/">Content Manager</a></div>
  </div>
  <div class="quick_link-box two">
    <div class="quick_link-box_detail"><a href="http://fizzkart.com/member/catalog/manage-orders.php">Order Manager</a></div>
  </div>
  <div class="quick_link-box three">
    <div class="quick_link-box_detail"><a href="http://fizzkart.com/member/product/">Product Manager</a></div>
  </div>
  <div class="quick_link-box four">
    <div class="quick_link-box_detail"><a href="http://fizzkart.com/member/coupon/">Coupon Manager</a></div>
  </div>
  <div class="quick_link-box five">
    <div class="quick_link-box_detail"><a href="http://fizzkart.com/member/newsletter/">Newsletter Manager</a></div>
  </div>
  <div class="quick_link-box six">
    <div class="quick_link-box_detail"><a href="http://fizzkart.com/member/discount/">Discount Manager</a></div>
  </div>
  <div class="quick_link-box seven">
    <div class="quick_link-box_detail"><a href="http://fizzkart.com/member/productquery/">Product Query Manager</a></div>
  </div>
  <div class="quick_link-box eight">
    <div class="quick_link-box_detail"><a href="http://fizzkart.com/member/shipping/">Shipping Manager</a></div>
  </div>
  <div class="quick_link-box nine">
    <div class="quick_link-box_detail"><a href="http://fizzkart.com/member/announcement/">Announcement Manager</a></div>
  </div>
  <div class="quick_link-box ten ">
    <div class="quick_link-box_detail"><a href="http://fizzkart.com/member/slider/">Banner Manager</a></div>
  </div>
  <div class="quick_link-box ten ">
    <?php $totalkey  = $cms->getSingleresult(" SELECT count(*) FROM #_searchkey where keywords != '' and store_id = '".$_SESSION[store_id]."' ")?>
    <div class="quick_link-box_detail"><a href="http://fizzkart.com/member/catalog/searched-key.php">Search Keywords(<?=$totalkey?>)</a></div>
  </div>
  <?php if($_SESSION[usertype]=='brand') {?>
  <div class="quick_link-box ten" >
    <?php $totalkey  = $cms->getSingleresult("select count(*) from  #_request_brand where brand_id ='".$_SESSION[uid]."' and status = 'Active' ")?>
    <div class="quick_link-box_detail"><a href="http://fizzkart.com/member/catalog/store-list-brand.php">Approved Stores(<?=$totalkey?>)</a></div>
  </div>
  <div class="quick_link-box ten ">
    <?php $totalkey  = $cms->getSingleresult("select count(*) from  #_request_brand where brand_id ='".$_SESSION[uid]."' and status = 'Inactive' ")?>
    <div class="quick_link-box_detail"><a href="http://fizzkart.com/member/catalog/store-list-brand.php">Pending Store Request(<?=$totalkey?>)</a></div>
  </div>
  <?php }?>
  <?php if($_SESSION[usertype]=='store') {?>
  <div class="quick_link-box ten ">
    <?php $totalOrder  = $cms->getSingleresult("SELECT count(*) FROM `fz_order_summary` where store_id = '".$_SESSION[uid]."' ");?>
    <?php $paynet  = $cms->getSingleresult("SELECT sum(paynet) FROM `fz_order_summary` where store_id = '".$_SESSION[uid]."' ");?>
    <div class="quick_link-box_detail"><a href="http://fizzkart.com/member/catalog/manage-orders.php">Total Order <?=$totalOrder?> of <?=$cms->price_format($paynet)?> </a></div>
  </div>
  <div class="quick_link-box ten ">
    <?php $tbrands  = $cms->getSingleresult("select count(*) from  #_request_brand where store_user_id ='".$_SESSION[uid]."' and status = 'Active'  ");?> 
    <div class="quick_link-box_detail"><a href="http://fizzkart.com/member/catalog/my-brands-list.php">Total Brands (<?=$tbrands?>) </a></div>
  </div>
  <?php } ?>
</div>
