<?php
$storesid[] = 0;
if($_GET[searchfor]){
	$getstores = $cms->db_query("select  pid from fz_store_user where status = 'Active' and type = '".$_GET[searchfor]."' ");
	if(mysql_num_rows($getstores)){
		while($getrs=$cms->db_fetch_array($getstores)){
			$storesid[] = $getrs[pid];
		}
		$storesid = array_unique($storesid);
	} 
}
if($_GET[pcatid]){
	$secarr[] = 0;
	$getsecondstores = $cms->db_query("select store_user_id from fz_store_menu where cat_id = '".$_GET[pcatid]."'");
	if(mysql_num_rows($getsecondstores)){
		while($getrs2=$cms->db_fetch_array($getsecondstores)){
			$secarr[] = $getrs2[store_user_id];
		}
		$secarr = array_unique($secarr);
	}
	$cond2 .= " and pid in (".implode(',',$secarr).")"; 
}
$cond2 .= " and store_user_id in (".implode(',',$storesid).")"; 
if($_GET[key]!=""){
	$cond2 .= " and (title like '%".$_GET[key]."%' or store_url like '%".$_GET[key]."%' or tagline like '%".$_GET[key]."%' or meta_description like '%".$_GET[key]."%' or meta_title like '%".$_GET[key]."%' or meta_keyword like '%".$_GET[key]."%' or description like '%".$_GET[key]."%') ";
}
if($_GET[city]!=""){
	$cityId = $cms->getSingleresult("select pid from fz_city where city='".$_GET[city]."'");
	$cond2 .= " and city_id = ".$cityId;
}
if($_GET[market]!=""){
	$market_id = $cms->getSingleresult("select pid from fz_market where market_name='".$_GET[market]."'");
	$cond2 .= " and market_id = ".$market_id;
} 
/*if($_GET[key]!=""){  
		$prodQry = $cms->db_query("select store_user_id from fz_products_user where 1 and ( title like '%".$_GET[key]."%' or body1 like '%".$_GET[key]."%' or kf1 like '%".$_GET[key]."%' or kf2 like '%".$_GET[key]."%' or kf3 like '%".$_GET[key]."%' ) group by store_user_id ");
		if(mysql_num_rows($prodQry)){
			while($prodrs=$cms->db_fetch_array($prodQry)){
				$storeIds[] = $prodrs[store_user_id];
			}
			$storeIds = array_unique($storeIds);
			$cond2 .= " or store_user_id in (".implode(',',$storeIds).") ";
		} 
}*/
///echo " select * from  fz_store_detail where 1 $cond2"; die; 
include "site/Paging.php";
$Obj=new Paging(" select * from  fz_store_detail where  status = 'Active' $cond2 ");
$Obj->setLimit(10);//set record limit per page
$limit=$Obj->getLimit();
$offset=$Obj->getOffset($_REQUEST["page"]); 
 
$searchqry = " select * from  fz_store_detail where status = 'Active' ".$cond2;

$getProductCategory  = $cms->getProductCategory(" select store_user_id from  fz_store_detail where status = 'Active' ".$cond2);

$sql=" select * from  fz_store_detail where  status = 'Active' $cond2 order by title ASC  limit $offset, $limit";
$searchexe = $cms->db_query($sql);
$count = mysql_num_rows($searchexe);
include "site/search.inc.php";

 ?>

