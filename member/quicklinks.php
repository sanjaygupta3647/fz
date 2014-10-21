<div class="div-tbl ">
        <div class="title"><img src="images/section-icon.png" alt="">Quick Links</div>
        <div class="tbl-contant">
          <div class="sb-wrap-all">
            <div class="sb-wrap"><!--<span class="notification">5</span> --><a href="<?=SITE_PATH_MEM?>content/" class="section-box"> <span>Content</span> Manager </a> </div>

            <div class="sb-wrap"> <a href="<?=SITE_PATH_MEM?>catalog/manage-orders.php?id=<?=$cms->getSingleresult("select pid from #_store_detail where `store_user_id` = '".$_SESSION[uid]."'")?>" class="section-box"> <span>Order</span> Manager </a> </div>
            <div class="sb-wrap"> <a href="<?=SITE_PATH_MEM?>product/" class="section-box"><span>Product</span> Manager </a> </div>
            <div class="sb-wrap"><!--<span class="notification">10</span> -->
            <a href="<?=SITE_PATH_MEM?>coupon/"class="section-box"> <span>Coupon</span> Manager </a> </div>
            <div class="sb-wrap"> <a href="<?=SITE_PATH_MEM?>discount/" class="section-box"> <span>Discount </span> Manager </a> </div>
            <div class="sb-wrap"><!-- <span class="notification">7</span>-->
            <a href="<?=SITE_PATH_MEM?>shipping/" class="section-box"> <span>Shipping</span> Manager </a> </div>
            <div class="sb-wrap"> <a href="<?=SITE_PATH_MEM?>announcement/" class="section-box"><span>Announce</span> Manager </a> </div>
            <div class="sb-wrap"> <a href="<?=SITE_PATH_MEM?>newsletter/" class="section-box"> <span>Newsletter</span> Manager </a> </div>
            <div class="sb-wrap"> <a href="<?=SITE_PATH_MEM?>slider/" class="section-box"> <span>Banner </span> Manager </a> </div>
            <div class="sb-wrap"> <!--<span class="notification">15</span>--><a  href="<?=SITE_PATH_MEM?>productquery/" class="section-box"> <span>Product Query</span> Manager </a> </div>
          </div>
        </div>
      </div>
        <div class="cl2"></div>