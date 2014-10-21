<?php
$storesid = array();
$per_page = PRO_COMBO_SIZE; 

if($_POST){
$page=$_POST['page'];
$qry=$_POST['qry'];
$url=$_POST['url'];
} 
$start = ($page-1)*$per_page;  
$searchqry = " $qry limit $start,$per_page "; 
$searchexe = $cms->db_query($searchqry);

  if(mysql_num_rows($searchexe)){
	 while($storeres=$cms->db_fetch_array($searchexe))
				{   
					$status = $cms->getSingleresult("select status from #_barnds_product where prod_id = '".$storeres[pid]."' and store_user_id = '".$current_store_user_id."'");
					if($status=='Inactive'){
						$storeres[status] = 'Inactive';					
					}
					if($storeres[status]!='Inactive'){
					$img = SITE_PATH."uploaded_files/thumb/no-img.gif";
					if(file_exists('../uploaded_files/thumb/'.$storeres['image1']) && $storeres['image1']!="")
					{
						  $img = SITE_PATH."uploaded_files/thumb/".$storeres['image1'];
					}
					$src = '../uploaded_files/thumb/'.$storeres['image1'];
					$siz = @getimagesize($src);
					if($siz[1]<160){
					$h = ' height="'.$siz[1].'"';
					}else{
						//$w = ' weight="'.$siz[0].'"';
						$h = ' height="160"';
					}
					?>

<div class="apparel_main_div" style="height:331px; width:248px;">
				<table width="150" align="center" height="160"  cellspacing="0" cellpadding="0">
				  <tbody><tr>
					<td align="center" valign="middle"> 
					<a href="<?=SITE_PATH?>domain/<?=$url?>/detail/<?=$adm->baseurl($storeres['title'])?>/<?=$storeres['pid']?>">
						<img src="<?=$img?>"  <?=$h?>   <?=$w?>     title="<?=$storeres['title']?>" alt="<?=$storeres['title']?>" align="middle"/>
					</a>
					 </td>
				  </tr>
				</tbody>
				</table> 
        <div class="apparel_text" style=" width:244px;">
          <p><?=$storeres['title']?></p>
		  <?php
					$offerprice2 = $cms->getSingleresult("select offerprice from #_barnds_product where prod_id = '".$storeres[pid]."' and store_user_id = '".$current_store_user_id."'");
					if($offerprice2){
						$storeres['offerprice'] = $offerprice2;
					}
				    ?>
         <span><?php if($storeres['price']>$storeres['offerprice']){?><span>Rs.<?=$storeres['price']?></span> Rs. <?=$storeres['offerprice']?> <?php }
						else {?> Rs.<?=$storeres['price']?> <?php }?> </span></br>  
						<?php
						if($storeres['offerprice']){
							$ded = $storeres['price'] - $storeres['offerprice'];
							$per = ceil(($ded*100)/$storeres['price'])?>
						<a href="<?=SITE_PATH?>domain/<?=$url?>/detail/<?=$adm->baseurl($storeres['title'])?>/<?=$storeres['pid']?>">BUY NOW</a> 
	<?php $check = $cms->getSingleresult("select count(*) from #_product_compare where  ssid = '".session_id()."' and product_id = '".$storeres['pid']."' "); ?>
	<p style="color:black"><input type="checkbox" <?=($check)?'checked':''?> value="<?=$storeres['pid']?>" class="cmp">Add To Compare</p>
		<?php if($storeres['combo']){ 
				$com = explode(',',$storeres['combo']);
				foreach($com as $val){
				$fretit = $cms->getSingleresult("select title from #_products_user where pid = '$val'");
				$freprice = $cms->getSingleresult("select offerprice from #_products_user where pid = '$val'")?>
				<p><span style="color:#003366">FREE <?=$fretit?> worth RS. <?=$freprice?></span><br /></p>
				<?php 
					}
				} 
						}?>
	   
	   </div>
      </div>
<?php $i++;
			  }
	  }
}
else{
	?><a>No Record Found</a><?
}