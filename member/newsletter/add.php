<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php  
 if($cms->is_post_back()) {
 		$_POST['ipaddress'] = $_SERVER['REMOTE_ADDR'];
		$_POST['store_id'] = $_SESSION[uid];  
		$uids =  $cms->sqlquery("rs","newsletter",$_POST); 
		if($uids){
			/*
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
		 */  
		$store_name= $cms->getSingleresult("select title from fz_store_detail  where status='Active' and store_user_id = '".$_SESSION[uid]."' ");
		$store_image= $cms->getSingleresult("select image from fz_store_detail  where status='Active' and store_user_id = '".$_SESSION[uid]."' ");
		$store_email= $cms->getSingleresult("select email_id from fz_store_user  where status='Active' and pid = '".$_SESSION[uid]."' ");
		
		$subject 		   = $subject;
		$msg			   =  $body;
		$emails=explode(',', $emails);
		$arremail 		   = $emails; 
		$email             = new PHPMailer();
		$email->IsSMTP(); // telling the class to use SMTP
		$email->IsQmail();
		$email->SMTPAuth   = true;                  // enable SMTP authentication
		$email->SMTPSecure = "ssl";                 // sets the prefix to the servier
		$email->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
		$email->Port       = 465;                   // set the SMTP port for the GMAIL server
		$email->Username   = "fizzkart@gmail.com";  // GMAIL username
		$email->Password   = "admin@1212";            // GMAIL password
		$email->SetFrom('fizzkart@gmail.com', $store_name);
		$email->AddReplyTo('fizzkart@gmail.com',$store_name); 
		$email->Subject    = $subject;
		//$email->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test 
		$email->MsgHTML($msg); 
		$Attachment='<?=SITE_PATH?>uploaded_files/orginal/<?=$store_image?>';
		foreach($arremail as $key=>$mail){	
			$email->AddAddress($mail); 
			if($email->Send()) {
				$adm->sessset('Newsletter has been sent to all listed membsers', 's'); 
			} else {
				$adm->sessset('No Email id founds!', 'e'); 
			}
			$email->ClearAddresses();
		} 
		 
	if(isset($_GET['start']) && $_GET['start'] > 0) {
			$path = SITE_PATH_MEM.CPAGE."/index.php?start=".$_GET['start'];
		} else {
			$path = SITE_PATH_MEM.CPAGE;
		}
		$cms->redir($path, true);
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
      <td width="75%"><textarea name="emails" lang="R" rows="10" cols="54" title="At least one email"><?=(!$id)?$cms->getDomainSiteEmails():$emails?></textarea></td>
    </tr>
	 
	<tr>
	  <td valign="top" class="label">Description:</td>
	  <td valign="top"><?=$adm->get_editor('body', $body, SITE_SUB_PATH)?></td>
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