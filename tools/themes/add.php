<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php  
if($cms->is_post_back()){ 
	if($updateid){	
		$uids =  $cms->sqlquery("rs","themes",$_POST,'pid',$updateid);
		$adm->sessset('Record has been updated', 's');
	}else{		 
 		$uids =  $cms->sqlquery("rs","themes",$_POST);
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
	$rsAdmin=$cms->db_query("select * from #_themes where pid='".$id."'");
	$arrAdmin=$cms->db_fetch_array($rsAdmin);
	@extract($arrAdmin);
}
?> 
  <table width="100%" border="0" align="left" cellpadding="4" cellspacing="1" class="frm-tbl2">
    <tr  class="grey_">
      <td width="25%" class="label">Title:*</td>
      <td width="75%"><input name="title" type="text" style="" class="txt medium" id="themes" lang="R" title="Title" value="<?=$title?>" /></td>
    </tr>

     <tr  class="grey_">
      <td width="25%" class="label">Top Strip Color:*</td>
      <td width="75%"><input name="header_strip" <?=($header_strip)?'style="background-color:#'.$header_strip.' "':''?>  type="text" class="txt" id="header_strip" lang="R" title="Top Strip Color" value="<?=$header_strip?>" /></td>
    </tr>
	<tr  class="grey_">
      <td width="25%" class="label">Second Strip Color:*</td>
      <td width="75%"><input name="sstrip" <?=($sstrip)?'style="background-color:#'.$sstrip.' "':''?>  type="text" class="txt" id="sstrip" lang="R" title="Second Strip Color" value="<?=$sstrip?>" /></td>
    </tr>
    <tr  class="grey_">
      <td width="25%" class="label">Border Color:*</td>
      <td width="75%"><input name="border"  <?=($border)?'style="background-color:#'.$border.' "':''?>  type="text" class="txt" id="border" lang="R" title="Border Color" value="<?=$border?>" /></td>
    </tr>
	<tr  class="grey_">
      <td width="25%" class="label">Background Color:*</td>
      <td width="75%"><input name="background"  <?=($background)?'style="background-color:#'.$background.' "':''?>  type="text" class="txt" id="background" lang="R" title="Border Color" value="<?=$background?>" /></td>
    </tr>

	<tr class="grey_">
      <td width="25%" class="label">Footer Strip Color:*</td>
      <td width="75%"><input name="footer_strip"  <?=($footer_strip)?'style="background-color:#'.$footer_strip.' "':''?>  type="text" class="txt" id="footer_strip" lang="R" title="Border Color" value="<?=$footer_strip?>" /></td>
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
 
 