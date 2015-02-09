<?php
$searchP[] = 0;
if($_GET[key]){
	$getprods = $cms->db_query("select pid from #_products_user  where 1 and ( title like '%".$_GET[key]."%' or pcode like '%".$_GET[key]."%' or kf1 like '%".$_GET[key]."%' or kf2 like '%".$_GET[key]."%' or kf3 like '%".$_GET[key]."%' or meta_title like '%".$_GET[key]."%' or meta_keyword like '%".$_GET[key]."%' or meta_description like '%".$_GET[key]."%')"  );
	if(mysql_num_rows($getprods)){
		while($getrs=$cms->db_fetch_array($getprods)){
			$searchP[] = $getrs[pid];
		}
		 
	} 
	$getprods2 = $cms->db_query("select prod_id from #_product_feature  where     fdescription like  '%".$_GET[key]."%'  "  );
	if(mysql_num_rows($getprods2)){
		while($getrs2=$cms->db_fetch_array($getprods2)){
			$searchP[] = $getrs2[prod_id];
		}
		
	}
} 
$searchP = array_unique($searchP); 



$user[] = 0;
$catQ = $cms->db_query("select store_user_id from #_products_user  where pid in (".implode(",",$searchP).") and status = 'Active' group by store_user_id "  );
	if(mysql_num_rows($catQ)){
		while($catR=$cms->db_fetch_array($catQ)){
			$user[] = $catR[store_user_id];
		}
		
}


$getcats[] = 0;
$catQ = $cms->db_query("select cat_id from #_products_user  where pid in (".implode(",",$searchP).") and status = 'Active' group by cat_id "  );
	if(mysql_num_rows($catQ)){
		while($catR=$cms->db_fetch_array($catQ)){
			$getcats[] = $catR[cat_id];
		}
		
}

//echo " select * from  fz_store_detail where 1 $cond2"; die; 
if($_GET[cat_id]){
	$cnd .= " and cat_id = '".$_GET[cat_id]."' "; 
}
if($_GET[brand]){
	$cnd .= " and store_user_id = '".$_GET[brand]."' "; 
}
include "site/Paging.php";
$Obj=new Paging(" select * from  fz_products_user where  pid in (".implode(",",$searchP).") and status = 'Active' $cnd  ");
$Obj->setLimit(10);//set record limit per page
$limit=$Obj->getLimit();
$offset=$Obj->getOffset($_REQUEST["page"]); 
 
