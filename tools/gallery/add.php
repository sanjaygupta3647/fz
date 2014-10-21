<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php 
 
/*if($cms->is_post_back() or $imgDel!=0){
	if(($updateid && $_FILES[file1][name]!="")or $imgDel!=0 ){  
	if($imgDel) $updateid = $imgDel;
	  $image_name =  $cms->getSingleresult("select image from #_gallery where pid='".$updateid."'");
				if(trim($image_name)!="")
				{  
							@unlink(UP_FILES_FS_PATH."/orginal/".$image_name);							 
							@unlink(UP_FILES_FS_PATH."/big/".$image_name);
							@unlink(UP_FILES_FS_PATH."/small/".$image_name);
							@unlink(UP_FILES_FS_PATH."/services/".$image_name); 
							@unlink(UP_FILES_FS_PATH."/products/".$image_name); 
				}
	}
}*/
if($cms->is_post_back()){ 
	if($updateid){ 
		$cms->sqlquery("rs","gallery",$_POST,'pid',$updateid);
		$adm->sessset('Record has been updated', 's');
		
	} else {
		if(!$cms->db_scalar("select count(*) from #_gallery where caption='".$caption."'")){
			$cms->sqlquery("rs","gallery",$_POST);
			$adm->sessset('Record has been added', 's');
		} else{
			$adm->sessset('Album name already exist', 'e');
		}
	}
	$cms->redir(SITE_PATH_ADM.CPAGE.(($catid)?'?view=true&catid='.$catid:''), true);
	
}
if(isset($id)){
	$rsAdmin=$cms->db_query("select * from #_gallery where pid='".$id."'");
	$arrAdmin=$cms->db_fetch_array($rsAdmin);
	@extract($arrAdmin);
}
?>
 
  <table width="100%" border="0" align="left" cellpadding="4" cellspacing="1" class="frm-tbl2"  >
  <?php if($catid){?>
    <tr>
      <td width="25%" valign="top" class="label">Caption name:<span>*</span></td>
      <td width="75%"><input class="txt medium" name="caption" type="text" id="caption" lang="R" title="Caption" value="<?=$caption?>" />
      </td>
    </tr>
    <?php if($_GET[id] and file_exists(UP_FILES_FS_PATH."/thumb/".$image)){?>
    <tr>
      <td valign="top"  class="label"></td>
      <td><img src="<?=SITE_PATH."uploaded_files/thumb/".$image?>"?></td>
    </tr>
    <?php } ?>
    <tr>
      <td width="25%" valign="top"  class="label">Image: </td>
      <td width="75%"><input type="text" name="image" value="<?=$image?>" class="txt medium" id="upimg" />
      <img  class="img-click" onClick="window.open('<?=SITE_PATH_ADM."crop/imageupload.php?imgid=upimg&image=gallery"?>','mywindow','width=800,height=400,left=200,scrollbars=yes, top=100,screenX=0,screenY=100')" src="<?=SITE_PATH_ADM?>images/clickhere.png" alt="" />
     <!-- <a href="<?=SITE_PATH_ADM."crop/imageupload.php?imgid=upimg"?>" class="upimg uibutton loading" >click here</a>--></td>
   </tr>
   <?php }else{?>
   <tr>
     <td valign="top" class="label">Album name:<span>*</span></td>
     <td><input class="txt medium" name="caption" type="text" id="caption" lang="R" title="Category" value="<?=$caption?>" /></td>
   </tr>
  <?php /*?>
    <tr>
     <td valign="top" class="label">Token:<span>*</span></td>
     <td>  <?php
   if($slug=="")
   {
   ?><input class="txt medium" name="slug" type="text" id="slug" lang="R" title="slug" value="<?='TOK'.time()?>" />
   <?php
   } else
   { echo $slug; }?></td>
   </tr><?php */?>
   
   <tr>
      <td valign="top"  class="label">Second heading:</td>
      <td><input name="caption2" type="text" class="txt medium" id="caption2"  value="<?=$caption2?>" xml:lang="R" /></td>
    </tr>
   <tr>
     <td valign="top" class="label">Token:<span>*</span></td>
     <?php if($slug) $slug = $slug; else $slug = "TOK_".time();  ?>
     <td><input class="txt medium" name="slug" type="text" id="token" lang="R"   title="Token" value="<?=$slug?>" /></td>
   </tr>
   <?php if($_GET[id] and file_exists(UP_FILES_FS_PATH."/thumb/".$image)){?>
    
    <tr>
      <td valign="top"  class="label"></td>
      <td><img src="<?=SITE_PATH."uploaded_files/thumb/".$image?>"?> </td>
    </tr>
    <?php } ?>
    <tr>
      <td width="25%" valign="top"  class="label">Image: </td>
      <td width="75%">
     <?php /*?> <input name="file1" type="file" id="file1" />&nbsp;&nbsp; SITE_PATH_ADM."crop/upload_crop.php?id=".$_GET[id]<?php */?>
    	 <input type="text" name="image" value="<?=$image?>" class="txt medium" id="upimg" />
    <img  class="img-click" onClick="window.open('<?=SITE_PATH_ADM."crop/imageupload.php?imgid=upimg&image=gallery"?>','mywindow','width=800,height=400,left=200,scrollbars=yes, top=100,screenX=0,screenY=100')" src="<?=SITE_PATH_ADM?>images/clickhere.png" alt="" />
   </tr>

    <?php } ?>
	<tr>
	  <td class="label">Status:<span>*</span></td>
	  <td><select name="status"  class="txt" lang="R" title="Status">
	  <option value="Active" <?=(($status=='Active')?'selected="selected"':'')?>>Active</option>
	  <option value="Inactive" <?=(($status=='Inactive')?'selected="selected"':'')?>>Inactive</option>
	  </select>	  </td>
    </tr>
	<tr>
	  <td>&nbsp;</td>
	  <td><input type="submit" name="Submit" class="uibutton  loading" value="&nbsp;&nbsp;&nbsp;Submit&nbsp;&nbsp;&nbsp;" /></td>
    </tr>	
  </table>
 
 