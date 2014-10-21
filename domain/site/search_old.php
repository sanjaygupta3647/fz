<?php
$ssid = session_id();
$checkkey  = $cms->getSingleresult("select count(*) from #_searchkey where keywords = '".$_GET[keywords]."' and  ssid = '$ssid' ");	
if(!$checkkey){
	$cms->db_query("insert into #_searchkey set keywords = '".$_GET[keywords]."', store_id = '$current_store_id', ssid = '$ssid' ");	
}

$style = 'style="color:brown; font-weight: bold;"';
$listbrand[]=0;
$listcate[]=0;
$listspecification[]=0;
if($_GET[brand]){
	$listbrand= explode(',',$_GET[brand]);
}
if($_GET[category]){
	$listcate= explode(',',$_GET[category]);
}

if($_GET[specification]){
	$listspecification= explode(',',$_GET[specification]);
}
$prod_arr1[] = 0;
$brandProds = $cms->db_query("select prod_id from #_barnds_product where store_user_id='$current_store_user_id'   ");			
			if(mysql_num_rows($brandProds)){
				  while($res=$cms->db_fetch_array($brandProds)){
					$prod_arr1[] = $res[prod_id];
				  }
} 
$allprod =  $cms->db_query("select pid from fz_products_user  where store_user_id='$current_store_user_id' and status = 'Active' "); 
if(mysql_num_rows($allprod)){
				  while($userProd=$cms->db_fetch_array($allprod)){
					$prod_arr1[] = $userProd[pid];
				  }
}
$prod_arr[] = 0;
$ser = explode(",",$_GET[keywords]);
$ser[] = $_GET[keywords];
if(count($ser)){
	foreach($ser as $srkey){
		$getproduct = $cms->db_query("select pid from #_products_user where pid in (".(implode(',',$prod_arr1)).") 	and (title like '%".$srkey."%' or 
		kf1 like '%".$srkey."%' or kf2 like '%".$srkey."%' or kf3 like '%".$srkey."%') ");
		if(mysql_num_rows($getproduct)){
			  while($res=$cms->db_fetch_array($getproduct)){
				$prod_arr[] = $res[pid];
			  }
		} 
		$fet = $cms->db_query("select t1.prod_id from #_product_feature as t1,#_products_user as t2  where t1.fdescription like '%".$srkey."%' and t1.prod_id =t2.pid  and  t2.pid in (".(implode(',',$prod_arr1)).")");
		 if(mysql_num_rows($fet)){
			  while($res2=$cms->db_fetch_array($fet)){
				$prod_arr[] = $res2[prod_id];
			  }
		}
	
	}
}


 


