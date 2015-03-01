<?php 
 
include "site/search.inc.php";
$metaTitle = $cms->getSingleresult("select meta_title from #_meta_info where url='about-us' and store_user_id = '0'");
$metaIntro = $cms->getSingleresult("select meta_description from #_meta_info where url='about-us' and store_user_id = '0'");
$metaKeyword = $cms->getSingleresult("select meta_keyword from #_meta_info where url='about-us' and store_user_id = '0'");
?>

<div class="row" style="margin-top:20px;">
  <div class="registerheadbox">
    
  </div>
  <div class="col-md-12 col-sm-12">
    <?php
			$body = $cms->getSingleresult("SELECT body FROM `#_pages` where url ='about-us' and status = 'Active'  and store_user_id = '0'	 ");
			$heading = $cms->getSingleresult("SELECT heading FROM `#_pages` where url ='about-us' and status = 'Active' and store_user_id = '0'"); 
					 
			?>
    <div class="heading2 col-md-12 col-sm-12"><?=$cms->removeSlash($heading)?></div>
    <form method="post" action="" onSubmit="return formvalid(this);">
      <div class="subarea">
       
                    
         <div class="col-md-12 col-sm-12">
        <div class="col-md-12 col-sm-12" id="list1a">
		  <!--<a><?=$cms->removeSlash($heading)?></a>-->
		  <div class="col-md-12 col-sm-12" style="margin-top:20px;margin-bottom:20px;"><?=$cms->removeSlash($body)?></div>
	
		
           
	</div>
        </div>
      </div>
    </form>
  </div>
</div>
