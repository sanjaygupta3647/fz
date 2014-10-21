<?php
$prod=$cms->db_query("select title,image1,body1 from #_products_user where pid='".$items[2]."' ");
$prod1=$cms->db_query("select dsize,dprice,dofferprice from #_product_price where proid='".$items[2]."' ");
$res=$cms->db_fetch_array($prod); 
$res1=$cms->db_fetch_array($prod1); 
?>

<div class="main_navi_class">
 <div class="locate_dealer_main">
  <div class="dealer_list">
    <div class="dealer_heading">
      <h2>Store Dealer list for “<?=$res[title]?>”</h2>
    </div>
    <div class="product_ovrview">
	  <?php $img1 = SITE_PATH_M."uploaded_files/orginal/".$res['image1']; ?>
      <div class="product_ovrview_image"> <img src="<?=$img1?>" style="max-width:147px; max-height:208px;" title="<?=$res[title]?>"  alt="<?=$res[title]?>"/> </div>
      <!-----main div of frame------>
      <div class="product_ovrview_text">
        <div class="product_ovrview_text_left">Product Name :</div>
        <div class="product_ovrview_text_right"><?=$res[title]?></div>
      </div>
      <!-----main div of frame------>
      <!-----main div of frame------>
      <div class="product_ovrview_text">
        <div class="product_ovrview_text_left">Description :</div>
        <div class="product_ovrview_text_right"><?=stripslashes(substr(strip_tags($res[body1]),0,250))?>...</div> 
      </div>
      <!-----main div of frame------>
      <!-----main div of frame------>
      <div class="product_ovrview_text">
        <div class="product_ovrview_text_left">Actual Price :</div>
        <div class="product_ovrview_text_right">
		   <?php
			if($res1[dofferprice]<$res1[dprice]) $price = $res1[dofferprice]; else $price  = $res1[dprice];
		   ?>
          <h2><?=str_replace('.00','',$price)?>/-</h2>
        </div>
      </div>
      <!-----main div of frame------>
      <!-----main div of frame------>
	  <?php
	  $storesQry=$cms->db_query("select store_user_id from #_barnds_product where prod_id='".$items[2]."' group by store_user_id ");
	  $cnt = mysql_num_rows($storesQry);
	  ?>
      <div class="product_ovrview_text">
        <div class="product_ovrview_text_left">&nbsp;</div>
        <div class="product_ovrview_text_right"><a href="#"><?=$cnt?> Seller<?=($cnt>1)?'s':''?> Available</a></div>
      </div>
      <!-----main div of frame------>
    </div>
  </div>
  <div class="seller_list">
    <div class="seller_list_top">
      <h2>Seller’s list for this product</h2>
      <div class="sorting_selectors">
         <form  action="" method="post">
        <div>
          <input type="text" name="name" id="field2" placeholder="Search by Name" class="locate_store_search" />
        </div>
        <div>
          <input type="text" maxlength="6" name="pincode" id="field3" placeholder="Pin code" class="locate_store_search" />
        </div>
        <div>
          <input type="submit" name="button" id="button" value="Search" class="search_filtr_btn" />
        </div>
		</form>
      </div>
    </div>
    <div class="seller_list_bottom">
	
	<?php  
	$storesQry=$cms->db_query("select store_user_id from #_barnds_product where prod_id='".$items[2]."' group by store_user_id ");
	if(mysql_num_rows($storesQry)){
	while($res1=$cms->db_fetch_array($storesQry)){ 
	if($_POST['button']=='Search'){ 
			 if($_POST[pincode]!=""){
			   $cond .= " and pincode=".$_POST[pincode].""; 
			  }
			if($_POST[name]!=""){
			  $cond .= "and title ='".$_POST[name]."'"; 
			 } 
		$columns = "select * ";
		$sql = " from #_store_detail where store_user_id='".$res1[store_user_id]."' $cond";
		$sql_count = "select count(*) ".$sql; 
		$sql = $columns.$sql; 
		$result = $cms->db_query($sql); 
		$line = $cms->db_fetch_array($result); 
		$reccnt = $cms->db_scalar($sql_count);
		if($reccnt){
			$res1[store_user_id]=$line[pid]; 
		}
		
	 }  
	$Address = $cms->getSingleresult("select Address from #_store_detail where store_user_id = '".$res1[store_user_id]."'");
	$title = $cms->getSingleresult("select title from #_store_detail where store_user_id = '".$res1[store_user_id]."'");
	$store_url = $cms->getSingleresult("select store_url from #_store_detail where store_user_id = '".$res1[store_user_id]."'");
	$image = $cms->getSingleresult("select image from #_store_detail where store_user_id = '".$res1[store_user_id]."'");
	$pincode = $cms->getSingleresult("select pincode from #_store_detail where store_user_id = '".$res1[store_user_id]."'");
	 
		$storeprice = $cms->getPriceSize($items[2],$res1[store_user_id],$res1[dsize]);      
		?> 
		  <div class="seller_list_details">
			<div class="seller_list_details1"><img src="<?=SITE_PATH_M."uploaded_files/orginal/".$image?>" style="max-width:163px;max-height:43px;"   alt=""/>
			  <p><strong>Seller</strong> : <?=$title?></p>
			</div>
			<div class="seller_list_details2">
			  <div class="seller_list_details2_left">Dealer's Price :</div>
			  <div class="seller_list_details2_right">
				<h2 style="font-size: 25px;"><?=str_replace('.00','',$storeprice)?>/-</h2>
				<p>Inclusive of taxes</p>
				<!--<p>(Free home delivery)</p> -->
			  </div>
			</div>
			<div class="seller_list_details3">
			  <!--<h3>Available</h3>
			  <p>Delivered in 2 to 3  Business Days</p> -->
			</div>
			<div class="seller_list_details4"> <a class="deal" target="_balnk" href="<?="http://".$store_url.".fizzkart.com/detail/".$adm->baseurl($res[title])."/".$items[2]?>">Buy Now</a> </div>
		  </div>
      <?php
		}
	}else{  echo '<p style="color:red; font-weight:bold;" > No Seller Available!</p>';  }?>
       
        
       
    </div>
  </div>
 </div>
</div>
