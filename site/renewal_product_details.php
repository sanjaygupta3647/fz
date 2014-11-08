<?php
    if(!$_SESSION[ren_store_id]){
		header("Location:".SITE_PATH."renewal_account"); die; 
	}
	$metaTitle = $cms->getSingleresult("select meta_title from #_meta_info where url='member-login' and store_user_id = '0'");
	$metaIntro = $cms->getSingleresult("select meta_description from #_meta_info where url='member-login' and store_user_id = '0'");
	$metaKeyword = $cms->getSingleresult("select meta_keyword from #_meta_info where url='member-login' and store_user_id = '0'");
 // echo $_SESSION[uid];
	$plan_id = $cms->getSingleresult("select plan_id from #_store_detail where  store_user_id = '".$_SESSION[ren_store_id]."'");
	$type = $cms->getSingleresult("select type from #_store_user where  pid = '".$_SESSION[ren_store_id]."'");
	$noOfDays = $cms->getSingleresult("select noOfDays from #_store_detail where  store_user_id = '".$_SESSION[ren_store_id]."'");
	$amount = $cms->getSingleresult("select amount from #_store_detail where  store_user_id = '".$_SESSION[ren_store_id]."'");
	$plan_id = $cms->getSingleresult("select plan_id from #_store_detail where  store_user_id = '".$_SESSION[ren_store_id]."'");
	/* for brand */
    
	/* for store */
	$data = $cms->db_query("select name,noOfBrands,noOfStores,noOfProducts from #_plans where  pid = '".$plan_id."'");
	$plans = $cms->db_fetch_array($data); 
 
	/* for store */
	$create_date = $cms->getSingleresult("select create_date from #_store_detail where  store_user_id = '".$_SESSION[ren_store_id]."'");
	 
	$numOfProducts = $cms->getSingleresult("select t1.noOfProducts from #_plans as t1, #_store_detail as t2 where t2.pid ='".$_SESSION[ren_store_id]."' and t1.pid= t2.plan_id");
    $total = $cms->getSingleresult("select count(*) from #_products_user where store_user_id ='".$_SESSION[ren_store_id]."' ");
	 
	$noOfMessage = $cms->getSingleresult("select noOfMessage from #_store_detail  where store_user_id = '".$_SESSION[ren_store_id]."'");
	$currentUse = $cms->getSingleresult("select count(*) from #_message_stats  where store_id= '".$_SESSION[ren_store_id]."'");
	$reCreate_date = $cms->getSingleresult("select create_date from #_reg_renewal where  user_id = '".$_SESSION[ren_store_id]."' order by pid desc limit 1");
	if($reCreate_date){
		$create_date=$reCreate_date;
	}
	$remmsg = $noOfMessage-$currentUse;
    $name = $cms->getSingleresult("select name from #_store_user where  pid = '".$_SESSION[ren_store_id]."'");
	 $qry = $cms->db_query("SELECT * FROM `#_store_detail` where store_user_id = '".$_SESSION[ren_store_id]."'");
 	 $res = $cms->db_fetch_array($qry); 
	if($cms->is_post_back()){
			 
			  $plan_ID = $_POST[planID]; 
			  $noOfDays1=$noOfDays-$cms->getRemainDays($create_date);
			 // $_SESSION[succ] = "Thank you for successfull Renewal with us!"; 
			
			}
	?>
 
<div class="contentarea">
<div class="renewal_main">
<div class="renewal_main1"><h2>Upgrade Your Plan in few minutes</h2></div>
<div class="renewal_main2"><h4><?='SMS Remain '. ($remmsg).' Out of '.$noOfMessage.'SMS '?></h4>
<div class="renewal_main2-left">
<p>Plan name: <?=$plans[name]?></p>
<p>Your Plan : <?=$res[noOfDays]?>Days / Rs. <?=$res[amount]?> / <?=$res[noOfMessage]?> Message</p>
<p>Your Store name : <b> <?=$name?></b></p> 
<p>Stores URL: <a href="http://<?=$res[store_url]?>.fizzkart.com" target="_blank" style="text-decoration:none">Store Link </a></p>
</div>
<div class="renewal_main2-right">
<p>Starting Date of Your plan :<? echo date('d/m/y',strtotime($create_date));?></p>
<p>Expiry Date of Your plan : <? 
 $date = date_create($create_date);  
  date_add($date, date_interval_create_from_date_string($noOfDays.' days'));
echo date_format($date, 'd/m/y');
?></p>
</div>
</div>
 <form action="renewal_product_sumit" method="post" autocomplete="off" >
		 <input type="hidden" name="plan_id" value="<?=$plan_id?>" />
<div class="renewal_main3">
<p><strong>Select Your Product Plan:</strong>  </p>
</div>
<div class="renewal_main4"><?php
$qry = $cms->db_query("select * from fz_product_pack where status ='Active' "); ?>
	<select name="product_pack" id="product_pack" required>
	<?php while($res = $cms->db_fetch_array($qry)){ ?>
					    <option value="<?=$res[pid]?>"><?=$res[pack_name]?>(<?=$res[qty]?> Product) and Amount <?=$res[amount]?></option>
	 <?php } ?>
	</select>		
 
</div>
<div class="renewal_main5">
<input type="submit" name="proceed_submit" id="proceed_submit" value="Proceed to next"/>

</form>
</div>
 </div>
</div>  
 
 