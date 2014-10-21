<?php
$searchexe = $cms->db_query($_POST[pqry]);
$count = mysql_num_rows($searchexe); 
?> 
        <?php
			 while($storeres=$cms->db_fetch_array($searchexe))
				{   
					$status = $cms->getSingleresult("select status from #_barnds_product where prod_id = '".$storeres[pid]."' and store_user_id = '".$current_store_user_id."'");
					if($status=='Inactive'){
						$storeres[status] = 'Inactive';					
					}
					if($storeres[status]!='Inactive'){
					 
					
					?>
        <div class="cat_product_div" id="scroll_load">
        <h2 title="<?=$storeres['title']?>"><?=substr(trim($storeres['title']),0,30)?></h2>
          <div class="cat_product_textmain">
            <div class="cat_product_image">
            <img src="<?=$cms->getImageSrc($storeres['image1'])?>"  width="200" height="180"  title="<?=$storeres['title']?>" alt="<?=$storeres['title']?>"/>
            </div>
            <div class="cat_product_text_info">
             
              <?php 
				$Cprice = $cms->getBothPrice($storeres['pid'],$current_store_user_id);
				$mainprice = $Cprice[0];
				$disprice = $Cprice[1];  
				$check = $cms->getSingleresult("select count(*) from #_product_compare where  ssid = '".session_id()."' and product_id = '".$storeres['pid']."' "); ?>
              <div class="cat_product_text_info_buttn">
                 
               <div class="cat_product_text_info_buttn_left">
					<a class="product_price product_price">
					<?=($disprice >0 && $disprice < $mainprice)?$cms->price_format($disprice):$cms->price_format($mainprice)?>/-</a>

					<?php if($disprice < $mainprice && $disprice!=0 ){ ?>
					<a class="product_price right_price">
						<?=$cms->price_format($mainprice)?>/-</a>
					<?php
					}?>
                </div>
                <div class="cat_product_text_compare_div"> 
				<input <?=($check)?'checked':''?> value="<?=$storeres['pid']?>" class="cmp"  type="checkbox" name="compare"> Compare 
                </div>
				<?php if($current_store_type!="store"){?>
                <div style="" class="cat_product_text_info_buttn_right"> 
                <a href="<?=SITE_PATH.'locate-store/'.$adm->baseurl($storeres['title']).'/'.$storeres['pid']?>" class="locate_dealer_btn">Locate Dealer</a>
                <a href="<?=SITE_PATH?>detail/<?=$adm->baseurl($storeres['title'])?>/<?=$storeres['pid']?>" class="detail_btn">Details</a> 
                </div><?php }else{?>
				<div  class="cat_product_text_info_buttn_right" style="float: left; margin-left: 10px;"> 
                <a href="<?=SITE_PATH?>detail/<?=$adm->baseurl($storeres['title'])?>/<?=$storeres['pid']?>" class="locate_dealer_btn">Add To Cart</a> 
				<a href="<?=SITE_PATH?>detail/<?=$adm->baseurl($storeres['title'])?>/<?=$storeres['pid']?>" class="detail_btn">Details</a>
                </div>
				<?php
				}?>


              </div>
              </div>
          </div> 
        </div>
        <?php $i++;
			  }
	  }?>
         
     