<div class="contentarea">
  <div class="leftpanel">
    <div class="categorybox">
      <?php include "left.search.php"; ?>
      <div class="heading">Category</div>
      <?php
					$sql_city1="select pid,name,image,body from #_category where parentId='0' and status = 'Active'";
					$sql_city1_query=$cms->db_query($sql_city1);
					while($city_array=$cms->db_fetch_array($sql_city1_query)){ @extract($city_array);?>
      <?php
						$sql="select plan_id from #_plans_category where cat_id ='$pid' group by plan_id";
						$sqlquery=$cms->db_query($sql);
						$noStore = 0;
						if(mysql_num_rows($sqlquery)){
							$plans = array();
							while($resl=$cms->db_fetch_array($sqlquery)){ 
								$plans[] = $resl[plan_id];
							}
							if(count($plans)){
								$noStore = $cms->getSingleresult("select count(*) from #_store_detail where plan_id in (".implode(',',$plans).")");
							} 
						}?>
      <div class="catlink"><a  <?php if($items[2]==$pid){?> style="color:#000;font-weight:bold;"<?php }?> href="<?=SITE_PATH?>store-category/<?=$adm->baseurl($name)?>/<?=$pid?>">
        <?=ucwords(strtolower($name))?> (<?=$noStore?>)</a></div>
      <?php }?>
    </div>
  </div>
  <div class="midpanel">
    <?php
		if($_GET[key]) $txt = "Your search result for ".$_GET[key]." ".ucfirst($_GET[searchfor]);
		if($_GET[city]) $txt = "Your search result for all ".ucfirst($_GET[searchfor]) ." in ".$_GET[city];
		if($_GET[city] && $_GET[key]) $txt = "Your search result for all ".$_GET[key]." ".ucfirst($_GET[searchfor]) ." in ".$_GET[city];
		if(!$_GET[searchfor]) $txt = "Please select from search for dropdown";
	?>
    <div class="bardcom"> <a href="<?=SITE_PATH?>">Home</a><img src="<?=SITE_PATH?>image/arrow.png" width="18" height="11" alt="" style="margin:0 0 0 5px;"/> <a href="javascript:void(0)" > <?=$txt?></a></div>
    <?php 
				 
				
				if($count){
				while($serchres=$cms->db_fetch_array($searchexe)){ @extract($serchres); 
					$img = SITE_PATH."image/noimg.jpg";
					if(file_exists(UP_FILES_FS_PATH.'/orginal/'.$image) && $image!=""){
						$img = SITE_PATH."uploaded_files/orginal/".$image;
					}?>
    <div class="catdetailbox">
      <div class="logobox"><img style="max-height:134px" src="<?=$img?>" width="184"  alt="<?=$title?>" title="<?=$title?>"  /></div>
      <div class="detailbox">
        <?php
						 
						$link  = "http://".$store_url.".fizzkart.com";
						?>
        <div class="heading"><a style="text-decoration:none" href="<?=$link?>">
          <?=ucwords(strtolower($title))?>
          </a></div>
        <?php
						$catslist = "";
						$catqry = $cms->db_query("select name from #_store_menu where store_user_id = '$store_user_id' and parent = '0' limit 0, 4");
						while($cats=$cms->db_fetch_array($catqry)){
							$catslist .= ucwords(strtolower(trim($cats[name]))).", ";
						}
						$catslist = substr($catslist,0,-2);
						?>
        <div class="subtext">Category :
          <?=($catslist)?$catslist:'Not Set'?>
        </div>
        <?php
						$titlePr = "";
						$prodQry = $cms->db_query("select title,pid from fz_products_user where store_user_id = '$store_user_id' and ( title like '%".$_GET[key]."%' or body1 like '%".$_GET[key]."%' or kf1 like '%".$_GET[key]."%' or kf2 like '%".$_GET[key]."%' or kf3 like '%".$_GET[key]."%' ) limit 0, 6");
							if(mysql_num_rows($prodQry)){
								?>
        <div class="subtext">Products :
          <?php
					   while($prodrs=$cms->db_fetch_array($prodQry)){?>
							<a href="<?=$link?>/detail/<?=$adm->baseurl($prodrs[title])?>/<?=$prodrs[pid]?>"><?=ucwords(strtolower(trim($prodrs[title])))?>,</a><?php
           
					   }?>
        </div>
        <?php
								 
							}  
						?>
        <div class="subrandbox">
          <?php $qry ="select brand_id from #_request_brand where store_user_id ='$store_user_id' and status ='Active'
				 limit 0,6"; 
					  $brnadsqry =$cms->db_query($qry);
					  $j = 1;
					  $totbarnd = mysql_num_rows($brnadsqry);
					  $list = "";
					  $imgs = "";
					  if($totbarnd){ 
					  while($serchres=$cms->db_fetch_array($brnadsqry)){		
								$type = $cms->getSingleresult("select type from #_store_user where pid = '".$serchres[brand_id]."'");
								if($type=='brand'){
									$list .= $cms->getSingleresult("select title from #_store_detail where store_user_id ='".$serchres[brand_id]."'").", ";
									$image =  $cms->getSingleresult("select image from #_store_detail where store_user_id ='".$serchres[brand_id]."'");
									$img = SITE_PATH."uploaded_files/orginal/no-img.gif";
									if(file_exists(UP_FILES_FS_PATH.'/orginal/'.$image) && $image!=""){
										$img = SITE_PATH."uploaded_files/orginal/".$image;
									}
									$imgs .= '<div class="imgbox"><img style="max-width:50px" src="'.$img.'"   height="25"   /></div>';
									$j++; 
								
								}								
															
							}
							if($list!=""){?>
          <div class="heading">Brands</div>
          <div class="divider"></div>
          <?=$imgs?>
          <?php 
							}
							
						}?>
        </div>
      </div>
    </div>
    <?php
				}
			}else{
			?>
    <div class="catdetailbox">
      <div class="pag_no">
        <div class="detailbox">
          <p style="text-align:center"><b>No Record Found!</b></p>
        </div>
      </div>
    </div>
    <?php
			}?>
    <div class="pag_no">
      <?php $Obj->getPageNo(); ?>
    </div>
  </div>
  <div class="rightpanel">
    <div class="brandbox">
      <div class="heading">Product Categories</div>
      <?=$getProductCategory?>
    </div>
    <div class="adspace">
	<?php
	$adv=$cms->db_query("select * from #_advertise where  status='Active' and place ='main-site' ");
	$advcount = mysql_num_rows($adv);
	while($advres=$cms->db_fetch_array($adv)){?>
		<a href="<?=($advres[linkurl])?$advres[linkurl]:'#'?>"> <img src="<?=SITE_PATH?>uploaded_files/orginal/<?=$advres[image]?>" border="0" alt="<?=$advres[title]?>" title="<?=$advres[title]?>"> </a>
		<?php
	}
	?>
    </div>
  </div>
</div>
