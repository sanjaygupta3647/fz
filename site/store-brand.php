<?php 
$brnd[] = 0;
$brndall[] = 0;
$storesid[] = 0;

if($items[2]){
	$getstores = $cms->db_query("select t1.store_user_id from fz_store_detail as t1, fz_plans_category as t2 where t2.cat_id = '".$items[2]."' and t1.plan_id= t2.plan_id");
		if(mysql_num_rows($getstores)){
			while($getrs=$cms->db_fetch_array($getstores)){
				$storesid[] = $getrs[store_user_id];
			}
			$storesid = array_unique($storesid);
			$cond2 = " and pid in (".implode(',',$storesid).")";
	} 
}

$brandqry=$cms->db_query("select pid from fz_store_user where type!='store' and status='Active' $cond2");
if(mysql_num_rows($brandqry)){
	while($brndres=$cms->db_fetch_array($brandqry)){  
		$brnd[] = $brndres[pid];
	}
}
$brandqry=$cms->db_query("select pid from fz_store_user where type!='store' and status='Active'");
if(mysql_num_rows($brandqry)){
	while($brndres=$cms->db_fetch_array($brandqry)){  
		$brndall[] = $brndres[pid];
	}
}
$brnds = $cms->db_query(" select pid from fz_store_user where type != 'store' and status = 'Active' ");
if(mysql_num_rows($brnds)){
	while($rs=$cms->db_fetch_array($brnds)){
		$bid[] = $rs[pid];
	}
	$bid = array_unique($bid);
} 
if(count($bid)){
	$cond4 .= " and store_user_id in (".implode(',',$bid).")";
}
//echo $cms->getSingleresult(" select count(*) from  fz_store_detail where store_user_id in (".implode(',',$brnd).") ");die;
include "site/Paging.php";
$Obj=new Paging(" select * from  fz_store_detail where store_user_id in (".implode(',',$brnd).") and store_url!='' $cond4 ");
$Obj->setLimit(5);//set record limit per page
$limit=$Obj->getLimit();
$offset=$Obj->getOffset($_REQUEST["page"]); 
 
$searchqry = "select * from  fz_store_detail where store_user_id in (".implode(',',$brnd).") $cond4 ";
$sql = " select * from  fz_store_detail where store_user_id in (".implode(',',$brnd).") and store_url!='' $cond4  order by title ASC  limit $offset, $limit";
$searchexe = $cms->db_query($sql);
$count = mysql_num_rows($searchexe);
include "site/search.inc.php";

 ?> <div class="contentarea">
        	<div class="leftpanel">
            	<div class="categorybox">
					<?php include "left.search.php"; ?>
                	<div class="heading"><a title="View all brands" alt="View all brands"  href="<?=SITE_PATH?>store-brand" style="color:#ff6600; text-decoration:none">Brand Category</a></div>
					<?php
					$catQry="select pid,name from #_category where parentId='0' and status = 'Active'";
					$catQrys=$cms->db_query($catQry);
					while($res2=$cms->db_fetch_array($catQrys)){ 
						 $storesids = array();
						 $storesids[] = 0;
						 $cond3 = "";  
						 $getstores = $cms->db_query("select t1.store_user_id from fz_store_detail as t1, fz_plans_category as t2 where t2.cat_id = '".$res2[pid]."' and t1.plan_id= t2.plan_id");
						 if(mysql_num_rows($getstores)){
							while($getrs=$cms->db_fetch_array($getstores)){
								$storesids[] = $getrs[store_user_id];
							}
							$storesids = array_unique($storesids);
							$cond3 = " and pid in (".implode(',',$storesids).")";
						 }  
  						 $noStore = 0;
						 $noStore = $cms->getSingleresult("select count(*) from #_store_user where type!='store' and status = 'Active' and pid in (".implode(',',$brndall).") $cond3 "); ?>				
					<div class="catlink"><a  <?php if($items[2]==$res2[pid]){?> style="color:#000;font-weight:bold;"<?php }?> href="<?=SITE_PATH?>store-brand/<?=$adm->baseurl($res2[name])?>/<?=$res2[pid]?>"><?=$res2[name]?> (<?=$noStore?>)</a></div>
					<?php }?> 
                </div>
            </div>
            
            <div class="midpanel">
			 
		<div class="bardcom"> 
		<a href="<?=SITE_PATH?>">Home</a> | <a href="<?=SITE_PATH?>store-category" >Stores</a> | <a class="brndactive" href="<?=SITE_PATH?>store-brand">Brands</a>
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
                    	<div class="heading"><a style="text-decoration:none" href="http://<?=$store_url?>.fizzkart.com"><?=$title?></a></div>
						<?php
						$catslist = "";
						$catqry = $cms->db_query("select cat_id from #_plans_category where plan_id = '$plan_id' limit 0, 4");
						while($cats=$cms->db_fetch_array($catqry)){
							$catslist .= $cms->removeSlash($cms->getSingleresult("select name from #_category where pid = '".$cats[cat_id]."'")).", ";
						}
						?>
                        <div class="subtext">Category : <?=substr($catslist,0,-2)?></div>
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
			}
			else{
			?><div class="catdetailbox"><div class="pag_no"><div class="detailbox"><p style="text-align:center"><b>No Record Found!</b></p></div></div></div><?php
			}?> 
			<div class="pag_no"><?php $Obj->getPageNo(); ?></div>	
            </div>
            
            <div class="rightpanel">
            	<div class="brandbox">
                	<div class="heading">Featured Store(s)</div>
					<?=$cms->getRelatedStoreSearach($cms->db_query($searchqry))?>  
                </div>
                
                <div class="adspace">
                	<?php
						$adv=$cms->db_query("select * from #_advertise where  status='Active' and place ='main-site' ");
						$advcount = mysql_num_rows($adv);
						while($advres=$cms->db_fetch_array($adv)){?>
							<a href="<?=($advres[linkurl])?$advres[linkurl]:'#'?>">
							<img src="<?=SITE_PATH?>uploaded_files/orginal/<?=$advres[image]?>" border="0" alt="<?=$advres[title]?>" title="<?=$advres[title]?>">
							</a>
						<?php
						}
					?> 
                </div>
                
            </div>
            
        </div>