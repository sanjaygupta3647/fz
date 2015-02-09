<?php  
	$ch = $cms->db_query("select * from #_template where title ='Registartion' and store_id = '$current_store_id' ");
	if(!mysql_num_rows($ch)){
		$ch = $cms->db_query("select * from #_template where title ='Registartion' and store_id = '0' ");
	} 
	$tempRes = $cms->db_fetch_array($ch);
	echo $tempRes[body]; 

	$metaTitle = $cms->getSingleresult("select meta_title from #_meta_info where url='registration' and store_user_id = '$current_store_user_id'");
	$metaIntro = $cms->getSingleresult("select meta_description from #_meta_info where url='registration' and store_user_id = '$current_store_user_id'");
	$metaKeyword = $cms->getSingleresult("select meta_keyword from #_meta_info where url='registration' and store_user_id = '$current_store_user_id'");
	if($cms->is_post_back()){	
		if($_POST[password]!=$_POST[repassword] and trim($_POST[password])!=""){
			$er= '<p align="left" style="color:red; margin:10px 0; display:block; ">Password does not match!</p>'; 
		} else { 
			$chek=$cms->getSingleresult("select email from #_members where email='".$_POST[email]."'"); 
			if(!$chek){
				$_POST[password] = $cms->encryptcode($_POST[password]);
				$cms->sqlquery("rs","members",$_POST); 
				$lastId  = mysql_insert_id();
				$arr[user_id] = $lastId;
				$arr[store_id] = $current_store_id;
				$cms->sqlquery("rs","member_access",$arr);
				$urlsite =  str_replace("http://","",SITE_PATH);
				$urlsite =  str_replace("/","",$urlsite);
				$mess = "Thanks for registering with us on fizzkart.com store.Now you have access of $urlsite Admin fizzkart.com";
				$adminEmail = $cms->getSingleresult("select email_id from #_store_user where pid = '$current_store_user_id' ");
				$headers = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= 'From: '.$adminEmail . "\r\n" .'CC: '.$adminEmail;
				$ch = $cms->db_query("select * from #_template where title ='Registartion' and store_id = '$current_store_id' ");
				if(!mysql_num_rows($ch)){
					$ch = $cms->db_query("select * from #_template where title ='Registartion' and store_id = '0' ");
				} 
				$tempRes = $cms->db_fetch_array($ch);
				$subject2 = $tempRes[subject]; 
				$subject2 = str_replace("%%storename%%",$urlsite,$subject2);
				$mess2 = $tempRes[body]; 
				$mess2 = str_replace("%%subdomain%%",SITE_PATH,$mess2);
				$mess2 = str_replace("%%name%%", $_POST[fname].' ' .$_POST[lname],$mess2);
				$mess2 = str_replace("%%sex%%", $_POST[gender],$mess2);
				$mess2 = str_replace("%%email%%", $_POST[email],$mess2);
				$mess2 = str_replace("%%mobile%%", $_POST[mob],$mess2);
				$mess2 = str_replace("%%state%%", $_POST[state],$mess2);
				$mess2 = str_replace("%%address%%", $_POST[address],$mess2);
				$mess2 = str_replace("%%pincode%%", $_POST[zipcode],$mess2); 
				@mail($_POST[email], $subject2, $mess2,$headers); 
				$cms->sendSms($_POST[mob],$mess,$current_store_id);
				$er= '<p align="left" style="color:green; margin:10px 0; display:block; " >Thank you for successful registration.</p>';
				$_POST = false; 
			}else{
				$er= '<p align="left" style="color:red; margin:10px 0; display:block; " >This email id allrady registered.</p>'; 
			}
		}
	}
?>

