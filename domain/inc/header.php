<?php
 
if(trim($_POST[keywords])){
 $uri = SITE_PATH."search/?keywords=".trim($_POST[keywords]);
 $cms->redir($uri, true);die;
}
//$cms->pageView($cms->geturl(),$current_store_user_id);
?>
	<div  id="hader"> 
        <div class="logo"><?php
		 $hedlogo = $cms->getSingleresult("select image from #_store_detail where store_url = '".$base."'");
		$img = SITE_PATH_M."images/default-logo.jpg";
					if(file_exists('../uploaded_files/orginal/'.$hedlogo) && $hedlogo!="")
					{  
						  $img = MAIN_SITE."/uploaded_files/orginal/".$hedlogo;
				    }?>	
		<?php 
		$city_id = $cms->getSingleresult("select city_id from #_store_detail where pid = '".$current_store_id."'");
	
		 
		 	?>
		<a href="<?=SITE_PATH?>"><img src="<?=$img?>" style="max-height:75px; border:0; padding-top:5px;"/></a></div>
		<div style="width:700px; margin:10px 0 0 0; height:auto; float: right;  color: #330026; line-height:20px; font-size:12px; text-align:right;" >
		<a style="color: #330026;" href="<?=SITE_PATH?>">Home</a> &nbsp;&nbsp; | &nbsp;&nbsp; <a style="color: #330026;" href="<?=SITE_PATH?>page/about-us">About us</a> &nbsp;&nbsp; | &nbsp;&nbsp; <a style="color: #330026;" href="<?=SITE_PATH?>contact-us">Contact us</a> &nbsp;&nbsp;&nbsp;&nbsp; | &nbsp;&nbsp; <a style="color: #330026;" href="<?=SITE_PATH?>shipping_avail">Shiping Area</a> &nbsp;&nbsp;</div> 
        <div class="contact_info"> 
		
		
		<div class="srch_cart" style="float: right;">
		<div class="link_box2"><?php
		$totalComp = $cms->getSingleresult("select count(*) from #_product_compare where  ssid = '".session_id()."'"); 
		if($totalComp){ ?>
		<a href="<?=SITE_PATH?>compare" class="top_link2"  >View Compare(<?=$totalComp?>)</a>
		<?php }?>
		<a href="<?=SITE_PATH?>track-your-order" class="top_link2" >Track your order </a>
		<?php
		 
		$rsAdmin=$cms->db_query("select * from #_offer_title where store_user_id='".$current_store_user_id."'");
		$arrAdmin=$cms->db_fetch_array($rsAdmin);
		@extract($arrAdmin);?>
		<a href="<?=SITE_PATH?>hot-deal" class="top_link2" ><?=($offer_title3)?$offer_title3:'Hot Deals'?> </a>
		<a href="<?=SITE_PATH?>offer" class="top_link2" ><?=($offer_title2)?$offer_title2:'Period Offers'?> </a>
		 <a class="top_link2" href="<?=SITE_PATH?>combo-offer" ><?=($offer_title1)?$offer_title1:'Combo Offers'?> </a> 
		</div>
            <div class="srch"> 
              <form action="" method="post"> 
                <input type="text" autocomplete="off" class="srch_field" id="country" onkeyup="suggest(this.value);" onblur="fill();" 
				placeholder="Search for Brands, Products" value="<?=$_GET[keywords]?>" name="keywords"> 
				
				<input type="image"  name="search" src="<?=SITE_PATH?>images/search-icon.jpg" style="margin-top: -21px;float: right;margin-right: 0px;">				
              </form>
            </div>
            <div class="cart"></div>
          </div>
		<div class="suggestionsBox" id="suggestions" style="display: none;">  
				<img src="<?=SITE_PATH?>images/arrow.png" style="position: relative; top: -12px; left: 30px;" alt="upArrow" /> 
				<div class="suggestionList" id="suggestionsList"> &nbsp; </div> 
			  </div>
		</div>
        
      </div>