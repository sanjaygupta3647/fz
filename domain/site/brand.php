<div id="container2"> <span class="text_a_c2"><?=$cms->getSingleresult("select name from #_brand where pid = '".$items[3]."'")?> </span>
    <div class="container2_data"><?php 
	 $store=$cms->db_query("select pid,title,clicks,image1,price,offerprice from #_products_user where store_user_id='$current_store_user_id' and status = 'Active' and brand_id = '".$items[3]."' order by pid desc");
			if(mysql_num_rows($store))
			{
				while($storeres=$cms->db_fetch_array($store))
				{   
					$img = SITE_PATH."uploaded_files/orginal/no-img.gif";
					if(file_exists('../uploaded_files/orginal/'.$storeres['image1']) && $storeres['image1']!="")
					{
						  $img = SITE_PATH."uploaded_files/orginal/".$storeres['image1'];
					}
						?> 
						<div class="container2_data1">
						<a href="<?=SITE_PATH?>domain/<?=$items[0]?>/detail/<?=$adm->baseurl($storeres['title'])?>/<?=$storeres['pid']?>">
						<img src="<?=$img?>" title="<?=$storeres['title']?>" alt="<?=$storeres['title']?>" width="150" height="200" class="border"/>
						</a>
						<?=$storeres['title']?><br/> 
						<?php if($storeres['offerprice']){?><span>Rs.<?=$storeres['price']?></span> Rs. <?=$storeres['offerprice']?> <?php }
						else {?> Rs.<?=$storeres['price']?> <?php }?>
						
        				<li><a href="<?=SITE_PATH?>domain/<?=$items[0]?>/detail/<?=$adm->baseurl($storeres['title'])?>/<?=$storeres['pid']?>">BUY NOW</a> </li>
      					</div> <? 
					
				}
			}
			else echo'<div class="container2_data1">No Product Available!</div>';
			?>
       
    </div>
  </div>
  <div id="container3"> <span class="text_a">Most Visited</span>
    <div class="container2_data"><?php
	 $mostvisited=$cms->db_query("select pid,title,clicks,image1,price,offerprice from #_products_user where store_user_id='$current_store_user_id' and status = 'Active' and brand_id = '".$items[3]."' order by clicks desc limit 0, 10");
			if(mysql_num_rows($mostvisited))
			{
				while($most_visited=$cms->db_fetch_array($mostvisited))
				{   
					$img = SITE_PATH."uploaded_files/orginal/no-img.gif";
					if(file_exists('../uploaded_files/orginal/'.$most_visited['image1']) && $most_visited['image1']!="")
					{
						  $img = SITE_PATH."uploaded_files/orginal/".$most_visited['image1'];
					}
						?> 
						<div class="container2_data1">
						<a href="<?=SITE_PATH?>domain/<?=$items[0]?>/detail/<?=$adm->baseurl($most_visited['title'])?>/<?=$most_visited['pid']?>">
						<img src="<?=$img?>"  alt="<?=$most_visited['title']?> : No. of Clicks <?=$most_visited['clicks']?>"  title="<?=$most_visited['title']?> : No. of Clicks <?=$most_visited['clicks']?>" width="150" height="200" class="border"/>
						</a><?=$most_visited['title']?><br/> 
						<?php if($most_visited['offerprice']){?><span>Rs.<?=$most_visited['price']?></span> Rs. <?=$most_visited['offerprice']?> <?php }
						else {?> Rs.<?=$most_visited['price']?> <?php }?>
						
        				<li><a href="<?=SITE_PATH?>domain/<?=$items[0]?>/detail/<?=$adm->baseurl($most_visited['title'])?>/<?=$most_visited['pid']?>">BUY NOW</a> </li>
      					</div> <? 
					
				}
			}
			else echo'<div class="container2_data1">No Product Available!</div>';
			?>
      
     
    </div>
  </div>
  <div class="brand_container"> <span class="text_brand_con">Top Most Brands</span>
    <div class="brand_data"> <?php $brands=$cms->db_query(" SELECT t1.image, t1.name FROM `#_brand` as t1,#_products_user as t2  WHERE t1.pid =t2.brand_id and t2.store_user_id='$current_store_user_id' group by t2.brand_id ");
			if(mysql_num_rows($brands))
			{
				while($brandss=$cms->db_fetch_array($brands))
				{   
					$img = SITE_PATH."uploaded_files/orginal/no-img.gif";
					if(file_exists('../uploaded_files/orginal/'.$brandss['image']) && $brandss['image']!="") 
					{
						  $img = SITE_PATH."uploaded_files/orginal/".$brandss['image'];
					}
						?> <img src="<?=$img?>" width="180" height="115" title="<?=$brandss['name']?>"  alt="<?=$brandss['name']?>" class="pad"/> 
						   <? 
					
				}
			}else echo'<div class="container2_data1">No Brand Available!</div>';?> </div>
  </div>