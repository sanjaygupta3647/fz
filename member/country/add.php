<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php 
if($cms->is_post_back()){
	$_POST[url] = $adm->baseurl($pagename);
	if($updateid){
		$cms->sqlquery("rs","country",$_POST,'pid',$updateid);
		$cms->sessset('Record has been updated', 's');
	}else{
		$_POST[submitdate] = time();
		$cms->sqlquery("rs","country",$_POST);
		$cms->sessset('Record has been added', 's');
	}
	$cms->redir(SITE_PATH_ADM.CPAGE, true);
}	
if(isset($id)){
	$rsAdmin=$cms->db_query("select * from #_country where pid='".$id."'");
	$arrAdmin=$cms->db_fetch_array($rsAdmin);
	@extract($arrAdmin);
}
?>
 
  <table width="100%" border="0" align="left" cellpadding="4" cellspacing="1" class="frm-tbl2">
     
   <tr>
      <td width="25%"  class="label">Country Name:</td>
      <td width="75%"><input type="text" name="country"  lang="R" title="Country Name" class="txt medium" value="<?=$country?>" /></td>
    </tr> 
	<tr>
      <td width="25%"  class="label">Country Order:</td>
      <td width="75%"><input type="text" name="country_order"    title="Name" class="txt medium"value="<?=$country_order?>" /></td>
    </tr>  
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
 