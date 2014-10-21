<?php
$metaTitle = $cms->getSingleresult("select meta_title from #_meta_info where url='order-track' and store_user_id = '$current_store_user_id'");
$metaIntro = $cms->getSingleresult("select meta_description from #_meta_info where url='order-track' and store_user_id = '$current_store_user_id'");
$metaKeyword = $cms->getSingleresult("select meta_keyword from #_meta_info where url='order-track' and store_user_id = '$current_store_user_id'"); 
?>
<div class="track_main_percent_div">
<div class="Trackpage_maindiv margin_bottom">
  <h2>Track Your Order</h2>
  <div class="order_id_area">
    <p class="track_order-p">
	Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip </p>
    <div class="track_field-div-main">
          <?php if($_SESSION[err]){ ?><p class="errormsg2"><span class="cross_imge"></span><?=$_SESSION[err]?></p> <?php unset($_SESSION[err]); } ?>

    <div class="track_field-div">
	<form action="<?=SITE_PATH?>order_summary" method="post" name="frmSample"  onSubmit="return formvalid(this);" >
      <label for="textfield">Order Id:</label>
      <input type="text" name="orderid" value=""   lang="RisAlphaNum" title="Order Id" required placeholder="eg. 01234567890"  maxlength="12" />
    </div>
    <div class="track_field-div">
    <label for="textfield">Email Address:</label>
      <input type="text" name="email"   lang="RisEmail"  required placeholder="Your Email Address" required oninvalid="setCustomValidity &amp;&amp; setCustomValidity('Please enter a valid Email Address.')" onchange="setCustomValidity &amp;&amp; setCustomValidity('')" />
    </div>
    <input type="submit" value="Track Order" name="track_button" id="track_button" />
	  
	</form>
    </div>
  </div>
</div>
</div>


