<?php include("../../lib/opin.inc.php")?>
<?php  defined('_JEXEC') or die('Restricted access'); ?>
<?php 
if(!$_SESSION[coupon_counter]){
	$_SESSION[coupon_counter] = 0;
}


if($_SESSION[coupon]){
	$cms->redir(SITE_PATH_ADM."coupon",1);
}
$ssid = session_id();
  
$phone=$cms->getSingleresult("select phone from #_setting where id='1'"); 
 
if(!$_SESSION[coupon] and !$_POST['code'] and !$_SESSION[coupon_counter]){  
	$otp = $cms->generate_random_password(); 
	$mess = "OTP for coupon is $otp @fizzkart.com";   
	$cms->sendSms($phone,$mess,0);
	$ip = $_SERVER['REMOTE_ADDR']; 
	$hostaddress = gethostbyaddr($ip); 
	$_SESSION[coupon_counter] = 1;
	$cms->db_query("insert into #_admin_lostlogin set atype='su',phone='$phone',ip='$hostaddress',ipaddr='$ip',otp='$otp',ssid ='$ssid' "); 
	/* $otp=$cms->getSingleresult("select otp from #_admin_lostlogin where ssid='$ssid' order by aid DESC LIMIT 1");
	$_SESSION[ot]=$otp; */
} 
if($cms->is_post_back()){  
  $otp=$cms->getSingleresult("select otp from #_admin_lostlogin where ssid='$ssid' order by aid DESC LIMIT 1");   
  $rade=$_POST['code']; 
	if($_POST['code']){  
		   if($otp==$rade){  
				$adm->sessset('Succsessful Log On Coupon Managent', 's'); 
				$_SESSION[coupon] = 1;
				$cms->redir(SITE_PATH_ADM."coupon",1); 
		   }else{  
				$adm->sessset('Please enter valid OTP', 'e'); 
		   }
	}else{  
        $adm->sessset('Please enter OTP', 'e');
	} 	
	   $cms->redir(SITE_PATH_ADM."coupon/?log=coupon",1);
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
	  <td>&nbsp;<?=$err?></td>
	  <td>
	  <input type="submit" name="Submit" class="uibutton  loading" value="&nbsp;&nbsp;&nbsp;Submit&nbsp;&nbsp;&nbsp;" /></td>
  </form>
	</tr>	
  </table>
  
 