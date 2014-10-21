<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php 
if($cms->is_post_back()){
	$_POST[url] = $adm->baseurl($pagename);
	if($updateid){
		$cms->sqlquery("rs","testi",$_POST,'pid',$updateid);
		$cms->sessset('Record has been updated', 's');
	}else{
		$_POST[submitdate] = time();
		$cms->sqlquery("rs","testi",$_POST);
		$cms->sessset('Record has been added', 's');
	}
	$cms->redir(SITE_PATH_ADM.CPAGE, true);
}	
if(isset($id)){
	$rsAdmin=$cms->db_query("select * from #_testi where pid='".$id."'");
	$arrAdmin=$cms->db_fetch_array($rsAdmin);
	@extract($arrAdmin);
}
?>
 
  <table width="100%" border="0" align="left" cellpadding="4" cellspacing="1" class="frm-tbl2">
    <tr  class="grey_">
      <td width="25%" class="label">Name:</td>
      <td width="75%"><input name="name" type="text" class="txt medium"id="name" value="<?=$name?>" /></td>
    </tr>
    
   <tr>
      <td width="25%"  class="label">Company:</td>
      <td width="75%"><input type="text" name="company" class="txt medium"value="<?=$company?>" /></td>
    </tr>
	<tr  class="grey_">
	  <td class="label">Website:</td>
	
	  <td><input name="website" type="text" class="txt medium"value="<?=$website?>" xml:lang="R" /></td>
	</tr>
	<tr>
	  <td valign="top" class="label">&nbsp;</td>
	  <td valign="top">&nbsp;</td>
    </tr>
	<tr>
	  <td valign="top" class="label">Short description:</td>
	  <td valign="top">
      <textarea rows="8" cols="60" name="sort_body"><?=$sort_body?></textarea>
      </td>
	</tr>
	<?php /*?><tr  class="grey_">
	  <td colspan="2" valign="top" class="label">Full description:</td>
    </tr>
	<tr  class="grey_">
	  <td colspan="2" valign="top" class="label"><?=$cms->get_editor("body", $body)?></td>
    </tr><?php */?>
	<tr>
	  <td class="label">Status:<span>*</span></td>
	  <td><select name="status" class="select" lang="R" title="Status">
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
 