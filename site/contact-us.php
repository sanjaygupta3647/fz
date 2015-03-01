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
<div class="row" style="margin-top:20px;">
  <div class="col-md-12 col-sm-12">
    
  </div>
  <div class="col-md-12 col-sm-12"> 
    <div class="heading2 col-md-12 col-sm-12"><?=$cms->removeSlash($heading)?>
      
    </div>
    <form class="form-horizontal" role="form"  method="post" action="" onSubmit="return formvalid(this);" >
      <div class="col-md-12 col-sm-12">
		<?=$msg?>
        <div><?=$cms->removeSlash($body)?></div>
                    
         <div class="col-md-12 col-sm-12">
         <h2 class="h5">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate </h2>
        <div class="col-md-6 col-sm-6">
          <fieldset>
          <legend>Fill this form for your query</legend>
            <div class="col-md-12 col-sm-12">
              <div class="form-group">
				  <label for="store_name" class="col-md-4 col-sm-4 control-label">Name :</label>
				  <div class="col-md-8 col-sm-8">
					<input type="text" class="form-control" lang="R" name="name" title="Your Name" value="<?=$_POST[name]?>" id="store_name" placeholder="Your Name">
				  </div>
			  </div>
              <div class="form-group">
				  <label for="tagline" class="col-md-4 col-sm-4 control-label">Email :</label>
				  <div class="col-md-8 col-sm-8">
					<input type="email" class="form-control" lang="RisEmail" name="email" value="<?=$_POST[email]?>"  title="Email" id="tagline" placeholder="Your Email Address" >
				  </div>
			  </div>
              <div class="form-group">
				  <label for="phone" class="col-md-4 col-sm-4 control-label">Contact No :</label>
				  <div class="col-md-8 col-sm-8">
					<input type="text" class="form-control" lang="R" name="phone" title="Phone" value="<?=$_POST[phone]?>" id="phone" placeholder="Contact No.">
				  </div>
			  </div>
              <div class="form-group">
				  <label for="query" class="col-md-4 col-sm-4 control-label">Query :</label>
				  <div class="col-md-8 col-sm-8">
					<textarea name="query" class="form-control" id="query" title="Query" lang="R" placeholder="Write Your Query Here..." rows="5" cols="4"><?=$_POST[query]?></textarea>
				  </div>
			  </div>
			  <div class="form-group">
				  <label for="city" class="col-md-4 col-sm-4 control-label">City :</label>
				  <div class="col-md-8 col-sm-8">
					<input type="text" class="form-control" lang="R" name="city" title="City" value="<?=$_POST[city]?>" id="city" placeholder="City">  
				  </div>
			  </div>
			  <div class="form-group">
				  <label for="pincode" class="col-md-4 col-sm-4 control-label">Pin Code :</label>
				  <div class="col-md-8 col-sm-8">
					<input type="text" class="form-control" value="<?=$_POST[pinCode]?>"  lang="R" title="Pin Code" id="pincode" name="pinCode" placeholder="Pin Code"> 
				  </div>
			  </div>
			  <div class="form-group">
				  <label for="secCode" class="col-md-4 col-sm-4 control-label">Security Code :</label>
				  <div class="col-md-8 col-sm-8">
					<?php  $rand =  $cms->generate_random_password(); ?>
					  <input type="text" disabled="disabled"    value="<?=$rand?>" alt="captcha" size="12" style="text-indent:10px; background:#<?=$colres[background]?>; font-weight:bold; width:60px;"/> 
					  <input type="hidden" name="captcha" value="<?=$rand?>" size="10"> 
					  <label  style="clear:both;">&nbsp;</label>
					  <input type="text" class="form-control" value="" id="secCode"  lang="R" title="Security Code" name="secCode" placeholder="Enter Security Code..">
				  </div>
			  </div>
			   
            </div>
          </fieldset>
          <div class="blankspace">&nbsp;</div>
          <div class="form-group">
				<div class="col-md-offset-3 col-md-9 col-sm-offset-3 col-sm-9">
				<input type="submit" name="submit" id="button" value="Submit" class="proceedbtn">
				</div>
		  </div>
        </div>
        <div class="col-md-6 col-sm-6">
          <img src="image/contact_img.jpg" class="img-responsive"  alt=""/>
          <p class="scnd_div_Detail_p_tag">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
