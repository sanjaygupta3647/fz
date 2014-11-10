<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php  
if($cms->is_post_back()){   
	if($updateid){
		$cms->sqlquery("rs","sms_tamplate",$_POST,'pid',$updateid); 
		$adm->sessset('Record has been updated', 's');
	}else{
		$_POST[submitdate] = time();
		$cms->sqlquery("rs","sms_tamplate",$_POST);
		$updateid = mysql_insert_id();
		$adm->sessset('Record has been added', 's');
	} 
	if(isset($_GET['start']) && $_GET['start'] > 0) {
		$path = SITE_PATH_ADM.CPAGE."/index.php?start=".$_GET['start'];
	} else {
		$path = SITE_PATH_ADM.CPAGE;
	}
	$cms->redir($path, true);
}	
if(isset($id)){
	$rsAdmin=$cms->db_query("select * from #_sms_tamplate where pid='".$id."'");
	$arrAdmin=$cms->db_fetch_array($rsAdmin); 
	@extract($arrAdmin);
} 
?>
 
 
  <table width="100%" border="0" align="left" cellpadding="4" cellspacing="1" class="frm-tbl2">  
 
	<tr  class="grey_">
      <td width="25%" valign="top" class="label">SMS Title:</td>
      <td width="75%"><input name="title" type="text" class="txt medium" id="title" lang="R" title="Title" value="<?=$title?>" /></td>
    </tr>  
	<tr>
	  <td valign="top" class="label">SMS Body:</td>
	  <td width="75%"><textarea name="smsBody" cols="80" rows="5" lang="R" title="Sms Body" id="Sms"><?=$smsBody?></textarea></td>
	</tr>   
	<tr>
	  <td class="label">Status:<span>*</span></td>
	  <td><select name="status" class="txt medium" lang="R" title="Status">
	  <option value="Active" <?=(($status=='Active')?'selected="selected"':'')?>>Active</option>
	  <option value="Inactive" <?=(($status=='Inactive')?'selected="selected"':'')?>>Inactive</option>
	  </select>	  </td>
    </tr> 
	<tr>
	  <td>&nbsp;</td>
	  <td>
	  <input type="submit" name="Submit" class="uibutton  loading" value="&nbsp;&nbsp;&nbsp;Submit&nbsp;&nbsp;&nbsp;" /></td>
    </tr>	
  </table>
  