<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php 
if($cms->is_post_back()){ 
	if($updateid){ 
		$uids =  $cms->sqlquery("rs","updates",$_POST,'pid',$updateid);
		$adm->sessset('Record has been updated', 's');
	} else { 
		$_POST[submitdate] = time();
		$uids = $cms->sqlquery("rs","updates",$_POST);
		$updateid = mysql_insert_id();
		$adm->sessset('Record has been added', 's');
	}	
	$arr[url] = $adm->baseurl($_POST[title])."-".$updateid;
	$uids =  $cms->sqlquery("rs","updates",$arr,'pid',$updateid);
 	$cms->redir(SITE_PATH_ADM.CPAGE.(($subpageid)?'?view=true&subpageid='.$subpageid:''), true);
}	
if(isset($id)){
	$rsAdmin=$cms->db_query("select * from #_updates where pid='".$id."'");
	$arrAdmin=$cms->db_fetch_array($rsAdmin);
	@extract($arrAdmin);
}
?>
 
  <table width="100%" border="0" align="left" cellpadding="4" cellspacing="1" class="frm-tbl2"> 
	 
    <tr>
      <td width="25%"  class="label">Title:<span>*</span></td>
      <td width="75%"><input type="text" name="title" class="txt medium"  lang="R" title="Title" value="<?=$title?>" /></td>
    </tr>

	<tr>
      <td width="25%"  class="label">Sub Title:<span>*</span></td>
      <td width="75%"><input type="text" name="subtitle" class="txt medium"  lang="R" title="Sub Title" value="<?=$subtitle?>" /></td>
    </tr>

	<tr>
      <td width="25%"  class="label">Meta Title:<span>*</span></td>
      <td width="75%"><input type="text" name="metaTitle" class="txt medium"   title="Meta Title" value="<?=$metaTitle?>" /></td>
    </tr>

	<tr>
      <td width="25%"  class="label">Meta Key:<span>*</span></td>
      <td width="75%"><textarea name="metaKey" class="txt medium" ><?=$metaKey?></textarea></td>
    </tr>

	<tr>
      <td width="25%"  class="label">Meta Description:<span>*</span></td>
      <td width="75%"><textarea name="metaDesc" class="txt medium" ><?=$metaDesc?></textarea></td>
    </tr>

	 
     
	
    <tr class="grey_">
	  <td  width="25%"  class="label">Full description:</td>
	  <td width="75%"><?=$adm->get_editor('body', $cms->removeSlash($body))?></td>
    </tr>
	 
	 <tr class="grey_">
	  <td class="label">Status:<span>*</span></td>
	  <td><select name="status"  class="txt" lang="R" title="Status">
	  <option value="Active" <?=(($status=='Active')?'selected="selected"':'')?>>Active</option>
	  <option value="Inactive" <?=(($status=='Inactive')?'selected="selected"':'')?>>Inactive</option>
	  </select>	  </td>
    </tr> 
     
	<tr>
	  <td>&nbsp;</td>
	  <td> 
	  <input type="submit" name="Submit" class="uibutton  loading"  value="Submit" /></td>
    </tr>	
  </table>
 
