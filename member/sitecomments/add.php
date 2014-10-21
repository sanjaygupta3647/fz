<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php 

if($cms->is_post_back()){   
	if($updateid){
		$cms->sqlquery("rs","review",$_POST,'pid',$updateid); 
		$adm->sessset('Record has been updated', 's');
	}else{
		$_POST[submitdate] = time(); 
		$_POST['store_user_id']  =  $_SESSION[uid];
		$cms->sqlquery("rs","review",$_POST);
		$updateid = mysql_insert_id();
		$adm->sessset('Record has been added', 's');
	} 
	if(isset($_GET['start']) && $_GET['start'] > 0) {
		$path = SITE_PATH_MEM.CPAGE."/index.php?start=".$_GET['start'];
	} else {
		$path = SITE_PATH_MEM.CPAGE;
	}
	$cms->redir($path, true);
}	
if(isset($id)){
	$rsAdmin=$cms->db_query("select * from #_review where pid='".$id."'");
	$arrAdmin=$cms->db_fetch_array($rsAdmin); 
	@extract($arrAdmin);
}
?>
 
 
  <table width="100%" border="0" align="left" cellpadding="4" cellspacing="1" class="frm-tbl2">  
 
	<tr  class="grey_">
      <td width="25%" valign="top" class="label">Title:</td>
      <td width="75%"><textarea name="title" cols="80" rows="5" lang="R" title="Title" id="Title"><?=$title?></textarea></td>
    </tr>  
	<tr>
	  <td valign="top" class="label">Comment:</td>
	  <td valign="top">
			<textarea name="comment" cols="90" rows="5" title="Comment" id="Comment"><?=$cms->removeSlash($comment)?> </textarea>
      </td>
	</tr>   
	<tr  class="grey_">
      <td width="25%" valign="top" class="label">Star:</td>
      <td width="75%"> <?=$star?>/5 </td>
    </tr>  
	<tr>
	  <td class="label">Review For:<span>*</span></td>
	  <td><?=$type?>   </td>
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
  