<?php 
$metaTitle = $cms->getSingleresult("select meta_title from #_meta_info where url='login' and store_user_id = '$current_store_user_id'");
$metaIntro = $cms->getSingleresult("select meta_description from #_meta_info where url='login' and store_user_id = '$current_store_user_id'");
$metaKeyword = $cms->getSingleresult("select meta_keyword from #_meta_info where url='login' and store_user_id = '$current_store_user_id'"); 
$host = $_SERVER['HTTP_HOST']; 
$expire=time()+120;
$path=SITE_PATH."user-login"; 
$domain = str_replace("http://","",SITE_PATH);
$domain = str_replace("/","",$domain);

setcookie("user",$host,$expire, $path, $domain);
//echo $_COOKIE["user"];   
//setcookie("user", "", time()-60,$path,"");
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
			 /********** cookie work *********/
				$year = time() + 31536000;
				$hour = time() + 3600; 
				if(!$_POST['uremember']) {
					setcookie('uremember', 0, $year);
					setcookie('u_user','', $year);
					setcookie('u_pass','', $year); 
				} 
				if ($uremember == "1") //if the Remember me is checked, it will create a cookie.
                   {
					  setcookie('uremember', 1, $year);
					  setcookie('u_user',$email, $year);
					  setcookie('u_pass', $_POST['password'], $year); 
				   }
				/********** cookie work *********/ 
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
require_once 'src/Google_Client.php'; // include the required calss files for google login
require_once 'src/contrib/Google_PlusService.php';
require_once 'src/contrib/Google_Oauth2Service.php';
session_start(); 
$client = new Google_Client();
$client->setApplicationName("Asig 18 Sign in with GPlus"); // Set your applicatio name
$client->setScopes(array('https://www.googleapis.com/auth/userinfo.email', 'https://www.googleapis.com/auth/plus.me')); // set scope during user login
$client->setClientId('408177103986-kr4b5kg7lpq3fr0apvcdb58l3k64v292.apps.googleusercontent.com'); // paste the client id which you get from google API Console
$client->setClientSecret('43BoDIZxKPBd1W-Jbcx-Nj-S'); // set the client secret
$client->setRedirectUri('http://fizzkart.com/user-login'); // paste the redirect URI where you given in APi Console. You will get the Access Token here during login success
$client->setDeveloperKey('AIzaSyBqYwUrAWkn10VAZQhAiPWz5vGUwxbvvgM'); // Developer key
$plus 		= new Google_PlusService($client);
$oauth2 	= new Google_Oauth2Service($client); // Call the OAuth2 class for get email address
if(isset($_GET['code'])) {
	$client->authenticate(); // Authenticate
	$_SESSION['access_token'] = $client->getAccessToken(); // get the access token here
	header('Location: http://fizzkart.com/user-login');
}

