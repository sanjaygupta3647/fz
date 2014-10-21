<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php  
 if($cms->is_post_back()){   
		$_POST[store_id] = 0;
		if($updateid){
			$cms->sqlquery("rs","template",$_POST,'pid',$updateid); 
			$adm->sessset('Record has been updated', 's');
		}else{
			$_POST[submitdate] = time();
			$cms->sqlquery("rs","template",$_POST);
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
	$rsAdmin=$cms->db_query("select * from #_template where pid='".$id."'");
	$arrAdmin=$cms->db_fetch_array($rsAdmin);
	@extract($arrAdmin);
}
$mails_template[] = "Contact us";
?>
 
  <table width="100%" border="0" align="left" cellpadding="4" cellspacing="1" class="frm-tbl2"> 
    <tr>
      <td width="25%"  class="label">Mail On:</td>
      <td width="75%">
	  <select name="title" class="txt medium" >
		  <?php foreach($mails_template as $val){ ?>
			<option value="<?=$val?>" <?=(($val==$title)?'selected="selected"':'')?>><?=$val?></option> 
			<?php
		  }?>
	  </select> 
	  </td>
    </tr> 
	<tr>
      <td width="25%"  class="label">Mail Subject:</td>
      <td width="75%"><input type="text" name="subject"  lang="R" title="Mail Subject" class="txt medium" value="<?=$subject?>" />
	  </td>
    </tr> 
	<tr>
	  <td valign="top" class="label">Mail Body:</td>
	  <td valign="top">
      <?=$adm->get_editor('body', stripslashes($body))?> 
      </td>
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
 