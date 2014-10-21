<?php
$metaTitle = $cms->getSingleresult("select meta_title from #_meta_info where url='join-store' and store_user_id = '$current_store_user_id'");
$metaIntro = $cms->getSingleresult("select meta_description from #_meta_info where url='join-store' and store_user_id = '$current_store_user_id'");
$metaKeyword = $cms->getSingleresult("select meta_keyword from #_meta_info where url='join-store' and store_user_id = '$current_store_user_id'");
 if($cms->is_post_back()){
	$_POST[password] = $cms->encryptcode($_POST[password]);
	@extract($_POST); 
	$rsAdmin_login = $cms->db_query("select pid,mob,fname, email from #_members where `email`='".$email."' and  `password`='".$password."'");
	if(mysql_num_rows($rsAdmin_login)){
			$arrAdmin_login = $cms->db_fetch_array($rsAdmin_login);  
			 $tcnt =$cms->getSingleresult("select count(*) from #_member_access where store_id='".$current_store_id."' and  `user_id`='".$arrAdmin_login[pid]."'");
			if(!$tcnt){
			     /********** cookie work *********/
				$year = time() + 31536000;
				$hour = time() + 3600; 
				if(!$_POST['uremember']) {
					setcookie('uremember', 0, $year);
					setcookie('u_user','', $year);
					setcookie('u_pass', '', $year); 
				} 
				if ($uremember == "1") //if the Remember me is checked, it will create a cookie.
                   {
					  setcookie('uremember', 1, $year);
					  setcookie('u_user',$email, $year);
					  setcookie('u_pass', $_POST['password'], $year); 
				   }
				/********** cookie work *********/ 
				$cms->db_query("insert into #_member_access set store_id='".$current_store_id."', `user_id`='".$arrAdmin_login[pid]."' ");
			    $adminEmail = $cms->getSingleresult("select email_id from #_store_user where pid = '$current_store_user_id' ");
				$headers = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= 'From: Fizzkart@fizzkart.com' . "\r\n" .'CC: '.$adminEmail;
				$ch = $cms->db_query("select * from #_template where title ='Join Store' and store_id = '$current_store_id' ");
				if(!mysql_num_rows($ch)){
					$ch = $cms->db_query("select * from #_template where title ='Join Store' and store_id = '0' ");
				} 
				$tempRes = $cms->db_fetch_array($ch);
				$subject2 = $tempRes[subject]; 
				$subject2 = str_replace("%%storename%%", $base.".fizzkart.com",$subject2);
				$mess2 = $tempRes[body]; 
				$mess2 = str_replace("%%storename%%", SITE_PATH,$mess2);
				$mess2 = str_replace("%%name%%",$arrAdmin_login[fname],$mess2);			  
				@mail($_POST[email], $subject2, $mess2,$headers); 
             	$mobmess = "Thanks for registering with $base.fizzkart.com store.Now you have access of $base.fizzkart.com Admin fizzkart.com ";
				$cms->sendSms($arrAdmin_login[mob],$mobmess,$current_store_id);
				$er= 'Thank you for Successful Joining.';
                $colorclass='success_msg_p';
				$_POST = false; 
			  //die;     
			}else{
			
				$er= 'You  have already join this site!';
			    $colorclass='error_msg_p';
			} 

		} 		
	else{
		$er= 'Invalid email id and password. Try again!';
	    $colorclass='error_msg_p';
	}
 }
?>
<div class="main_right_percent">
	<div class="maindiv_login">
		<div class="maindiv_login_left">
			<p class="<?=$colorclass?>"><?=$er?></p> 
			<div class="headind_signin"><strong>Join Now</strong></div>
				<div class="signin_div">
					<form name="" action="" method="post">
						<div class="signin_page-fields">
							<div class="signin_page-fields1">
								<span><label for="user-id">Email or User Id</label></span>
								<span><input type="text" name="email" title="User name" id="usr-id_field" class="usr-id_field_cls othr_flds username_icon" lang="RisEmail" value="<?=($_COOKIE['u_user'])?$_COOKIE['u_user']:''?>" placeholder="Email or Username" /></span>
							</div>
							<div class="signin_page-fields1">
								<span><label for="user-id">Password</label></span>
								<span><input type="password" name="password" id="usr-id_field"  lang="R"  title="Password" value="<?=($_COOKIE['u_pass'])?$_COOKIE['u_pass']:''?>" class="usr-id_field_cls othr_flds password_icon" placeholder="Your Password" /></span>
								<!--<div class="forgot_id-pass_div">
								<span><a href="#">Forgot your id</a></span><span>Or</span><span><a href="forgot-password?user=memberuser">Forgot your Password</a></span>
								</div>-->
							</div>
						</div>
						<div class="signin_check">
							<span><input type="checkbox"  id="signin_check" class="signin_check_cls" name="uremember"  value="1"  <?=($_COOKIE['uremember'])?'checked="checked"':''?> /></span>
							<span><label for="checkbox">Keep me Logged in</label></span>
						</div>
						<div class="signin_button">
							<span>
								<input type="submit" name="Submit" id="signin_button" value="Join Now" class="signin_button_cls login_button mem_login"/>
							</span>
						</div>
					</form>

				</div>
			</div>
			<div class="maindiv_login_right">
				<div class="join_form_text"><strong>Join Our Store's Now</strong></div>
				<p style="font-size: 15px;">
					fizzkart is India's best online shopping platform, a place where people can connect with each other to buy and services. Launched in soon with the vision for buyers and sellers to "meet online ", today we have over million people buy online shop product.
				</p>
				<p style="font-size: 15px;">
					so you are register fizzkart and join this store and enjoy to online shopping save money and time.
				</p>
				<p style="font-size: 15px;">
				 Join a high-profile online shopping company  national market in the fast-growing.
				 </p>
			</div>
		</div>
	</div>
</div>
    