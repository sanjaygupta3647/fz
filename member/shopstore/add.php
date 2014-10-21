<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php 
 if($cms->is_post_back()) {
 		$check=$cms->db_query("select pid from #_our_store where store_id='".$_SESSION[store_id]."'");
		if(mysql_num_rows($check)){
		$cms->db_query("update #_our_store set body = '".addslashes($_POST[body])."'  where store_id='".$_SESSION[store_id]."' "); 
		}
		else{
		$uids =  $cms->sqlquery("rs","our_store",$_POST); 
		}
		
		$adm->sessset('Stores detail have been updated successfully.', 's');
 		$cms->redir(SITE_PATH_MEM.CPAGE, true);
		 
}
 	$rsAdmin=$cms->db_query("select * from #_our_store where store_id='".$_SESSION[store_id]."'");
	if(mysql_num_rows($rsAdmin))	{
	$arrAdmin=$cms->db_fetch_array($rsAdmin);
	@extract($arrAdmin);
	}
 ?> <?=$adm->alert()?>
   <table width="100%" border="0" align="left" cellpadding="4" cellspacing="1" class="frm-tbl2">
    <tr>
	  <td valign="top" class="label">Our Stores :</td>
	  <td valign="top">&nbsp;<input type="hidden" name="store_id" value="<?=$_SESSION[store_id]?>" /></td>
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
  