$searchqry = " select * from  fz_store_detail where 1 ".$cond2;
$sql="select * from  fz_products_user where  pid in (".implode(",",$searchP).") and status = 'Active' $cnd order by title ASC  limit $offset, $limit";
$searchexe = $cms->db_query($sql);
$count = mysql_num_rows($searchexe);
include "site/search.inc.php";
?> <div class="contentarea">
        	<div class="leftpanel">
            	<div class="categorybox">
					<?php include "left.search.php"; ?>
                	<div class="heading">Category</div>
					<?php  
					$curl1 = $cms->geturl();
					$catQr=$cms->db_query("select pid,name,image,body from #_category where pid in (".implode(",",$getcats).") and status = 'Active'  order by name");
					while($cateres=$cms->db_fetch_array($catQr)){ ;
					$noProds  = $cms->getSingleresult("select count(*) from #_products_user where pid in (".implode(",",$searchP).") and cat_id = '".$cateres[pid]."' and status = 'Active'");
					$cat_id  = $_GET[cat_id];
					$strtoreplace1 = "&cat_id=$cat_id"; 
					$curl1 = str_replace($strtoreplace1,"",$curl1);
					?>  
					<div class="catlink"><a <?php if($_GET[cat_id]==$cateres[pid]){?> style="color:#000;font-weight:bold;"<?php }?> 
					href="<?=$curl1?>&cat_id=<?=$cateres[pid]?> "><?=$cms->removeSlash($cateres[name])?> (<?=$noProds?>)</a></div>
					<?php }  ?> 
                </div>
            </div>
            
            <div class="midpanel">
			<div class="bardcom"> 
				<a href="#">Your product search result for <strong>'<?=$_GET[key]?>'</strong></a>  
			</div>
				<?php 
				 
				
				if($count){
				while($serchres=$cms->db_fetch_array($searchexe)){ @extract($serchres); 
					$img = SITE_PATH."image/noimg.jpg";
					if(file_exists(UP_FILES_FS_PATH.'/orginal/'.$image1) && $image1!=""){
						$img = SITE_PATH."uploaded_files/orginal/".$image1;
					}?>
					<div class="catdetailbox">
                	<div class="logobox"><img style="max-height:134px" src="<?=$img?>" width="184"  alt="<?=$title?>" title="<?=$title?>"  /></div>
                    <div class="detailbox">
						<?php

						$url = $cms->getSingleresult("select store_url from #_store_detail where store_user_id ='".$store_user_id."' ");
						$type = $cms->getSingleresult("select type from #_store_user where pid ='".$store_user_id."' ");
						$store_domain = $cms->getSingleresult("select store_domain from #_store_detail where store_user_id ='".$store_user_id."' "); 
						$base  =  ($store_domain)?"http://".$store_domain:"http://".$url.".fizzkart.com" ; 
						$link  =  $base."/detail/".$adm->baseurl($title)."/".$pid;
						?>
                    	<div class="heading"><a class="newtab" target="_blank" style="text-decoration:none" href="<?=$link?>"><?=$title?></a></div>
						<?php 
						$Cprice = $cms->getBothPrice($pid,$store_user_id);
						$mainprice = $Cprice[0];
						$disprice = $Cprice[1];   
						 
						 
						//if($offerprice<$price){ $pri =$offerprice; }else  $pri =$price;
						$storeTitle = $cms->getSingleresult("select title from #_store_detail where store_user_id = '$store_user_id'"); 
						?>
						<div class="subtext">Store :  <a class="newtab"  href="<?=$link?>" target="_blank" ><?=$storeTitle?></a> </div>
                        <div class="subtext">Price :  <?=($disprice >0 && $disprice < $mainprice)?$cms->price_format($disprice):$cms->price_format($mainprice)?></div>
						 <div class="subtext" style="font-size:12px;"><?php
							$getprods22 = $cms->db_query("select * from #_product_feature  where  prod_id =  '$pid' and ftitle!='' and fdescription!=''    "  );
							
							if($kf1) echo " - ".$kf1."<br/>";
							if($kf2) echo " - ".$kf2."<br/>";
							if($kf3) echo " - ".$kf3."<br/>";
							if(mysql_num_rows($getprods22)){  
								while($getrs22=$cms->db_fetch_array($getprods22)){
									   echo " - ".$getrs22[ftitle]." - ".$getrs22[fdescription]."<br/>";
								} 
							}
							
						?>							 
						</div>  
						<div class="subrandbox"> 
						<?php  
					  if($type=='brand'){
					  $qry ="select store_user_id from #_barnds_product where brand_id ='$store_user_id' and prod_id = '$pid' and status ='Active' limit 0,6"; 
					  $brnadsqry =$cms->db_query($qry);
					  $j = 1;
					  $totbarnd = mysql_num_rows($brnadsqry);
					  $list = "";
					  $imgs = "";
					  if($totbarnd){ 
						while($serchres=$cms->db_fetch_array($brnadsqry)){ 
								$list  = $cms->getSingleresult("select title from #_store_detail where store_user_id ='".$serchres[store_user_id]."'");
								$image =  $cms->getSingleresult("select image from #_store_detail where store_user_id ='".$serchres[store_user_id]."'");
								$img = SITE_PATH."uploaded_files/orginal/no-img.gif";
								if(file_exists(UP_FILES_FS_PATH.'/orginal/'.$image) && $image!=""){
									$img = SITE_PATH."uploaded_files/orginal/".$image;
								}
								$store_domain = $cms->getSingleresult("select store_domain from #_store_detail where store_user_id ='".$serchres[store_user_id]."' "); 
								$store_url = $cms->getSingleresult("select store_url from #_store_detail where store_user_id ='".$serchres[store_user_id]."' ");
								$base  =  ($store_domain)?"http://".$store_domain:"http://".$store_url.".fizzkart.com" ; 
						        $link  =  $base."/detail/".$adm->baseurl($title)."/".$pid;
								$imgs .= '<div class="imgbox"><a class="newtab" href="'.$link.'"><img style="max-width:50px" src="'.$img.'"  title="'.$list.'"  height="25"   /></a></div>';
								$j++;  			
							}
							if($imgs!=""){?>
								<div class="heading">Dealers</div>
								<div class="divider"></div>
								<?=$imgs?>
								<?php 
							}
							
						}
				}?> 
                    </div> 
                    </div>
                    
                </div>

				<?php
				}
			}else{
			?><div class="catdetailbox"><div class="pag_no"><div class="detailbox"><p style="text-align:center"><b>No Record Found!</b></p></div></div></div><?php
			}?>
			<div class="pag_no"><?php $Obj->getPageNo(); ?></div>	
            </div>
            
            <div class="rightpanel">
            	<div class="brandbox">
                	<div class="heading">Popular Brands</div>
					<?php  
					$curl = $cms->geturl();
					$catQr=$cms->db_query("select title,store_user_id from #_store_detail where store_user_id in (".implode(",",$user).") and status = 'Active'");
					while($cateres=$cms->db_fetch_array($catQr)){ ;
					$noProds32  = $cms->getSingleresult("select count(*) from #_products_user where pid in (".implode(",",$searchP).") and store_user_id = '".$cateres[store_user_id]."' and status = 'Active'");
					$brndid  = $_GET[brand];
					$strtoreplace = "&brand=$brndid"; 
					$curl = str_replace($strtoreplace,"",$curl);
					?> 
					<div class="logonamebox">
					<a href="<?=$curl?>&brand=<?=$cateres[store_user_id]?>" <?php if($cateres[store_user_id]==$_GET[brand]){?> style="color:#000;font-weight:bold;"<?php }?>>
					<?=strtoupper($cateres[title])?>(<?=$noProds32?>)</a></div>
					<?php }  ?>  
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