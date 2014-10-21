<?php
if($cms->is_post_back()){
	@extract($_POST);
	
	$password=$cms->encryptcode($password); 
	//echo $password;
	//exit;
	$rsAdmin_login = $cms->db_query("select pid,type, status, name, email_id from #_store_user where `user_name`='".$user_name."' and  `password`='".$password."'");
	if(mysql_num_rows($rsAdmin_login)){
		$arrAdmin_login = $cms->db_fetch_array($rsAdmin_login);
		if($arrAdmin_login[status]=='Active'){
			$_SESSION[uid] = $arrAdmin_login[pid]; 
			$_SESSION[usertype] = $arrAdmin_login[type];
			$_SESSION[store_id] = $cms->getSingleresult("select pid from #_store_detail where `store_user_id`='".$_SESSION[uid]."'");
			$_SESSION[eid] = $arrAdmin_login[email_id];
			$_SESSION[uname] = $arrAdmin_login[name];
			header("Location:".SITE_PATH_MEM); die; 
			 
		}
		else{
			$er= '<p align="left" style="color:red; margin:10px 0; display:block; " >Inactive Account, Please contact to administrator!</p>';
		} 
	} else {
		$er= '<p align="left" style="color:red; margin:10px 0; display:block; " >Invalid User name and password. Try again!</p>';
	}
}
include "site/search.inc.php";

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
                	<div class="stepbox"  style="width:auto; margin-left:30px;">Member Login Panel</div>
					
                    <div class="registerbox">
                    	<fieldset style="margin: 55px 0 10px 150px;width: 550px;">
                        	<legend>Store/Brand Login Here</legend>
							<?php
							if($er!=""){?>
							<p style="color:red"><?=$er?></p>
							<?php
							}
							?>
                            <div class="formarea">
                            	<label>User Name</label>
                                <input  name="user_name" title="User name" lang="R" value="<?=$user_name?>" type="text" class="othr_flds"> 
                                <label>Password</label>
                                <input name="password" value="" size="15" lang="R" title="Password" type="password" class="login_text_fild"> 
								 <p><span style="float:right">
								  <a href="<?=SITE_PATH?>forgot-password">Forgot Password?</a>
								  </span></p>
                            </div>
                        </fieldset> 
                        <div class="blankspace">&nbsp;</div>
                        <input type="submit" name="Submit"   value="Login" class="proceedbtn" /> 
                    </div>
                </div>
				</form>
            </div>
        </div>
 
    