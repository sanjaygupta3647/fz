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
			$getcartQty = $cms->getSingleresult("select count(*) from #_cart where  ssid = '".session_id()."'"); 
			if($getcartQty){
			
			$cms->redir(SITE_PATH."cart",true);
			 }
			else{
			  
			   $cms->redir(SITE_PATH."profile",true);die; 
			} 
		}else{
			$er= '<p align="left" style="color:#f89b09; margin:10px 0; display:block; " >You are not register for this Store/Brand Domain!</p>';
		}
		 
		
	} else {
		$er= '<p align="left" style="color:#f89b09; margin:10px 0; display:block; " >Invalid email id and password. Try again!</p>';
	}
}

?>
<div id="intabdiv" style="margin:0px auto; width:450px;">
    <form action="" method="post" onSubmit="return formvalid(this);">
	  
       <table style="float:left; width:450px; height:200px; border-color:#ccc; margin-top:35px; padding-bottom:20px;" width="100%" border="0" class="CSSTableGenerator" >
        <tr>
          <th height="30" colspan="2" align="center" style="color:black" valign="middle" class="title_text_inn">Website Member Login Here </th>
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
          <td align="left" valign="middle" ><input name="Submit" type="submit" class="login_button mem_login" value="Login"></td>
        </tr>
      </table>
    </form>
  </div>
    