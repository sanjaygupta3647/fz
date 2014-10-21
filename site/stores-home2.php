<div class="storebox">
  <div class="heading">
  <img src="<?=SITE_PATH?>images/heading-arrow-icon.jpg" width="11" height="7" alt="Heading" />
  <a style="text-decoration:none;color:#ff6600;" href="<?=SITE_PATH?>store-category/">Our Stores</a></div>
  <div class="storearea, stepcarousel" id="mygallery">
    <ul id="flexiselDemo3">
			 <?php			
			$sql_city1="SELECT pid,name FROM `fz_store_user` where type !='brand' and status = 'Active'";
			$sql_city1_query=$cms->db_query($sql_city1);
			while($city_array=$cms->db_fetch_array($sql_city1_query)){ @extract($city_array);
				$image = $cms->getSingleresult("select image from #_store_detail where store_user_id = '$pid'");
				$title = $cms->getSingleresult("select title from #_store_detail where store_user_id = '$pid'");
				 ?> 
			<?php
			$storeName = substr($cms->getSingleresult("select title from #_store_detail where store_user_id = '$pid'"),0,15);
			$storeId = substr($cms->getSingleresult("select pid from #_store_detail where store_user_id = '$pid'"),0,15);
			$storeurl = $cms->getSingleresult("select store_url from #_store_detail where store_user_id = '$pid'");
			$theme = $cms->getSingleresult("select theme from #_store_detail where store_user_id = '$pid'");
			$theme = ($theme)?$theme:'domain';
			?>
			<li><a href="http://<?=$storeurl?>.fizzkart.com" class="our_brand_section">
			<p style="line-height:20px; margin:15px 10px; padding:0; text-decoration:none;"><?=ucwords(strtolower($storeName))?></p></a></li> 
		<?php }?> 
		
		

    </ul>
  </div>
</div>