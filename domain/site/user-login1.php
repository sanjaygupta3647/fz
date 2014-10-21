<?php

$metaTitle = $cms->getSingleresult("select meta_title from #_meta_info where url='login' and store_user_id = '$current_store_user_id'");
$metaIntro = $cms->getSingleresult("select meta_description from #_meta_info where url='login' and store_user_id = '$current_store_user_id'");
$metaKeyword = $cms->getSingleresult("select meta_keyword from #_meta_info where url='login' and store_user_id = '$current_store_user_id'");
 if($cms->is_post_back()){
	@extract($_POST);
	$rsAdmin_login = $cms->db_query("select pid, fname, lname, email from #_members where `email`='".$email."' and  `password`='".$cms->encryptcode($password)."'");
	if(mysql_num_rows($rsAdmin_login)){
		$arrAdmin_login = $cms->db_fetch_array($rsAdmin_login);  
		$tcnt =$cms->getSingleresult("select count(*) from #_member_access where store_id='".$current_store_id."' and  `user_id`='".$arrAdmin_login[pid]."'");
		if($tcnt){
			$_SESSION[userid] = $arrAdmin_login[pid]; 
			$_SESSION[user_store_id] = $current_store_id; 
			$_SESSION[email] = $arrAdmin_login[email];
			$_SESSION[fname] = $arrAdmin_login[fname];
			$_SESSION[lname] = $arrAdmin_login[lname];
			$arr4=array();
		    $arr4[userid]=$_SESSION[userid]; 
			$arr4[user_store_id]=$_SESSION[user_store_id]; 
			 $cms->sqlquery("rs","user_log",$arr4); 
			  if($_SESSION[review]=='review'){ 
			      $itmes1=$_SESSION[title1];
	              $itmes2=$_SESSION[prod_id1];  
			   $cms->redir(SITE_PATH."product_rate/$itmes1/$itmes2",true);die;  }
			$getcartQty = $cms->getSingleresult("select count(*) from #_cart where  ssid = '".session_id()."'"); 
			if($getcartQty){
			
			$cms->redir(SITE_PATH."cart",true);
			 }
			else{
			  
			   $cms->redir(SITE_PATH."profile",true);die; 
			} 
		}else{
			$er= 'You are not register for this Store/Brand Domain!';
 		}
		 
		
	} else {
		$er= 'Invalid email id and password. Try again! ';
	     
	}
}

?>
<div class="maindiv_login">
<div class="maindiv_login_left">
<?php if($er){ ?> <p class="error_msg_p"><?=$er?></p>  <?php } ?> 
<div class="headind_signin"><strong>Sign in</strong></div>
<div class="signin_div">
<form name="" action="" method="post">
<div class="signin_page-fields">
<div class="signin_page-fields1">
<span><label for="user-id">Email or User Id</label></span>
<span><input type="text" name="email" title="User name" id="usr-id_field" class="usr-id_field_cls othr_flds username_icon" lang="RisEmail" value="<?=$email?>" placeholder="Email or Username" /></span>
</div>
<div class="signin_page-fields1">
<span><label for="user-id">Password</label></span>
<span><input type="password" name="password" id="usr-id_field"  lang="R"  title="Password" class="usr-id_field_cls othr_flds password_icon" placeholder="Your Password" /></span>

<div class="forgot_id-pass_div">
<span><a href="#">Forgot your id</a></span><span>Or</span><span><a href="forgot-password?user=memberuser">Forgot your Password</a></span>
</div>
</div>
</div>
<div class="signin_check">
<span><input type="checkbox" name="signin_check" id="signin_check" class="signin_check_cls" /></span>
<span><label for="checkbox">Lorem Ipsum dolor sit amet</label></span>
</div>
<div class="signin_button">
<span><input type="submit" name="Submit" id="signin_button" value="Sign in" class="signin_button_cls login_button mem_login"/></span>
</div>
</form>

</div>
</div>
<div class="maindiv_login_right">
<div class="login-or_option">
OR
</div>
<div class="facebook_login" align="center">
<div><p>Login with your Facebook Account</p>
<a href="Javascript:void(0)"><img src="../images/login_with_fb.png" alt=""/></a>
</div>
<div class="twitter_login" align="center">
<p>Login with your Google Account</p>
<a href="Javascript:void(0)"><img src="../images/login_with_gplus.png" alt=""/></a>
</div>
</div>

</div>
</div>
