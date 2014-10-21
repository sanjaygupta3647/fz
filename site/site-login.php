<?php
include "common_css.php";
include "common_js.php";

if($cms->is_post_back()){
	@extract($_POST);
	$rsAdmin_login = $cms->db_query("select pid, fname, email from #_members where `email`='".$email."' and  `password`='".$password."'");
	if(mysql_num_rows($rsAdmin_login)){
		$arrAdmin_login = $cms->db_fetch_array($rsAdmin_login);
		$_SESSION[userid] = $arrAdmin_login[pid];
		
		$_SESSION[email] = $arrAdmin_login[email];
		$_SESSION[uname] = $arrAdmin_login[fname];
		$getcartQty = $cms->getSingleresult("select count(*) from #_cart where  ssid = '".session_id()."'");
		?>
		<script type="text/javascript">
			parent.window.location = '<?=SITE_PATH."profile"?>';
		</script>
		<?
		$redpath = SITE_PATH."/profile";
		if($getcartQty>0){
		$redpath = SITE_PATH."/cart";
		}
		$cms->redir($redpath,true);die;
		
	} else {
		$er= '<p align="left" style="color:#f89b09; margin:10px 0; display:block; " >Invalid email id and password. Try again!</p>';
	}
}

?>
<div id="intabdiv">
    <form action="" method="post" onSubmit="return formvalid(this);">
	<?=$er?>
       <table width="380" border="0" cellspacing="4" cellpadding="0">
        <tr>
          <td height="30" colspan="2" align="left" valign="middle" class="title_text_inn">Website Member Login Here </td>
        </tr>
        <tr>
          <td align="right" valign="top">Email : </td>
          <td width="160" align="left" valign="middle"><input  name="email" title="User name" lang="RisEmail" value="<?=$email?>" type="text" class="login_text_fild"></td>
        </tr>
        <tr>
          <td align="right" valign="top">Password : </td>
          <td align="left" valign="middle"><input name="password" value="" size="15" lang="R" title="Password" type="password" class="login_text_fild"></td>
        </tr>
        <tr>
          <td align="right" valign="top">&nbsp;</td>
          <td align="right" valign="middle" ><input name="Submit" type="submit" class="login_button" value="Login"></td>
        </tr>
      </table>
    </form>
  </div>
    