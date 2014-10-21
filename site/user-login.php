<?php    
	$metaTitle = $cms->getSingleresult("select meta_title from #_meta_info where url='member-login' and store_user_id = '0'");
	$metaIntro = $cms->getSingleresult("select meta_description from #_meta_info where url='member-login' and store_user_id = '0'");
	$metaKeyword = $cms->getSingleresult("select meta_keyword from #_meta_info where url='member-login' and store_user_id = '0'");
	$user_log=$_SESSION['domain-user'];
    $er=$cms->login();   
  
require_once 'src/Google_Client.php'; // include the required calss files for google login
require_once 'src/contrib/Google_PlusService.php';
require_once 'src/contrib/Google_Oauth2Service.php'; 
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
if (isset($_COOKIE["user"])){
				$base=$_COOKIE["user"];  
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
	if($me['displayName']) $name = explode(' ',$me['displayName']);
	$_SESSION[fname] = $name[0];
	$_SESSION[lname] = $name[1];
	if($email!=$user['email']){
	$_SESSION['gplusuer'] = $me; // start the session
	$_SESSION[userid]= $me; 
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
				if($base!=""){
				$expire=time()+120;
                $path="http://$base/profile"; 
                setcookie("user_id",$pid,$expire,$path,"fizzkart.com");
				header("Location: http://$base/profile");die; 
				//$cms->redir($base."/profile",true);die;
				}else{ $cms->redir(SITE_PATH."profile",true);die;  }  
	   }else{ 	$_SESSION['gplusuer'] = $me; // start the session
				$_SESSION[userid]=$_SESSION['gplusuer']; 
				$pid = $cms->getSingleresult("select pid from #_members where email='".$user['email']."'");
				$_SESSION[uid]=$pid;
				$_SESSION[userid]=$pid;
				if($base!=""){
				$expire=time()+120;
                $path="http://$base/profile"; 
                setcookie("user_id",$pid,$expire, $path, "fizzkart.com");
				header("Location: http://$base/profile");die; 
				//$cms->redir($base."/profile",true);die;
				}else{ $cms->redir(SITE_PATH."profile",true);die;  }  
	   }
}  

 
 ?> 
<div class="contentarea">
  <div class="registerarea">
<?php
	$qry = $cms->db_query("SELECT noOfDays,amount FROM `#_plans_hosting` where pid ='".$_SESSION[planID]."'  ");
	$res = $cms->db_fetch_array($qry);	 
	$sql=$cms->db_query("select name from #_plans  where status='Active' and pid = '".$_SESSION[tarifid]."'");
	$res2 = $cms->db_fetch_array($sql);	 
	$body = $cms->getSingleresult("SELECT body FROM `#_pages` where url ='user-login' and status = 'Active'  and store_user_id = '0'	 ");
	$heading = $cms->getSingleresult("SELECT heading FROM `#_pages` where url ='user-login' and status = 'Active' and store_user_id = '0'");  
?>
    <div class="heading"><?=$cms->removeSlash($heading)?></div>
      <div class="subarea">
      <?=$cms->removeSlash($body)?>
	  <?=$er?>
      <h2>Choose Your Login Section</h2>
        <div class="divfor_left-area">
          <div class="heading_comn">
          <h2>Store user login</h2>
		 
          <form action="" method="post" autocomplete="off" onSubmit="return formvalid(this);">
          <input type="hidden" name="type" value="user" />
		  <div>
            <div id="label">
              <label for="textfield">Email :</label>
            </div>
            <div id="inputs">
              <input type="text" name="email_id" lang="R isEmail" title="Email Id" value="<?=($_COOKIE['u_user'])?$_COOKIE['u_user']:''?>"   id="textfield" class="input_mail" />
            </div>
          </div>
          <div>
            <div id="label">
              <label for="textfield">Password :</label>
            </div>
            <div id="inputs">
              <input type="password" name="password" lang="R" title="password" value="<?=($_COOKIE['u_pass'])?$_COOKIE['u_pass']:''?>"  id="textfield" class="input_pass" />
            </div>
          </div>
          <div>
            <div id="label">
              <label for="textfield">&nbsp;</label>
            </div>
            <div id="inputs">
              <input type="submit" name="usrform_btn" id="usrform_btn" value="Login">
              <span><input type="checkbox" name="uremember"  value="2"  <?=($_COOKIE['uremember'])?'checked="checked"':''?> />Keep me Logged in</span>
            </div>
		 	  
          </div>
          <div>
            <div id="label">
              <label for="textfield">&nbsp;</label>
            </div>
            <div id="inputs">
              <span><a href="registration-user">Register Now</a></span>
              <span><a href="forgot-password?user=storeuser">Forgot Password ?</a></span>
            </div>
          </div>
          <center style="padding-top: 50px;"><?php 
if(isset($authUrl)) {
	echo "<a class='login' href='$authUrl'><img src='image/google-login-button-asif18.png' width='240' height='46's alt=\"Google login using php api for your website\" title=\"login with google\" /></a>";
	    
}
?>  <img border="0" src="../image/fb_login_icon.png" onClick="fblogin();" width="240" height="46" style="cursor:pointer; margin:10px 0 0 0;" />
<div id="fb-root" style="float:left; width:1px;"></div>
<br /></center>
          </form>
        </div>
        <div class="divfor_right-area">
         <h2>Store Owner login</h2>
         <form action="" method="post" autocomplete="off" onSubmit="return formvalid(this);" >
		 <input type="hidden" name="type" value="member" />
          <div>
            <div id="label">
              <label for="textfield">Username :</label>
            </div>
            <div id="inputs">
              <input type="text" name="user_name" lang="R" id="textfield" title="user_name" value="<?=($_COOKIE['m_user'])?$_COOKIE['m_user']:''?>" />
            </div>
          </div>
          <div>
            <div id="label">
              <label for="textfield">Password :</label>
            </div>
            <div id="inputs">
              <input type="password" name="password" lang="R" title="password" value="<?=($_COOKIE['m_pass'])?$_COOKIE['m_pass']:''?>" id="textfield" class="input_pass" />
            </div>
          </div>
          <div>
            <div id="label">
              <label for="textfield">&nbsp;</label>
            </div>
            <div id="inputs">
              <input type="submit" name="usrform_btn" id="usrform_btn" value="Login" />
              <span><input type="checkbox" name="mremember" value="1" <?=($_COOKIE['mremember'])?'checked="checked"':''?> />Keep me Logged in</span>
            </div>
          </div>
          <div>
            <div id="label">
              <label for="textfield">&nbsp;</label>
            </div>
            <div id="inputs">
              <span><a href="Step-1">Register Now</a></span>
              <span><a href="forgot-password?user=memberuser">Forgot Password ?</a></span>
            </div>
          </div>
          </form>

        </div>
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