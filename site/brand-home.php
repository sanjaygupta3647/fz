<div class="brandbox">
	<div class="heading"><a  href="<?=SITE_PATH?>search/?search=1&searchfor=brand" title="View all brands" style="color:#ff6600; text-decoration:none">Our Brands</a></div>
	<?php			
		$sql_city1="SELECT pid,name FROM `fz_store_user` where type ='brand' and status = 'Active' ORDER BY RAND()";
		$sql_city1_query=$cms->db_query($sql_city1);
		while($city_array=$cms->db_fetch_array($sql_city1_query)) {
			@extract($city_array);
			$image = $cms->getSingleresult("select image from #_store_detail where store_user_id = '$pid' and status = 'Active' and our_popular_store= '1'");
			$brandname = substr($cms->getSingleresult("select title from #_store_detail where store_user_id = '$pid' and status = 'Active' and our_popular_store= '1'"),0,15);
			$brandId = substr($cms->getSingleresult("select pid from #_store_detail where store_user_id = '$pid' and status = 'Active' and our_popular_store= '1'"),0,15);
			$brandurl = $cms->getSingleresult("select store_url from #_store_detail where store_user_id = '$pid' and status = 'Active' and our_popular_store= '1'");
			$theme = $cms->getSingleresult("select theme from #_store_detail where store_user_id = '$pid' and status = 'Active' and our_popular_store= '1'");
			$theme = ($theme)?$theme:'domain';
			if($brandurl) {
	?>
			<div class="logobox">
				<div class="imgbox" align="center">
					<a href="http://<?=$brandurl?>.fizzkart.com"><img src="<?=$cms->getImageUrl($image, 100, 27)?>" width="100"  height="27" alt="<?=$brandname?>" title="<?=$brandname?>" /></a>
				</div>
				<div class="text" style="display:none;"><?=ucwords(strtolower(substr((($brandname)?$brandname:$name),0,12)))?></div>
			</div> 
		<?php 
			}
		}
		?> 
</div>