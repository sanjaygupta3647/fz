<?php include("../../lib/opin.inc.php")?>
<?php  defined('_JEXEC') or die('Restricted access'); ?>
<?php 
                 $ssid = session_id();
			     $otp1=$_SESSION['otp'];
                 $ssid1=$cms->getSingleresult("select ssid from #_admin_lostlogin where ssid='$ssid' order by aid DESC LIMIT 1");
				 $otp2=$cms->getSingleresult("select otp from #_admin_lostlogin where ssid='$ssid' order by aid DESC LIMIT 1"); 
				 if(($otp1==$otp2) && ($ssid==$ssid1)){   
				 $cms->redir(SITE_PATH_ADM."coupon");
				   }   
				$phone=$cms->getSingleresult("select phone from #_setting where id='1'"); 
				$ssid1=$cms->getSingleresult("select count(*) from #_admin_lostlogin where ssid='$ssid' order by aid DESC LIMIT 1");
			    $nonce = md5( rand( 0,65337 ) . time() ); //generates the salt
		        $_SESSION['nonce'] = $nonce; //stored in the session object
		if(!$ssid1){  
			    $otp = $cms->generate_random_password(); 
				$mess = "OTP for coupon is%$otp%@fizzkart.com";   
			    $cms->sendSms($phone,$mess,0);
			    $ip = $_SERVER['REMOTE_ADDR'];
			    $ssid = session_id();  
		        $hostaddress = gethostbyaddr($ip);  
				//$phone=$arrAdmin[phone];
			    $cms->db_query("insert into #_admin_lostlogin set phone='$phone',ip='$hostaddress',ipaddr='$ip',otp='$otp',ssid ='$ssid' ");
                   
		}
		
 if($cms->is_post_back()){  
	    $rsAdmin1=$cms->getSingleresult("select otp from #_admin_lostlogin where phone='$phone' order by aid DESC LIMIT 1"); 
	     $rade=$_POST['code'];
if($_POST['code']){
	   if($rsAdmin1==$rade){
		   $_SESSION['otp']=$rade;
	    $cms->redir(SITE_PATH_ADM."coupon");
	   }else{
		   $err="Please enter valid OTP";
	   //$cms->redir(SITE_PATH_ADM."content");
	   }
}else{ $err="Please enter OTP.";}	   
		
	   $cms->redir(SITE_PATH_ADM.CPAGE, true);
}	    
       ?>
	  
 <form action="" method="post" name="">
  <table width="100%" border="0" align="left" cellpadding="4" cellspacing="1" class="frm-tbl2">     
    <tr>
      <td width="25%"  class="label">Enter Your Code:</td>
      <td width="75%"><input type="text" name="code"  lang="R" title="code" class="txt medium" value="" style="width:100px;" placeholder="Enter Your OTP" />
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
  <script type="text/javascript"> 
 function addField(){
  var newContent = '<br /><strong style="margin-left:40px;">Title :</strong><input type="text" name="ftitle[]"  title="ftitle" class="txt medium"value="" /><br /><strong>Description :</strong><input type="text" name="fdescription[]" style="margin-top:10px;" title="description" class="txt medium" value="" /><br />';
  $(".addmore").append(newContent); 
 }
</script>
 