if(isset($_SESSION['access_token'])) {
	$client->setAccessToken($_SESSION['access_token']);
} 
if ($client->getAccessToken()) {
  $user 		= $oauth2->userinfo->get();
  $me 			= $plus->people->get('me');
  $optParams 	= array('maxResults' => 100);
  $activities 	= $plus->activities->listActivities('me', 'public',$optParams);
  // The access token may have been updated lazily.
  $_SESSION['access_token'] 		= $client->getAccessToken();
  $email 							= filter_var($user['email'], FILTER_SANITIZE_EMAIL); // get the USER EMAIL ADDRESS using OAuth2
} else {
	$authUrl = $client->createAuthUrl();
} 
if(isset($me)){ 
    $email = $cms->getSingleresult("select email from #_members where email='".$user['email']."'");
	if($email!=$user['email']){
	$_SESSION['gplusuer'] = $me; // start the session
	$_SESSION[userid]= $me;
	if($me['displayName']) $name = explode(' ',$me['displayName']);
	$_POST[fname]=$name[0];
	$_POST[lname]=$name[1];
	$_POST[gender]=$me['gender'];
	$_POST[email]=$user['email'];
	$_POST[city]=$me['placesLived'][0]['value'];
	$cms->sqlquery("rs","members",$_POST); 
	$pid = $cms->getSingleresult("select pid from #_members where email='".$user['email']."'");
	$_SESSION[uid]=$pid;
	$_SESSION[userid]=$pid;
	//$cms->redir(SITE_PATH."profile",true);die; 
				$lastId  = mysql_insert_id();  
				$adminEmail = SITE_MAIL;
				$headers = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= 'From: Fizzkart@fizzkart.com' . "\r\n" .'CC: '.$adminEmail; 				 
				$ch = $cms->db_query("select * from #_template where title ='Registration Update Link' and store_id = '0' ");				 
				$tempRes = $cms->db_fetch_array($ch);
				$subject2 = $tempRes[subject];  
				$link="http://fizzkart.com/registration-user?email_id=".$user['email']; 
				$subject2 = str_replace("%%sitename%%",SITE_PATH,$subject2); 
				$subject2 = str_replace("%%link%%",$link,$subject2);
				$mess2 = $tempRes[body]; 
				$mess2 = str_replace("%%subdomain%%",SITE_PATH,$mess2);
				$mess2 = str_replace("%%name%%", $_POST[fname].' ' .$_POST[lname],$mess2);
				$mess2 = str_replace("%%sex%%", $_POST[gender],$mess2);
				$mess2 = str_replace("%%email%%", $_POST[email],$mess2);
				$mess2 = str_replace("%%city%%", $_POST[city],$mess2); 
				$mess2 = str_replace("%%link%%", $link,$mess2);
				@mail($_POST[email], $subject2, $mess2,$headers);  
				$er= '<p align="left" style="color:green; margin:10px 0; display:block; " >Thank you for successful registration.</p>';
				$_POST = false;
				$cms->redir(SITE_PATH."profile",true);die;  
	   }else{ 	$_SESSION['gplusuer'] = $me; // start the session
				$_SESSION[userid]=$_SESSION['gplusuer']; 
				$pid = $cms->getSingleresult("select pid from #_members where email='".$user['email']."'");
				$_SESSION[uid]=$pid;
				$_SESSION[userid]=$pid;
				$cms->redir(SITE_PATH."cart",true);die; 
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
<span><input type="text" name="email" title="User name" id="usr-id_field" class="usr-id_field_cls othr_flds username_icon" lang="RisEmail" value="<?=($_COOKIE['u_user'])?$_COOKIE['u_user']:''?>" placeholder="Email or Username" /></span>
</div>
<div class="signin_page-fields1">
<span><label for="user-id">Password</label></span>
<span><input type="password" name="password" id="usr-id_field"  lang="R" value="<?=($_COOKIE['u_pass'])?$_COOKIE['u_pass']:''?>"  title="Password" class="usr-id_field_cls othr_flds password_icon" placeholder="Your Password" /></span>
<div class="forgot_id-pass_div">
 
<span><a href="#">Forgot your Password</a></span> <span> <a href="#">|</a></span>  
<span ><a href="<?=SITE_PATH?>join-store">Click here to Join Store</a></span>
</div>
</div>
</div>
<div class="signin_check">
<span><input type="checkbox" name="uremember"  value="1"  <?=($_COOKIE['uremember'])?'checked="checked"':''?>></span>
<span><label for="checkbox">Keep me Logged in</label></span>
</div>
<div class="signin_button">
<span><input type="submit" name="Submit" id="signin_button" value="Sign in" class="signin_button_cls login_button mem_login"/></span>
</div>
</form>

</div>
</div>
<div class="maindiv_login_right">

<div class="tie-up_login" align="center">
<div class="facebook_login"><p>Login with your Facebook Account</p></div>
<img border="0" src="<?=SITE_PATH_M?>image/fb_login_icon.png" onClick="fblogin();" width="250" height="48" style="cursor:pointer" />
<div id="fb-root" style="float:left; width:1px;"></div>
 

<div class="login-or_option">
OR
</div>
<div class="twitter_login" align="center">
<p>Login with your Google Account</p>
<?php 
if(isset($authUrl)) {
	echo "<a class='login' href='$authUrl'><img src='images/login_with_gplus.png' alt=\"Google login using php api for your website\" title=\"login with google\" width='250' height='48' /></a>"; 
}
?>
</div>
</div>

</div>
</div>
 <script>
window.fbAsyncInit = function() {
	FB.init({
	    appId: '539322812832955',
        cookie: true,
       	xfbml: true,
        oauth: true
   });      
};
(function() {
	var e = document.createElement('script'); e.async = true;
    e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
    document.getElementById('fb-root').appendChild(e);
}());

function fblogin(){
	FB.login(function(response){
	 if (response.authResponse) {
		  window.location='validatefb';
	 }
	},{scope: 'publish_stream,email,user_birthday'});
}
</script>
<div id="fb-root"></div>