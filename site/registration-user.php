<?php 

  if($cms->is_post_back()){	
		 $check  = $cms->getSingleresult(" select count(*) from #_members where email = '".$_POST[email]."'");
		 if($_POST[password]!=$_POST[repassword] and trim($_POST[password])!=""){ 
			$postmsg= '<p class="error_msg">Password does not match!</p>'; 
		 }
		 if($check){ 
			$postmsg= '<p class="error_msg">This email is allready registered with us!</p>'; 
		 }
		 if(!$postmsg){ 
			$_POST[password] = $cms->encryptcode($_POST[password]);
			$cms->sqlquery("rs","members",$_POST); 
			$lastId  = mysql_insert_id(); 
			$mess = "Thanks for registering with us on fizzkart.com store.Now you have access of $base.fizzkart.com Admin fizzkart.com";
			$adminEmail = SITE_MAIL;
			$headers = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'From: Fizzkart@fizzkart.com' . "\r\n" .'CC: '.$adminEmail; 				 
			$ch = $cms->db_query("select * from #_template where title ='Registartion' and store_id = '0' ");				 
			$tempRes = $cms->db_fetch_array($ch);
			$subject2 = $tempRes[subject]; 
			$subject2 = str_replace("%%storename%%",SITE_PATH,$subject2);
			$mess2 = $tempRes[body]; 
			$mess2 = str_replace("%%subdomain%%", SITE_PATH,$mess2);
			$mess2 = str_replace("%%name%%", $_POST[fname].' ' .$_POST[lname],$mess2);
			$mess2 = str_replace("%%sex%%", $_POST[gender],$mess2);
			$mess2 = str_replace("%%email%%", $_POST[email],$mess2);
			$mess2 = str_replace("%%mobile%%", $_POST[mob],$mess2);
			$mess2 = str_replace("%%state%%", $_POST[state],$mess2);
			$mess2 = str_replace("%%address%%", $_POST[address],$mess2);
			$mess2 = str_replace("%%pincode%%", $_POST[zipcode],$mess2); 
			@mail($_POST[email], $subject2, $mess2,$headers); 
			$cms->sendSms($_POST[mob],$mess,$current_store_id);
			$postmsg= '<p class="success_msg">Thank you for successful registration.</p>';
			$_POST = false; 
			 
		}
	 }
	   $email_id=$_GET['email_id'];
	   if($email_id){
	   $rsAdmin_login = $cms->db_query("select * from #_members where `email`='".$email_id."'");
		if(mysql_num_rows($rsAdmin_login)){
			$arrAdmin_login = $cms->db_fetch_array($rsAdmin_login); extract($arrAdmin_login);  
			
	     }
	  }	 
	 include "site/search.inc.php";

?>

