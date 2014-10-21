<?php
	$metaTitle = $cms->getSingleresult("select meta_title from #_meta_info where url='contact-us' and store_user_id = '$current_store_user_id'");
	$metaIntro = $cms->getSingleresult("select meta_description from #_meta_info where url='contact-us' and store_user_id = '$current_store_user_id'");
	$metaKeyword = $cms->getSingleresult("select meta_keyword from #_meta_info where url='contact-us' and store_user_id = '$current_store_user_id'");
	if($cms->is_post_back()) {
		if(strtolower($_POST['secCode'])==strtolower($_POST['captcha'])){
			$_POST['ipaddress'] = $_SERVER['REMOTE_ADDR'];
			$_POST['store_id'] = $current_store_id; 
			$usermail = $cms->getSingleresult("select email_id from #_store_user where pid = '".$current_store_user_id."'");
			$_POST['mailto'] = $usermail;
			$uids =  $cms->sqlquery("rs","contact",$_POST); 
			if($uids){
				$er= '<p align="left" style="color:green; margin:10px 0; display:block; " >Thank You For Contact With Us. We Will Get You Back Soon.</p>'; 
				$adminEmail = $cms->getSingleresult("select email_id from #_store_user where pid = '$current_store_user_id' ");
				$headers = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= 'From: Fizzkart@fizzkart.com' . "\r\n";
				$ch = $cms->db_query("select * from #_template where title ='Sub Domain Site Query' and store_id = '$current_store_id' ");
				if(!mysql_num_rows($ch)){
					$ch = $cms->db_query("select * from #_template where title ='Sub Domain Site Query' and store_id = '0' ");
				} 
				$tempRes = $cms->db_fetch_array($ch);
				$subject2 = $tempRes[subject]; 
				$subject2 = str_replace("%%sitename%%", $base.".fizzkart.com",$subject2);
				$mess2 = $tempRes[body]; 
				$mess2 = str_replace("%%sitename%%", SITE_PATH,$mess2);
				$mess2 = str_replace("%%name%%",$_POST[name],$mess2);
				$mess2 = str_replace("%%contact%%",$_POST[phone],$mess2);
				$mess2 = str_replace("%%pincode%%",$_POST[pinCode],$mess2);
				$mess2 = str_replace("%%city%%",$_POST[city],$mess2);
				$mess2 = str_replace("%%email%%",$_POST[email],$mess2);
				$mess2 = str_replace("%%query%%",$_POST[query],$mess2);				 
				@mail($_POST[email], $subject2, $mess2,$headers);  
				@mail($adminEmail, $subject2, $mess2,$headers);  
				$_POST = false;
			}
		} else {
			$er= '<p align="left" style="color:red; margin:10px 0; display:block; " >Invalid Security Code!</p>'; 
		} 
	}
?>
<div class="body">
	<div class="domain_contact_main">
		<h2>
			fizzkart is India's best online shopping platform, a place where people can connect with each other to buy and services. Launched in soon with the vision for buyers and sellers to "meet online ", today we have over million people buy online shop product.
		</h2>
		<div class="regfrm_main3" align="center">
			<h2> Submit Your Query </h2>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<form id="create-post-form" method="post" action="" onSubmit="return formvalid(this);" >
					<tr>
						<td align="left" valign="top">
							<table width="100%" border="0" align="center" cellpadding="4" cellspacing="4">
								<?php if($er){ ?>
								<tr>
									<td width="" align="left" colspan="2" valign="middle" class="regtxt"><?=$er?></td>
								</tr>	
									<?php } ?>
								<tr>
									<td width="30%" align="right" valign="middle" class="regtxt">Name :</td>
									<td width="70%" align="left" valign="middle">
										<input type="text" name="name" lang="R" title="First Name" value="<?=$_POST['name']?>" id="textfield" autofocus   class="othr_flds" placeholder="Name"/>
									</td>
								</tr>
								<tr>
									<td width="30%" align="right" valign="middle" class="regtxt">Mobile:</td>
									<td width="70%" align="left" valign="middle">
										<input type="text" name="phone"  value="<?=$_POST['phone']?>"  lang="RisNaN" title="Mobile" id="Mobile" class="othr_flds"   placeholder="Your Mobile Number"/>
									</td>
								</tr> 
								<tr>
									<td width="30%" align="right" valign="middle" class="regtxt">Email :</td>
									<td width="70%" align="left" valign="middle">
										<input type="email" name="email" id="" title="Name" lang="RisEmail" value="<?=$_POST[email]?>"  class="othr_flds"  placeholder="Your Email id"/>
									</td>
								</tr> 
								<tr>
									<td width="30%" align="right" valign="top" class="regtxt">Query :</td>
									<td width="70%" align="left" valign="middle">
										<textarea name="query" cols="5" rows="4" class="area_regadress" placeholder="Write Your Query Here.."><?=$_POST[query]?></textarea>
									</td>
								</tr> 
								<tr>
									<td width="30%" align="right" valign="middle" class="regtxt">City :</td>
									<td width="70%" align="left" valign="middle">
										<input type="text" name="city" lang="R" title="City" id="textfield7" class="othr_flds" value="<?=$_POST[city]?>"  placeholder="City"/>
									</td>
								</tr>
								<tr>
									<td width="30%" align="right" valign="middle" class="regtxt">Pin Code :</td>
									<td width="70%" align="left" valign="middle">
									<input type="text" name="pinCode" lang="R" title="Pin Code" id="textfield7" class="othr_flds" value="<?=$_POST[pinCode]?>"  placeholder="Pin Code"/>
								</td>
								</tr>
								<tr>
									<td width="30%" align="right" valign="bottom" class="regtxt">Security code:</td>
									<td width="70%" align="left" valign="top">
										<?php $rand =$cms->generate_random_password(); ?>
										<input type="text" disabled="disabled" class="othr_flds"  value="<?=$rand?>" alt="captcha" size="5" style="text-indent:3px; background:#<?=$colres[background]?>; font-weight:bold; width:60px;"/><br /><br /> 
										<input type="hidden" name="captcha" value="<?=$rand?>">
										<input name="secCode" class="othr_flds" value=""  title="Security Code" lang="R" type="text" placeholder="Enter the code above here" />
									</td>
								</tr> 
								<tr>
									<td width="30%" align="right" valign="middle" class="regtxt">&nbsp;</td>
									<td width="70%" align="left" valign="middle">
										<input type="submit" name="button" id="button" value="Submit" class="sub_regbtn"/>
										<input type="reset" name="button2" id="button2" value="Reset" class="sub_regbtn"/>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</form>
			</table>
		</div>
		<div class="domain_contact_right">
			<h2>Feedback</h2>
			<p>Want to share a quick feedback? Awesumed by us? Or Not happy with the product? Join the fizzkart community at
			<a href="mailto:support.fizzkart.com">support.fizzkart.com</a> and give us a shout!</p>
			<h2>Complaint</h2>
			<p>If you are not happy with our services call the number above and ask for a Complaint to be raised. Our complaint handling champs would attend to your issue straightaway.
			If your concern still remains unresolved, please drop an email to: <a href="mailto:support.fizzkart.com">support@fizzkart.com</a></p>
			<img src="<?=SITE_PATH?>images/contact_img.jpg" width="429" height="335"  alt="" align="right"/> 
		</div>
	</div>
</div>
 