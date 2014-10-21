<footer>
  <div id="footer_div" class="footer_id">
    <div id="footer_main">
      <div id="footer2">
        <div class="footer_nav">
          <ul>
            <li><a href="<?=SITE_PATH?>">Home</a></li>
            <li><a href="<?=SITE_PATH?>hot-deal">Hot Deals</a></li>
            <li><a href="<?=SITE_PATH?>period-offer">Period Offers</a></li>
            <li><a href="<?=SITE_PATH?>combo-offer">Combo Offers</a></li>
          </ul>
          <ul>
            <li><a href="<?=SITE_PATH?>page/about-us">About Us</a></li>
            <li><a href="<?=SITE_PATH?>contact-us">Contact Us</a></li>
            <li><a href="<?=SITE_PATH?>page/terms-of-use">Terms of Use</a></li>
            <li><a href="<?=SITE_PATH?>page/privacy-policy">Privacy policy</a></li>
          </ul>
          <ul>
            <li><a href="<?=SITE_PATH?>page/payment-options">Payment Options</a></li>
            <li><a href="<?=SITE_PATH?>page/payment-options">Delivery policy</a></li>
            <li><a href="<?=SITE_PATH?>page/refund-policy">Refund policy</a></li>
            <li><a href="<?=SITE_PATH?>faq">F.A.Qs</a></li>
          </ul>
        </div>
        <div class="footer_options">
          <div class="footer_options2">
            <?php
	    //echo $cms->geturl();
	   //$cms->pageView($cms->geturl(),$current_store_user_id);
	   $likebox = $cms->getSingleresult("select likebox from #_store_detail where store_user_id ='$current_store_user_id' ");
	   if($likebox==""){?>
            <iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2Ffizzkartcom%2F482016821917105&width=400&height=258&colorscheme=light&show_faces=true&header=false&stream=false&show_border=true" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:400px; height:258px;" allowTransparency="true"></iframe>
            <?php
	   }
	   ?>
            <?=$cms->removeSlash($likebox)?>
          </div>
        </div>
      </div>
    </div>
    <div id="header2" style="background:#<?=$colres[footer_strip]?>; height:35px; width:100%; float:left;">
      <div style="width:1024px; padding-top:10px; height:25px; margin:0px auto;">Copyright &copy; fizzkart.com,
        <?=date('Y')?>
        <span style="float:right;">Powered by: <a href="http://fizzkart.com" style="color:#fff" target="_blank">fizzkart.com</a></span></div>
    </div>
  </div>
</footer>
<!-- Start of StatCounter Code for Default Guide --> 
<script type="text/javascript">
var sc_project=9655994; 
var sc_invisible=0; 
var sc_security="709dac70"; 
var scJsHost = (("https:" == document.location.protocol) ?
"https://secure." : "http://www.");
document.write("<sc"+"ript type='text/javascript' src='" +
scJsHost+
"statcounter.com/counter/counter.js'></"+"script>");
</script>
<noscript>
<div class="statcounter"><a title="web analytics"
href="http://statcounter.com/" target="_blank"><img
class="statcounter"
src="http://c.statcounter.com/9655994/0/709dac70/0/"
alt="web analytics"></a></div>
</noscript>
<!-- End of StatCounter Code for Default Guide -->