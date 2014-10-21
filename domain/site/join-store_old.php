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
				$er= '<p align="left" style="color:green; margin:10px 0; display:block;" >Thank you for Successful Joining. </p>';
               $_POST = false; 
			  //die;     
			}else{
			
				$er= '<p align="left" style="color:#f89b09; margin:10px 0; display:block; " >You  have already join this site!</p>';
			
			} 

		} 		
	else{
		$er= '<p align="left" style="color:#f89b09; margin:10px 0; display:block; " >Invalid email id and password. Try again!</p>';
	}
 }
?>
<div id="intabdiv" style="margin:0px auto; width:450px;">
    <form action="" method="post" onSubmit="return formvalid(this);">
	  
       <table style="float:left; width:450px; height:200px; border-color:#ccc; margin-top:35px; padding-bottom:20px;" width="100%" border="0" class="CSSTableGenerator" >
        <tr>
          <th height="30" colspan="2" align="center" style="color:black" valign="middle" class="title_text_inn">Enter your detail to join the store </th>
        </tr>
		<?php
			if($er){?>
				 <tr><td height="43" colspan="2" align="left" valign="middle" class="title_text_inn"><?=$er?></td>
				 </tr>

			<?
			}
		?>
        <tr>
          <td width="35%" height="52" align="left" valign="top" style="color:black; border:none; padding-left:50px;">Email : </td>
          <td width="65%" align="left" valign="middle" style="border:none;"><input  name="email" title="User name" style="color:black;width:200px;" lang="RisEmail" value="<?=$email?>" type="text" class="othr_flds"></td>
        </tr>
        <tr style="background:none;">
          <td width="35%" height="43" valign="top"  style="color:black; border:none; padding-left:50px;">Password : </td>
          <td align="left" valign="middle" style="border:none;"><input name="password" value=""  lang="R" style="color:black; width:200px;" title="Password" type="password" class="othr_flds"></td>
        </tr>
        <tr>
          <td width="35%" valign="top" style="border:none;">&nbsp;</td>
          <td align="left" valign="middle" ><input name="Submit" type="submit" class="login_button mem_login" value="Join"></td>
        </tr>
      </table>
    </form>
  </div>
    