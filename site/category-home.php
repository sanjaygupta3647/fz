<div class="categorybox">
  <div class="heading"><img src="images/heading-arrow-icon.jpg" width="11" height="7" alt="Heading" />Categories</div>
  <div class="boxarea">
	<?php 		  
	$sql_city1="select pid,name,image,body from #_category where parentId='0' and status = 'Active'";
	$sql_city1_query=$cms->db_query($sql_city1);
	while($city_array=$cms->db_fetch_array($sql_city1_query)){ @extract($city_array); 
	$sql="select plan_id from #_plans_category where cat_id ='$pid' group by plan_id";
	$sqlquery=$cms->db_query($sql);
	$noStore = 0;
	if(mysql_num_rows($sqlquery)){
		$plans = array();
		while($resl=$cms->db_fetch_array($sqlquery)){ 
			$plans[] = $resl[plan_id];
		}
		if(count($plans)){
			$noStore = $cms->getSingleresult("select count(*) from  fz_store_detail as t1, fz_store_user as t2 where t1.plan_id in (".implode(',',$plans).") 
			and t1.status = 'Active' and  t1.store_user_id = t2.pid and (t2.type = 'store' or t2.type = 'brand')" );
		} 
	}?>
    <div class="commonbox">
      <div class="imgbox"><a href="<?=SITE_PATH?>store-category/<?=$adm->baseurl($name)?>/<?=$pid?>">
	  <img src="<?=$cms->getImageUrl($image, 182, 124)?>" width="182" height="124" alt="<?=$adm->baseurl($name)?>" title="<?=$adm->baseurl($name)?>" /></a></div>
      <div class="cat-head"> <a style="text-decoration:none; color:black" href="<?=SITE_PATH?>store-category/<?=$adm->baseurl($name)?>/<?=$pid?>"> <?=$name?></a>(<strong><?=$noStore?></strong>)</div>
      <div class="subtext"><?=$body?></div>
    </div><?php
  }?> 
</div>
</div>