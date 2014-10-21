<?php include("../lib/opin.inc.php")?>
<?php include_once "inc/header.inc.php"; ?>
 <div class="main"> 
 <div class="main_wrap">
 <div class="main_head">
 <header class="index_header"> 
 <div class="hrd-right-wrap"> 
	<?php  
	$plan_id = $cms->getSingleresult("select plan_id from #_store_detail where  pid = '".$_SESSION[store_id]."'");
	$type = $cms->getSingleresult("select type from #_store_user where  pid = '".$_SESSION[uid]."'");
	$name = $cms->getSingleresult("select name from #_store_user where  pid = '".$_SESSION[uid]."'");
	$noOfDays = $cms->getSingleresult("select noOfDays from #_store_detail where  pid = '".$_SESSION[store_id]."'");
	$amount = $cms->getSingleresult("select amount from #_store_detail where  pid = '".$_SESSION[store_id]."'");
	/* for brand */
    $noOfStores = $cms->getSingleresult("select noOfStores from #_plans where  pid = '".$plan_id."'");
    $requestedStores = $cms->getSingleresult("select count(*) from #_request_brand where brand_id ='".$_SESSION[uid]."' and status = 'Active' ");
	$remainStores = (int)($noOfStores - $requestedStores); 
	/* for brand */
	/* for store */
	$noOfBrands = $cms->getSingleresult("select noOfBrands from #_plans where  pid = '".$plan_id."'");
	$requestedBrands = $cms->getSingleresult("select count(*) from #_request_brand where store_user_id ='".$_SESSION[uid]."' and status = 'Active'  ");
	$remainBrands = (int)($noOfBrands -$requestedBrands);
	/* for store */
	$create_date = $cms->getSingleresult("select create_date from #_store_detail where  pid = '".$_SESSION[store_id]."'");
	$numOfProducts = $cms->getSingleresult("select t1.noOfProducts from #_plans as t1, #_store_detail as t2 where t2.pid ='".$_SESSION[store_id]."' and t1.pid= t2.plan_id");
    $total = $cms->getSingleresult("select count(*) from #_products_user where store_user_id ='".$_SESSION[uid]."' ");
	 
	$noOfMessage = $cms->getSingleresult("select noOfMessage from #_store_detail  where pid ='".$_SESSION[store_id]."' ");
	$currentUse = $cms->getSingleresult("select count(*) from #_message_stats  where store_id ='".$_SESSION[store_id]."' ");
	$remmsg = $noOfMessage-$currentUse;
	$type = $cms->getSingleresult("select type from #_store_user where  pid = '".$_SESSION[uid]."'");
	//$brandId = $cms->getSingleresult("select pid from #_brand where brand_owner ='".$_SESSION[uid]."' "); 
	
	
  	switch ($_SESSION[usertype])
	{
	case "brand":
	  $result = "<br/>Number Of Stores Remain = $remainStores / $noOfStores";
	  $showbrand = 1;
	  break;
	case "store":
	   $result = "<br/>Number Of Brands Remain $remainBrands out of $noOfBrands.";
	  break;
	case "brand-store":
	  echo "";
	  break;
	default:
	   echo "";
	}
	?>
    <div class="brdcm">
      Welcome to Your Dashboard <span><?=ucwords($name)?></span>  
    </div>
	<span><?=$cms->getSingleresult("select name from #_plans where pid = '".$plan_id."'")?>(For <?=$noOfDays?> Day(s) = <?=$cms->price_format($amount)?><br/>
	<?='Product Remain To Add = '. (int)($numOfProducts-$total).'/'.$numOfProducts.' Products '?><br /></span> 
	<span>  
	<?php 
	if($type=='store'){ 
	$sql=$cms->db_query("select brand_id from #_request_brand where store_user_id ='".$_SESSION[uid]."' and status = 'Active'  ");
		   if(mysql_num_rows($sql)){ 
				   while ($rs = $cms->db_fetch_array($sql)){ 
					   $submitdateb = $cms->getSingleresult("select submitdate from #_barnds_product where store_user_id ='".$_SESSION[uid]."' and brand_id='".$rs[brand_id]."' order by pid desc limit 1 ");
                       if($submitdateb){
						   $name = $cms->getSingleresult("select title from #_store_detail where  store_user_id = '".$rs[brand_id]."'"); 
						   $total_product = $cms->getSingleresult("select count(*) from #_products_user where store_user_id ='".$rs[brand_id]."' and submitdate>$submitdateb");  
						   if($total_product>0){ ?><?=$total_product?> New Product Added In <a href="<?=SITE_PATH_MEM?>product-brand?soterId=<?=$rs[brand_id]?>"><?=$name?></a>&nbsp;&nbsp;&nbsp;<?php
						   } 
					   }   
				   }
			} 
	}		
	?><br /></span>
  </div>
  <div class="hrd-right-wrap right"> 
	<?php  
	$plan_id = $cms->getSingleresult("select plan_id from #_store_detail where  pid = '".$_SESSION[store_id]."'");
	
	$noOfDays = $cms->getSingleresult("select noOfDays from #_store_detail where  pid = '".$_SESSION[store_id]."'");
	$amount = $cms->getSingleresult("select amount from #_store_detail where  pid = '".$_SESSION[store_id]."'");
	/* for brand */
    $noOfStores = $cms->getSingleresult("select noOfStores from #_plans where  pid = '".$plan_id."'");
    $requestedStores = $cms->getSingleresult("select count(*) from #_request_brand where brand_id ='".$_SESSION[uid]."' and status = 'Active' ");
	$remainStores = (int)($noOfStores - $requestedStores); 
	/* for brand */
	/* for store */
	$noOfBrands = $cms->getSingleresult("select noOfBrands from #_plans where  pid = '".$plan_id."'");
	$requestedBrands = $cms->getSingleresult("select count(*) from #_request_brand where store_user_id ='".$_SESSION[uid]."' and status = 'Active'  ");
	$remainBrands = (int)($noOfBrands -$requestedBrands);
	/* for store */
	$create_date = $cms->getSingleresult("select create_date from #_store_detail where  pid = '".$_SESSION[store_id]."'");
    $reCreate_date = $cms->getSingleresult("select create_date from #_reg_renewal where user_id = '".$_SESSION[uid]."' order by pid desc limit 1");
	$numOfProducts = $cms->getSingleresult("select t1.noOfProducts from #_plans as t1, #_store_detail as t2 where t2.pid ='".$_SESSION[store_id]."' and t1.pid= t2.plan_id");
    $total = $cms->getSingleresult("select count(*) from #_products_user where store_user_id ='".$_SESSION[uid]."' ");
	 
	$noOfMessage = $cms->getSingleresult("select noOfMessage from #_store_detail  where pid ='".$_SESSION[store_id]."' ");
	$currentUse = $cms->getSingleresult("select count(*) from #_message_stats  where store_id ='".$_SESSION[uid]."' ");
	$remmsg = $noOfMessage-$currentUse; 
	//$brandId = $cms->getSingleresult("select pid from #_brand where brand_owner ='".$_SESSION[uid]."' ");  
	if($reCreate_date){
		$create_date=$reCreate_date;
	}  
	
  	switch ($_SESSION[usertype])
	{
	case "brand":
	  $result = "<br/>Number Of Stores Remain = $remainStores / $noOfStores";
	  $showbrand = 1;
	  break;
	case "store":
	   $result = "<br/>Number Of Brands Remain $remainBrands out of $noOfBrands.";
	  break;
	case "brand-store":
	  echo "";
	  break;
	default:
	   echo "";
	}
	?>
    <div class="second_brdcm">
     
     <span>
	<?='Days Remain = '. ($noOfDays-$cms->getRemainDays($create_date)).'/'.$noOfDays.' Days '.$result?><br /> Message Remain = <?=$remmsg?>/<?=$noOfMessage?> </span>
    </div>
	
  </div>
  <div class="cl"></div>
</header>
    <div class="content"> 
         <?  include"dashboad.php"; ?>  
    </div>
      <? include"inc/footer.inc.php"; ?>
      </div>
      </div>
  </div>
  <div class="cl"></div>
</div>
</div>
 
</body>
</html>