<div class="body" >
	<div class="domain_register_frm_main">
		<div class="frm_main1"> <br />
			<h2>Register With Us</h2>
			<p>
				fizzkart is India's best online shopping platform, a place where people can connect with each other to buy and services. Launched in soon with the vision for buyers and sellers to "meet online ", today we have over million people buy online shop product.
			</p>
			<p>
				Sign up below form for enjoy all services from fizzkart.com.  
			</p>
		</div>
		<div class="regfrm_main3" align="center">
			<table width="800" border="0" cellspacing="0" cellpadding="0">
				<form id="create-post-form" method="post" action="" onSubmit="return formvalid(this);" >
					<tr>
						<td align="left" valign="top">
							<table width="800" border="0" align="center" cellpadding="10" cellspacing="10">
								<?php if($er){?>
								<tr>
									<td width="800" align="left" colspan="2" valign="middle" class="regtxt"><?=$er?></td>
								</tr>	
								<?php } ?>
								<tr>
									<td width="200" align="right" valign="middle" class="regtxt">Name :</td>
									<td width="600" align="left" valign="middle">
										<input type="text" name="fname" lang="R" title="First Name" value="<?=$_POST[fname]?>" id="textfield" autofocus   class="fld_regname" placeholder="First Name"/> -
										<input type="text" name="lname" id="textfield2"  value="<?=$_POST[lname]?>"    class="fld_regname" placeholder="Last Name"/>
									</td>
								</tr>
								<tr>
									<td width="200" align="right" valign="middle" class="regtxt">Sex :</td>
									<td width="600" align="left" valign="middle" class="raddtxt">
										<input type="radio" name="gender" checked="checked"  value="Male" />Male&nbsp;&nbsp;&nbsp;
										<input type="radio" name="gender"   value="Female" />Female
									</td>
								</tr>
								<tr>
									<td width="200" align="right" valign="middle" class="regtxt">Email :</td>
									<td width="600" align="left" valign="middle">
										<input type="email" name="email" id="" title="Name" lang="RisEmail" value="<?=$_POST[email]?>"  class="othr_flds"  placeholder="Your Email id"/>
									</td>
								</tr>
								<tr>
									<td width="200" align="right" valign="middle" class="regtxt">Password :</td>
									<td width="600" align="left" valign="middle">
										<input type="password"  name="password"  title="Password" lang="R" class="othr_flds" placeholder="Password"/>
									</td>
								</tr>
								<tr>
									<td width="200" align="right" valign="middle" class="regtxt">Re-Enter Password :</td>
									<td width="600" align="left" valign="middle">
										<input type="password"  name="repassword"  title="Re-Enter Password" lang="R" class="othr_flds" placeholder="Re-Enter Password"/>
									</td>
								</tr>
								<tr>
									<td width="200" align="right" valign="middle" class="regtxt">Mobile:</td>
									<td width="600" align="left" valign="middle">
										<input type="text" name="mob" value="<?=$_POST[mob]?>" lang="R" title="Mobile" id="Mobile" class="othr_flds"   placeholder="Your Mobile Number"/>
									</td>
								</tr>
								<tr>
									<td width="200" align="right" valign="middle" class="regtxt">City :</td>
									<td width="600" align="left" valign="middle">
										<?php  $sql_city1="select pid,city from #_city where country_id='80'";
										$sql_city1_query=$cms->db_query($sql_city1);
										?>
										<input type="hidden" name="country_id" class="login_text_fild" value="80" />
										<select class="login_text_fild" lang="R" title="City" name="city" style=" background-color:#fff; float:left;height:30px;width:315px;margin-left: 0px;color: black; border-radius:5px;" >
											<option value="">Select</option>
											<?php while($city_array=$cms->db_fetch_array($sql_city1_query)){  ?>
											<option value="<?=$city_array['city']?>" <? if($_POST[city]==$city_array['city'])echo 'selected="selected"'; ?>><?php echo $city_array['city']; ?></option>
											<?php }?>
										</select>
									</td>
								</tr>
								<tr>
									<td width="200" align="right" valign="middle" class="regtxt">State :</td>
									<td width="600" align="left" valign="middle">
										<input list="browsers" name="state" value="<?=$_POST[state]?>" lang="R" title="State" class="othr_flds" placeholder="Type Your State Here">
										<datalist id="browsers">
										  <option value="Uttar Pradesh">
										  <option value="Maharashtra">
										  <option value="Bihar">
										  <option value="West Bengal">
										  <option value="Andhra Pradesh">
										  <option value="Madhya Pradesh">
										  <option value="Tamil Nadu">
										  <option value="Rajasthan">
										  <option value="Karnataka">
										  <option value="Gujarat">
										  <option value="Odisha">
										  <option value="Kerala">
										  <option value="Jharkhand">
										  <option value="Assam">
										  <option value="Punjab">
										  <option value="Chhattisgarh">
										  <option value="Haryana">
										  <option value="Jammu and Kashmir">
										  <option value="Uttarakhand">
										  <option value="Himachal Pradesh">
										  <option value="Tripura">
										  <option value="Meghalaya">
										  <option value="Manipur">
										  <option value="Nagaland">
										  <option value="Goa">
										  <option value="Arunachal Pradesh">
										  <option value="Mizoram">
										  <option value="Sikkim">
										  <option value="Delhi">
										  <option value="Puducherry">
										  <option value="Chandigarh">
										  <option value="Andaman and Nicobar Islands">
										  <option value="Dadra and Nagar Haveli">
										  <option value="Daman and Diu">
										  <option value="Lakshadweep">  
										</datalist>
									</td>
								</tr>
								<tr>
									<td width="200" align="right" valign="top" class="regtxt">Address :</td>
									<td width="600" align="left" valign="middle">
										<textarea name="address" lang="R" title="Address" id="textarea" cols="5" rows="4" class="area_regadress" placeholder="Your Address"><?=stripslashes($_POST[address])?></textarea>
									</td>
								</tr>
								<tr>
									<td width="200" align="right" valign="middle" class="regtxt">Pin Code :</td>
									<td width="600" align="left" valign="middle">
										<input type="text" name="zipcode" lang="R" title="Pin Code" id="textfield7" class="othr_flds" value="<?=$_POST[zipcode]?>"  placeholder="Pin Code"/>
									</td>
								</tr>
								<tr>
									<td width="200" align="right" valign="middle" class="regtxt">&nbsp;</td>
									<td width="600" align="left" valign="middle"><input type="submit" name="button" id="button" value="Submit" class="sub_regbtn"/>
										<input type="reset" name="button2" id="button2" value="Reset" class="sub_regbtn"/>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</form>
			</table>
		</div>
		<div class="frm_main4"></div>
	</div>
</div>
