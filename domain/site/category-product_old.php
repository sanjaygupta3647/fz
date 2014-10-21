<?php
$getcatn = $cms->removeSlash($cms->getSingleresult("select name from #_store_menu where cat_id = '".$items[2]."' 
		  and store_user_id = '$current_store_user_id'"));
$ms = ucwords(strtolower( $getcatn." Product(s)"));
$metaTitle =  $ms;
$metaIntro = $ms ." on ".SITE_PATH;
$metaKeyword = $ms.",Category Product ,".SITE_PATH.",".str_replace(' ',',',$getcatn);
?>
<?php
$listbrand[]=0;
 if($_GET[brand]){
	$listbrand= explode(',',$_GET[brand]);
}

if($_GET[specification]){
	$listspecification= explode(',',$_GET[specification]);
}
 //echo $items[2],"sjdfj";die;
$style = 'style="color:brown; font-weight: bold;"';
$disable = 'disabled="disabled"';
$getproduct_sub_category = $cms->db_query("select cat_id from #_store_menu where parent = '".$items[2]."'");
$prod_subcat_arr = array();
if(mysql_num_rows($getproduct_sub_category)){
	  while($res=$cms->db_fetch_array($getproduct_sub_category)){
		$prod_subcat_arr[] = $res[cat_id];
	  }
}else{
	$prod_subcat_arr[] = $items[2];
}
$prods[] = 0;
$allprod =  $cms->db_query("select pid from fz_products_user  where store_user_id='$current_store_user_id' and status = 'Active' and cat_id in  (".implode(',',$prod_subcat_arr).")"); 
if(mysql_num_rows($allprod)){
				  while($userProd=$cms->db_fetch_array($allprod)){
					$prods[] = $userProd[pid];
				  }
}
$cond = "";
$brandProds = $cms->db_query("select prod_id from #_barnds_product where store_user_id='$current_store_user_id'  and cat_id in  (".implode(',',$prod_subcat_arr).") and status='Active' ");			
			if(mysql_num_rows($brandProds)){
				  while($res=$cms->db_fetch_array($brandProds)){
					$prods[] = $res[prod_id];
				  }
}  
/*new code start*/  
		$brandsP[] = 0; 
		if($_GET[brand]){	
			foreach($listbrand as $v){
				$brnd[]	= " brand_id = '$v'	";
			}
			 $brandProds = $cms->db_query("select prod_id from #_barnds_product where store_user_id='$current_store_user_id' and  (".implode(" or ",$brnd).") and cat_id in  (".implode(',',$prod_subcat_arr).") and  status='Active' ");			
			if(mysql_num_rows($brandProds)){
				  while($res=$cms->db_fetch_array($brandProds)){
					$brandsP[] = $res[prod_id];
				  }
			} 
			 
			$cond .= " and pid in (".implode(',',$brandsP).") "; 
			 
		} 
		
		if($_GET[price]!=""){
					$arr = explode('-',$_GET[price]);
					if(count($arr)>1){
						 $condnew = " and dofferprice>=".$arr[0]." and dofferprice <=".$arr[1];
						}else{
							$condnew .= " and dofferprice > ".$_GET[price]." ";
					}
					
		}	
		 
		if($_GET[specification]){	
				$condc = " and prod_id in  (".implode(',',$prods).") ";
				foreach($listspecification as $t){
					$vals = explode("--",$t); 
					$spe2[]	= " (ftitle = '".$vals[0]."'	and  fdescription = '".$vals[1]."')	";
				}
				if(count($spe2)){
					$condc .="and  (".implode(" or ",$spe2).") ";
				}
 				$specQry =  $cms->db_query("select prod_id from fz_product_feature where 1  $condc "); 
				if(mysql_num_rows($specQry)){
					  $specPro = array();
					  while($res21=$cms->db_fetch_array($specQry)){
						$specPro[] = $res21[prod_id];						 
					  }
				} 
			// print_r($specPro);die; 
			if(count($specPro)){
				 //echo "select * from fz_product_feature where prod_id in  (".implode(',',$specPro).")";die;
				  $cond .= " and pid in (".implode(',',$specPro).") "; 
			} 
		} 
		$storeQry1 = $cms->db_query("select pid  from #_products_user where pid in (".implode(',',$prods).") and status = 'Active' "); 
		$lft[] = 0;
		if(mysql_num_rows($storeQry1)){
				  while($res211=$cms->db_fetch_array($storeQry1)){
					$lft[] = $res211[pid];
				  }
		 }  
	    $storePrice = $cms->db_query("select proid  from fz_product_price where proid in (".implode(',',$lft).") $condnew order by proid asc"); 
		$lft1[] = 0;
		if(mysql_num_rows($storePrice)){
				  while($res211=$cms->db_fetch_array($storePrice)){
					$lft1[] = $res211[proid];
				  }
		 } 
		/*  for paging */
		$storeQryCnt = "select *  from fz_products_user where pid in (".implode(',',$lft1).") and status = 'Active'  $cond order by porder asc  ";
		$rec_per_page = 12;
		$storeQryCntrs = $cms->db_query($storeQryCnt);
		$counts = mysql_num_rows($storeQryCntrs);
		$totcontentpage = (int)(($counts/$rec_per_page)+1);  
		/*  for paging */ 
		$storeQry = "select *  from fz_products_user where pid in (".implode(',',$lft1).") and status = 'Active'  $cond order by porder asc limit 0, 12 ";

/*new code end*/
?>

<div  class="main_matter_area">
  <?php 
$_SESSION[catname]=$items[1];
$_SESSION[catid]=$items[2];
	 echo $cms->breadcrumbs(); 
       ?>
  <div class="main_text_brdr_none">
    <div class="left_refine_search" id="container_box">
      <div class="left_refine_search1"><span class="catmenue">Refine Your Search</span></div>
      <div class="left_refine_search2">
        <?php
			$getPar = $cms->getSingleresult("select parent from #_store_menu where cat_id = '".$items[2]."' and store_user_id = '$current_store_user_id' ");
			if(!$getPar){
				$getPar = $items[2];
			} 
			$qry = $cms->db_query("select cat_id, name from #_store_menu where parent = '".$getPar."' and store_user_id = '$current_store_user_id' order by porder asc"); 
			if(mysql_num_rows($qry)){ ?>
        <b>
        <?=$cms->removeSlash($cms->getSingleresult("select name from #_store_menu where cat_id = '".$getPar."' and store_user_id = '$current_store_user_id' "))?>
        </b> <b><a href="<?=SITE_PATH?>category-product/<?=$items[1]?>/<?=$items[2]?>">Reset Your Search</a></b>
        <?php         
				while($subcat=$cms->db_fetch_array($qry)){  
						//$total =$cms->getSingleresult("select count(*) from #_products_user where  cat_id ='".$subcat[cat_id]."' and 
						//pid in (".implode(',',$prods).")  "); 
						$total =$cms->getStoreProductByCatid($subcat[cat_id],$current_store_user_id);?>
        <a <?=($items[2]==$subcat[cat_id])?$style:''?> href="<?=SITE_PATH?>category-product/<?=$cms->baseurl21($subcat[name])?>/<?=$subcat[cat_id]?>"> --
        <?=$cms->removeSlash($subcat[name])?>
        (
        <?=$total?>
        )</a>
        <?php 
						 }
			} 
			?>
      </div>
      <div class="left_refine_search3">
        <div class="product_text">
          <h3>Product Category</h3>
          <ul>
            <?php  
		  $cateqry=$cms->db_query("select cat_id,name  from #_store_menu where parent = '0' and store_user_id = '$current_store_user_id' order by porder");
		  if(mysql_num_rows($cateqry)){ 
		  while($catRes=$cms->db_fetch_array($cateqry)){?>
            <li><a href="<?=SITE_PATH?>category-product/<?=$cms->baseurl21($cms->removeSlash($catRes[name]))?>/<?=$catRes[cat_id]?>">
              <?=$cms->removeSlash($catRes[name])?>
              </a></li>
            <?php
			  }
		  }
		  ?>
          </ul>
        </div>
      </div>
      <div class="price_range">
        <ul>
          <?php			
			$maxPrice = $cms->roundUptoNearestN($cms->getSingleresult("select max(dofferprice) from #_product_price where proid in(".implode(',',$prods).") "));  
			$minPrice =  $cms->roundUptoNearestN($cms->getSingleresult("select min(dofferprice) from #_product_price where proid in(".implode(',',$prods).")   ")); 
			$var = $cms->roundUptoNearestN($maxPrice/5);  
			if($maxPrice){ 
			echo '<h3  style="padding-left:0px; color:black">Price Range</h3>'; 
			$range1 = $minPrice/2;		 
			$range2 = $minPrice;	
			$range =$range1.'-'.$range2;
			$range0 ='1-'.($range1-1);
			$low = $range1-1;  
			?> 
		  <?php	 
			$cnts= $cms->getSingleresult("select count(DISTINCT proid) from #_product_price where proid in(".implode(',',$prods).") and dofferprice >=1  and dofferprice <= $low ");			 
			 
			?>
          <li>
            <input type="radio" class="refine" <?=($_GET[price]==$range0)?'checked="checked"':''?> <?=($_GET[price] && $_GET[price]==$range0)?'checked="checked"':''?>  name="price"  value="<?=$range0?>">
            <a <?=($_GET[price]==$range0)?$style:''?> href="#">
            <?=CUR. " ".'1 To '.$low?>
            (
            <?=$cnts?>
            )</a></li>
          <li>
            <input type="radio" class="refine" <?=($_GET[price]==$range)?'checked="checked"':''?> name="price"  value="<?=$range?>" />
            <a <?=($_GET[price]==$range)?$style:''?> href="#">
            <?php			 
			$rQry = "select count(DISTINCT proid) from #_product_price where proid in(".implode(',',$prods).")   and dofferprice >=$range1  and dofferprice <= $range2 ";			 
			?>
            <?=CUR. " ".$range1 .' To '.$range2?>
            (
            <?=$cms->getSingleresult($rQry)?>
            )</a></li>
          <?php
			}
			for($i=$minPrice;$i<$maxPrice;$i=$i+$var){
			$range1 = $i+1;
			$sum = $i+$var;
			$range2 = $sum;			
			if($loop==5){
			$range = $range2;
		 
				$rQry1 = "select count(DISTINCT proid) from #_product_price where proid in(".implode(',',$prods).")   and dofferprice > $range ";			
				 
				?>
          <li>
            <input type="radio" class="refine" <?=($_GET[price]==$range)?'checked="checked"':''?>  name="price" value="<?=$range?>">
            <a <?=($_GET[price]==$range)?$style:''?> href="#">
            <?=' More Then '.CUR. " ".($range)?>
            (
            <?=$cms->getSingleresult($rQry1)?>
            )</a></li>
          <?php
			}else{
				$range = $range1.'-'.$range2;				 
				$rQry2 = "select count(DISTINCT proid) from #_product_price where proid in(".implode(',',$prods).")  and dofferprice >= $range1  and dofferprice <= $range2 ";			
				 ?>
          <li >
            <input type="radio" class="refine" <?=($_GET[price]==$range)?'checked="checked"':''?>  name="price" value="<?=$range?>">
            <a  <?=($_GET[price]==$range)?$style:''?> href="#">
            <?=CUR." ".$range1.' To '.$range2?>
            (
            <?=$cms->getSingleresult($rQry2)?>
            )</a></li>
          <?php         
				} 
				$loop++;
			}
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
			$specifications = substr($specifications,0,-1); 
			?>
          <ul>
            <?php
		$brandQry = $cms->db_query("select brand_id from #_request_brand where store_user_id='$current_store_user_id' and status ='Active' ");
		if(mysql_num_rows($brandQry)){
			$show = 0;			
			 while($brandslist=$cms->db_fetch_array($brandQry)){	 
				 $brandprodQry = $cms->db_query("select prod_id from #_barnds_product where store_user_id='$current_store_user_id' and brand_id = '".$brandslist[brand_id]."'	and status = 'Active' and  cat_id in (".implode(',',$prod_subcat_arr).") and prod_id in(".implode(',',$prods).")  ");
				 $cntpro = mysql_num_rows($brandprodQry);
				 $pr = array();
				 if($cntpro){ 
					 while($res4=$cms->db_fetch_array($brandprodQry)){
						$pr[] = $res4[prod_id];
					 }
				 }
				 $cntbrand =  0;
				 if($_GET[price]!=""){
					$arr = explode('-',$_GET[price]);
					if(count($arr)>1){
						 $condnew34 .= " and dofferprice>=".$arr[0]." and dofferprice <=".$arr[1];
						}else{
							$condnew34 .= " and dofferprice > ".$_GET[price]." ";
					}
					
				 }
				/* if(count($pr)){
				 $cntbrand = $cms->getSingleresult("select count(*) from #_products_user where status = 'Active' and pid in (".implode(',',$pr).") $cond34 ");
				 }*/ 
				  if(count($pr)){
				 $cntbrand = $cms->getSingleresult("select count(DISTINCT proid) from #_product_price where proid in (".implode(',',$pr).") $condnew34 ");
				 } 

				  if(!$show){?>
            <h3 style="color:black;  padding: 6px 0 0 0;">Brand(s)</h3>
            <?php 
					$show++; 
				 }?>
            <li>
              <input <?=($cntbrand)?'':'disabled="disabled"'?> type="checkbox" class="refine brand"  <?=(in_array($brandslist[brand_id],$listbrand))?'checked="checked"':'' ?>   name="brand" value="<?=$brandslist[brand_id]?>">
              <a href="#">
              <?=$cms->getSingleresult("select title from #_store_detail where store_user_id = '".$brandslist[brand_id]."'")?>
              (
              <?=$cntbrand?>
              )</a></li>
            <?php 
			}
		} 
		?>
          </ul>
          <?php
			if($_GET[price]!=""){
					$arr = explode('-',$_GET[price]);
					if(count($arr)>1){
						 $condnew1 .= " and dofferprice>=".$arr[0]." and dofferprice <=".$arr[1];
						}else{
							$condnew1 .= " and dofferprice > ".$_GET[price]." ";
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
			$newp[] = 0;
			$qrys = $cms->db_query("select pid from #_products_user where status = 'Active' and pid in (".implode(',',$prods).")  ");
			if(mysql_num_rows($qrys)){
				while($resnew=$cms->db_fetch_array($qrys)){
						$newp[] = $resnew[pid];
				} 
			}
			$newpnew[] = 0;
			$qrysnew = $cms->db_query("select proid from #_product_price where  pid in (".implode(',',$prods).") $condnew1 ");
			if(mysql_num_rows($qrysnew)){
				while($resnew1=$cms->db_fetch_array($qrysnew)){
						$newpnew[] = $resnew1[proid];
				} 
			} 
			if($specifications){?>
          <div id="scroll-pane">
          <?php
				$disp = 0;
				echo '<h3 style="padding-left:0px; color:black">Specification</h3>';
				$spe = explode(',',$specifications);
				$spe = array_unique($spe);
				$spec = array();
				foreach($spe as $vals){
				if($vals!=""  and !in_array(strtolower(trim($vals)),$spec)){
					$spec[] = strtolower(trim($vals));
					$arrfd = array(); 
					$feature  = "select t1.fdescription from #_product_feature as t1, #_products_user as t2 where t1.ftitle = '$vals' and t2.pid = t1.prod_id and t1.prod_id in  (".implode(',',$newp).") group by t1.fdescription"; 
						$getQry = $cms->db_query($feature);
						if(mysql_num_rows($getQry)){ 
							$c = 1;
							while($resf=$cms->db_fetch_array($getQry)){ extract($resf);
								 $sub = trim($fdescription); 
								 if($sub!="" and !in_array($sub,$arrfd)){ 
									 $arrfd[] = $sub;
									 $spcnt = $cms->getSingleresult("select count(*) from #_product_feature as t1, #_products_user as t2 where t1.ftitle = '$vals' and t1.prod_id in  (".implode(',',$newp).") and  t1.fdescription = '$sub' and t1.prod_id = t2.pid ");
									if($spcnt){ 
										$vvl = $sub."type=".$vals;
										
										if($c==1){?>
          <li ><a  href="#"><strong>
            <?=$vals?>
            </strong></a></li>
          <?php }?>
          <?php $va = $vals."--".$sub; ?>
          <li>
            <input type="checkbox" <?=(@in_array($va,$listspecification))?'checked="checked"':'' ?> class="refine specification"  name="specification" value="<?=$va?>">
            <a <?=($items[5]==$sub and $sub!="")?$style:''?> href="#">
            <?=substr($sub,0,25)?>
            (
            <?=$spcnt?>
            )</a></li>
          <?php 
          
											$c++; $disp++;
									}
								}
							}					
						}
					}
				}
				echo" </div>";
			}
			 
			?>
        </ul>
      </div>
      
    </div>
    <?php 
	

	$searchexe = $cms->db_query($storeQry);
	$count = $counts; 
	?>
    <div class="apparel_paging3" id="content">
      <div style="width:100%" class="main_text_areain_apparel">
        <h3>
          <?=$cms->removeSlash($cms->getSingleresult("select title from #_store_detail where store_user_id ='".$_GET[brand]."'"))?>
          <?=$cms->removeSlash($cms->getSingleresult("select name from #_store_menu where cat_id = '".$items[2]."' 
		  and store_user_id = '$current_store_user_id'"))?>
          <span>(
          <?=$count?>
          Product<?=($count>1)?'s':''?>
          )</span></h3>
      </div>
      <?php  
	if($count){ 
		$cqry = $cms->db_query("select product_id from #_product_compare where  ssid = '".session_id()."'");
		$r = array();
		while($cres=$cms->db_fetch_array($cqry)){
			$r[] = $cres[product_id];
		}  
	   ?>
      <div class="compare_div" <?=(count($r))?'':'style="display:none"'?> id="compare_id">
        <?php 
		$p1 = $cms->getSingleresult("select title from #_products_user where pid = '".$r[0]."'");
	    $im1 = $cms->getSingleresult("select image1 from #_products_user where pid = '".$r[0]."'");
		$img1 = ($im1)?$cms->getImageSrc($im1):SITE_PATH.'images/plus_icon.png';

		$p2 = $cms->getSingleresult("select title from #_products_user where pid = '".$r[1]."'");
		$im2 = $cms->getSingleresult("select image1 from #_products_user where pid = '".$r[1]."'");
		$img2 = ($im2)?$cms->getImageSrc($im2):SITE_PATH.'images/plus_icon.png';

		$p3 = $cms->getSingleresult("select title from #_products_user where pid = '".$r[2]."'");
		$im3 = $cms->getSingleresult("select image1 from #_products_user where pid = '".$r[2]."'");
		$img3 = ($im3)?$cms->getImageSrc($im3):SITE_PATH.'images/plus_icon.png';

		$p4 = $cms->getSingleresult("select title from #_products_user where pid = '".$r[3]."'");
		$im4 = $cms->getSingleresult("select image1 from #_products_user where pid = '".$r[3]."'");
		$img4 = ($im4)?$cms->getImageSrc($im4):SITE_PATH.'images/plus_icon.png';
	  ?>
        <div class="first_compare"> <img src="<?=$img1?>" height="50" width="50" class="compare_imge" alt="<?=$p1?>" title="<?=$p1?>"/>
          <p class="compare_text">
            <?=($p1)?$p1:'Add More Item'?>
          </p>
          <a href="Javascript:void(0)" alt="<?=$r[0]?>"  class="compare_product-close removeComp"></a> </div>
        <div class="first_compare"> <img src="<?=$img2?>" height="50" width="50" class="compare_imge" alt="<?=$p2?>" title="<?=$p2?>"/>
          <p class="compare_text">
            <?=($p2)?$p2:'Add More Item'?>
          </p>
          <a href="Javascript:void(0)" alt="<?=$r[1]?>"  class="compare_product-close removeComp"></a> </div>
        <div class="first_compare"> <img src="<?=$img3?>" height="50" width="50" class="compare_imge" alt="<?=$p3?>" title="<?=$p3?>"/>
          <p class="compare_text">
            <?=($p3)?$p3:'Add More Item'?>
          </p>
          <a href="Javascript:void(0)" alt="<?=$r[2]?>"  class="compare_product-close removeComp"></a> </div>
        <div class="first_compare"> <img src="<?=$img4?>" height="50" width="50" class="compare_imge" alt="<?=$p4?>" title=""<?=$p4?>/>
          <p class="compare_text">
            <?=($p4)?$p4:'Add More Item'?>
          </p>
          <a href="Javascript:void(0)" alt="<?=$r[3]?>"  class="compare_product-close removeComp"></a> </div>
        <a href="Javascript:void(0)" alt="Remove Compare" title="Remove Compare" class="compare_div-close"></a>
        <div class="compare_btn">
          <input type="button" class="location" lang="<?=SITE_PATH?>compare" alt="Show Compare Product(s)" title="Show Compare Product(s)" name="compare_btn" value="Compare" />
        </div>
      </div>
      <div id="content" class="infinite-scroll">
        <?php $i=1;
		      $k=1;
			 while($storeres=$cms->db_fetch_array($searchexe))
				{   
					$status = $cms->getSingleresult("select status from #_barnds_product where prod_id = '".$storeres[pid]."' and store_user_id = '".$current_store_user_id."'");
					if($status=='Inactive'){
						$storeres[status] = 'Inactive';					
					}
					if($storeres[status]!='Inactive'){ 
					?>
        <div class="cat_product_div" id="scroll_load">
          <h2 title="<?=$storeres['title']?>">
            <?=substr(trim($storeres['title']),0,30)?>
          </h2>
          <div class="cat_product_textmain">
            <div class="cat_product_image"> <img src="<?=$cms->getImageSrc($storeres['image1'])?>"  width="200" height="180"  title="<?=$storeres['title']?>" alt="<?=$storeres['title']?>"/> </div>
            <div class="cat_product_text_info"> 
              <div class="cat_product_text_info_buttn">
                <?php $check = $cms->getSingleresult("select count(*) from #_product_compare where  ssid = '".session_id()."' and product_id = '".$storeres['pid']."' "); ?>
				<div class="cat_product_text_info_buttn_left sizesuccesshide_cat<?=$i?>">
				<?php 
				$Cprice = $cms->getBothPrice($storeres['pid'],$current_store_user_id);
				$mainprice = $Cprice[0];
				$disprice = $Cprice[1];   
				 ?>
				 <a class="product_price product_price">
                  <?=($disprice >0 && $disprice < $mainprice)?$cms->price_format($disprice):$cms->price_format($mainprice)?>
                  /-</a>
                  <?php if($disprice < $mainprice && $disprice!=0 ){ ?>
                  <a class="product_price right_price">
                  <?=$cms->price_format($mainprice)?>
                  /-</a>
                  <?php
					}?>
                </div>
				  <samp class="sizesuccess_cat<?=$i?>"> </samp>
                <div class="cat_product_text_compare_div">
                  <input <?=($check)?'checked':''?> value="<?=$storeres['pid']?>" class="cmp"  type="checkbox" name="compare">
                  Compare </div>  
             <form action="#" name="theForm" method="post">
			    <?php  
				 $prod_price =$cms->db_query("SELECT dsize FROM #_product_price WHERE store_id = '$current_store_user_id' AND proid ='".$storeres['pid']."'"); 
			      //print_r(mysql_num_rows($prod_price));
				 if(mysql_num_rows($prod_price)>1){ ?> 
				<div class="dropdown_on-mini-detail">   
				<select class="list_of_detail crt<?=$storeres['pid']?> size<?=$storeres['pid']?>"   alt="<?=$storeres['pid']?>" title="<?=$i?>" name="size"> 
						<?php 
						while($pro_p=$cms->db_fetch_array($prod_price)){ 
							?>  
						  <option value="<?=$pro_p[dsize]?>"><?=$pro_p[dsize]?></option>  
				  <?php } ?></select>
				  </div> 
		   <?php }else{ ?> <div class="dropdown_on-mini-detailnon">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </div>  <?php } ?>
                <div class="color_boxes_maindiv">
                 <span class="size_selection-color" style="float:left;" > <?php if($storeres[color]){ ?>Colour : <?php }else{ ?> &nbsp; <?php } ?></span>  
			<?php 
					$clr = @explode(',', $storeres[color]);
			        $k=$storeres['pid'].$i; 
				 if(count($clr)>1){  
					foreach($clr as $val){ 
					$clrcode = $cms->getSingleresult("select colorcode from #_color where name = '$val' and store_user_id = '$current_store_user_id'");    
					 ?>
					 <div class="color_boxes">
					  <input type="radio" id="checkbox-1-<?=$k?>"  name="color<?=$storeres['pid']?>"  value="<?=$clrcode?>" class="regular-checkbox<?=$k?> color<?=$storeres['pid']?>"  <?=($clrcode=='$clrcode')?'checked':''?>>
				     <label for="checkbox-1-<?=$k?>" class="checkbox-1-<?=$k?>"></label> 
				 
				<?php include("color_css.php"); ?>
			</div>
	   <?php $k++;  
	                 } 
		          }    ?>  
            </div>  
				
                <?php if($current_store_type!="store"){?>
                <div style="" class="cat_product_text_info_buttn_right"> <a href="<?=SITE_PATH.'locate-store/'.$adm->baseurl($storeres['title']).'/'.$storeres['pid']?>" class="locate_dealer_btn">Locate Dealer</a> <a href="<?=SITE_PATH?>detail/<?=$adm->baseurl($storeres['title'])?>/<?=$storeres['pid']?>" class="detail_btn">Details</a> </div>
                <?php }else{?>
                <div  class="cat_product_text_info_buttn_right" style="float: left; margin-left: 10px;"> <a href="Javascript:void(0)" class="locate_dealer_btn addtocart_index" alt="<?=$storeres['pid']?>">Add To Cart</a> <a href="<?=SITE_PATH?>detail/<?=$adm->baseurl($storeres['title'])?>/<?=$storeres['pid']?>" class="detail_btn">Details</a> </div>
                <?php
				}?>
              </div>
            </div>
          </div>
        </div>
        <?php $i++;
			  }
	  }?>
      </div>
      </form>
	  <?php		
		}
		else{ 
			echo ' <p style="color:black; margin-left:20px; min-height: 300px;">No Product Found</p> ';
		}?>
    </div>
  </div>
</div>
