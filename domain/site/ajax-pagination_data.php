<?php 
	
 			$start = ($_POST[page]*12);
			$end = 12; 
			$storeQry = $_POST[query] ." limit $start , $end";
			$searchexe = $cms->db_query($storeQry);
			$count = $counts;  
			$current_store_type = $cms->getSingleresult("select type from #_store_user where  pid = '".$current_store_user_id."'");
			 while($storeres=$cms->db_fetch_array($searchexe))
				{   
				    $status = $cms->getSingleresult("select status from #_barnds_product where prod_id = '".$storeres[pid]."' and store_user_id = '".$current_store_user_id."'");
					if($status=='Inactive'){
						$storeres[status] = 'Inactive';					
					}
					if($storeres[status]!='Inactive'){ 
					$path = SITE_PATH."detail/".$adm->baseurl($storeres['title'])."/".$adm->baseurl($storeres['pid']);
					?>
        <div class="cat_product_div" id="scroll_load">
          <h2 title="<?=$storeres['title']?>">
            <?=substr(trim($storeres['title']),0,30)?>
          </h2>
          
          <div class="cat_product_textmain">  
		    <div class="onhovr_link" <?=($current_store_type=="brand")?'style="display:none"':''?>> 
			<img lang="<?=SITE_PATH?>ms_files/quickview/<?=$storeres['pid']?>/<?=$current_store_user_id?>"  class="popupdetail" src="<?=SITE_PATH?>images/quick_view_icon.png"> 
			</div> 
            <div class="cat_product_image"><a href="<?=$path?>"><img src="<?=$cms->getImageSrc($storeres['image1'])?>"  width="200" height="180"  title="<?=$storeres['title']?>" alt="<?=$storeres['title']?>"/></a> </div>
            <div class="cat_product_text_info"> 
              <div class="cat_product_text_info_buttn">
                <?php $check = $cms->getSingleresult("select count(*) from #_product_compare where  ssid = '".session_id()."' and product_id = '".$storeres['pid']."' "); ?>
				<div class="cat_product_text_info_buttn_left sizesuccesshide_cat<?=$i?>">
				<?php 
				$Cprice = $cms->getBothPrice($storeres['pid'],$current_store_user_id);
				$mainprice = $Cprice[0];
				$disprice = $Cprice[1];   
				 ?>
				 <a class="product_price product_price">
                  <?=($disprice >0 && $disprice < $mainprice)?$cms->price_format($disprice):$cms->price_format($mainprice)?>
                  /-</a>
                  <?php if($disprice < $mainprice && $disprice!=0 ){ ?>
                  <a class="product_price right_price">
                  <?=$cms->price_format($mainprice)?>
                  /-</a>
                  <?php
					}?>
                </div>
				  <samp class="sizesuccess_cat<?=$i?>"> </samp>
                <div class="cat_product_text_compare_div">
                  <input <?=($check)?'checked':''?> value="<?=$storeres['pid']?>" class="cmp"  type="checkbox" name="compare">
                  Compare </div>  
              </div>
            </div>
          </div>
        </div>
        <?php $i++;
			  }
	  }?>
        
       