<?php   
$cityid = $cms->getSingleresult("select pid from #_city where city = '".$items[1]."'");
$searchqry = " select * from  #_store_detail where     city_id  = '$cityid' ";
$searchexe = $cms->db_query($searchqry);
 
?>
<div class="body">
  <div class="main_matter_area_srchleft">
    <div class="main_matter_area_srchleft1">
      <div class="text_inn_cat"> Related Brands </div>
      <ul>
	   <?=$cms->getRelatedbradsSearach($cms->db_query($searchqry))?>  
        <li class="ramaiyaa">
          <div class="text_inn_cat">Categories</div>
        </li><?php
		$sql_city1="select pid,name,image,body from #_category where parentId='0' and status = 'Active'";
		$sql_city1_query=$cms->db_query($sql_city1);
		while($city_array=$cms->db_fetch_array($sql_city1_query)){ @extract($city_array);?>
        <li class="ramaiyaa"><a href="<?=SITE_PATH?>store-category/<?=$adm->baseurl($name)?>/<?=$pid?>"><?=$name?></a></li>
		<?php }?>
         
      </ul>
      <ul>
        <li></li>
      </ul>
    </div>
  </div>
  <div class="main_matter_area_srchmid">
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
				<a href="<?=SITE_PATH?><?=($theme)?$theme:'domain'?>/<?=$store_url?>">View More </a>
				<?php
				$catslist = "";
				$catqry = $cms->db_query("select cat_id from #_plans_category where plan_id = '$plan_id' limit 0, 4");
				while($cats=$cms->db_fetch_array($catqry)){
					$catslist .= $cms->getSingleresult("select name from #_category where pid = '".$cats[cat_id]."'").", ";
				}
				?>
				<p>Category : <?=substr($catslist,0,-2)?></p>
				<?php $qry ="select brand_id from #_request_brand where store_user_id ='$store_user_id' and status ='Active' limit 0,6"; 
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
    
    
    <div class="main_matter_area_srchmid2"></div>
  </div>
  <div class="main_matter_area1">
    <table width="100%" border="0" cellspacing="0" cellpadding="0"> 
      <tr>
        <td><?php include "right.php";?></td>
      </tr>
      <tr>
        <td align="left" valign="top">&nbsp;</td>
      </tr>
    </table>
  </div>
</div>
