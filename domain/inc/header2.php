<div class="main_navi_class">
<div style="background:#<?=$colres[sstrip]?>;" class="fixed_nav">
<ul class="js-css-menu shadow">
<?php 
$catmenu = 0;
$cateqry1=$cms->db_query("select cat_id,name from #_store_menu where store_user_id ='$current_store_user_id' and parent='0'  order by porder ");
if(mysql_num_rows($cateqry1)){
 	while($catRes=$cms->db_fetch_array($cateqry1)){?>
	    <li><a href="<?=SITE_PATH?>category-product/<?=$cms->baseurl21($cms->removeSlash($catRes[name]))?>/<?=$catRes[cat_id]?>"><?=$cms->removeSlash($catRes[name])?></a><?php	
		$subcategory = array();
		$scateqry=$cms->db_query("select cat_id,name from #_store_menu where parent='".$catRes[cat_id]."' and store_user_id ='$current_store_user_id'  order by porder");
  		if(mysql_num_rows($scateqry)){?>
			<div class="inner_ul">
				<ul >
					<li class="cat-menu" style="display:none;"><b>Sub Categories</b></li><?php 
					while($scatRes=$cms->db_fetch_array($scateqry)){?>
						<?php $subcategory[] = $scatRes[cat_id];  ?>
						<li><a href="<?=SITE_PATH?>category-product/<?=$cms->baseurl21($scatRes[name])?>/<?=$scatRes[cat_id]?>"><?=$cms->removeSlash($scatRes[name])?></a></li><?php		 
					}?>
				</ul>
				<ul><?php
			    $brandsarr = array();
			    $brandQry = $cms->db_query("select brand_id from #_request_brand where store_user_id='$current_store_user_id' and status ='Active' ");
				if(mysql_num_rows($brandQry)){
					while($brs=$cms->db_fetch_array($brandQry)){
						$brandsarr[] =$brs[brand_id];
					}
				}
				if(count($subcategory)==0){$subcategory[] = 0;}
				if(count($brandsarr)>0){
				$brands=$cms->db_query("select brand_id from #_barnds_product where store_user_id='".$current_store_user_id."' 
				and status = 'Active' and cat_id in (".implode($subcategory,',').")	 and brand_id in (".implode($brandsarr,',').") group by brand_id desc");
  					if(mysql_num_rows($brands)){ echo '<li><b>Brands </b></li>'; $catmenu = 1;
						while($scatRes=$cms->db_fetch_array($brands)){?>
							<li><a href="<?=SITE_PATH?>category-product/<?=$cms->baseurl21($cms->getSingleresult("select title from #_store_detail where store_user_id = '".$scatRes[brand_id]."'"))?>/<?=$catRes[cat_id]?>/?search=1&brand=<?=$scatRes[brand_id]?>">
									<?=$cms->removeSlash($cms->getSingleresult("select title from #_store_detail where store_user_id = '".$scatRes[brand_id]."'"))?>
									</a></li><?php
						}
					}
				}
					?>					
				</ul>			
			</div>
		<?php
		}?>		  
	</li><?php
	}
 
}
?>
</ul>
</div>
</div>
