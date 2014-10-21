<?php
if($cms->is_post_back()){
	@extract($_POST);
	$user_type=$_GET['user'];
	if($user_type=='storeuser'){
	$rsAdmin_login = $cms->db_query("select  fname,email,password from #_members where `email`='".$user_name."' ");
	        }else{
	$rsAdmin_login = $cms->db_query("select  name,email_id,password,user_name from #_store_user where `user_name`='".$user_name."' ");
	               }
	if(mysql_num_rows($rsAdmin_login)){
	            $rs = $cms->db_fetch_array($rsAdmin_login);
				
		        $adminEmail = SITE_MAIL;
				$headers = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= 'From: Fizzkart@fizzkart.com' . "\r\n" .'CC: '.$adminEmail; 				 
				$ch = $cms->db_query("select * from #_template where title ='Forgot Password' and store_id = '0' ");				 
				$tempRes = $cms->db_fetch_array($ch);
				$subject2 = $tempRes[subject]; 
				$mess2 = $tempRes[body]; 
		 if($user_type=='storeuser'){ 
				$mess2 = str_replace("%%name%%", $rs[fname],$mess2);
				$mess2 = str_replace("%%username%%", $rs[fname],$mess2);
				$mess2 = str_replace("%%email%%", $rs[email],$mess2);
				$mess2 = str_replace("%%password%%",$cms->decryptcode($rs[password]),$mess2);
				 
		        @mail($rs[email], $subject2, $mess2,$headers);
				$er= '<p align="left" style="color:green; margin:10px 0; display:block; " >Email Id And password Hass been Send Your email Id!</p>';
		  }else{
		        
				$mess2 = str_replace("%%name%%", $rs[name],$mess2);
				$mess2 = str_replace("%%username%%", $rs[user_name],$mess2);
				$mess2 = str_replace("%%email%%", $rs[email_id],$mess2);
				$mess2 = str_replace("%%password%%",$cms->decryptcode($rs[password]),$mess2);
				
		       @mail($rs[email_id], $subject2, $mess2,$headers);
			   $er= '<p align="left" style="color:green; margin:10px 0; display:block; " >User name And password Hass been Send Your email Id!</p>';
		  }
		
	} else {
		$er= '<p align="left" style="color:red; margin:10px 0; display:block; " >Invalid User name!</p>';
	}
}
//include "site/search.inc.php";

 ?>

<div class="contentarea">
        	 
            <div class="registerarea">
				<?php
			$qry = $cms->db_query("SELECT noOfDays,amount FROM `#_plans_hosting` where pid ='".$_SESSION[planID]."'  ");
			$res = $cms->db_fetch_array($qry);	

			$sql=$cms->db_query("select name from #_plans  where status='Active' and pid = '".$_SESSION[tarifid]."'");
			$res2 = $cms->db_fetch_array($sql);	
					 
			?>
            	<div class="heading"></div>
				<form method="post" action="" onSubmit="return formvalid(this);">
                <div class="subarea">
                	<div class="stepbox"  style="width:auto; margin-left:30px;">Forgot Password</div>
					
                    <div class="forgot_passdiv">
                    <h3>Forgot Your Password</h3>
                    	<fieldset class="forgot_pass_fieldset">
                        	
							<?php
							if($er!=""){?>
							<p style="color:red"><?=$er?></p>
							<?php
							}
							?>
                            <div class="formarea">
                            	<label>User Name or Email Id:</label>
                                <input  name="user_name" title="User name" lang="R" value="<?=$user_name?>" type="text" class="login_text_fild">  
                            </div>
                        </fieldset> 
                        <div class="blankspace">&nbsp;</div>
						
						<!-- <input type="submit" name="usrform_btn" id="usrform_btn" value="Login"> -->
                        <input type="submit" name="Submit"   value="Login" class="forgot_pass_submit_btn" id="usrform_btn" /> 
                    </div>
                </div>
				</form>
            </div>
        </div>
 
    