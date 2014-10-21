<?php 
$metaTitle = $cms->getSingleresult("select meta_title from #_meta_info where url='contact-us' and store_user_id = '0'");
$metaIntro = $cms->getSingleresult("select meta_description from #_meta_info where url='contact-us' and store_user_id = '0'");
$metaKeyword = $cms->getSingleresult("select meta_keyword from #_meta_info where url='contact-us' and store_user_id = '0'");
$msg = "";
 if($cms->is_post_back()) {
	if(strtolower($_POST['secCode'])==strtolower($_POST['captcha'])){
		$_POST['ipaddress'] = $_SERVER['REMOTE_ADDR'];
		$_POST['store_id'] = '0';  
		$_POST['mailto'] = SITE_MAIL;
		
		
		$uids =  $cms->sqlquery("rs","contact",$_POST); 
		if($uids){
				$msg= '<p class="success_msg">Thank You For Contact With Us. We Will Get You Back Soon.</p>';  
				$headers = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= 'From: Fizzkart@fizzkart.com' . "\r\n" .'CC: '.SITE_MAIL; 
				$ch = $cms->db_query("select * from #_template where title ='Main Site Query' and store_id = '0' "); 
				$tempRes = $cms->db_fetch_array($ch);
				$subject2 = $tempRes[subject]; 
				$subject2 = str_replace("%%storename%%", $base.".fizzkart.com",$subject2); 

				$mess2 = $tempRes[body]; 
				$mess2 = str_replace("%%name%%", $_POST[name],$mess2); 
				$mess2 = str_replace("%%email%%", $_POST[email],$mess2);
				$mess2 = str_replace("%%phone%%", $_POST[phone],$mess2);
				$mess2 = str_replace("%%contact%%", $_POST[phone],$mess2);
				$mess2 = str_replace("%%city%%", $_POST[city],$mess2); 
				$mess2 = str_replace("%%query%%", nl2br($_POST[query]),$mess2); 
				$mess2 = str_replace("%%pincode%%", $_POST[pinCode],$mess2); 
				@mail($_POST[email], $subject2, $mess2,$headers); 
				$_POST = false;
		}  
			 
		} else {
			$msg= '<p class="error_msg">Invalid Security Code!</p>';
	} 
}
include "site/search.inc.php";

?>
<?php
$body = $cms->getSingleresult("SELECT body FROM `#_pages` where url ='contact-us' and status = 'Active'  and store_user_id = '0'	 ");
$heading = $cms->getSingleresult("SELECT heading FROM `#_pages` where url ='contact-us' and status = 'Active' and store_user_id = '0'"); 
$heading  = ($heading)?$heading:'Contact Us';
?>
<div class="contentarea">
  <div class="registerheadbox">
    
  </div>
  <div class="registerarea"> 
    <div class="heading2"><?=$cms->removeSlash($heading)?>
      
    </div>
    <form  method="post" action="" onSubmit="return formvalid(this);" >
      <div class="subarea">
		<?=$msg?>
        <div><?=$cms->removeSlash($body)?></div>
                    
         <div class="main_register">
         <h2 class="main_register_form_text">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate </h2>
        <div class="registerbox2">
          <fieldset>
          <legend>Fill this form for your query</legend>
            <div class="formarea">
              <label>Name :</label>
              <input type="text" lang="R" name="name" title="Your Name" value="<?=$_POST[name]?>" id="store_name" placeholder="Your Name">
              <label>Email :</label>
              <input type="email" lang="RisEmail" name="email" value="<?=$_POST[email]?>"  title="Email" id="tagline" placeholder="Your Email Address" >
			   <label>Contact No :</label>
              <input type="text" lang="R" name="phone" title="Phone" value="<?=$_POST[phone]?>" id="phone" placeholder="Contact No.">
              <label>Query :</label>
              <textarea name="query" id="query" title="Query" lang="R" placeholder="Write Your Query Here..." rows="5" cols="4"><?=$_POST[query]?></textarea>
              <label>City :</label>
              <input type="text" lang="R" name="city" title="City" value="<?=$_POST[city]?>" id="city" placeholder="City">  
              <span id="marketDiv2"></span>
              <label>Pin Code :</label>
              <input type="text" value="<?=$_POST[pinCode]?>"  lang="R" title="Pin Code" name="pinCode" placeholder="Pin Code"> 
			  <label> Security Code :</label>
			  <?php  $rand =  $cms->generate_random_password(); ?>
			  <input type="text" disabled="disabled"    value="<?=$rand?>" alt="captcha" size="12" style="text-indent:10px; background:#<?=$colres[background]?>; font-weight:bold; width:60px;"/> 
			  <input type="hidden" name="captcha" value="<?=$rand?>" size="10"> 
			  <label  style="clear:both;">&nbsp;</label>
              <input type="text" value=""  lang="R" title="Security Code" name="secCode" placeholder="Enter Security Code.."> 
            </div>
          </fieldset>
          <div class="blankspace">&nbsp;</div>
          <input type="submit" name="submit" id="button" value="Submit" class="proceedbtn">
        </div>
        <div class="scnd_div_Detail">
          <img src="image/contact_img.jpg" width="429" height="335"  alt="" align="center"/>
          <p class="scnd_div_Detail_p_tag">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
