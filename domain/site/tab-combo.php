 
 <ul class="Combo_offerdiv"><?php
  for($i = 1; $i<=$cntcmbo;$i++){?>
		<li><a lang="Combo<?=$i?>" href="Javascript:void(0)" name="combo"  class="tab <?=($i==1)?'active':''?> ">Combo <?=$i?></a></li><?php
	}?>
</ul>
<?php
$j = 1;
while($comB=$cms->db_fetch_array($comboQry)){
$allp = explode(",",$comB['comboprod']); 
$dsize=@explode("$$",$comB['prod_id']);
$p1 = $cms->getSingleresult("select title from #_products_user where status='Active' and pid = '".$dsize[0]."'");
$p1image = $cms->getSingleresult("select image1 from #_products_user where status='Active' and pid = '".$dsize[0]."'");?>
<div class="tab_innerdiv Combo<?=$j?>">
  <div class="tab_innerdiv_main">
    <h3  style="margin-top:10px;"><?=$comB[title]?></h3>
    <div class="tab_innerdiv_data" align="center" style="margin-top:10px;"> 
	<a href="<?=SITE_PATH?>detail/<?=$adm->baseurl($p1)?>/<?=$comB['prod_id']?>">
	 <img src="<?=$cms->getImageUrl($p1image,135,120); ?>" width="135" height="120"  title="<?=$p1?>"  alt="<?=$p1?>"/></a>
      <div class="tab_innerdiv_text">
        <p><?=$p1?></p>
        <p class="combo_price"><strong>Rs.  <?=$cms->getPriceSize($comB['prod_id'],$current_store_user_id,$dsize[0])?> /-</strong></p>
      </div>
    </div> 
	<?php
	$ct = 1;
	foreach($allp as $val){
		$dsize=@explode("$$",$val);
		$p = $cms->getSingleresult("select title from #_products_user where status='Active' and pid = '".$dsize[0]."'");
		$pimage = $cms->getSingleresult("select image1 from #_products_user where status='Active' and pid = '".$dsize[0]."'");?>
		 <?=($ct==3)?'':'<div class="combo_plus">+</div>'?>
		<div class="tab_innerdiv_data" align="center"> <a href="<?=SITE_PATH?>detail/<?=$adm->baseurl($p1)?>/<?=$dsize[0]?>">
		<img src="<?=$cms->getImageUrl($pimage,135,120); ?>" width="135" height="120"  title="<?=$p?>"  alt="<?=$p?>"/></a>
		  <div class="tab_innerdiv_text">
			<p><?=$p?> </p>
			<p class="combo_price"><strong>Rs. <?=$cms->getPriceSize($val,$current_store_user_id,$dsize[1])?> /-</strong></p>
		  </div>
		</div>
		<?php $ct++;
		}?> 
		<!--<p  style="margin-top:10px;"><?=$comB[info]?></p>-->
		</div>
		
		<div class="combo_right_price-detail"> <a href="javascript:void(0)" class="buycombo" lang="<?=$comB['pid']?>">Buy This Combo</a>
		 <br />
		 <p style="padding: 15px; display:none;" id="ajaxload"><img src="<?=SITE_PATH?>images/ajax-loading.gif" alt="" title="" /></p>
		<span>Total Cost = <strong style="color:red;"><strike><?=$comB['totalprice']?></strike> /-</strong></span>  
		<span>Combo Price = <strong><?=$comB['comboprice']?> /-</strong></span>
		<span>Saving Amount = <strong><?=($comB['totalprice']-$comB['comboprice'])?> /-</strong></span></div>

		<p  style="margin-top:10px; color:black;float:left;"><?=$comB[info]?></p>
		</div><?php
			$j++;
}?>
