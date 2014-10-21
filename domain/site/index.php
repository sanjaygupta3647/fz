<?php
$metaTitle = $cms->getSingleresult("select meta_title from #_meta_info where url='home' and store_user_id = '$current_store_user_id'");
$metaIntro = $cms->getSingleresult("select meta_description from #_meta_info where url='home' and store_user_id = '$current_store_user_id'");
$metaKeyword = $cms->getSingleresult("select meta_keyword from #_meta_info where url='home' and store_user_id = '$current_store_user_id'");
 ?>
   
<div class="subdomain_bodymain">
  <div class="subdomain_bodymain_wrap">
    <div class="body1_section">
      <div class="body1_section_left" style="height:330px;" id="main-banner">
        <ul class="slideshow">
          
		  <?php
		$beannerQry=$cms->db_query("SELECT * FROM #_slider where store_id='".$current_store_id."' and status = 'Active' order by porder asc");
		if(mysql_num_rows($beannerQry)){
			while($res=$cms->db_fetch_array($beannerQry)){?>
			<li class="show"><a href="#"><img src="<?=SITE_PATH_M?>uploaded_files/orginal/<?=$res[image]?>" width="704" height="330" alt="<?=($res[alt])?$res[alt]:$metaTitle?>"/></a></li>
     <?php	
			}
		}else{?>
      <li class="show"> <a href="<?=$linkurl?>"> <img src="images/new_banner.jpg" width="704" height="330" alt="home banner" title="home banner"/>
    </a> </li>   <?php
		}
		?>
