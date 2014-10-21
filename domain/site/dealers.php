<?php
$metaTitle = $cms->getSingleresult("select meta_title from #_meta_info where url='dealers' and store_user_id = '$current_store_user_id'");
$metaIntro = $cms->getSingleresult("select meta_description from #_meta_info where url='dealers' and store_user_id = '$current_store_user_id'");
$metaKeyword = $cms->getSingleresult("select meta_keyword from #_meta_info where url='dealers' and store_user_id = '$current_store_user_id'"); 
if($current_store_type!='store'){?>

<div class="dealers_list_box">
  <div class="dealer_main_div">
    <h2>Our Dealer(s) List</h2>
    <div style="clear:both;"></div>
       <!-----main div of frame------>
	 <?php
	include "../site/Paging.php";
	$Obj=new Paging("select  store_user_id  from fz_request_brand where brand_id = '$current_store_user_id' and status ='Active'");
	$Obj->setLimit(8);//set record limit per page
	$limit=$Obj->getLimit();
	$offset=$Obj->getOffset($_REQUEST["page"]);
 	$sql = " select  store_user_id  from fz_request_brand where brand_id = '$current_store_user_id' and status ='Active' limit $offset, $limit";
	$searchexe = $cms->db_query($sql);
	$count = mysql_num_rows($searchexe);
	$tcount = mysql_num_rows($cms->db_query($sql));
	?>
	 <?php 
	if($count){ 
	while($res1=$cms->db_fetch_array($searchexe)){ 
		$Address = $cms->getSingleresult("select Address from #_store_detail where store_user_id = '".$res1[store_user_id]."'");
		$title = $cms->getSingleresult("select title from #_store_detail where store_user_id = '".$res1[store_user_id]."'");
		$name = $cms->getSingleresult("select name from #_store_user where pid = '".$res1[store_user_id]."'");
		$store_url = $cms->getSingleresult("select store_url from #_store_detail where store_user_id = '".$res1[store_user_id]."'");
		$image = $cms->getSingleresult("select image from #_store_detail where store_user_id = '".$res1[store_user_id]."'");
		$theme = $cms->getSingleresult("select theme from #_store_detail where store_user_id = '".$res1[store_user_id]."'");
		$pincode = $cms->getSingleresult("select pincode from #_store_detail where store_user_id = '".$res1[store_user_id]."'");
		$img = SITE_PATH_M."image/noimg.jpg";
		if(file_exists('../uploaded_files/orginal/'.$image) && $image!=""){
			  $img = SITE_PATH_M."uploaded_files/orginal/".$image;
		}
	?> 	
    <div class="dealer_main_frame">
      <div class="dealer_main_frame_left">
        <div class="dealer_main_frame_left1" align="center"><img src="<?=$img?>"  style="max-width:170px; padding-top:5px; max-height:127px"   title="<?=ucwords($title)?>" alt="<?=ucwords($title)?>"/></div>
        <div class="dealer_main_frame_left2">
          <div class="dealer_main_frame_left2_left">Store Owner</div>
          <div class="dealer_main_frame_left2_right"><?=$name?></div>
        </div>
      </div>
      <div class="dealer_main_frame_right">
        <div class="dealer_main_frame_right1"><?php				
				$catQry = $cms->db_query("select  name  from #_store_menu where store_user_id = '".$res1[store_user_id]."' and  parent ='0' order by porder ");
				$rescnt = mysql_num_rows($catQry);
				$na = "";
				if($rescnt){ 
					while($res=$cms->db_fetch_array($catQry)){ 
						$na .= 	 $res[name].", ";
					}
					
				}
	
				?>
          <div class="dealer_main_frame_right1_left" <?=(!$na)?'style="display:none"':''?>>Deals in :</div>
			<div class="dealer_main_frame_right1_right">
			<?=substr($na,0,-2)?>
			</div>
        </div>
        <div class="dealer_main_frame_right1 div_top_padd">
          <div class="dealer_main_frame_right1_left">Address :</div>
          <div class="dealer_main_frame_right1_right"> <?=$Address?>
            <p><?=($pincode)?'Pin code :  '.$pincode:''?></p>
          </div>
        </div>
        <div class="dealer_main_frame_right2"> 
          <input lang="http://<?=$store_url?>.fizzkart.com" class="location deal"  type="button" value="More Details..." name="detail_btn" id="detail_btn">
        </div>
      </div>
    </div>
    <!-----main div of frame------> 
 
 <?php
	}
  }
}
?>     
    
    <div class="pag_no" style="color:black"><?php $Obj->getPageNo(); ?></div>	 
  </div>
  
  <div class="right_feature_product">
    <h2>Featured Products</h2>
    <div class="vertical_product_show"><?php  
	$newstore = $cms->db_query("select pid  from #_products_user where status='Active' and store_user_id ='$current_store_user_id' ");
	if(mysql_num_rows($newstore)){
		while($nes=$cms->db_fetch_array($newstore)){
			$pidsss[] = $nes[pid];
		}
	}
	 
	$cnt = count($pidsss);
	$show = 4;
	if($cnt<4) $show = $cnt;
	
	$pidsss2 = array_rand($pidsss,$show);
	foreach($pidsss2 as $val){  
		$new =$cms->db_query("select status,pid,title,store_user_id,clicks,image1  from #_products_user where status='Active' and pid = '".$pidsss[$val]."' ");
		if(mysql_num_rows($new)){ 
			while($nesw=$cms->db_fetch_array($new)){
			$imgs = SITE_PATH_M."image/noimg.jpg";
			if(file_exists('../uploaded_files/thumb/'.$nesw[image1]) && $nesw[image1]!=""){
				  $imgs = SITE_PATH_M."uploaded_files/thumb/".$nesw[image1];
			}?> 
			<div class="frst_product">
			<div class="image"><img src="<?=$imgs?>" style="max-width:100px; max-height:193px" title="<?=$nesw[title]?>"   alt="<?=$nesw[title]?>"/></div>
			<div class="text">
			<p><?=$nesw[title]?></p>
			<p><?php 
				 $dsize =$cms->getSingleresult("select dsize  from #_product_price where   proid = '".$nesw[pid]."' ");
			     $price = $cms->getPriceSize($nesw[pid],$current_store_user_id,$dsize);
				 echo $cms->price_format($price);
			?></p>
			<a style="background:#<?=$colres[sstrip]?>" href="<?=SITE_PATH?>detail/<?=$adm->baseurl($nesw['title'])?>/<?=$nesw['pid']?>">Buy Now</a> </div>
			</div><?php		
			}
		}	
	}
	?> 
      
      
    </div>
  </div>
</div>
