<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php 
if($cms->is_post_back()){  
	$_POST[url] = $adm->baseurl($pagename);
	$_POST[store_user_id] = $_SESSION[uid];
	if($updateid){
		$cms->sqlquery("rs","advertise",$_POST,'pid',$updateid); 
		$adm->sessset('Record has been updated', 's');
	}else{
		$_POST[submitdate] = time();
		$cms->sqlquery("rs","advertise",$_POST);
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
	$rsAdmin=$cms->db_query("select * from #_advertise where pid='".$id."'");
	$arrAdmin=$cms->db_fetch_array($rsAdmin); 
	@extract($arrAdmin);
}
?>
 
 
  <table width="100%" border="0" align="left" cellpadding="4" cellspacing="1" class="frm-tbl2">
  
    
     <tr>
      <td width="25%"  class="label">Title:</td>
      <td width="75%"><input type="text" name="title" id="title"   title="title" class="txt medium" value="<?=$title?>" /></td>
    </tr>
	<tr>
      <td width="25%"  class="label">Link Url:</td>
      <td width="75%"><input type="text" name="linkurl" id="title"   title="Link Url" class="txt medium" value="<?=$linkurl?>" /></td>
    </tr>
	 
    <?php if($image  and is_file($_SERVER['DOCUMENT_ROOT'].SITE_SUB_PATH."uploaded_files/orginal/".$image)==true){?>
          <tr>
            <td valign="top" class="label">&nbsp;</td>
            <td valign="top"><img src="<?=SITE_PATH?>uploaded_files/orginal/<?=$image?>" width="100"> &nbsp;&nbsp;
            </td>
          </tr>
    <?php } ?>
          <tr>
            <td valign="top" class="label">Image:</td>
            <td valign="top"> <input type="text" name="image" value="<?=$image?>" class="txt medium" id="upimg" />
       <img onClick="window.open('<?=SITE_PATH_MEM."crop/imageupload.php?imgid=upimg&image=product&view=thumb&name=".$image?>','mywindow','width=900,height=400,left=200,scrollbars=yes, top=100,screenX=0,screenY=100')" src="<?=SITE_PATH_MEM?>images/clickhere.png" alt=""  class="img-click" /> <br /></td>
          </tr>  

	<tr>
	  <td class="label">Place:<span>*</span></td>
	  <td><select name="place" class="txt medium" >
	  <option value="main-site" <?=(($place=='main-site')?'selected="selected"':'')?>>Main Site</option>
	  <option value="theme" <?=(($place=='theme')?'selected="selected"':'')?>>Theme</option>
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
 