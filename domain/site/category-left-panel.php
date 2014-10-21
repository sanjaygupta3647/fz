<div class="span_1_of_left"><!----Add this code for active left scrolling moovable 'id="container_box3"'--->
 <section  class="sky-form">
    <h5 class="m_1">Parent Categories</h5>
    <div class="row2 row1 scroll-pane">
	<?php
	$getPar = $cms->getSingleresult("select parent from #_store_menu where cat_id = '".$items[2]."' and store_user_id = '$current_store_user_id' ");
    if(!$getPar){
    	$getPar = $items[2];
    }
	$getPname = $cms->db_query("select name,cat_id from #_store_menu where parent = '0' and store_user_id = '$current_store_user_id' order by porder");
	if(mysql_num_rows($getPname)){ ?>
    	<select class="dropdown dropdowncat" tabindex="8" data-settings='{"wrapperClass":"metro"}'> 
		 <?php
		while($pcat=$cms->db_fetch_array($getPname)){
			//$total =$cms->getStoreProductByCatid($pcat[cat_id],$current_store_user_id);?>
			<option value="<?=$pcat[cat_id]?>" <?=($getPar==$pcat[cat_id])?'selected':''?>><?=$cms->removeSlash($pcat[name])?> </option><?php
		}?>
        </select><?php	 
	      
	}
    ?> 
    </div>
  </section>

  <section  class="sky-form">
    <h5 class="m_1">Sub Categories</h5>
    <div class="row2 row1 scroll-pane"><?php 
	$qry = $cms->db_query("select cat_id, name from #_store_menu where parent = '".$getPar."' and store_user_id = '$current_store_user_id' order by 
	porder asc"); 
	$getPname = $cms->getSingleresult("select name from #_store_menu where cat_id = '".$getPar."' and store_user_id = '$current_store_user_id' ");
	if(mysql_num_rows($qry)){ ?> 
    	<select class="dropdown dropdowncat" tabindex="8" data-settings='{"wrapperClass":"metro"}'>
		 <option value="<?=$getPar?>" >All</option>
		 <?php
		while($subcat=$cms->db_fetch_array($qry)){
			$total =$cms->getStoreProductByCatid($subcat[cat_id],$current_store_user_id);?>
			<option value="<?=$subcat[cat_id]?>" <?=($items[2]==$subcat[cat_id])?'selected':''?>><?=$cms->removeSlash($subcat[name])?>(<?=$total?>)</option><?php
		}?>
        </select><?php	
	}
      
	 
    ?> 
    </div>
  </section>
 
  <section  class="sky-form">
    <h4>Price</h4>
    <div class="row2 row1 scroll-pane">      
      <div class="col col-4"><?php 
	   if(($key = array_search(0, $prods)) !== false && count($prods)>1) {
			unset($prods[$key]);
		}
		if(($key = array_search(0, $lft)) !== false && count($lft)>1) {
			unset($lft[$key]);
		}
		if(!count($prods)) $prods[] = 0;
		$maxPrice = $cms->roundUptoNearestN($cms->getSingleresult("select max(dofferprice) from #_product_price where proid in(".implode(',',$prods).") "));  
		$minPrice =  (int)$cms->getSingleresult("select min(dofferprice) from #_product_price where proid in(".implode(',',$prods).")   "); 
		$var = $cms->roundUptoNearestN($maxPrice/5);   
		$k = 1;
		 
		for($i=$minPrice;$i<$maxPrice;$i=$i+$var){
			$sum = $i+$var;
			$start = 1+$i;
			if($k==1){
				//$getQty = $cms->getSingleresult("select count(DISTINCT proid) from #_product_price where proid in(".implode(',',$prods).")   and dofferprice >=$i  and dofferprice < $sum ");
				$getQty = count($cms->getProductCountByPrice($prods,$i,$sum,$current_store_user_id));
				$range = $i.'-'.$sum;
				?><label class="checkbox"><input type="radio" class="refine" <?=($_GET[price]==$range)?'checked="checked"':''?> name="price"  value="<?=$range?>"><i></i>Rs <?=$i?> - Rs <?=$sum?>(<?=$getQty?>)</label><?php
			}else if($k==5){
					$range = $start.'-'.$maxPrice;
					//$getQty = $cms->getSingleresult("select count(DISTINCT proid) from #_product_price where proid in(".implode(',',$prods).")   and dofferprice >=$start  and dofferprice < $maxPrice ");
					$getQty = count($cms->getProductCountByPrice($prods,$start,$maxPrice,$current_store_user_id));
				?><label class="checkbox"><input type="radio" class="refine" <?=($_GET[price]==$range)?'checked="checked"':''?> name="price"  value="<?=$range?>"><i></i>Rs <?=$start?> - Rs <?=$maxPrice?>(<?=$getQty?>)</label><?php
			}else{ 
					$range = $start.'-'.$sum;
					//$getQty = $cms->getSingleresult("select count(DISTINCT proid) from #_product_price where proid in(".implode(',',$prods).")   and dofferprice >=$start  and dofferprice < $sum ");
					$getQty = count($cms->getProductCountByPrice($prods,$start,$sum,$current_store_user_id));
				?><label class="checkbox"><input type="radio" class="refine" <?=($_GET[price]==$range)?'checked="checked"':''?> name="price"  value="<?=$range?>"><i></i>Rs <?=$start?> - Rs <?=$sum?>(<?=$getQty?>)</label><?php
			}
			$k++;
			 
		}
			
			?>
         
      </div>
    </div>
  </section>

  <?php
   /******************BRAND********************/
   $qrysnew = $cms->db_query("select pid from fz_products_user where  pid in (".implode(',',$lft).") $cond ");
	$filter1[] = 0;
	if(mysql_num_rows($qrysnew)){
		while($resnew1=$cms->db_fetch_array($qrysnew)){
				$filter1[] = $resnew1[pid];
		} 
	}
    $brandQry = $cms->db_query("select brand_id from #_request_brand where store_user_id='$current_store_user_id' and status ='Active' ");
    if(mysql_num_rows($brandQry)){?>		 
		<section  class="sky-form">
		<h4>Brands<?=$brtot?></h4><div class="row2 row1 scroll-pane"><?php
		while($brandslist=$cms->db_fetch_array($brandQry)){ 
				$cntbrand = $cms->getSingleresult("select count(DISTINCT prod_id) from #_barnds_product where store_user_id='$current_store_user_id' and brand_id = '".$brandslist[brand_id]."'	and status = 'Active' and  cat_id in (".implode(',',$prod_subcat_arr).") and prod_id in(".implode(',',$filter1).")  "); 
				 if($cntbrand){?>
					<div class="col col-4">
						<label class="checkbox">
						  <input type="radio" class="refine" <?=($_GET[brand]==$brandslist[brand_id])?'checked="checked"':''?> name="brand"  value="<?=$brandslist[brand_id]?>" >
						  <i></i><?=$cms->getSingleresult("select title from #_store_detail where store_user_id = '".$brandslist[brand_id]."'")?>(<?=$cntbrand?>)</label>
					</div><?php					
				 }
		}echo "<div></section>";
	}



	/******************BRAND********************/
	$catspid[] = $items[2];
	$pcategory = $cms->db_query("select pid from #_category where parentId = '".$items[2]."'"); 
	if(mysql_num_rows($pcategory)){
		  while($resp=$cms->db_fetch_array($pcategory)){
			$catspid[] = $resp[pid];
		  }
	}
	$catsp = $cms->getSingleresult("select parentId  from #_category where pid = '".$items[2]."'");
	if($catsp) $catspid[]= $catsp;
	$catspid = array_unique($catspid);
	$specQry = $cms->db_query("select specifications from #_category where pid in (".implode(',',$catspid).") "); 
	if(mysql_num_rows($specQry)){
		  while($spec=$cms->db_fetch_array($specQry)){
			$specifications .= $spec[specifications].",";
		  }
	}
	//$cond = 0;
	$brandsPro[] = 0;
	/*
	if($_GET[brand]){	
		$cond = 1; 
		$brandProds = $cms->db_query("select prod_id from #_barnds_product where store_user_id='$current_store_user_id' and  brand_id = '".$_GET[brand]."' and cat_id in  (".implode(',',$prod_subcat_arr).") ");			
		if(mysql_num_rows($brandProds)){
			  while($res=$cms->db_fetch_array($brandProds)){
				$brandsPro[] = $res[prod_id];
			  }
		}  
		$condnew1 .= " and pid in (".implode(',',$brandsPro).") ";  
	}
	if($_GET[price]!=""){
		$cond = 1;
		$arr = explode('-',$_GET[price]);
		if(count($arr)>1){
			 $condnew1 .= " and dprice>=".$arr[0]." and dofferprice <=".$arr[1];
			}else{
			 $condnew1 .= " and dprice > ".$_GET[price]." ";
		}
					
	}*/
	 
	 
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
				$feature  = "select t1.fdescription from #_product_feature as t1, #_products_user as t2 where t1.ftitle = '$vals' and t2.pid = t1.prod_id and t1.prod_id in  (".implode(',',$prods).") group by t1.fdescription"; 
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
  <!-- 
  <section  class="sky-form">
    <h4>Colors</h4>
    <ul class="color-list">
      <li class="selected_col"><a href="#"><span class="color c1"></span></a></li>
      <li><a href="#"><span class="color c2"></span></a></li>
      <li><a href="#"><span class="color c3"></span></a></li>
      <li class="selected_col"><a href="#"><span class="color c4"></span></a></li>
      <li><a href="#"><span class="color c5"></span></a></li>
      <li><a href="#"><span class="color c6"></span></a></li>
      <li><a href="#"><span class="color c7"></span></a></li>
    </ul>
  </section>-->
</div>

