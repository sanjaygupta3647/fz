<div class="span_1_of_left"  >
 
	<?php 
  $qry = $cms->db_query("select cat_id, name from #_store_menu where cat_id in (".implode(',',$catsIds).")  and store_user_id = '$current_store_user_id' order by 
	name asc"); 
  if(mysql_num_rows($qry)){ ?> 
  <section  class="sky-form">
    <h4>Product Categories</h4>
    <div class="row2 row1 scroll-pane"><?php
     while($subcat=$cms->db_fetch_array($qry)){?>
      <div class="col col-4">
		<label class="checkbox">
		  <?php 
	      //$total =$cms->getStoreProductByCatid($subcat[cat_id],$current_store_user_id);
		  $total =$cms->getSingleresult("select count(*) from fz_products_user where pid in (".implode(',',$prod_arr).") and cat_id = '".$subcat[cat_id]."' ");?>
		  <input type="radio" <?=($subcat[cat_id] == $_GET[category])?'checked="checked"':'' ?> class="refine"  name="category" value="<?=$subcat[cat_id]?>" >
		  <i></i><?=$subcat[name]?>(<?=$total?>)</label>
	  </div>  <?php }?>
     </div> 
  </section> <?php }?>

   
 
  <section  class="sky-form">
    <h4>Price</h4>
    <div class="row2 row1 scroll-pane">      
      <div class="col col-4"><?php  
		if(!count($lft)) $lft[] = 0;
		$maxPrice = $cms->roundUptoNearestN($cms->getSingleresult("select max(dofferprice) from #_product_price where proid in(".implode(',',$prod_arr).") "));  
		$minPrice =  (int)$cms->getSingleresult("select min(dofferprice) from #_product_price where proid in(".implode(',',$prod_arr).")   "); 
		$var = $cms->roundUptoNearestN($maxPrice/5);   
		$k = 1;
		 
		for($i=$minPrice;$i<$maxPrice;$i=$i+$var){
			$sum = $i+$var;
			$start = 1+$i;
			if($k==1){
				$getQty = $cms->getSingleresult("select count(DISTINCT proid) from #_product_price where proid in(".implode(',',$lft).")   and dofferprice >=$i  and dofferprice < $sum ");
				$range = $i.'-'.$sum;
				?><label class="checkbox"><input type="radio" class="refine" <?=($_GET[price]==$range)?'checked="checked"':''?> name="price"  value="<?=$range?>"><i></i>Rs <?=$i?> - Rs <?=$sum?>(<?=$getQty?>)</label><?php
			}else if($k==5){
					$range = $start.'-'.$maxPrice;
					$getQty = $cms->getSingleresult("select count(DISTINCT proid) from #_product_price where proid in(".implode(',',$lft).")   and dofferprice >=$start  and dofferprice < $maxPrice ");
				?><label class="checkbox"><input type="radio" class="refine" <?=($_GET[price]==$range)?'checked="checked"':''?> name="price"  value="<?=$range?>"><i></i>Rs <?=$start?> - Rs <?=$maxPrice?>(<?=$getQty?>)</label><?php
			}else{ 
					$range = $start.'-'.$sum;
					$getQty = $cms->getSingleresult("select count(DISTINCT proid) from #_product_price where proid in(".implode(',',$lft).")   and dofferprice >=$start  and dofferprice < $sum ");
				?><label class="checkbox"><input type="radio" class="refine" <?=($_GET[price]==$range)?'checked="checked"':''?> name="price"  value="<?=$range?>"><i></i>Rs <?=$start?> - Rs <?=$sum?>(<?=$getQty?>)</label><?php
			}
			$k++;
			 
		}
			
			?>
         
      </div>
    </div>
  </section> 
  <?php  
	$catspid[] = 0;  
	$catsp = $cms->db_query("select parent  from #_store_menu where cat_id in (".implode(',',$catsIds).") group by parent ");
	if(mysql_num_rows($catsp)){
		  while($rs=$cms->db_fetch_array($catsp)){
			$catspid[] = $rs[parent];
		  }
	} 
	$catspid = array_unique($catspid); 
	$specQry = $cms->db_query("select specifications from #_category where pid in (".implode(',',$catspid).") "); 
	if(mysql_num_rows($specQry)){
		  while($spec=$cms->db_fetch_array($specQry)){
			$specifications .= $spec[specifications].",";
		  }
	}
	 
	 
	$qrysnew = $cms->db_query("select pid from fz_products_user where  pid in (".implode(',',$lft).") $cond ");
	$filter = array();
	if(mysql_num_rows($qrysnew)){
		while($resnew1=$cms->db_fetch_array($qrysnew)){
				$filter[] = $resnew1[pid];
		} 
	}  
	if(!count($filter)) $filter[] = 0; 
	$specifications = substr($specifications,0,-1); 
	if($specifications){ 
		$spe = explode(',',$specifications);
		$spe = array_unique($spe);  
		$spec = array();
		foreach($spe as $vals){
			if($vals!=""  and !in_array(strtolower(trim($vals)),$spec)){
				$spec[] = strtolower(trim($vals));
				$arrfd = array(); 
				$feature  = "select t1.fdescription from #_product_feature as t1, #_products_user as t2 where t1.ftitle = '$vals' and t2.pid = t1.prod_id and t1.prod_id in  (".implode(',',$filter).") group by t1.fdescription"; 
				$getQry = $cms->db_query($feature);
				$gtot = mysql_num_rows($getQry);
				if($gtot){ 
					$c = 1;
					?><section  class="sky-form"><h4><?=$vals?></h4><div class="row2 row1 scroll-pane"> <?php
					while($resf=$cms->db_fetch_array($getQry)){ extract($resf);
						$sub = trim($fdescription);  
						if($sub!="" and !in_array($sub,$arrfd)){  
							 $arrfd[] = $sub; 
							 $spcnt = $cms->getSingleresult("select count(*) from #_product_feature as t1, #_products_user as t2 where t1.ftitle = '$vals'  and  t1.fdescription = '$sub' and t1.prod_id in  (".implode(',',$filter).") and t1.prod_id = t2.pid "); 
							 
							 $vvl = $sub."type=".$vals;
							 $va = $vals."--".$sub; 
							 if($c==1){
								?>
								<?php 
							 }
							?>  
							  <div class="col col-4">
								<label class="checkbox">
								  <input type="checkbox" <?=(@in_array($va,$listspecification))?'checked="checked"':'' ?> class="refine specification"  name="specification" value="<?=$va?>" >
								  <i></i><?=substr($sub,0,25)?>(<?=$spcnt?>)</label>
							  </div>  
							  <?=($c==$gtot)?'':''?>
							 <?php 
								 $c++; 
							  
						}

					}echo'</div></section>';
				}
			}
		}
	}
  ?>

  
  
</div>

