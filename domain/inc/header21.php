<div style="background:#<?=$colres[sstrip]?>; width:100%; height:35px; float:left; margin-top:10px; margin-bottom:2px;">
<ul class="js-css-menu shadow responsive">
<?php 
$cateqry1=$cms->db_query("select cat_id,name from #_store_menu where store_user_id ='$current_store_user_id' and parent='0'  order by porder ");
if(mysql_num_rows($cateqry1)){
 	while($catRes=$cms->db_fetch_array($cateqry1)){?>
	    <li><a href="<?=SITE_PATH?>category-product/<?=$catRes[cat_id]?>"><?=$catRes[name]?></a><?php	
		$subcategory = array();
		$scateqry=$cms->db_query("select cat_id,name from #_store_menu where parent='".$catRes[cat_id]."' and store_user_id ='$current_store_user_id'  order by porder");
  		if(mysql_num_rows($scateqry)){?>
			<div>
				<ul>
					<li><b>Categories</b></li><?php 
					while($scatRes=$cms->db_fetch_array($scateqry)){?>
						<?php $subcategory[] = $scatRes[cat_id];  ?>
						<li><a href="<?=SITE_PATH?>category-product/<?=$scatRes[cat_id]?>"><?=$cms->removeSlash($scatRes[name])?></a></li><?php		 
					}?>
				</ul>
				<ul><?php
				if(count($subcategory)==0){$subcategory[] = 0;}
				$brands=$cms->db_query("select brand_id from #_barnds_product where store_user_id='".$current_store_user_id."' 
				and status = 'Active' and cat_id in (".implode($subcategory,',').")	group by brand_id desc");
  					if(mysql_num_rows($brands)){ echo '<li><b>Brands</b></li>';
						while($scatRes=$cms->db_fetch_array($brands)){?>
							<li><a href="<?=SITE_PATH?>category-product/<?=$catRes[cat_id]?>/?search=1&brand=<?=$scatRes[brand_id]?>">
									<?=$cms->removeSlash($cms->getSingleresult("select title from #_store_detail where store_user_id = '".$scatRes[brand_id]."'"))?>
									</a></li><?php
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