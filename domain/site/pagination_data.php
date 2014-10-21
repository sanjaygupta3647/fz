<?php
$storesid = array();
$per_page = PRO_CAT_SIZE; 

if($_POST){
$page=$_POST['page'];
$qry=$_POST['qry'];
$url=$_POST['url'];
} 
 
$start = ($page-1)*$per_page;
echo $searchqry = " $qry limit $start,$per_page "; 
$searchexe = $cms->db_query($searchqry);

  if(mysql_num_rows($searchexe)){
	 while($storeres=$cms->db_fetch_array($searchexe))
				{   
					$status = $cms->getSingleresult("select status from #_barnds_product where prod_id = '".$storeres[pid]."' and store_user_id = '".$current_store_user_id."'");
					if($status=='Inactive'){
						$storeres[status] = 'Inactive';					
					}
					if($storeres[status]!='Inactive'){
					$img = SITE_PATH."image/noimg.jpg"; 
					//$w = ' width="160"';
					if(file_exists('../uploaded_files/orginal/'.$storeres['image1']) && $storeres['image1']!=""){
						$img = SITE_PATH."uploaded_files/orginal/".$storeres['image1'];
						$src = '../uploaded_files/orginal/'.$storeres['image1'];
						$siz = @getimagesize($src);
						if($siz[1]<160){
							$h = ' height="'.$siz[1].'"';
						}else{
 						$h = ' height="160"';
						}
					}else 
						if(file_exists('../uploaded_files/orginal/'.$storeres['image1']) && $storeres['image1']!=""){
						$img = SITE_PATH."uploaded_files/orginal/".$storeres['image1'];
						$src = '../uploaded_files/orginal/'.$storeres['image1'];
						$siz = @getimagesize($src);
						if($siz[1]<160){
						$h = ' height="'.$siz[1].'"';
						}else{
 						$h = ' height="160"';
						}
					}
					
					?>

<div class="apparel_main_div">
  <table width="150" height="160"  cellspacing="0" cellpadding="0" align="left">
    <tbody>
      <tr>
        <td align="center" valign="middle"><a href="<?=SITE_PATH?>domain/detail/<?=$adm->baseurl($storeres['title'])?>/<?=$storeres['pid']?>"> <img src="<?=$img?>" style="padding-left:20px;" <?=$h?> <?=$w?> title="<?=$storeres['title']?>" alt="<?=$storeres['title']?>" align="middle"/></a></td>
      </tr>
    </tbody>
  </table>
  <div class="apparel_text">
    <p> </p>
    <div class="view1_2" style="width: 355px;">
      <p style="line-height:15px; padding-left:20px; font-size:10px; text-align: left; font-weight:bold ">
        <?=$storeres['title']?>
      </p>
      <p style="background:url(<?=SITE_PATH?>domain/images/tickmark.png) left top no-repeat; line-height:15px; padding-left:20px; font-size:10px; text-align: left;<?=($storeres[kf1]=="")?'display:none':''?>">
        <?=$cms->removeSlash($storeres[kf1])?>
      </p>
      <p style="background:url(<?=SITE_PATH?>domain/images/tickmark.png) left top no-repeat; line-height:15px; padding-left:20px; font-size:10px; text-align: left; text-align: left;<?=($storeres[kf2]=="")?'display:none':''?>">
        <?=$cms->removeSlash($storeres[kf2])?>
      </p>
      <p style="background:url(<?=SITE_PATH?>domain/images/tickmark.png)  left top no-repeat; line-height:15px; padding-left:20px; font-size:10px; text-align: left;<?=($storeres[kf3]=="")?'display:none':''?>">
        <?=$cms->removeSlash($storeres[kf3])?>
      </p>
    </div>
    <?php
					$offerprice2 = $cms->getSingleresult("select offerprice from #_barnds_product where prod_id = '".$storeres[pid]."' and store_user_id = '".$current_store_user_id."'");
					if($offerprice2){
						$storeres['offerprice'] = $offerprice2;
					}
				    ?>
    <div class="view1_2" style="width: 355px;">
      <p style=" line-height:15px; padding-left:20px; font-size:10px; text-align: left; "> <span>
        <?php if($storeres['price']>$storeres['offerprice']){?>
        <span>Rs.
        <?=$storeres['price']?>
        </span> Rs.
        <?=$storeres['offerprice']?>
        <?php }
						else {?>
        Rs.
        <?=$storeres['price']?>
        <?php }?>
        </span> <a href="<?=SITE_PATH?>domain/detail/<?=$adm->baseurl($storeres['title'])?>/<?=$storeres['pid']?>">BUY NOW</a> </p>
      <?php $check = $cms->getSingleresult("select count(*) from #_product_compare where  ssid = '".session_id()."' and product_id = '".$storeres['pid']."' "); ?>
      <p style="line-height:15px; padding-left:18px; font-size:10px; text-align: left; ">
        <input type="checkbox" <?=($check)?'checked':''?> value="<?=$storeres['pid']?>" class="cmp">
        Add To Compare</p>
    </div>
  </div>
</div>
<?php $i++;
			  }
	  }
}
else{
	?>
<a>No Record Found</a><?
}