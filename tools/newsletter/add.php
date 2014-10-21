<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php 
 if($cms->is_post_back()) {
 		$_POST['ipaddress'] = $_SERVER['REMOTE_ADDR'];
		$uids =  $cms->sqlquery("rs","newsletter",$_POST); 
		if($uids){  
		$to = $emails;
		$subject = $subject; 
		$from = "info@fizzkart.com";
		$headers = "From: $from\r\n"; 
		$headers .= "Reply-To: ". strip_tags($_POST['Email']) . "\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	    $message = '<html><body>'; 
		$message .= '<table rules="all" style="border-color: #666;" cellpadding="10"  width="60%">';
		$message .= "<tr style='background: #eee;'><td><strong><p>" . strip_tags($_POST['body']) . "</p><p>@Fizzkart, Admin</p></td></tr>"; 
		$message .= "</table>";
		$message .= "</body></html>"; 
		@mail($to,$subject,$message,$headers);  
		$adm->sessset('Newsletter has been sent to all listed membsers', 's');
 		$cms->redir(SITE_PATH_ADM.CPAGE, true);
		} 
}
if(isset($id)){
	$rsAdmin=$cms->db_query("select * from #_newsletter where pid='".$id."'");
	$arrAdmin=$cms->db_fetch_array($rsAdmin);
	@extract($arrAdmin);
}
?> <?=$adm->alert()?>
   <table width="100%" border="0" align="left" cellpadding="4" cellspacing="1" class="frm-tbl2">
    <tr  class="grey_">
      <td width="25%" class="label">Subject:*</td>
      <td width="75%"><input name="subject" type="text" class="txt medium" id="title" lang="R" title="Subject" value="<?=$subject?>" /></td>
    </tr>
    <tr  class="grey_">
      <td width="25%" class="label">To:*</td>
      <td width="75%"><textarea name="emails" lang="R" rows="10" cols="60" title="At least one email"><?=(!$id)?$cms->getSiteEmails():$emails?></textarea></td>
    </tr>
	 
	<tr>
	  <td valign="top" class="label">Description:</td>
	  <td valign="top">&nbsp;</td>
    </tr>
	<tr class="grey_">
	  <td colspan="2" class="label"><?=$adm->get_editor('body', $body, SITE_SUB_PATH)?></td>
    </tr>
	
	<tr>
	  <td>&nbsp;</td>
	  <td>
	  <input type="submit" name="Submit" class="uibutton  loading"  value="&nbsp;&nbsp;&nbsp;Submit&nbsp;&nbsp;&nbsp;" /></td>
    </tr>	
  </table>
 
 <script type="text/javascript">
$('.upimg').popupWindow({ 
centerScreen:1 
}); 
</script>