</ul>
      </div>
      <div class="body1_section_right">
        <h2>Featured Products</h2>
        <div class="feature_product_div"> 
          <!-- Load left issue in this part -->
          <div id="fituredprod">
            <?php 
		$prods = $cms->getFeaturedProds($current_store_user_id,$current_store_type);

	    if(count($prods)==1 and $current_store_type=='store'){ 
			$brand_p = $cms->db_query("select prod_id from #_barnds_product where status='Active' and store_user_id ='$current_store_user_id' limit 10");
			if(mysql_num_rows($brand_p)){
				while($bp=$cms->db_fetch_array($brand_p)){
					$prods[] = $bp[prod_id];
				} 	
			} 
		}
		if(count($prods)){
			$homep=$cms->db_query("select pid,title,pcode,image1 from #_products_user where status = 'Active' and  pid in (".implode(',',$prods).")  ");
			if(mysql_num_rows($homep)){
				while($res1=$cms->db_fetch_array($homep)){?>
            <div class="feature_product_div_data">
              <div class="feature_product_div-image" align="center"> <img src="<?=$cms->getImageSrc($res1['image1'])?>" 
				  width="173" height="155" title="<?=strip_tags($res1['title'])?>" alt="<?=strip_tags($res1['title'])?>"/></div>
              <div class="feature_product_div-text">
                <h3>
                  <?=strip_tags($res1['title'])?>
                </h3>
                <p></p>
              </div>
              <?php 
					$price = $cms->getBothPrice($res1['pid'],$current_store_user_id);
					 
					$cost = $cms->price_format($price[0]);
					if($price[1] and $price[1]<$price[0]){$cost = $cms->price_format($price[1]); }
				  ?>
              <div class="feature_product_div-buy_price" style="margin-top: 55px;"> <span>
                <?=$cost?>
                </span> <a href="<?=SITE_PATH?>detail/<?=$adm->baseurl(strip_tags($res1[title]))?>/<?=$res1[pid]?>" class="buynow" >Buy Now</a> </div>
            </div>
            <?php 
				}
			}
		}?>
          </div>
          <!-- Load left issue in this part --> 
        </div>
      </div>
    </div>
    <div class="body2_section">
      <div class="body2_section-categories">
        <?php   
	  $cats =$cms->getHomeCategory($current_store_user_id);
	 if(count($cats)>=4){
	 ?>
        <h2>Categories</h2>
        <?php 
       foreach( $cats as $val){ ?>
        <div class="category_1">
          <?php					
			$getdet=$cms->db_query("select name,image from #_store_menu where store_user_id ='$current_store_user_id' and parent='0' and cat_id = '".$val."' ");
			$dcont = mysql_num_rows($getdet); 
			$catRes=$cms->db_fetch_array($getdet);?>
          <h3>
            <?=substr($cms->removeSlash($catRes[name]),0,35)?>
          </h3>
          <div class="category_1_image" align="center"><a href="<?=SITE_PATH?>category-product/<?=$cms->baseurl21($cms->removeSlash($catRes[name]))?>/<?=$val?>"><img src="<?=$cms->getImageSrc($catRes['image'])?>" alt="<?=$catRes[name]?>" title="<?=$catRes[name]?>"/></a></div>
        </div>
        <?php	
			 }
		?>
        <?php } ?>
      </div>
    </div>
    <div class="body3_section">
      <?php 
		$prods[] = 0;
	    $newprod =$cms->db_query("select pid from #_products_user where status='Active' and store_user_id ='$current_store_user_id' order by pid desc limit 0, 6 ");
		if(mysql_num_rows($newprod)){
				while($bp=$cms->db_fetch_array($newprod)){
					$prods[] = $bp[pid];
				} 	
		}
		if(count($prods)<6 and $current_store_type=='store'){ 
			$brand_p = $cms->db_query("select prod_id from #_barnds_product where status='Active' and store_user_id ='$current_store_user_id' limit 6");
			if(mysql_num_rows($brand_p)){
				while($bp=$cms->db_fetch_array($brand_p)){
					$prods[] = $bp[prod_id];
				} 	
			} 
		}  
		$new =$cms->db_query("select status,pcode,pid,title,clicks,image1,color from #_products_user where status='Active' and pid in (".implode(',',$prods).") order by pid desc limit 0, 6 "); 
		//$countpro  = mysql_num_rows($new);
		 
		?>
      <div class="body3_section_left">
        <h2>New Arrivals</h2>
        <div class="body2_section-categories">
          <?php 
		if(mysql_num_rows($new)){ 
		$i = 1; 
		 while($newRes=$cms->db_fetch_array($new)){ $path = SITE_PATH."detail/".$adm->baseurl($newRes['title'])."/".$adm->baseurl($newRes['pid']); ?>
          <div class="body2_section-category_1">
            <h3 title="<?=$newRes[title]?>">
              <?=substr(strip_tags($newRes[title]),0,32)?>
            </h3>
            <div class="body2_section-category_1_image" align="center"> <a href="<?=$path?>"><img src="<?=$cms->getImageSrc($newRes['image1'])?>" title="<?=$newRes[title]?>"  alt="<?=$newRes[title]?>"/></a> </div>
            <div class="body2_section-category_1_text">  
			<samp class="sizesuccesshide<?=$i?>">
			<?php  $price = $cms->getBothPrice($newRes['pid'],$current_store_user_id);  
			    if($price[1]>0 && $price[1]< $price[0]){?>
              <span style="font-size:12px;color:#FF0000;text-decoration:line-through; margin-right:5px;"> 
              <?=$cms->price_format($price[0])?>
              </span>
              <?php  } 
				 $cost = $price[0];
				 if($price[1]>0 && $price[1]< $price[0]){
					$cost = $price[1];
				 }
			  ?>
              <span> 
              <?=$cms->price_format($cost)?>
              /-</span> 
			  </samp>
			   <samp class="sizesuccess<?=$i?>">  </samp> 
			    </div>  
				 
				<form action="#" name="theForm" method="post">
<?php  
     
       $prod_price =$cms->db_query("SELECT dsize FROM #_product_price WHERE store_id = '$current_store_user_id' AND proid ='".$newRes['pid']."'");
	  
		if(mysql_num_rows($prod_price)>1){ ?>
     <!--<div class="dropdown_on-mini-detail">  
	           <select class="list_of_detail crt<?=$newRes['pid']?> size<?=$newRes['pid']?>"   alt="<?=$newRes['pid']?>" title="<?=$i?>" name="size" id="list_of_detail"> 
                <?php 
				while($pro_p=$cms->db_fetch_array($prod_price)){ 
				 	?>   
                  <option value="<?=$pro_p[dsize]?>"><?=$pro_p[dsize]?></option> 
          <?php } ?></select>
          </div>-->                      
  <?php }else{ ?>  <?php } ?>
                <!--<div class="color_boxes_maindiv">
                <span class="size_selection-color" style="float:left;" > <?php if($newRes[color]){ ?>Colour : <?php }else{ ?> &nbsp; <?php } ?></span>  
			<?php
			        $clr = @explode(',', $newRes[color]);
			        $k=$newRes['pid'].$i; 
				    if(count($clr)>1){  
					foreach($clr as $val){ 
					$clrcode = $cms->getSingleresult("select colorcode from #_color where name = '$val' and store_user_id = '$current_store_user_id'");  
					 ?>
					 <div class="color_boxes">
					 <input type="radio" id="checkbox-1-<?=$k?>"  name="color"  value="<?=$clrcode?>" class="regular-checkbox<?=$k?> color"  <?=($clrcode=='$clrcode')?'checked':''?>>
				     <label for="checkbox-1-<?=$k?>" class="checkbox-1-<?=$k?>"></label>  
				<?php include("color_css.php"); ?>
			</div>
	<?php $k++;    } 
		     }    ?> 
            </div>--> 
          <!--<div class="body2_section-category_1_buy_btn">  
              <?php
			if($current_store_type=='brand'){?>
              <a href="<?=SITE_PATH?>locate-store/<?=$adm->baseurl($newRes[title])?>/<?=$newRes[pid]?>" class="float_left">Locate Store</a>
              <?php
			 }else{?>
            
              <a href="Javascript:void(0)"  class="float_left addtocart_index" alt="<?=$newRes[pid]?>" title="<?=$color1?>" lang="<?=$newRes['pid']?>" >Add to Cart</a>
			  
              <?php
			 }?>
              <a href="<?=SITE_PATH?>detail/<?=$adm->baseurl($newRes[title])?>/<?=$newRes[pid]?>" class="float_right"`>More Info</a> </div>-->
			  
          </div>
		  </form>
          <?=($i==3)?'<div class="clr"></div>':''?>
          <?php $i++;
		  }
		}else{?>
		
          <div class="body2_section-categories">
            <h1 >No Product Found!</h1>
          </div>
          <?php 
		  }?>
        </div>
      </div>
      <?php 
	  ?>
      <div class="body3_section_right">
        <?php
		if($current_store_type=='brand'){
			$stores=$cms->db_query("select store_user_id  from #_request_brand where brand_id ='".$current_store_user_id."' and status = 'Active' order by   rand() LIMIT 6 ");
			$tcnt = mysql_num_rows($stores); 
			if($tcnt){?>
        <h2><a style="text-decoration:none;color:#000" href="<?=SITE_PATH?>dealers">Our Dealer(s)</a></h2>
        <div class="populr_store_div" align="center">
          <?php 
				while($stRes=$cms->db_fetch_array($stores)){
					$image = $cms->getSingleresult("select image from #_store_detail where store_user_id = '".$stRes[store_user_id]."' and status = 'Active'");
					$getTitle = $cms->getSingleresult("select title from #_store_detail where store_user_id = '".$stRes[store_user_id]."' and status = 'Active'");
					$store_url = $cms->getSingleresult("select store_url from #_store_detail where store_user_id = '".$stRes[store_user_id]."' and status = 'Active'");				 
					$red = "http://$store_url.fizzkart.com";   ?>
          <img lang="<?=$red?>" class="location"  style="cursor:pointer"  src="http://fizzkart.com/uploaded_files/orginal/<?=$image?>" border="0" alt="<?=strip_tags($getTitle)?>" title="<?=strip_tags($getTitle)?>" />
          <?php 
					}?>
        </div>
        <?php
			}
		}else{
			$brands=$cms->db_query("select brand_id  from #_request_brand where store_user_id ='".$current_store_user_id."' and status = 'Active' order by   rand() LIMIT 6 ");
				$tcnt = mysql_num_rows($brands); 
				if($tcnt){?>
						<h2>Our Brands</h2>
						<div class="populr_store_div" align="center">
						  <?php 
								while($stRes=$cms->db_fetch_array($brands)){
										$image = $cms->getSingleresult("select image from #_store_detail where store_user_id = '".$stRes[brand_id]."' and status = 'Active'");
										$getTitle = $cms->getSingleresult("select title from #_store_detail where store_user_id = '".$stRes[brand_id]."' and status = 'Active'");
										$store_url = $cms->getSingleresult("select store_url from #_store_detail where store_user_id = '".$stRes[brand_id]."' and status = 'Active'"); 
										//$red = "http://$store_url.fizzkart.com";   ?>
										 <img  lang="<?=SITE_PATH?>brand-product/<?=$stRes[brand_id]?>" class="location" style="cursor:pointer"  src="<?=SITE_PATH_M?>uploaded_files/orginal/<?=$image?>" border="0" alt="<?=strip_tags($getTitle)?>" title="<?=strip_tags($getTitle)?>" 
										  style="max-height:140px; max-width:156px;"/>
										<?php 
									}?>
						</div>
						<?php
				} 
		}?>
      </div>
    </div>
  </div>
</div>
