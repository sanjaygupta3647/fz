<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php 
 if($cms->is_post_back()){
    $page_name = $cms->getSingleresult("select page from #_meta_info where  store_user_id = '".$_SESSION[uid]."' and page='".$_POST[page]."'"); 
 	$_POST[store_user_id] = $_SESSION[uid]; 
	$_POST[url] = $adm->baseurl($_POST[page]);
	if($updateid){ 
		$uids =  $cms->sqlquery("rs","meta_info",$_POST,'pid',$updateid);
		$adm->sessset('Record has been updated', 's');
	} else {
 		$_POST[submitdate] = time();
		if(!$page_name){
			$uids = $cms->sqlquery("rs","meta_info",$_POST);
			$adm->sessset('Record has been added', 's');
        }else{
			$adm->sessset(''.$page_name.' Meta Info has been Allrady added', 'e');
		}
	}	
 	//$cms->redir(SITE_PATH_MEM.CPAGE, true);
	if(isset($_GET['start']) && $_GET['start'] > 0) {
		$path = SITE_PATH_MEM.CPAGE."/index.php?start=".$_GET['start'];
	} else {
		$path = SITE_PATH_MEM.CPAGE;
	}
	$cms->redir($path, true);	
}	
if(isset($id)){
	$rsAdmin=$cms->db_query("select * from #_meta_info where pid='".$id."'");
	$arrAdmin=$cms->db_fetch_array($rsAdmin);
	@extract($arrAdmin);
}
?> 
  <table width="100%" border="0" align="left" cellpadding="4" cellspacing="1" class="frm-tbl2"> 
	<tr>
      <td width="25%"  class="label">Page:<span>*</span></td>
      <td width="75%">
	  <select name="page"  class="txt medium"  title="Page"> 
	  <?php
		foreach($metapage as $val){ 
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
 
