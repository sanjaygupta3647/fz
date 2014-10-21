<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php 
if($cms->is_post_back()){
	$_POST[url] = $adm->baseurl($title);
	$path = UP_FILES_FS_PATH."/services";
	if($_FILES[file1][name]){
		$_POST['image'] = $cms->uploadFile($path,$_FILES['file1']['name'],'file1');
	}

	if($updateid){	
		$uids =  $cms->sqlquery("rs","services",$_POST,'pid',$updateid);
		$adm->sessset('Record has been updated', 's');
	}else{
		$_POST[dd] = date("d");
		$_POST[mm] = date("m");
		$_POST[yy] = date("Y");
		
		$_POST[submitdate] = time();
		$uids =  $cms->sqlquery("rs","services",$_POST);
		$adm->sessset('Record has been added', 's');
	}
	$cms->db_query("update #_services set `body` = '".$_POST[body]."' where `pid` in ($uids)");
	$cms->redir(SITE_PATH_ADM.CPAGE, true);
}	
if(isset($id)){
	$rsAdmin=$cms->db_query("select * from #_services where pid='".$id."'");
	$arrAdmin=$cms->db_fetch_array($rsAdmin);
	@extract($arrAdmin);
}
?>
<div class="internal-data">
  <table width="100%" border="0" align="left" cellpadding="4" cellspacing="1"  class="data-tbl">
    <tr  class="grey_">
      <td width="25%" class="label">Title:*</td>
      <td width="75%"><input name="title" type="text" class="txt medium" id="title" lang="R" title="Title" value="<?=$title?>" /></td>
    </tr>
     
    <tr>
      <td  class="label">Date:*</td>
       <td><?=$cms->cal("cdate",$cdate, 'input', "yyyy-mm-dd")?></td>
    </tr>
    <tr>
      <td width="25%"  class="label">Status:<span>*</span></td>
      <td width="75%"><select name="status"  class="txt" title="Status" lang="R" xml:lang="R">
        <option value="Active" <?=(($status=='Active')?'selected="selected"':'')?>>Active</option>
        <option value="Inactive" <?=(($status=='Inactive')?'selected="selected"':'')?>>Inactive</option>
      </select></td>
    </tr>
	<?php /*?><tr>
	  <td valign="top" class="label">Short Description:</td>
	  <td valign="top">&nbsp;</td>
    </tr>
	<tr class="grey_">
	  <td colspan="2" class="label" ><textarea id="sort_body" rows="6" cols="80" name="sort_body"><?=$sort_body?></textarea>
	  </td>
    </tr> <?php */?>
	<tr>
	  <td valign="top" class="label">Description:</td>
	  <td valign="top">&nbsp;</td>
    </tr>
	<tr class="grey_">
	  <td colspan="2" class="label"><?=$adm->get_editor('body', $body, SITE_SUB_PATH)?></td>
    </tr>
	<tr  class="grey_">
      <td width="25%" class="label">Link:*</td>
      <td width="75%"><input name="link" type="text" class="txt medium" id="link" lang="R" title="link" value="<?=$link?>" /></td>
    </tr>
    <tr  class="grey_">
      <td width="25%" class="label">Banner Slug:*</td>
      <td width="75%"><input name="banner" type="text" class="txt medium" id="banner" lang="R" title="banner" value="<?=$banner?>" /></td>
    </tr>
    <tr  class="grey_">
      <td width="25%" class="label">Gallery Slug:*</td>
      <td width="75%"><input name="gallery" type="text" class="txt medium" id="gallery" lang="R" title="gallery" value="<?=$gallery?>" /></td>
    </tr>
    <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
	  
	<tr>
	  <td>&nbsp;</td>
	  <td>
	  <input type="submit" name="Submit" class="uibutton  loading"  value="&nbsp;&nbsp;&nbsp;Submit&nbsp;&nbsp;&nbsp;" /></td>
    </tr>	
  </table>
</div>