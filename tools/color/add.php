<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php  
if($cms->is_post_back()){ 
	if($updateid){	
		$uids =  $cms->sqlquery("rs","color",$_POST,'pid',$updateid);
		$adm->sessset('Record has been updated', 's');
	}else{		 
 		$uids =  $cms->sqlquery("rs","color",$_POST);
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
	$rsAdmin=$cms->db_query("select * from #_color where pid='".$id."' and store_user_id = '".$_SESSION[uid]."'");
	$arrAdmin=$cms->db_fetch_array($rsAdmin);
	@extract($arrAdmin);
}
?>
  
  <table width="100%" border="0" align="left" cellpadding="4" cellspacing="1" class="frm-tbl2">
       <tr  class="grey_">
		  <td width="25%" class="label">Click to change color:</td>
		  <td width="75%"><input class="color" name="colorcode"   value="<?=($colorcode)?$colorcode:'080305'?>"></td>
		</tr>
    <tr  class="grey_">
      <td width="25%" class="label">Title:*</td>
      <td width="75%"><input name="name" type="text" class="txt medium" id="color" lang="R" title="color" value="<?=$name?>" /></td>
    </tr>
    
    
    <tr>
      <td width="25%"  class="label">Status:<span>*</span></td>
      <td width="75%"><select name="status"  class="txt" title="Status" lang="R" xml:lang="R">
        <option value="Active" <?=(($status=='Active')?'selected="selected"':'')?>>Active</option>
        <option value="Inactive" <?=(($status=='Inactive')?'selected="selected"':'')?>>Inactive</option>
      </select></td>
    </tr>
	 
	<tr>
	  <td>&nbsp;</td>
	  <td>
	  <input type="submit" name="Submit" class="uibutton  loading"  value="&nbsp;&nbsp;&nbsp;Submit&nbsp;&nbsp;&nbsp;" /></td>
    </tr>	
  </table>
 
 