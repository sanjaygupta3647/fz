<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php 
if($cms->is_post_back()){ 
	$err = 0;
	if($id){
		$count=$cms->getSingleresult("select count(*) from #_pages where store_user_id='0' and url='".$_POST[url]."' and pid!='$id' ");
		if($count){
			$err = 1;
			$ms = "You are not allowed to add new entry for ".$_POST[url].",you can only edit it now.";
			$adm->sessset($ms, 'e');
		}
	}else{
		$count=$cms->getSingleresult("select count(*) from #_pages where store_user_id='0' and url='".$_POST[url]."'");
		if($count){
			$err = 1;
			$ms = "You are not allowed to add new entry for ".$_POST[url].",you can only edit it now.";
			$adm->sessset($ms, 'e');
		}
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
	
	$cms->redir(SITE_PATH_ADM.CPAGE.(($subpageid)?'?view=true&subpageid='.$subpageid:''), true);
}	
if(isset($id)){
	$rsAdmin=$cms->db_query("select * from #_pages where pid='".$id."'");
	$arrAdmin=$cms->db_fetch_array($rsAdmin);
	@extract($arrAdmin);
}
?>
 
  <table width="100%" border="0" align="left" cellpadding="4" cellspacing="1" class="frm-tbl2">
     
    <tr>
      <td  class="label">Page:</td>
      <td>
	  <select name="url" class="txt" title="Page"><?php       
		foreach($textpage as $val){?> 
		<option value="<?=$val?>" <?=($url==$val)?'selected="selected"':''?>>  <?=ucwords($val)?>  </option>
      <?php } ?>
	  </select></td>
    </tr>
     
	 
    <tr>
      <td width="25%"  class="label">Heading:<span>*</span></td>
      <td width="75%"><input type="text" name="heading" class="txt medium"  lang="R" title="Heading" value="<?=$heading?>" /></td>
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
 
