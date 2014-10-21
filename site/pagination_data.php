<?php

$storesid = array();
$per_page = CAT_STORE_SIZE; 

if($_GET){
$page=$_GET['page'];
} 
//get table contents
$start = ($page-1)*$per_page; 
  $getstores = $cms->db_query("select t1.pid from #_store_detail as t1, #_plans_category as t2 where t2.cat_id = '".$items[2]."' and t1.plan_id= t2.plan_id");
	if(mysql_num_rows($getstores)){
		while($getrs=$cms->db_fetch_array($getstores)){
			$storesid[] = $getrs[pid];
		}
		$storesid = array_unique($storesid);
	}  
 if(count($storesid)){
 $cond2 = " and pid in (".implode(',',$storesid).")";
}
 
$searchqry = " select * from  #_store_detail where 1 ".$cond2. " limit $start,$per_page "; 
$searchexe = $cms->db_query($searchqry);

 ?> 
     <?php if(mysql_num_rows($searchexe)){
	while($serchres=$cms->db_fetch_array($searchexe)){ @extract($serchres); 
	$img = SITE_PATH."uploaded_files/orginal/no-img.gif";
	if(file_exists(UP_FILES_FS_PATH.'/orginal/'.$image) && $image!=""){
		$img = SITE_PATH."uploaded_files/orginal/".$image;
	}?>
     <div class="main_matter_area_srchmid1">
      <table width="100%" border="0" cellspacing="2" cellpadding="0">
        <tr>
          <td align="left" valign="top" class="title_text_inn"><?=$title?></td>
        </tr>
        <tr>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="100" align="left" valign="top"><img src="<?=$img?>" width="118" height="88" class="text_inn_img" /></td>
                <td align="left" valign="top" class="text_inn"><?=$Address?> 
				<a href="http://<?=$store_url.".fizzkart.com"?>/<?=($theme)?$theme:'domain'?>">View More </a>
				<?php
				$catslist = "";
				$catqry = $cms->db_query("select cat_id from #_plans_category where plan_id = '$plan_id' limit 0, 4");
				while($cats=$cms->db_fetch_array($catqry)){
					$catslist .= $cms->getSingleresult("select name from #_category where pid = '".$cats[cat_id]."'").", ";
				}
				?>
				<p>Category : <?=substr($catslist,0,-2)?></p>
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
									$imgs .= '<img src="'.$img.'" width="60" height="60" class="text_inn_img" />';
									$j++; 
								
								}								
															
							}
							if($list!=""){?> 
								<p>Brand : <?=substr($list,0,-2)?></p>
								<?=$imgs?>
								<?php 
							}
							
						}?>
                  </td>
              </tr>
            </table></td>
        </tr>
      </table>
    </div>    
    <?php }
	}else{?>
	
	<div class="main_matter_area_srchmid1">
      <table width="100%" border="0" cellspacing="2" cellpadding="0">
        <tr>
          <td align="left" valign="top" class="title_text_inn">No Record Found In This Search</td>
        </tr> 
      </table>
    </div> 
	
	<?php }?>
    
    
    <div class="main_matter_area_srchmid2">
	
	</div>
 