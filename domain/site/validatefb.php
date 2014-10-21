<?php
///ob_start();
include("facebook_constants.php"); 
$users = $facebook->getUser();  
if ($users!="") {	
  try { 
   $user_profile = $facebook->api('/me?scope=email');  
	//print_r($user_profile["email"]);
	$location=$user_profile["location"];
	$location=$location[name] ; 
	//echo "<pre>";
   // print_r($user_profile);  
	$logoutUrl = $facebook->getLogoutUrl();
	$fuserid=$user_profile["id"];
	$fusername=$user_profile["username"];
	$newtoken=base64_encode($fuserid."::".$fusername);
    if(isset($user_profile)){ 
    $email = $cms->getSingleresult("select email from #_members where email='".$user_profile['email']."'");
	$pid = $cms->getSingleresult("select pid from #_members where email='".$user_profile["email"]."'"); 
	$_SESSION[uid]=$pid;
    $_SESSION[userid]=$pid; 
	$_SESSION[user_store_id]= $current_store_id;
	$_SESSION[fname] = $user_profile['first_name'];
	if($email!=$user_profile["email"]){
	$_SESSION['gplusuer'] = $user_profile['name']; // start the session
	$_SESSION[userid]= $user_profile['id'];
	//if($user_profile['location']) $location = explode(' ',$user_profile['location']);
	$_POST[fname]=$user_profile['first_name'];
	$_POST[lname]=$user_profile['last_name'];
	$_POST[gender]=$user_profile['gender'];
	$_POST[email]=$user_profile['email'];  
	$_SESSION[fname] = $user_profile['first_name'];
	$_SESSION[lname] = $user_profile['last_name'];
	$_SESSION[email] = $user_profile["email"];
	if($location) $location1 = explode(',',$location);
    $_POST[city]=$location1[0]; 
	$_POST[address]=$location;  
	$cms->sqlquery("rs","members",$_POST); 
	$pid = $cms->getSingleresult("select pid from #_members where email='".$user_profile["email"]."'");
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
				$link="http://fizzkart.com/registration-user?email_id=".$user_profile["email"]; 
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
	   }else{ 	$_SESSION['gplusuer'] =$user_profile['first_name']; // start the session
				$_SESSION[userid]=$_SESSION['gplusuer']; 
				$pid = $cms->getSingleresult("select pid from #_members where email='".$user_profile["email"]."'");
				$_SESSION[uid]=$pid;
				$_SESSION[userid]=$pid; 
			   $cms->redir(SITE_PATH."profile",true);die;      
	   }
} 

  } catch (FacebookApiException $e) {
    $users = null;
  }
}
?>