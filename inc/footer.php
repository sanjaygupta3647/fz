
  <div class="footer container-fluid">
    <div class="footer_center container">
      <div class="footer_main row">
        <div class="footer_main2_left col-md-6 col-sm-5">
          <div class="ul_text">
            <ul>
              <?php
			///  $cms->pageView($cms->geturl(),$current_store_user_id);
			$rsAdmin=$cms->db_query("select * from #_setting where id='1'");
			$arrAdmin=$cms->db_fetch_array($rsAdmin);
			$sql_city1="select pid,city from #_city where  status='Active' and popular_city	='1' order by city limit 4 ";
			$sql_city1_query=$cms->db_query($sql_city1);
			$totcity =mysql_num_rows($sql_city1_query); $i=1;
			while($city_array=$cms->db_fetch_array($sql_city1_query)){ extract($city_array);?>
              <li><a href="<?=SITE_PATH?>search/?searchfor=store&amp;city=<?=$city?>">
                <?=$city?>
                </a></li>
              <?php
			} 
			?>
            </ul>
            <ul class="none">
              <li><a href="<?=SITE_PATH?>">Home</a></li>
              <li><a href="<?=SITE_PATH?>contact-us">Contact Us</a></li>
              <li><a href="<?=SITE_PATH?>about">About Us</a></li>
              <li><a href="<?=SITE_PATH?>faq">F.A.Qs</a></li>
            </ul>
          </div>
          <!--          <div class="ftr_logo"><img src="../image/ftr_logo.png" width="94" height="26"  alt=""/></div>--> 
		</div>
        <div class="footer_main2_right col-md-6 col-sm-7 hidden-xs">
          <div class="footer_main2_right1">
            <div class="footertext">
            <input type="text" name="email" id="subemail" placeholder="Enter Email to Subscribe" class="news_box" />
            <input type="button" name="submit" id="subscribe" value="Subscribe" class="subscribe_btn" /></div>
			<span id="subscribeMsg"> </span>
            
          </div>
          <div class="footer_main2_right2">
            <div class="hi-icon-wrap hi-icon-effect-5 hi-icon-effect-5d"> <a href="<?=$arrAdmin[fb]?>" class="hi-icon hi-icon-mobile">Facebook</a> <a href="<?=$arrAdmin[tw]?>" class="hi-icon hi-icon-screen">Desktop</a> <a href="#set-5" class="hi-icon hi-icon-earth">Partners</a> </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="row">
      
        <div class="col-md-6 col-sm-6"><p>© Copyright <?=date('Y')?>. Fizzkart.com All Rights Reserved.</p></div>
        <div class="col-md-6 col-sm-6" id="counter"> <img src="http://hitwebcounter.com/counter/counter.php?page=5074531&amp;style=0005&amp;nbdigits=9&amp;type=page&amp;initCount=0" height="32" title="" alt="" border="0" align="right" /> </div>
      
    </div>
  </div>
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
<noscript><div class="statcounter"><a title="web analytics"
href="http://statcounter.com/" target="_blank"><img
class="statcounter"
src="http://c.statcounter.com/9655994/0/709dac70/0/"
alt="web analytics" /></a></div></noscript>
<!-- End of StatCounter Code for Default Guide -->