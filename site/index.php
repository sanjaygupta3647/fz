<?php 
$metaTitle = $cms->getSingleresult("select meta_title from #_meta_info where url='home' and store_user_id = '0'");
$metaIntro = $cms->getSingleresult("select meta_description from #_meta_info where url='home' and store_user_id = '0'");
$metaKeyword = $cms->getSingleresult("select meta_keyword from #_meta_info where url='home' and store_user_id = '0'");

 if($_POST[searchbtn]){
	if($_POST[searchfor]!=""){
		$terms .= "&searchfor=".$_POST[searchfor];
    }
	header("Location:".SITE_PATH."search/?key=".$_POST[search].$terms); die; 
}

  
?> 
<div class="header">
  <div class="logo"><img src="<?=SITE_PATH?>image/logo/final.png"  height="84" alt="Fizzkart" /></div>
  <div class="searchbox">
      <form method="post" action="" onsubmit="return formvalid(this);">
      <div class="content-wrapper1" style="display:block;">
			<div class="search-box1">
				<div><input type="text" placeholder="Type your keyword..." class="searchformain" name="search"  value=""/>
				<span class="searchformain"> </span>
				
                <input type="image" src="images/search_for_home.png" class="style_form-search" name="searchbtn" value="Search" /></div>
              <div class="inset_radio_btn"> 
                <div class="radio_btns" title="store"><input type="radio" name="searchfor" checked="checked" value="store"   ><span >Store</span></div>
                <div class="radio_btns" title="brand"><input type="radio" name="searchfor" value="brand"  ><span>Brand</span></div>
                <div class="radio_btns" title="product"><input type="radio" name="searchfor" value="product"   ><span>Product</span></div>
 			  </div>
			</div>
		</div>
    </form>
  
  </div>
</div>
<?php include "site/home_banner.php"; ?>
<?php include "site/stores-home.php"; ?>
<?php include "site/category-home.php"; ?>
<?php include "site/brand-home.php"; ?>
