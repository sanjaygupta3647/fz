<div class="cart_main_div" style="float:none;">

<table  width="100%" border="0" class="CSSTableGenerator">
<tr>
<td>
	<h1>Period Offer</h1> 
</td>
</tr> 
<?php
$today = date('Y-m-d');
$cat_ids =  $cms->db_query("SELECT cat_id FROM `fz_offer` where store_user_id='$current_store_user_id' and status = 'Active' and '$today' >= dayfrom and   '$today' <= dayto "); 
if(mysql_num_rows($cat_ids)){
	  while($rs=$cms->db_fetch_array($cat_ids)){
		$cats_arr[] = $rs[cat_id];
	  }
} 
if(count($cats_arr)){
	foreach($cats_arr as $val){
		$brands =  $cms->db_query("SELECT * FROM `fz_offer_detail` where store_user_id='$current_store_user_id' and status = 'Active'  and   cat_id= '$val' "); 
		if(mysql_num_rows($brands)){
			while($r=$cms->db_fetch_array($brands)){ extract($r)?>
				<tr>
				<td><?php
				$dates =  $cms->db_query("SELECT dayfrom,dayto FROM `fz_offer` where store_user_id='$current_store_user_id' and status = 'Active' and cat_id = '$cat_id' "); 
				 $result=$cms->db_fetch_array($dates);
				  ?>
					<b style="font-size: 14px;"><a href="<?=SITE_PATH?>period-offer/<?=$adm->baseurl($title)?>/<?=$pid?>"><?=$title?></a> 
					from <?=date("d,M Y",strtotime($result[dayfrom]))?> To  <?=date("d,M Y",strtotime($result[dayto]))?></b> 
					<div><?php
					switch ($type){
							case "freeProd":
								echo "On purchase of $onshop item(s) get $getfree items(s) free";
								break;
							case "flatPercent":
								echo " Get $flatpercent % discount on each item";
								break;
							case "rangeQty":
								echo "Get $qtyDisPercent % discount on shopping of product between $qty1 and $qty2";
								break;
							case "rangeAmt":
								echo "Get Rs $discAmt discount on shopping of product between Rs. $amount1 and Rs. $amount2";
								break;
							default:
						}	 
				 ?> In 
				 <?php
				$getpar = $cms->getSingleresult("select parent from #_store_menu where store_user_id ='$current_store_user_id' and cat_id='$cat_id' ");
				 echo $cms->getSingleresult("select name from #_store_menu where store_user_id ='$current_store_user_id' and cat_id='$cat_id' "). " of ".
				$hedtitle = $cms->getSingleresult("select name from #_store_menu where store_user_id ='$current_store_user_id' and cat_id='$getpar' "); ?>
				 
				 </div> 
					<div><?=$info?></div>
				</td>
				</tr> 
			<?php
			}
		}
	}
}else{
?>
<tr>
<td>
	<p style="font-size: 14px;">No Record Found!</p>  
</td>
</tr> 
<?php 
}
?>
</table>
</div>
