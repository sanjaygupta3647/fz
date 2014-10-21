<?php
$style = 'style="color:brown; font-weight: bold;"';
 $getproduct_sub_category = $cms->db_query("select cat_id  from #_barnds_product where brand_id = '".$items[2]."' and store_user_id = '$current_store_user_id'");
$prod_subcat_arr = array();
if(mysql_num_rows($getproduct_sub_category)){
	  while($res=$cms->db_fetch_array($getproduct_sub_category)){
		$prod_subcat_arr[] = $res[cat_id];
	  }
}
$prod_subcat_arr = array_unique($prod_subcat_arr);
 ?>
<div  class="main_matter_area">
  <div class="main_text_brdr_none">
    <div class="left_refine_search">
      <div class="left_refine_search1"><span class="catmenue" style="">Refine Your Search</span></div>
      <div class="left_refine_search2"> 
        <b>Subcategory</b> 
		<?php
		$qry = $cms->db_query("select pid, name from #_category where pid in (".implode(',',$prod_subcat_arr).")  ");
		if(mysql_num_rows($qry)){
			 while($subcat=$cms->db_fetch_array($qry)){?>
			 <a <?=($items[2]==$subcat[pid])?$style:''?> href="<?=SITE_PATH?>domain/<?=$items[0]?>/brand-product/<?=$subcat[pid]?>/<?=$items[3]?>"><?=$cms->removeSlash($subcat[name])?>
			 <?php
 			 $t2 = $cms->getSingleresult("select count(*) from #_barnds_product where store_user_id='$current_store_user_id' and brand_id = '".$items[3]."' and status = 'Active' and cat_id ='".$subcat[pid]."' ");
			 ?>
			 (<?=$t2?>)</a>
			 <?php
			 }
		} 
		?>
		 
		
		</div>
      <div class="left_refine_search3">
        
        <ul>
        <?php
		$brandQry = $cms->db_query("select brand_id from #_request_brand where store_user_id='$current_store_user_id' and status ='Active' ");
		if(mysql_num_rows($brandQry)){
			$show = 0;			
			 while($brandslist=$cms->db_fetch_array($brandQry)){
					$brandcat = array();
					$getplan = $cms->getSingleresult("select plan_id from #_store_detail where pid = '".$brandslist[brand_id]."'");
					$brand_cat=$cms->db_query("select cat_id from #_plans_category where plan_id='".$getplan."' and parent!='0'");
					while($brand_cats=$cms->db_fetch_array($brand_cat)){
						$brandcat[] = $brand_cats[cat_id];
						$brand_cat2=$cms->db_query("select pid from #_category where parentId='".$brand_cats[cat_id]."' ");
						if(mysql_num_rows($brand_cat2)){
							while($brand_cats2=$cms->db_fetch_array($brand_cat2)){
								$brandcat[] = $brand_cats2[pid];
							}
						}
					}
				 $brandcat = array_unique($brandcat);
				 if(in_array($items[2],$brandcat)){
				 if(!$show){?>				 
				 <h3>Brand(s)</h3><?php
					$show++;
				 }?>
				 <li><a <?=($items[3]==$brandslist[brand_id])?$style:''?> href="<?=SITE_PATH.'domain/'.$items[0]?>/brand-product/<?=$items[2]?>/<?=$brandslist[brand_id]?>"><?=$cms->getSingleresult("select title from #_store_detail where pid = '".$brandslist[brand_id]."'")?>(<?=$cms->getSingleresult("select count(*) from #_barnds_product where store_user_id='$current_store_user_id' and brand_id = '".$brandslist[brand_id]."'	and status = 'Active' and  cat_id in (".implode(',',$prod_subcat_arr).") ")?>)</a></li>
				 <?php
				 }
			}
		} 
		?> 
        </ul>
        <div class="price_range">
          <ul>
            
			<?php 
			$brandProds = $cms->db_query("select prod_id from #_barnds_product where store_user_id='$current_store_user_id' and brand_id  = '".$items[3]."' and cat_id in  (".implode(',',$prod_subcat_arr).") ");
			$brandsp = array();
			if(mysql_num_rows($brandProds)){
				  while($res=$cms->db_fetch_array($brandProds)){
					$brandsp[] = $res[prod_id];
				  }
			}
 			if(count($brandsp)){
				$pricond = " pid in (".implode(',',$brandsp).") ";
				$maxPrice2 =  $cms->roundUptoNearestN($cms->getSingleresult("select max(offerprice) from #_products_user where pid in (".implode(',',$brandsp).") and status = 'Active' and 
				cat_id in (".implode(',',$prod_subcat_arr).") ")); 
				$minPrice2 = $cms->getSingleresult("select min(offerprice) from #_products_user where pid in (".implode(',',$brandsp).") and status = 'Active' and  cat_id in (".implode(',',$prod_subcat_arr).") "); 
				if(!$maxPrice || $maxPrice2>$maxPrice){
					$maxPrice = $maxPrice2;
				}
				if(!$minPrice || $minPrice2<$minPrice){
					$minPrice = $minPrice2;
				}
			}
 			//if(!$minPrice){$minPrice = 10;}  
			$var = $cms->roundUptoNearestN($maxPrice/5);
			
			if($maxPrice){ 
			echo '<h3>Price Range</h3>';
			 
			$range1 = $minPrice/2;		 
			$range2 = $minPrice;	
			$range =$range1.'-'.$range2;
			?>
			<li><a <?=($items[4]==$range)?$style:''?> href="<?=SITE_PATH.'domain/'.$items[0]?>/brand-product/<?=$items[2]?>/<?=$items[3]?>/<?=$range?>">
			<?php
			if($pricond){
			$rQry = "select count(*) from #_products_user where (store_user_id='$current_store_user_id' or $pricond ) 	and status = 'Active' and cat_id in (".implode(',',$prod_subcat_arr).")   and offerprice >=$range1  and offerprice <= $range2 ";			
			}else{			
			$rQry = "select count(*) from #_products_user where store_user_id='$current_store_user_id' and status = 'Active' and cat_id in (".implode(',',$prod_subcat_arr).")   and offerprice >=$range1  and offerprice <= $range2 ";			
			}
			
			?>
			<?=CUR. " ".$range1 .' To '.$range2?> (<?=$cms->getSingleresult($rQry)?>)</a></li> 
			<?php
			}
			for($i=$minPrice;$i<$maxPrice;$i=$i+$var){
			$range1 = $i+1;
			$sum = $i+$var;
			$range2 = $sum;			
			if($loop==5){
			$range = $range2;
			if($pricond){
				$rQry1 = "select count(*) from #_products_user where (store_user_id='$current_store_user_id' or $pricond ) 	and status = 'Active' and cat_id in (".implode(',',$prod_subcat_arr).")    and offerprice > $range ";			
				}else{			
				$rQry1 = "select count(*) from #_products_user where store_user_id='$current_store_user_id' and status = 'Active' and cat_id in (".implode(',',$prod_subcat_arr).")   and offerprice >= $range   ";			
				}
				?>
				 <li><a <?=($items[4]==$range)?$style:''?> href="<?=SITE_PATH.'domain/'.$items[0]?>/brand-product/<?=$items[2]?>/<?=$items[3]?>/<?=$range?>"><?=' More Then '.CUR. " ".($range)?> (<?=$cms->getSingleresult($rQry1)?>)</a></li> 
				<?php
			}else{
				$range = $range1.'-'.$range2;
				if($pricond){
				$rQry2 = "select count(*) from #_products_user where (store_user_id='$current_store_user_id' or $pricond ) 	and status = 'Active' and cat_id in (".implode(',',$prod_subcat_arr).")   and offerprice >= $range1  and offerprice <= $range2 ";			
				}else{			
				$rQry2 = "select count(*) from #_products_user where store_user_id='$current_store_user_id' and status = 'Active' and cat_id in (".implode(',',$prod_subcat_arr).")   and offerprice >= $range1  and offerprice <= $range2 ";			
				}

				?>
				 <li ><a  <?=($items[4]==$range)?$style:''?> href="<?=SITE_PATH.'domain/'.$items[0]?>/brand-product/<?=$items[2]?>/<?=$items[3]?>/<?=$range?>"><?=CUR." ".$range1.' To '.CUR. " ".$range2?> (<?=$cms->getSingleresult($rQry2)?>)</a></li> 
				<?php
				} 
				$loop++;
			}
			?> 
          </ul>
        </div>
       <div class="product_text">
		  <h3>Product Category</h3>
          <ul>
		  <?php  
		  $cateqry=$cms->db_query("select cat_id from #_plans_category where plan_id='$current_plan_id' and parent!='0' order by pid desc");
		  if(mysql_num_rows($cateqry)){ 
		  while($catRes=$cms->db_fetch_array($cateqry)){?>
			  <li><a <?=($items[2]==$catRes[cat_id])?$style:''?> href="<?=SITE_PATH?>domain/<?=$items[0]?>/category-product/<?=$catRes[cat_id]?>">
			  <?=$cms->removeSlash($cms->getSingleresult("select name from #_category where pid = '".$catRes[cat_id]."'"))?></a></li>
			  <?php
			  }
		  }
		  ?> 
          </ul>
        </div> 
      </div>
    </div>
    
    <div class="apparel_paging2">
      
      <?php /*?><div class="right"> <a href="#">>></a> <a href="#">>></a> <a href="#">5</a> <a href="#">4</a> <a href="#">3</a> <a href="#">2</a> <a href="#">1</a> </div><?php */?>
    </div>
    <div class="apparel_paging3">
	<div style="width:100%" class="main_text_areain_apparel">
        <h3><?=$cms->removeSlash($cms->getSingleresult("select title from #_store_detail where store_user_id = '".$items[2]."'"))?>
		<? //($items[3]=='sub-cat' &&  $items[4]>0)?' >> ' .$cms->removeSlash($cms->getSingleresult("select name from #_category where pid = '".$items[4]."'")):''?>
		 <? //($items[3]!='sub-cat' &&  $items[4]==0)?'Price Range : '.CUR. '' .$items[3]:''?>
		</h3>
      </div>
	<?php 
		
		$brandProds = $cms->db_query("select prod_id from #_barnds_product where store_user_id='$current_store_user_id' and cat_id in  (".implode(',',$prod_subcat_arr).") and brand_id = '".$items[2]."' ");
		$brandsp = array();
		if(mysql_num_rows($brandProds)){
			  while($res=$cms->db_fetch_array($brandProds)){
				$brandsp[] = $res[prod_id];
			  }
		}
		if($items[4]>0){
			$arr = explode('-',$items[4]);
			if(count($arr)>1){
				 $cond = " and offerprice>=".$arr[0]." and offerprice <=".$arr[1];
				}else{
					$cond = " and offerprice>".$items[4]." ";
			}		
		}
		 
	if(count($brandsp)){ 
	$storeQry = "select pid,status,title,clicks,image1,price,offerprice from #_products_user where 
	 status = 'Active' and cat_id in  (".implode(',',$prod_subcat_arr).") and   pid in  (".implode(',',$brandsp).")  $cond order by pid desc"; 
		
		 
 	  $i =1;  
	  $store=$cms->db_query($storeQry);  
 	  if(mysql_num_rows($store)){ 
	  while($storeres=$cms->db_fetch_array($store))
				{   
					$status = $cms->getSingleresult("select status from #_barnds_product where prod_id = '".$storeres[pid]."' and store_user_id = '".$current_store_user_id."'");
					if($status=='Inactive'){
						$storeres[status] = 'Inactive';					
					}
					if($storeres[status]!='Inactive'){
					$img = SITE_PATH."uploaded_files/orginal/no-img.gif";
					if(file_exists('../uploaded_files/orginal/'.$storeres['image1']) && $storeres['image1']!="")
					{
						  $img = SITE_PATH."uploaded_files/orginal/".$storeres['image1'];
					}?>
      <div class="apparel_main_div"><a href="<?=SITE_PATH?>domain/<?=$items[0]?>/detail/<?=$adm->baseurl($storeres['title'])?>/<?=$storeres['pid']?>">
	  <img src="<?=$img?>" width="150"  height="160" title="<?=$storeres['title']?>" alt="<?=$storeres['title']?>"/>
        <div class="apparel_text">
          <p><?=$storeres['title']?></p>
		  <?php
					$offerprice2 = $cms->getSingleresult("select offerprice from #_barnds_product where prod_id = '".$storeres[pid]."' and store_user_id = '".$current_store_user_id."'");
					if($offerprice2){
						$storeres['offerprice'] = $offerprice2;
					}
				    ?>
         <span><?php if($storeres['offerprice']){?><span>Rs.<?=$storeres['price']?></span> Rs. <?=$storeres['offerprice']?> <?php }
						else {?> Rs.<?=$storeres['price']?> <?php }?> </span></br>  
        <a href="<?=SITE_PATH?>domain/<?=$items[0]?>/detail/<?=$adm->baseurl($storeres['title'])?>/<?=$storeres['pid']?>">BUY NOW</a></div>
      </div>
	  <?php $i++;
			  }
				}
		}
	}else{
		
		echo '<div class="apparel_text"> <p>No Product In This Category</p></div> ';
		}?>
    </div>
  </div>
 </div>
