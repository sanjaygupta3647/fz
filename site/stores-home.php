<div class="row" style="margin-top:20px;">
	<div class="heading col-md-12">
		<!--<img src="<?=SITE_PATH?>images/heading-arrow-icon.jpg" width="11" height="7" alt="Heading" />-->
		<a style="text-decoration:none;color:#ff6600;" href="<?=SITE_PATH?>search/?key=&searchfor=store">Our Stores</a>
	</div>
	<div id="lista1" class="als-container col-md-12">
		<span class="als-prev"><img src="image/thin_left_arrow_333.png" alt="prev" title="previous" /></span>
		<div class="als-viewport">
			<ul class="als-wrapper">
				<?php	
					$sql_city1="SELECT pid,name FROM `fz_store_user` where type='store' and status = 'Active' ORDER BY RAND()";
					$sql_city1_query=$cms->db_query($sql_city1);
					while($city_array=$cms->db_fetch_array($sql_city1_query)) { 
						@extract($city_array);
						$image = $cms->getSingleresult("select image from #_store_detail where store_user_id = '$pid' and status = 'Active' and our_popular_store= '1'");
						$title = $cms->getSingleresult("select title from #_store_detail where store_user_id = '$pid' and status = 'Active' and our_popular_store= '1'");
						$storeName = substr($cms->getSingleresult("select title from #_store_detail where store_user_id ='$pid' and status = 'Active' and our_popular_store= '1'"),0,15);
						$storeId = substr($cms->getSingleresult("select pid from #_store_detail where store_user_id = '$pid' and status = 'Active' and our_popular_store= '1'"),0,15);
						$storeurl = $cms->getSingleresult("select store_url from #_store_detail where store_user_id = '$pid' and status = 'Active' and our_popular_store= '1'");

						$store_domain = $cms->getSingleresult("select store_domain from #_store_detail where store_user_id = '$pid' ");

						$theme = $cms->getSingleresult("select theme from #_store_detail where store_user_id = '$pid' and status = 'Active' and our_popular_store= '1'");
						$theme = ($theme)?$theme:'domain';
						if($storeId) {?>
							
				 <?php  $linkurl  =  ($store_domain)?"http://".$store_domain:"http://".$storeurl.".fizzkart.com" ?>
				<li class="als-item"><a class="newtab" target="_blank" href="<?=$linkurl?>"><img src="<?=$cms->getImageSrc($image)?>" width="150" height="70" alt="<?=$title?>"/></a></li>
				<?php	}
					} ?> 
			</ul>
		</div>
		<span class="als-next"><img src="image/thin_right_arrow_333.png" alt="next" title="next" /></span> 
	</div>
</div>