/*new code start*/ 

		$cond = "";
		$brandsP[] = 0;
		if($_GET[brand]){	
			foreach($listbrand as $v){
				$brnd[]	= " brand_id = '$v'	";
			}
 			$brandProds = $cms->db_query("select prod_id from #_barnds_product where store_user_id='$current_store_user_id' and   (".implode(" or ",$brnd).") and 
			prod_id in (".implode(",",$prod_arr).") ");			
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
						 $cond .= " and offerprice>=".$arr[0]." and offerprice <=".$arr[1];
						}else{
							$cond .= " and offerprice > ".$_GET[price]." ";
					}
					
		}	
		if($_GET[category]!=""){
					$cond .= " and cat_id in (".$_GET[category].") ";
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
		 
		$storeQry1 = $cms->db_query("select pid  from fz_products_user where pid in (".implode(',',$prod_arr).") and status = 'Active'  $cond "); 
		$lft[] = 0;
		if(mysql_num_rows($storeQry1)){
				  while($res211=$cms->db_fetch_array($storeQry1)){
					$lft[] = $res211[pid];
				  }
		 }
		$storeQry = "select *  from fz_products_user where pid in (".implode(',',$lft).") and status = 'Active'  $cond order by pid desc";
		/*new code end*/
?>
<div class="main_matter_area">
<?php 
$_SESSION[catname]=$items[1];
$_SESSION[catid]=$items[2];
	  echo $cms->breadcrumbs(); 
       ?>

  <div class="main_text_brdr_none">
    <div class="left_refine_search">
      <div class="left_refine_search1"><span class="catmenue" >Refine Your Search</span></div>
      <div class="left_refine_search3"><?php 			
			$qry = $cms->db_query("select cat_id from #_products_user where pid in (".implode(',',$prod_arr).") group by cat_id "); 
			if(mysql_num_rows($qry)){ ?><ul>				
				<li><b><a  href="<?=SITE_PATH?>search/?keywords=<?=$_GET[keywords]?>"><h3  style="padding-left:0px; color:black">Reset Your Search</h3></a></b></li><?php 
				 while($subcat=$cms->db_fetch_array($qry)){ 
					$t1 = $cms->getSingleresult("select count(*) from #_products_user where  cat_id ='".$subcat[cat_id]."' and pid in (".implode(',',$prod_arr).")");
					$t2 = 0;  
				   ?>
				  <?php $catName = $cms->removeSlash($cms->getSingleresult("select name from #_store_menu where cat_id = '".$subcat[cat_id]."' and store_user_id='$current_store_user_id' ")); 
				  if($catName){?>				    
					  <li><input type="checkbox" class="refine category"  <?=(in_array($subcat[cat_id],$listcate))?'checked="checked"':'' ?>   name="category" value="<?=$subcat[cat_id]?>">  
						<a  href="#"><?=$catName?> (<?=($t1+$t2)?>)</a></li><?php	 
				  }
				}
				  echo"</ul>";
			} 
			?> 
		</div>
	  <div class="price_range">
          <ul>            
			<?php			
			$maxPrice = $cms->roundUptoNearestN($cms->getSingleresult("select max(offerprice) from #_products_user where pid in(".implode(',',$prod_arr).") "));  
			$minPrice =  $cms->roundUptoNearestN($cms->getSingleresult("select min(offerprice) from #_products_user where pid in(".implode(',',$prod_arr).")   "));   
 			//if(!$minPrice){$minPrice = 10;}  
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
			$cnts = $cms->getSingleresult("select count(*) from #_products_user where pid in(".implode(',',$lft).")   and offerprice >=1  and offerprice <= $low ");			 
			?>
			<li><input type="radio" class="refine" <?=($_GET[price]==$range0)?'checked="checked"':''?> <?=($_GET[price] && $_GET[price]==$range0)?'checked="checked"':''?>  name="price"  value="<?=$range0?>">
			<a <?=($_GET[price]==$range0)?$style:''?> href="#">
			
			<?=CUR. " ".'1 To '.$low?> (<?=$cnts?>)</a></li> 

			<li><input type="radio" class="refine" <?=($_GET[price]==$range)?'checked="checked"':''?>  name="price"  value="<?=$range?>">
			<a <?=($_GET[price]==$range)?$style:''?> href="#">
			<?php			 
			$rQry = "select count(*) from #_products_user where pid in(".implode(',',$lft).")   and offerprice >=$range1  and offerprice <= $range2 ";			 
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
		 
				$rQry1 = "select count(*) from #_products_user where pid in(".implode(',',$lft).")   and offerprice > $range ";			
				 
				?>
				 <li> <input type="radio" class="refine" <?=($_GET[price]==$range)?'checked="checked"':''?>  name="price" value="<?=$range?>"><a <?=($_GET[price]==$range)?$style:''?> href="#"><?=' More Then '.CUR. " ".($range)?> (<?=$cms->getSingleresult($rQry1)?>)</a></li> 
				<?php
			}else{
				$range = $range1.'-'.$range2;				 
				$rQry2 = "select count(*) from #_products_user where pid in(".implode(',',$lft).")  and offerprice >= $range1  and offerprice <= $range2 ";			
				 ?>
				 <li > <input type="radio" class="refine" <?=($_GET[price]==$range)?'checked="checked"':''?>  name="price" value="<?=$range?>">
				 <a  <?=($_GET[price]==$range)?$style:''?> href="#"><?=CUR." ".$range1.' To '.CUR. " ".$range2?> (<?=$cms->getSingleresult($rQry2)?>)</a></li> 
				<?php
				} 
				$loop++;
			}
			$specifications = $cms->getSingleresult("select specifications from #_category where pid = '".$items[2]."'");
			if(!$specifications){
				$child = $cms->getSingleresult("select cat_id from #_store_menu where parent = '".$items[2]."'");
				if(!$child){
							$procat = $cms->getSingleresult("select parent from #_store_menu where cat_id = '".$items[2]."'");
							$specifications = $cms->getSingleresult("select specifications from #_category where pid = '".$procat."'");
				}
			}?> 
		<ul>
        <?php
		$brandQry = $cms->db_query("select brand_id from #_request_brand where store_user_id='$current_store_user_id' and status ='Active' ");
		if(mysql_num_rows($brandQry)){
			$show = 0;			
			 while($brandslist=$cms->db_fetch_array($brandQry)){	 
				 $brandprodQry = $cms->db_query("select prod_id from #_barnds_product where store_user_id='$current_store_user_id' and brand_id = '".$brandslist[brand_id]."'	and status = 'Active'  and prod_id in(".implode(',',$prod_arr).")  ");
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
						 $cond34 .= " and offerprice>=".$arr[0]." and offerprice <=".$arr[1];
						}else{
							$cond34 .= " and offerprice > ".$_GET[price]." ";
					}
					
				 }
				 if(count($pr)){
				 $cntbrand = $cms->getSingleresult("select count(*) from #_products_user where status = 'Active' and pid in (".implode(',',$pr).") $cond34 ");
				 } 

				  if(!$show){?>				 
				 <h3 style="color:black;  padding: 6px 0 0 0;">Brand(s)</h3><?php 
					$show++; 
				 }?>
				 <li><input <?=($cntbrand)?'':'disabled="disabled"'?> type="checkbox" class="refine brand"  <?=(in_array($brandslist[brand_id],$listbrand))?'checked="checked"':'' ?>   name="brand" value="<?=$brandslist[brand_id]?>"> 
				 <a href="#"><?=$cms->getSingleresult("select title from #_store_detail where pid = '".$brandslist[brand_id]."'")?>(<?=$cntbrand?>)</a></li>
				 <?php 
			}
		} 
		?> 
        </ul><?php
			if($_GET[price]!=""){
					$arr = explode('-',$_GET[price]);
					if(count($arr)>1){
						 $condnew .= " and offerprice>=".$arr[0]." and offerprice <=".$arr[1];
						}else{
							$condnew .= " and offerprice > ".$_GET[price]." ";
					}
					
			}
			$brandsPro[] = 0;
			if($_GET[brand]){	
				foreach($listbrand as $v){
					$brndn[]	= " brand_id = '$v'	";
				}
				$brandProds = $cms->db_query("select prod_id from #_barnds_product where store_user_id='$current_store_user_id' and  (".implode(" or ",$brndn).") ");			
				if(mysql_num_rows($brandProds)){
					  while($res=$cms->db_fetch_array($brandProds)){
						$brandsPro[] = $res[prod_id];
					  }
				} 
				 
				$condnew .= " and pid in (".implode(',',$brandsPro).") "; 
				 
			}
			$newp[] = 0;
			$qrys = $cms->db_query("select pid from #_products_user where status = 'Active' and pid in (".implode(',',$prod_arr).") $condnew ");
			if(mysql_num_rows($qrys)){
				while($resnew=$cms->db_fetch_array($qrys)){
						$newp[] = $resnew[pid];
				} 
			}
			if($specifications){
				echo '<h3 style="padding-left:0px; color:black">Specification</h3>';
				$spe = explode(',',$specifications);
				foreach($spe as $vals){
				if($vals){
					$feature  = "select t1.fdescription from #_product_feature as t1, #_products_user as t2 where t1.ftitle = '$vals' and t2.pid in  (".implode(',',$newp).") group by t1.fdescription";
						$getQry = $cms->db_query($feature);
						if(mysql_num_rows($getQry)){ 
							$c = 1;
							while($resf=$cms->db_fetch_array($getQry)){ extract($resf);
								 $sub = trim($fdescription);
								 if($sub!=""){
									$spcnt = $cms->getSingleresult("select count(*) from #_product_feature as t1, #_products_user as t2 where t1.ftitle = '$vals' and 
									t2.pid in  (".implode(',',$newp).") and t1.prod_id in  (".implode(',',$newp).") and  t1.fdescription like '%".$sub."%' and t1.prod_id = t2.pid ");
									if($spcnt){
										if($c==1){?>
											<li ><a  href="#"><strong><?=$vals?></strong></a></li>
										<?php
										}?>
										<li> <input type="checkbox" <?=(trim($_GET[specification])!="" && in_array($sub,$listspecification))?'checked="checked"':'' ?> class="refine specification"  name="specification" value="<?=$sub?>"><a <?=($items[5]==$sub and $sub!="")?$style:''?> href="#"><?=substr($sub,0,25)?>(<?=$spcnt?>)</a></li><?php
											$c++;
									}
								}
							}					
						}
					}
				}
			}
			 
			?> 
          </ul>
        </div>
       <div class="left_refine_search3"> 
       <div class="product_text">
		  <h3>Product Category</h3>
          <ul>
		  <?php  
		  $cateqry=$cms->db_query("select cat_id,name  from #_store_menu where parent = '0' and store_user_id = '$current_store_user_id' order by porder");
		  if(mysql_num_rows($cateqry)){ 
		  while($catRes=$cms->db_fetch_array($cateqry)){?>
			  <li><a <?=($items[2]==$catRes[cat_id])?$style:''?> href="<?=SITE_PATH?>category-product/<?=$cms->baseurl21($catRes[name])?>/<?=$catRes[cat_id]?>">
			  <?=$cms->removeSlash($catRes[name])?></a></li>
			  <?php
			  }
		  }
		  ?> 
          </ul>
        </div> 
      </div>
    </div>
    
    
	<?php
	include "../site/Paging.php";
	$Obj=new Paging($storeQry);
	$Obj->setLimit(9);//set record limit per page
	$limit=$Obj->getLimit();
	$offset=$Obj->getOffset($_REQUEST["page"]);
 	$sql = " $storeQry limit $offset, $limit";
	$searchexe = $cms->db_query($sql);
	$count = mysql_num_rows($searchexe);
	$tcount = mysql_num_rows($cms->db_query($storeQry));
	?>
    <div class="apparel_paging3">
      <div style="width:100%" class="main_text_areain_apparel">
        <h3>Your search result for '<?=$_GET[keywords]?>'
          (<?=$tcount?> Product<?=($tcount>1)?'s':''?>)</h3>  
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
      <div class="first_compare">
      <img src="<?=$img1?>" height="50" width="50" class="compare_imge" alt="<?=$p1?>" title="<?=$p1?>"/> 
      <p class="compare_text"><?=($p1)?$p1:'Add More Item'?></p>
      <a href="Javascript:void(0)" alt="<?=$r[0]?>"  class="compare_product-close removeComp"></a>
      </div>
      <div class="first_compare">
      <img src="<?=$img2?>" height="50" width="50" class="compare_imge" alt="<?=$p2?>" title="<?=$p2?>"/>
      <p class="compare_text"><?=($p2)?$p2:'Add More Item'?></p>
       <a href="Javascript:void(0)" alt="<?=$r[1]?>"  class="compare_product-close removeComp"></a>
      </div>
      <div class="first_compare">
      <img src="<?=$img3?>" height="50" width="50" class="compare_imge" alt="<?=$img3?>" title="<?=$img3?>"/>
      <p class="compare_text"><?=($p3)?$p3:'Add More Item'?></p>
       <a href="Javascript:void(0)" alt="<?=$r[2]?>"  class="compare_product-close removeComp"></a>
      </div>
      <div class="first_compare">
      <img src="<?=$img4?>" height="50" width="50" class="compare_imge" alt="<?=$p4?>" title="<?=$p4?>"/>
      <p class="compare_text"><?=($p4)?$p4:'Add More Item'?></p>
       <a href="Javascript:void(0)" alt="<?=$r[3]?>"  class="compare_product-close removeComp"></a>
      </div>
      <a href="Javascript:void(0)" alt="Remove Compare" title="Remove Compare" class="compare_div-close"></a>
      <div class="compare_btn">
	  <input type="button" class="location" lang="<?=SITE_PATH?>compare" alt="Show Compare Product(s)" title="Show Compare Product(s)" name="compare_btn" value="Compare" /></div>
      
      </div>
      <div id="content">
        <?php
			 while($storeres=$cms->db_fetch_array($searchexe))
				{   
					$status = $cms->getSingleresult("select status from #_barnds_product where prod_id = '".$storeres[pid]."' and store_user_id = '".$current_store_user_id."'");
					if($status=='Inactive'){
						$storeres[status] = 'Inactive';					
					}
					if($storeres[status]!='Inactive'){
					 
					
					?>
        <div class="cat_product_div">
        <h2 title="<?=$storeres['title']?>"><?=substr(trim($storeres['title']),0,30)?></h2>
          <div class="cat_product_textmain">
            <div class="cat_product_image">
            <img src="<?=$cms->getImageSrc($storeres['image1'])?>" height="200" width="180"  title="<?=$storeres['title']?>" alt="<?=$storeres['title']?>"/>
            </div>
            <div class="cat_product_text_info">
             
             <?php 
				$Cprice = $cms->getBothPrice($storeres['pid'],$current_store_user_id);
				$mainprice = $Cprice[0];
				$disprice = $Cprice[1];  
				$check = $cms->getSingleresult("select count(*) from #_product_compare where  ssid = '".session_id()."' and product_id = '".$storeres['pid']."' "); ?>
              <div class="cat_product_text_info_buttn">
                 
               <div class="cat_product_text_info_buttn_left">
					<a class="product_price product_price">
					<?=($disprice >0 && $disprice < $mainprice)?$cms->price_format($disprice):$cms->price_format($mainprice)?>/-</a>

					<?php if($disprice < $mainprice && $disprice!=0 ){ ?>
					<a class="product_price right_price">
						<?=$cms->price_format($mainprice)?>/-</a>
					<?php
					}?>
                </div>
                <div class="cat_product_text_compare_div"> 
				<input <?=($check)?'checked':''?> value="<?=$storeres['pid']?>" class="cmp"  type="checkbox" name="compare"> Compare 
                </div>
				<?php if($current_store_type!="store"){?>
                <div style="" class="cat_product_text_info_buttn_right"> 
                <a href="<?=SITE_PATH.'locate-store/'.$adm->baseurl($storeres['title']).'/'.$storeres['pid']?>" class="locate_dealer_btn">Locate Dealer</a>
                <a href="<?=SITE_PATH?>detail/<?=$adm->baseurl($storeres['title'])?>/<?=$storeres['pid']?>" class="detail_btn">Details</a> 
                </div><?php }else{?>
				<div  class="cat_product_text_info_buttn_right" style="float: left; margin-left: 10px;"> 
                <a href="<?=SITE_PATH?>detail/<?=$adm->baseurl($storeres['title'])?>/<?=$storeres['pid']?>" class="locate_dealer_btn">Add To Cart</a> 
				<a href="<?=SITE_PATH?>detail/<?=$adm->baseurl($storeres['title'])?>/<?=$storeres['pid']?>" class="detail_btn">Details</a>
                </div>
				<?php
				}?>


              </div>
              </div>
          </div>
        </div>
        <?php $i++;
			  }
	  }?>
        <div class="pag_no" style="color:black">
          <?php $Obj->getPageNo(); ?>
        </div>
      </div>
      <?php		
		}
		else{ 
			echo ' <p style="color:black; margin-left:20px;">No Product Found</p> ';
		}?>
    </div>
  </div>
 </div>
 