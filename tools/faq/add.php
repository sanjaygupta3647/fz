<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php 
if($cms->is_post_back()){   
	if($updateid){
		$cms->sqlquery("rs","faq",$_POST,'pid',$updateid); 
		$adm->sessset('Record has been updated', 's');
	}else{
		$_POST[submitdate] = time();
		$cms->sqlquery("rs","faq",$_POST);
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
	$rsAdmin=$cms->db_query("select * from #_faq where pid='".$id."'");
	$arrAdmin=$cms->db_fetch_array($rsAdmin); 
	@extract($arrAdmin);
}
?>
 
 
  <table width="100%" border="0" align="left" cellpadding="4" cellspacing="1" class="frm-tbl2">  
 
	<tr  class="grey_">
      <td width="25%" valign="top" class="label">Question:</td>
      <td width="75%"><textarea name="qsn" cols="80" rows="5" lang="R" title="Question" id="Question"><?=$qsn?></textarea></td>
    </tr>  
	<tr>
	  <td valign="top" class="label">Answer:</td>
	  <td valign="top">
			<?=$adm->get_editor('body', $cms->removeSlash($body))?> 
      </td>
	</tr>   
	<tr>
	    <td class="label">Question For:<span>*</span></td>
	  <td><select name="ftype" class="txt medium" lang="R" title="Type">
	  <option value="Site" <?=(($ftype=='Site')?'selected="selected"':'')?>>Site</option>
	  <option value="Product" <?=(($ftype=='Product')?'selected="selected"':'')?>>Product</option>
	  </select>	  </td>
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
  