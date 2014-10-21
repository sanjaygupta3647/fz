<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php 
 if($cms->is_post_back()){
 	$_POST[store_user_id] = 0; 
	$_POST[url] = $adm->baseurl($_POST[page]);
	if($updateid){ 
		$uids =  $cms->sqlquery("rs","meta_info",$_POST,'pid',$updateid);
		$adm->sessset('Record has been updated', 's');
	} else {
 		$_POST[submitdate] = time();
		$uids = $cms->sqlquery("rs","meta_info",$_POST);
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
	$rsAdmin=$cms->db_query("select * from #_meta_info where pid='".$id."'");
	$arrAdmin=$cms->db_fetch_array($rsAdmin);
	@extract($arrAdmin);
}
?>
 
  <table width="100%" border="0" align="left" cellpadding="4" cellspacing="1"  class="frm-tbl2">
    <tr>
      <td width="25%"  class="label">Page:<span>*</span></td>
      <td width="75%">
	  <select name="page"  class="txt medium"  title="Page"> 
	  <?php
		foreach($maisite_metapage as $val){ 
		?> <option value="<?=$val?>" <?=($page==$val)?'selected="selected"':''?>><?=$val?></option><?php
		}
	  ?>	  
	  </select>
	  </td>
    </tr>
	<tr  class="grey_">
      <td width="25%" valign="top" class="label">Meta title:</td>
      <td width="75%"><textarea name="meta_title" cols="80" rows="5" id="meta_title"><?=$meta_title?></textarea></td>
    </tr>
    
   <tr>
      <td width="25%" valign="top"  class="label">Meta keywords :</td>
      <td width="75%"><textarea name="meta_keyword" cols="80" rows="5" id="meta_keyword"><?=$meta_keyword?></textarea></td>
    </tr>
	<tr  class="grey_">
	  <td valign="top" class="label">Meta description :</td>
	
	  <td><textarea name="meta_description" cols="80" rows="5" id="meta_description"><?=$meta_description?></textarea></td>
    </tr>
	<tr>
	  <td>&nbsp;</td>
	  <td>
	  <?php if($_GET[subpageid]):?><input type="hidden" name="subpageid" class="uibutton  loading"  value="<?=$_GET[subpageid]?>" /><?php endif;?>
	  <input type="submit" name="Submit" class="uibutton  loading"  value="&nbsp;&nbsp;&nbsp;Update&nbsp;&nbsp;&nbsp;" /></td>
    </tr>	
  </table>
 
