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
				$er= '<p align="left" style="color:green; margin:10px 0; display:block; " >Your login detail has been sent to the registered email id!</p>';
		  }else{
		        
				$mess2 = str_replace("%%name%%", $rs[name],$mess2);
				$mess2 = str_replace("%%username%%", $rs[user_name],$mess2);
				$mess2 = str_replace("%%email%%", $rs[email_id],$mess2);
				$mess2 = str_replace("%%password%%",$cms->decryptcode($rs[password]),$mess2);
				
		       @mail($rs[email_id], $subject2, $mess2,$headers);
			   $er= '<p align="left" style="color:green; margin:10px 0; display:block; " >Your login detail has been sent to the registered email id!</p>';
		  }
		
	} else {
		$er= '<p align="left" style="color:red; margin:10px 0; display:block; " >Invalid User name!</p>';
	}
}
include "site/search.inc.php";

 ?>

<div class="row" style="margin-top:20px;">
        	 
            <div class="col-md-12 col-sm-12">
				<?php
			$qry = $cms->db_query("SELECT noOfDays,amount FROM `#_plans_hosting` where pid ='".$_SESSION[planID]."'  ");
			$res = $cms->db_fetch_array($qry);	

			$sql=$cms->db_query("select name from #_plans  where status='Active' and pid = '".$_SESSION[tarifid]."'");
			$res2 = $cms->db_fetch_array($sql);	
					 
			?>
            	
				<form method="post" class="form-horizontal" role="form" action="" onSubmit="return formvalid(this);">
                <div class="">
                	<div class="heading col-md-12 col-sm-12">Forgot Password</div>
					
                    <div class="col-md-6 col-sm-6">
                    	<fieldset class="forgot_pass-field">
                        	<legend>Fill the following details  </legend>
							<?php
							if($er!=""){?>
							<p style="color:red"><?=$er?></p>
							<?php
							}
							?>
							<div class="form-group">
								  <label for="Name" class="col-md-3 col-sm-3 control-label"><?php if($_GET[user]!='memberuser'){ ?>Email Id <?php }else{ ?> User Name <?php } ?></label>
								  <div class="col-md-9 col-sm-9">
									<input class="form-control" name="user_name" title="Email Id" lang="R" <?php if($_GET[user]!='memberuser'){ ?>placeholder="Enter Your Email Id" <?php }else{ ?> placeholder="Enter Your User Name" <?php } ?> value="<?=$user_name?>" type="text" class="login_text_fild"> 
								  </div>
							</div>
                            
                        </fieldset> 
                        <div class="form-group">
							<div class="col-md-offset-3 col-md-9 col-sm-offset-3 col-sm-9">
								<input type="submit" name="Submit"  value="Submit" class="btn btn-primary" /> 
							</div>
						</div>
                    </div>
                </div>
				</form>
            </div>
        </div>
 
    