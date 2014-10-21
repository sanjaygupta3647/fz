<?php 

if($cms->is_post_back()){ 
		 $_SESSION[theme] =  'domain';
		 $_SESSION[type] =  $_POST[type];
		 $_SESSION[tarifid] =  $_POST[tarifid];
		 $_SESSION[planID] =  $_POST[planID];
		 $_SESSION[proceed] =  1;
		 //print_r($_SESSION);
 		 header("Location:".SITE_PATH."Step-2"); 
}
include "site/search.inc.php";
?>

<div class="contentarea">
        	<div class="registerheadbox">
            	<div class="heading"><img src="images/heading-arrow-icon.jpg" width="11" height="7" alt="Register with us" /> New User? Register with us</div>
                <div class="subtext">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum </div>
            </div>
            <div class="registerarea">
            	<div class="heading">Enter your Details</div>
                <table width="800" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#fff">
<form id="create-post-form" method="post" action="" onSubmit="return formvalid(this);" >
<tr>
    <td align="left" valign="top"><table width="800" border="0" align="center" cellpadding="10" cellspacing="10">
    <tr>
    	<td width="800" align="left" colspan="2" valign="middle" class="regtxt"></td>
    </tr>
	
      <tr>
        <td width="200" align="right" valign="middle" class="reg_formtext">Name :</td>
        <td width="600" align="left" valign="middle">
        <input type="text" name="fname" lang="R" value="" id="textfield" autofocus placeholder="First Name" /> -
        <input type="text" name="lname" id="textfield2"  placeholder="Last Name" placeholder="First Name" /></td>
        
      </tr>
	  <tr>
        <td width="200" align="right" valign="middle" class="reg_formtext">Sex :</td>
        <td width="600" align="left" valign="middle" class="raddtxt">
        <input type="radio" name="gender" value="Male" />Male&nbsp;&nbsp;&nbsp;
        <input type="radio" name="gender" value="Female" />Female
            </td>
      </tr>
	  <tr>
        <td width="200" align="right" valign="middle" class="reg_formtext">Email :</td>
        <td width="600" align="left" valign="middle">
		<input type="email" name="email" id="" lang="RisEmail" value="" placeholder="Your Email id" /></td>
      </tr>
	  <tr>
        <td width="200" align="right" valign="middle" class="reg_formtext">Password :</td>
        <td width="600" align="left" valign="middle"><input type="password"  name="password"  title="Password" lang="R" class="othr_flds" placeholder="Enter Your Password"/></td>
      </tr>
	   <tr>
        <td width="200" align="right" valign="middle" class="reg_formtext">Re-Enter Password :</td>
        <td width="600" align="left" valign="middle">
		<input type="password"  name="repassword"  title="Re-Enter Password" lang="R" class="othr_flds" placeholder="Re-Enter Your Password"/></td>
      </tr>
      <tr>
        <td width="200" align="right" valign="middle" class="reg_formtext">Mobile:</td>
        <td width="600" align="left" valign="middle"><input type="text" name="mob" value="" lang="R" title="Mobile" id="Mobile" class="textfield_mobile"   placeholder="Your Mobile Number"/></td>
      </tr>
      <tr>
        <td width="200" align="right" valign="middle" class="reg_formtext">City :</td>
        <td width="600" align="left" valign="middle">
		
              <input type="hidden" name="country_id" class="login_text_fild" value="80" />
               
              <select class="login_text_fild" lang="R" title="City" name="city_id" >
                <option value="">Select</option>
                <option value="Haryana">Haryana</option>
                <option value="Delhi">Delhi</option>
                <option value="Uttar-Pradesh">Uttar-Pradesh</option>
                <option value="Kolkata">Kolkata</option>
              </select>
		</td>
      </tr>
      
      
      <tr>
        <td width="200" align="right" valign="middle" class="reg_formtext">State :</td>
        <td width="600" align="left" valign="middle">
        <select list="browsers" name="state" value="" lang="R" title="State" class="othr_flds" placeholder="Type Your City Here">        
		
          <option value="">Select</option>
          <option value="Uttar Pradesh">Uttar Pradesh</option>
          <option value="Maharashtra">Maharashtra</option>
          <option value="Bihar">Bihar</option>
          <option value="West Bengal">West Bengal</option>
        </select>
        
        </td>
      </tr>
      <tr>
        <td width="200" align="right" valign="top" class="reg_formtext">Address :</td>
        <td width="600" align="left" valign="middle"><textarea name="address" lang="R" title="Address" id="textarea" cols="5" rows="4" class="area_regadress" placeholder="Your Address"></textarea></td>
      </tr>
      <tr>
        <td width="200" align="right" valign="middle" class="reg_formtext">Pin Code :</td>
        <td width="600" align="left" valign="middle"><input type="text" name="zipcode" id="textfield7" class="textfield_pincode" value=""  placeholder="Your Area Pincode"/></td>
      </tr>
      
      <tr>
        <td width="200" align="right" valign="middle" class="regtxt">&nbsp;</td>
        <td width="600" align="left" valign="middle"><input type="submit" name="button" id="button" value="Submit" />
          <input type="reset" name="button2" id="button2" value="Reset" /></td>
      </tr>
    </table></td>
  </tr>
</form>
</table>
            </div>
        </div>