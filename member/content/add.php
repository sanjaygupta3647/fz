<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php 
 if($cms->is_post_back()){
	$path = UP_FILES_FS_PATH."/pages";
	$_POST[store_user_id] = $_SESSION[uid];
	$err = 0;
	if($id){
		$count=$cms->getSingleresult("select count(*) from #_pages where store_user_id='".$_POST[store_user_id]."' and url='".$_POST[url]."' and pid!='$id' ");
		if($count){
			$err = 1;
			$ms = "You are not allowed to add new entry for ".$_POST[url].",you can only edit it now.";
			$adm->sessset($ms, 'e');
		}
	}else{
		$count=$cms->getSingleresult("select count(*) from #_pages where store_user_id='".$_POST[store_user_id]."' and url='".$_POST[url]."'");
		if($count){
			$err = 1;
			$ms = "You are not allowed to add new entry for ".$_POST[url].",you can only edit it now.";
			$adm->sessset($ms, 'e');
		}
	}
	
	 

	if($_FILES[file1][name]){
		$_POST['pimage'] = $cms->uploadFile($path,$_FILES['file1']['name'],'file1');
	}
	if(!$err){	
		if($updateid){ 
			$uids =  $cms->sqlquery("rs","pages",$_POST,'pid',$updateid);
			$adm->sessset('Record has been updated', 's');
		} else {
			$_POST[submitdate] = time();
			$uids = $cms->sqlquery("rs","pages",$_POST);
			$adm->sessset('Record has been added', 's');
		}	
		$cms->db_query("update #_pages set `body` = '".$_POST[body]."', `sort_body` = '".$_POST[sort_body]."' where `pid` in ($uids)");
	}
	$cms->redir(SITE_PATH_MEM.CPAGE.(($subpageid)?'?view=true&subpageid='.$subpageid:''), true);
}	
if(isset($id)){
	$rsAdmin=$cms->db_query("select * from #_pages where pid='".$id."'");
	$arrAdmin=$cms->db_fetch_array($rsAdmin);
	@extract($arrAdmin);
}
?>
 
  <table width="100%" border="0" align="left" cellpadding="4" cellspacing="1" class="frm-tbl2">
   
	<tr>
      <td width="25%"  class="label">Page:<span>*</span></td>
      <td width="75%">
	  <select name="url"  class="txt medium"  lang="R" title="Page">
	  <option value="">---Select Page---</option>
	  <?php
		foreach($pages as $val){
			$urls = $adm->baseurl($val);
		?> <option value="<?=$urls?>" <?=($url==$urls)?'selected="selected"':''?>><?=$val?></option><?php
		}
	  ?>	  
	  </select>
	  </td>
    </tr>
    <tr>
      <td width="25%"  class="label">Heading:<span>*</span></td>
      <td width="75%"><input type="text" name="heading" class="txt medium"  lang="R" title="Heading" value="<?=$heading?>" /></td>
    </tr>
     
	<tr class="grey_">
	  <td class="label">Status:<span>*</span></td>
	  <td><select name="status"  class="txt" lang="R" title="Status">
	  <option value="Active" <?=(($status=='Active')?'selected="selected"':'')?>>Active</option>
	  <option value="Inactive" <?=(($status=='Inactive')?'selected="selected"':'')?>>Inactive</option>
	  </select>	  </td>
    </tr>
	<?php /*?><tr >
	  <td colspan="2" class="label">Short description:</td>
    </tr>
	<tr>
	  <td colspan="2"><textarea name="sort_body" id="sort_body" cols="80" rows="6"><?=$sort_body?></textarea></td>
    </tr><?php */?>
    <tr class="grey_">
	  <td  class="label">Full description:</td>
	  <td  ><?=$adm->get_editor('body', $cms->removeSlash($body))?></td>
    </tr>
	 
    <?php /*?> <tr>
      <td width="25%"  class="label">Banner Token:<span></span></td>
      <td width="75%"><input type="text" name="banner" class="txt medium"   title="banner" value="<?=$banner?>" /></td>
    </tr><?php */
	if($pagename=='index'){?>
     <tr>
      <td width="25%"  class="label">Gallery Token:<span></span></td>
      <td width="75%"><input type="text" name="slug" title="Gallery Token" class="txt medium" lang="R"   value="<?=$slug?>" /></td>
    </tr>
    <?php }?>
	<tr>
	  <td>&nbsp;</td>
	  <td>
	  <?php if($_GET[subpageid]):?>
     <?php /*?> <input type="hidden" name="subpageid" class="uibutton  loading"  value="<?=$_GET[subpageid]?>" /><?php */?>
	  <?php endif;?>
	  <input type="submit" name="Submit" class="uibutton  loading"  value="Submit" /></td>
    </tr>	
  </table>
 
