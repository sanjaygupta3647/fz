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
$brandsarr = array();
$brandQry = $cms->db_query("select brand_id from #_request_brand where store_user_id='$current_store_user_id' and status ='Active' ");
if(mysql_num_rows($brandQry)){
	while($brs=$cms->db_fetch_array($brandQry)){
		$brandsarr[] =$brs[brand_id];
	}
}
if(count($brandsarr)>0){
	$brandProds = $cms->db_query("select prod_id from #_barnds_product where store_user_id='$current_store_user_id' and brand_id in (".implode($brandsarr,',').")  and cat_id in  (".implode(',',$prod_subcat_arr).") and status='Active' ");			
				if(mysql_num_rows($brandProds)){
					  while($res=$cms->db_fetch_array($brandProds)){
						$prods[] = $res[prod_id];
					  }
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
		$priceprod[]  = 0;
		if($_GET[price]!=""){
				$arr = explode('-',$_GET[price]);
				/*if(count($arr)>1){
					 $condnew = " and dofferprice >= ".$arr[0]." and dofferprice <=".$arr[1];
					}else{
						$condnew .= " and dofferprice > ".$_GET[price]." ";
				}
				$storePrice = $cms->db_query("select proid  from fz_product_price where proid in (".implode(',',$prods).") $condnew ");  
				if(mysql_num_rows($storePrice)){
						  while($res211=$cms->db_fetch_array($storePrice)){
							$priceprod[] = $res211[proid];
						  } 
				 } */
				 $priceprod = $cms->getProductCountByPrice($prods,$arr[0],$arr[1],$current_store_user_id);
				 if(!count($priceprod)) $priceprod[] = 0;
				 $cond .= " and pid in (".implode(',',$priceprod).") "; 
				 
		}	
		if($_GET[specification]){	 
				
				$countspec = count($listspecification);
				foreach($listspecification as $t){
					$specPro = array();
					$vals = explode("--",$t); 
					$condcSp	= " and ftitle = '".$vals[0]."'	and  fdescription = '".$vals[1]."' and prod_id in (".implode(',',$prods).")	";
					$specQry =  $cms->db_query("select prod_id from fz_product_feature where 1  $condcSp ");
					if(mysql_num_rows($specQry)){
						while($res21=$cms->db_fetch_array($specQry)){
							$specPro[] = $res21[prod_id];						 
						  }
						  $cond .= " and pid in (".implode(',',$specPro).") "; 
					}
				}
				/*if($countspec>1){
					$newSparr[] = 0;
					$specPro = array_count_values($specPro);
					foreach($specPro as $key=>$val){
						if($val>1)  $newSparr[] = $key;
					} 
					$cond .= " and pid in (".implode(',',$newSparr).") "; 
				}else{
				if(!count($specPro)) {$specPro[] = 0;} 
				//echo "select prod_id from fz_product_feature where 1  and pid in (".implode(',',$specPro).") ";
				$cond .= " and pid in (".implode(',',$specPro).") "; 
				}*/
				 
				
				 
		}  
		$storeQry1 = $cms->db_query("select pid  from #_products_user where pid in (".implode(',',$prods).") and status = 'Active' "); 
		$lft[] = 0;
		if(mysql_num_rows($storeQry1)){
				  while($res211=$cms->db_fetch_array($storeQry1)){
					$lft[] = $res211[pid];
				  }
		 }  
	    
		/*  for paging */
		 
	    $storeQryCnt = "select *  from fz_products_user where pid in (".implode(',',$lft).") and status = 'Active'  $cond order by porder asc  ";
		$rec_per_page = 12;
		$storeQryCntrs = $cms->db_query($storeQryCnt);
		$counts = mysql_num_rows($storeQryCntrs);
		$totcontentpage = (int)(($counts/$rec_per_page)+1);  
		/*  for paging */ 
		$storeQry = "select *  from fz_products_user where pid in (".implode(',',$lft).") and status = 'Active'  $cond order by porder asc limit 0, 12 ";

/*new code end*/
?>

<div  class="main_matter_area">
  <?php 
$_SESSION[catname]=$items[1]; 
$_SESSION[catid]=$items[2]; 
	 echo $cms->breadcrumbs(); 
       ?>
  <div class="main_text_brdr_none"><?php
    include_once "category-left-panel.php"; 
	
	$searchexe = $cms->db_query($storeQry);
	$count = $counts; 
	?>
    <div class="apparel_paging3" id="content">
      <div style="width:100%" class="main_text_areain_apparel">
        <h3>
          <?=$cms->removeSlash($cms->getSingleresult("select title from #_store_detail where store_user_id ='".$_GET[brand]."'"))?>
          <?=$cms->removeSlash($cms->getSingleresult("select name from #_store_menu where cat_id = '".$items[2]."' 
		  and store_user_id = '$current_store_user_id'"))?>
          <span>(<?=$count?>
          Product<?=($count>1)?'s':''?>)</span></h3>
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
					$path = SITE_PATH."detail/".$adm->baseurl($storeres['title'])."/".$adm->baseurl($storeres['pid']);
					?>
        <div class="cat_product_div" id="scroll_load">
          <h2 title="<?=$storeres['title']?>">
            <?=substr(trim($storeres['title']),0,30)?>
          </h2>
          
          <div class="cat_product_textmain"> 
		    <div class="onhovr_link" <?=($current_store_type=="brand")?'style="display:none"':''?>> 
			<a  href="<?=SITE_PATH?>ms_files/quickview/<?=$storeres['pid']?>/<?=$current_store_user_id?>" rel="popuprel" class="inline_popup" w='900px' h='500px' target="_blank">
			<img  border="0" class="popupdetail"  src="<?=SITE_PATH?>images/quick_view_icon.png"> </a>
			</div> 
            <div class="cat_product_image"><a href="<?=$path?>"><img src="<?=$cms->getImageSrc($storeres['image1'])?>"  width="200" height="180"  title="<?=$storeres['title']?>" alt="<?=$storeres['title']?>"/></a> </div>
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
