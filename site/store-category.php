<?php

$get = $cms->getCountStoreAndBrandByCat($items[2]); 
$catname = $cms->getSingleresult("select name from #_category where pid = '".$items[2]."'");
$sql="select plan_id from #_plans_category where cat_id ='".$items[2]."' group by plan_id";
if($_GET[pcatid]){  
 		 $sql="select plan_id from #_plans_category where cat_id ='".$_GET[pcatid]."' and parent ='".$items[2]."' group by plan_id"; 
 } 
$sqlquery=$cms->db_query($sql);
$noStore = 0;
if(mysql_num_rows($sqlquery)){
	$plans = array();
	while($resl=$cms->db_fetch_array($sqlquery)){ 
		$plans[] = $resl[plan_id];
	} 
}
$storesid[] = 0;
if($items[2] && count($plans)>0){
	$getstores = $cms->db_query("select pid from fz_store_detail  where plan_id in (".implode(',',$plans).") and status = 'Active' ");
	if(mysql_num_rows($getstores)){
		while($getrs=$cms->db_fetch_array($getstores)){
			$storesid[] = $getrs[pid];
		}
		$storesid = array_unique($storesid);
	} 
}
 
if($_GET[cat_type]){
$ncond = " and type = '".$_GET[cat_type]."'";

}
$sid = array();
$stores = $cms->db_query(" select pid from fz_store_user where 1  and  type !='brand-store' $ncond  and status = 'Active' ");
if(mysql_num_rows($stores)){
	while($rs=$cms->db_fetch_array($stores)){
		$sid[] = $rs[pid];
	}
	$sid = array_unique($sid);
} 

$metaTitle = $catname ." fizzkart";
$metaIntro = $catname ." fizzkart all stores and brands";
$metaKeyword = $catname .", fizzkart, $catname  fizzkart"; 

if(count($sid)){
	 $cond2 .= " and store_user_id in (".implode(',',$sid).")";
}
if($_GET[storekey]){
	 $term = '%$'.$_GET[storekey].'$%';
	 $cond2 .= " and storekeys  like '$term' ";
}
$cond2 .= " and pid in (".implode(',',$storesid).")"; 
/* get store type query start */
$getkeyQry = " select pid,storekeys,store_user_id from  fz_store_detail where 1 $cond2 ";
/* get store type query end */
include "site/Paging.php";
$Obj=new Paging(" select * from  fz_store_detail where 1 $cond2 ");
$Obj->setLimit(10);//set record limit per page
$limit=$Obj->getLimit();
$offset=$Obj->getOffset($_REQUEST["page"]); 
 
$searchqry = " select * from  fz_store_detail where 1 ".$cond2;
$sql=" select * from  fz_store_detail where 1 $cond2 order by title ASC  limit $offset, $limit";
$searchexe = $cms->db_query($sql);
$count = mysql_num_rows($searchexe);
include "site/search.inc.php";

 ?> <div class="contentarea">
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
								$noStore = $cms->getSingleresult("select count(*) from  fz_store_detail as t1, fz_store_user as t2 where t1.plan_id in (".implode(',',$plans).") 
			and t1.status = 'Active' and  t1.store_user_id = t2.pid and (t2.type = 'store' or t2.type = 'brand')");
							}
							
						}?>
					<div class="catlink"><a  <?php if($items[2]==$pid){?> style="color:#000;font-weight:bold;"<?php }?> href="<?=SITE_PATH?>store-category/<?=$adm->baseurl($name)?>/<?=$pid?>"><?=ucwords(strtolower($name))?> (<?=$noStore?>)</a>
					</div>
					<?php }?> 
                </div>
            </div>
            
            <div class="midpanel">
			<div class="bardcom"> 
			<a href="<?=SITE_PATH?>">Home</a> 
			| <a <?=(!$_GET[cat_type])?'class="brndactive"':''?> href="<?=SITE_PATH?>store-category/shoes/<?=$items[2]?>" ><?=ucwords(strtolower($catname))?>(<?=($get[store_count]+$get[brand_count])?>)</a> | <a <?=($_GET[cat_type]=='store')?'class="brndactive"':''?> href="<?=SITE_PATH?>store-category/shoes/<?=$items[2]?>/?cat_type=store" >Stores(<?=$get[store_count]?>)</a> 
			| <a <?=($_GET[cat_type]=='brand')?'class="brndactive"':''?>  href="<?=SITE_PATH?>store-category/shoes/<?=$items[2]?>/?cat_type=brand">Brands(<?=$get[brand_count]?>)</a>
		</div>
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
                    	<div class="heading"><a style="text-decoration:none" href="http://<?=$store_url.".fizzkart.com"?>"><?=$title?></a></div>
						<?php
						$catslist = "";
						$catqry = $cms->db_query("select name from #_store_menu where store_user_id = '$store_user_id' and parent = '0' limit 0, 4");
						while($cats=$cms->db_fetch_array($catqry)){
							$catslist .= ucwords(strtolower(trim($cats[name]))).", ";
						}
						$catslist = substr($catslist,0,-2);
						?>
                        <div class="subtext">Category : <?=($catslist)?$catslist:'Not Set'?></div>
						<div class="subrandbox"> 
						<?php $qry ="select brand_id from #_request_brand where store_user_id ='$store_user_id' and 
						status ='Active'  limit 0,6"; 
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
			}?> 
			<div class="pag_no" <?=(!$count)?'style="float:left;"':''?>><?php $Obj->getPageNo(); ?></div>	
            </div>
            
            <div class="rightpanel">
            	<div class="brandbox">
                	<div class="heading">Popular Brands</div>
					<?=$cms->getAllBrandsByCat($items[2])?>  
                </div>

				<div class="brandbox">
                	<div class="heading">Product Categories</div>
					<?=$cms->getAllProductCategoriesByCat($items[2],$_GET[cat_type],$_GET[pcatid])?>  
                </div> 
				<div class="brandbox">
                	<div class="heading">Store Type</div>
					<?php 
					$cururl  = explode('?',$cms->geturl()); 
					//$mainlinik = SITE_PATH."store-category/".$items[1]."/".$items[2]."/?";  ?>
					<?=$cms->getAllStoreTypeByCat($getkeyQry,$_GET[cat_type],$_GET[storekey],$cururl[0])?>  
                </div> 
                
            </div>
            
        </div>