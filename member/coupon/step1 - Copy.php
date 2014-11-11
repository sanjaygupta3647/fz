<?php include("../../lib/opin.inc.php")?>
<?php  defined('_JEXEC') or die('Restricted access'); ?>
<?php 
$ssid = session_id();
$otp1=$_SESSION['otp'];
$ssid1=$cms->getSingleresult("select ssid from #_admin_lostlogin where ssid='$ssid' order by aid DESC LIMIT 1");
$otp2=$cms->getSingleresult("select otp from #_admin_lostlogin where ssid='$ssid' order by aid DESC LIMIT 1"); 
if(($otp1==$otp2) && ($ssid==$ssid1)){   
	$cms->redir(SITE_PATH_MEM."coupon",1);
}   
echo $phone=$cms->getSingleresult("select phone from #_setting where id='1'"); die;
$ssid1=$cms->getSingleresult("select count(*) from #_admin_lostlogin where ssid='$ssid' order by aid DESC LIMIT 1"); 
if(!$_SESSION[ot]){  
	$otp = $cms->generate_random_password(); 
	$mess = "OTP for coupon is%$otp%@fizzkart.com";  
	$cms->sendSms($phone,$mess,$_SESSION[uid]); 
	$ip = $_SERVER['REMOTE_ADDR'];
	$ssid = session_id();  
	$hostaddress = gethostbyaddr($ip); 
	$cms->db_query("insert into #_admin_lostlogin set atype='admin',phone='$phone',ip='$hostaddress',ipaddr='$ip',otp='$otp',ssid ='$ssid' "); 
	$otp=$cms->getSingleresult("select otp from #_admin_lostlogin where ssid='$ssid' order by aid DESC LIMIT 1");
	$_SESSION[ot]=$otp;
} 
if($cms->is_post_back()){  
  $otp=$cms->getSingleresult("select otp from #_admin_lostlogin where ssid='$ssid' order by aid DESC LIMIT 1");   
  $rade=$_POST['code']; 
	if($_POST['code']){  
		   if($otp==$rade){ 
				$_SESSION['otp']=$rade;
				$adm->sessset('Succsessful Log On Coupon Managent', 's'); 
				$cms->redir(SITE_PATH_MEM."coupon",1); 
		   }else{  
				$adm->sessset('Please enter valid OTP', 'e'); 
		   }
	}else{  
        $adm->sessset('Please enter OTP', 'e');
	} 	
	   $cms->redir(SITE_PATH_MEM."coupon/?log=coupon",1);
}	    
       ?>
	  
 <form action="" method="post" name="">
  <table width="100%" border="0" align="left" cellpadding="4" cellspacing="1" class="frm-tbl2">     
    <tr>
      <td width="25%"  class="label">Enter Your Code:</td>
      <td width="75%"><input type="text" name="code"  lang="R" title="code" class="txt medium" value="" style="width:100px;" placeholder="Enter Your OTP" maxlength="6" />
					  <input type="hidden" name="nonce"     class="txt medium" value="<?=$nonce?>"    /></td>
					   <input type="hidden" name="otp"      class="txt medium" value="<?=$otp?>"   /></td>
    </tr> 
	<tr>
	  <td>&nbsp; </td>
	  <td>
	  <input type="submit" name="Submit" class="uibutton  loading" value="&nbsp;&nbsp;&nbsp;Submit&nbsp;&nbsp;&nbsp;" /></td>
  </form>
	</tr>	
  </table>
  
 