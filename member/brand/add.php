<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php 
if($cms->is_post_back()){
	$_POST[url] = $adm->baseurl($pagename);
	if($updateid){
		$cms->sqlquery("rs","brand",$_POST,'pid',$updateid);
		$cms->sessset('Record has been updated', 's');
	}else{
		$_POST[submitdate] = time();
		$cms->sqlquery("rs","brand",$_POST);
		$cms->sessset('Record has been added', 's');
	}
	$cms->redir(SITE_PATH_ADM.CPAGE, true);
}	
if(isset($id)){
	$rsAdmin=$cms->db_query("select * from #_brand where pid='".$id."'");
	$arrAdmin=$cms->db_fetch_array($rsAdmin);
	 @extract($arrAdmin); 
}
?>
 
  <table width="100%" border="0" align="left" cellpadding="4" cellspacing="1" class="frm-tbl2">
    <tr  class="grey_">
      <td width="25%" class="label">Select Category:</td>
      <td width="75%">
      <select name="cat_id" class="select" id="catId" lang="R" title="Category">
      <option value="0")?>---Select Category--</option> 
      <? $rsAdmin1=$cms->db_query("select pid,name from #_category where parentId='0'");
	  while($arrAdmin2=$cms->db_fetch_array($rsAdmin1)){ 
	  ?>
	  <option value="<?=$arrAdmin2[pid]?>" <?=(($arrAdmin2[pid]==$cat_id)?'selected="selected"':'')?>><?=$arrAdmin2[name]?></option> 
      <?
	  $rsAdmin3=$cms->db_query("select pid,name from #_category where parentId='".$arrAdmin2[pid]."'");
	  if(mysql_num_rows($rsAdmin3)){
		   while($arrAdmin4=$cms->db_fetch_array($rsAdmin3)){
			?>
              <option value="<?=$arrAdmin4[pid]?>" <?=(($arrAdmin4[pid]==$cat_id)?'selected="selected"':'')?>><?=$arrAdmin2[name]?> &raquo; <?=$arrAdmin4[name]?></option> <?
				$rsAdmin5=$cms->db_query("select pid,name from #_category where parentId='".$arrAdmin4[pid]."'");
				if(mysql_num_rows($rsAdmin5)){
				while($arrAdmin6=$cms->db_fetch_array($rsAdmin5)){
				?>
				<option value="<?=$arrAdmin6[pid]?>" <?=(($arrAdmin6[pid]==$cat_id)?'selected="selected"':'')?>><?=$arrAdmin2[name]?> &raquo; <?=$arrAdmin4[name]?> &raquo;<?=$arrAdmin6[name]?></option> 
				<?   
				}
				}

		   }
		  }
	   }?>
	  </select>	
      
      </td>
    </tr>
    
   <tr>
      <td width="25%"  class="label">Name: </td>
      <td width="75%"><input type="text" name="name"  lang="R" title="Name" class="txt medium" value="<?=$name?>" /></td>
    </tr>
	 
	<tr>
	  <td valign="top" class="label">&nbsp;</td>
	  <td valign="top">&nbsp;</td>
    </tr>
	<tr>
	  <td valign="top" class="label">Short description:</td>
	  <td valign="top">
      <textarea rows="8" cols="60" name="body"><?=$body?></textarea>
      </td>
	</tr> 
	<tr>
	  <td class="label">Status:<span>*</span></td>
	  <td><select name="status" class="select" lang="R" title="Status">
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
 