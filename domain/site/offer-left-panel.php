<div class="span_1_of_left"  >
 
<?php 
$getPar = $cms->getSingleresult("select parent from #_store_menu where cat_id = '".$items[2]."' and store_user_id = '$current_store_user_id' ");
if(!$getPar){
	$getPar = $items[2];
}
$getPname = $cms->db_query("select name,cat_id from #_store_menu where parent = '0' and store_user_id = '$current_store_user_id' order by porder");
if(mysql_num_rows($getPname)){  
	$catarr[] = 0;
	$sql = $cms->db_query("select cat_id from fz_products_user where pid in (".implode(',',$prod_arr).")  group by cat_id");
	if(mysql_num_rows($sql)){
		while($rs=$cms->db_fetch_array($sql)){
				$catarr[]  = $rs[cat_id];
		}
	} 
}
 
$qry = $cms->db_query("select cat_id, name from #_store_menu where cat_id in (".implode(',',$catarr).")  and store_user_id = '$current_store_user_id' order by 
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
				 
				//$getQty = $cms->getSingleresult("select count(DISTINCT proid) from #_product_price where proid in(".implode(',',$lft).")   and dofferprice >=$i  and dofferprice < $sum ");
				$getQty = count($cms->getProductCountByPrice($prod_arr,$i,$sum,$current_store_user_id));
				$range = $i.'-'.$sum;
				?><label class="checkbox"><input type="radio" class="refine" <?=($_GET[price]==$range)?'checked="checked"':''?> name="price"  value="<?=$range?>"><i></i>Rs <?=$i?> - Rs <?=$sum?>(<?=$getQty?>)</label><?php
			}else if($k==5){
					$range = $start.'-'.$maxPrice;
					//$getQty = $cms->getSingleresult("select count(DISTINCT proid) from #_product_price where proid in(".implode(',',$lft).")   and dofferprice >=$start  and dofferprice < $maxPrice ");
					$getQty = count($cms->getProductCountByPrice($prod_arr,$start,$maxPrice,$current_store_user_id));
				?><label class="checkbox"><input type="radio" class="refine" <?=($_GET[price]==$range)?'checked="checked"':''?> name="price"  value="<?=$range?>"><i></i>Rs <?=$start?> - Rs <?=$maxPrice?>(<?=$getQty?>)</label><?php
			}else{ 
					$range = $start.'-'.$sum;
					//$getQty = $cms->getSingleresult("select count(DISTINCT proid) from #_product_price where proid in(".implode(',',$lft).")   and dofferprice >=$start  and dofferprice < $sum ");
					$getQty = count($cms->getProductCountByPrice($prod_arr,$start,$sum,$current_store_user_id));
				?><label class="checkbox"><input type="radio" class="refine" <?=($_GET[price]==$range)?'checked="checked"':''?> name="price"  value="<?=$range?>"><i></i>Rs <?=$start?> - Rs <?=$sum?>(<?=$getQty?>)</label><?php
			}
			$k++;
			 
		}
			
			?>
         
      </div>
    </div>
  </section>

  <?php
 //print_r($lft);
   /******************BRAND********************/
  /*$brandQry = $cms->db_query("select brand_id from #_request_brand where store_user_id='$current_store_user_id' and status ='Active' ");
    if(mysql_num_rows($brandQry)){?>		 
		<section  class="sky-form">
		<h4>Brands<?=$brtot?></h4><div class="row2 row1 scroll-pane"><?php
		while($brandslist=$cms->db_fetch_array($brandQry)){
				$cntbrand = $cms->getSingleresult("select count(prod_id) from #_barnds_product where store_user_id='$current_store_user_id' and brand_id = '".$brandslist[brand_id]."'	and status = 'Active' and  cat_id in (".implode(',',$prod_subcat_arr).") and prod_id in(".implode(',',$lft).")  "); 
				 if($cntbrand){?>
					<div class="col col-4">
						<label class="checkbox">
						  <input type="radio" class="refine" <?=($_GET[brand]==$brandslist[brand_id])?'checked="checked"':''?> name="brand"  value="<?=$brandslist[brand_id]?>" >
						  <i></i><?=$cms->getSingleresult("select title from #_store_detail where store_user_id = '".$brandslist[brand_id]."'")?>(<?=$cntbrand?>)</label>
					</div><?php					
				 }
		}echo "<div></section>";
	} */
	/******************BRAND********************/
	$catspid[] = 0; 
	 
	$catsp = $cms->db_query("select parent  from #_store_menu where cat_id in (".implode(',',$catarr).") group by parent ");
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
	 
	$brandsPro[] = 0;
	if($_GET[brand]){	
		foreach($listbrand as $v){
			$brndn[]	= " brand_id = '$v'	";
		}
		$brandProds = $cms->db_query("select prod_id from #_barnds_product where store_user_id='$current_store_user_id' and  (".implode(" or ",$brndn).") and cat_id in  (".implode(',',$prod_subcat_arr).") ");			
		if(mysql_num_rows($brandProds)){
			  while($res=$cms->db_fetch_array($brandProds)){
				$brandsPro[] = $res[prod_id];
			  }
		}  
		$condnew .= " and pid in (".implode(',',$brandsPro).") ";  
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
		$disp = 0;
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
					while($resf=$cms->db_fetch_array($getQry)){ extract($resf);
						$sub = trim($fdescription);  
						if($sub!="" and !in_array($sub,$arrfd)){  
							 $arrfd[] = $sub;
							  
							 $spcnt = $cms->getSingleresult("select count(*) from #_product_feature as t1, #_products_user as t2 where t1.ftitle = '$vals' and t1.prod_id in  (".implode(',',$filter).") and  t1.fdescription = '$sub' and t1.prod_id = t2.pid ");
							 if($spcnt){
								 $vvl = $sub."type=".$vals;
								 if($c==1){
									?><section  class="sky-form"><h4><?=$vals?></h4> 
									<?php 
								 }
								 $va = $vals."--".$sub; ?> 
								 <?=($c==1)?'<div class="row2 row1 scroll-pane">':''?>
								  <div class="col col-4">
									<label class="checkbox">
									  <input type="checkbox" <?=(@in_array($va,$listspecification))?'checked="checked"':'' ?> class="refine specification"  name="specification" value="<?=$va?>" >
									  <i></i><?=substr($sub,0,25)?>(<?=$spcnt?>)</label>
								  </div>  
								  <?=($c==$gtot)?'</div></section>':''?>
								 <?php 
									 $c++; $disp++; 
							 }  						  
							  
						}

					}
				}
			}
		}
	}
  ?>

   
  
</div>