<div class="register_user-main">
  <div class="register_user_text-form">
    <div class="register_user_text">
      <h2>Register With Us</h2>
      <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum </p>
    </div>
    <div class="register_user_form" align="center">
      <h2>User Registration</h2>
      <table width="800" border="0" cellspacing="0" cellpadding="0">
        <form id="create-post-form" method="post" action="" onSubmit="return formvalid(this);" >
          <tr>
            <td align="left" valign="top"><table width="100%" border="0" align="center" cellpadding="10" cellspacing="10" align="left">
                <?php
	if($postmsg){?>
                <tr>
                  <td width="800" align="left" colspan="2" valign="middle" class="regtxt"><?=$postmsg?></td>
                </tr>
                <?php }
	?>
                <tr>
                  <td width="200" align="right" valign="middle" class="regtxt">Name :</td>
                  <td width="600" align="left" valign="middle"><input type="text" name="fname" lang="RisAlpha" title="First Name" value="<?=$_POST[fname]?>" id="textfield" autofocus class="fld_regname margin_none" placeholder="First Name"/>-<input type="text" name="lname" lang="RisAlpha" title="Second Name" id="textfield2"  value="<?=$_POST[lname]?>" class="fld_regname" placeholder="Last Name"/></td>
                </tr>
                <tr>
                  <td width="200" align="right" valign="middle" class="regtxt">Sex :</td>
                  <td width="600" align="left" valign="middle" class="raddtxt"><input type="radio" name="gender" checked="checked"  value="Male" />
                    Male&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="gender"   value="Female" />
                    Female </td>
                </tr>
                <tr>
                  <td width="200" align="right" valign="middle" class="regtxt">Email :</td>
                  <td width="600" align="left" valign="middle"><input type="text" name="email" id="" title="Email" lang="RisEmail" value="<?=$_POST[email]?>"  class="fld_regname email"  placeholder="Your Email id"/></td>
                </tr>
                <tr>
                  <td width="200" align="right" valign="middle" class="regtxt">Password :</td>
                  <td width="600" align="left" valign="middle"><input type="password"  name="password"  title="Password" lang="R"  class="fld_regname email" placeholder="Password"/></td>
                </tr>
                <tr>
                  <td width="200" align="right" valign="middle" class="regtxt">Re-Enter Password :</td>
                  <td width="600" align="left" valign="middle"><input type="password"  name="repassword"  title="Re-Enter Password" lang="R" class="fld_regname email" placeholder="Re-Enter Password"/></td>
                </tr>
                <tr>
                  <td width="200" align="right" valign="middle" class="regtxt">Mobile:</td>
                  <td width="600" align="left" valign="middle"><input type="text" name="mob" value="<?=$_POST[mob]?>" lang="R" title="Mobile" id="Mobile" class="fld_regname email"   placeholder="Your Mobile Number"/></td>
                </tr>
                <tr>
                  <td width="200" align="right" valign="middle" class="regtxt">City :</td>
                  <td width="600" align="left" valign="middle"><?php  $sql_city1="select pid,city from #_city where country_id='80'";
		$sql_city1_query=$cms->db_query($sql_city1);
		?>
                    <input type="hidden" name="country_id" class="fld_regname select" value="80" />
                    <select lang="R" title="City" name="city_id" class="fld_regname select" >
                      <option value="">Select</option>
                      <?php while($city_array=$cms->db_fetch_array($sql_city1_query)){ ?>
                      <option value="<?php echo $city_array['pid']; ?>" <? if($_POST[city_id]==$city_array['pid'])echo 'selected="selected"'; ?>><?php echo $city12=$city_array['city']; ?></option>
                      <?php }?>
                    </select></td>
                </tr>
                <tr>
                  <td width="200" align="right" valign="middle" class="regtxt">State :</td>
                  <td width="600" align="left" valign="middle"><input list="browsers" name="state" value="<?=$_POST[state];?>" lang="R" title="State" class="fld_regname browser" placeholder="Type Your City Here" />
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
                    </datalist></td>
                </tr>
                <tr>
                  <td width="200" align="right" valign="top" class="regtxt">Address :</td>
                  <td width="600" align="left" valign="middle"><textarea name="address" lang="R" title="Address" id="textarea" cols="5" rows="4" class="fld_regname textarea" placeholder="Your Address"><?=stripslashes($_POST[address])?>
</textarea></td>
                </tr>
                <tr>
                  <td width="200" align="right" valign="middle" class="regtxt">Pin Code:</td>
                  <td width="600" align="left" valign="middle"><input type="text" name="zipcode" lang="RisNaN" title="Zipe Code" id="textfield7" class="fld_regname pin_code" value="<?=$_POST[zipcode]?>"  placeholder="Your Pin Code"/>
                    `</td>
                </tr>
                <tr>
                  <td width="200" align="right" valign="middle" class="regtxt">&nbsp;</td>
                  <td width="600" align="left" valign="middle"><input type="submit" name="button" id="button"  value="Submit" class="login_button subbutton" />
                    <input type="reset" name="button2" id="button2" value="Reset" class="sub_regbtn"/></td>
                </tr>
              </table></td>
          </tr>
        </form>
      </table>
    </div>
    <div class="frm_main4"></div>
  </div>
</div>
