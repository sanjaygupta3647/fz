<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php 
 
if($cms->is_post_back()){
	if($updateid && $_FILES[file1][name]!=""){  
	$image_name =  $cms->getSingleresult("select image from #_news where pid='".$updateid."'");
				if(trim($image_name)!="")
				{ 
					if(file_exists(UP_FILES_FS_PATH."/news/".$image_name))
						{ 
							 unlink(UP_FILES_FS_PATH."/news/".$image_name); 
						 
						} 
				}
	}
	 
	$_POST[url] = $adm->baseurl($title);
	
	if($cms->is_post_back()){
	$_POST[url] = $adm->baseurl($title);
	$big = UP_FILES_FS_PATH."/big";
	$news = UP_FILES_FS_PATH."/news";
 
	if($_FILES[file1][name]){
		$_POST['image'] = $cms->uploadFile($big,$_FILES['file1']['name'],'file1'); 
		$cms->make_thumb_gd($big."/".$_POST['image'], $news."/".$_POST['image'],186, 160);
		 
		}
	}
	if($updateid){	
		$uids =  $cms->sqlquery("rs","news",$_POST,'pid',$updateid);
		$adm->sessset('Record has been updated', 's');
	}else{
		$_POST[dd] = date("d");
		$_POST[mm] = date("m");
		$_POST[yy] = date("Y");
		
		$_POST[submitdate] = time();
		$uids =  $cms->sqlquery("rs","news",$_POST);
		$adm->sessset('Record has been added', 's');
	}
	$cms->db_query("update #_news set `body` = '".$_POST[body]."' where `pid` in ($uids)");
	$cms->redir(SITE_PATH_ADM.CPAGE, true);
}	
if(isset($id)){
	$rsAdmin=$cms->db_query("select * from #_news where pid='".$id."'");
	$arrAdmin=$cms->db_fetch_array($rsAdmin);
	@extract($arrAdmin);
}
?>
  <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css" />
  <script src="http://code.jquery.com/jquery-1.8.2.js"></script> 
  <script src="http://code.jquery.com/ui/1.9.1/jquery-ui.js"></script> 
  <script>
    $(function() {
        $( "#invdate2" ).datepicker({ dateFormat: 'yy-mm-dd' }).val();
    });</script>
  <table width="100%" border="0" align="left" cellpadding="4" cellspacing="1" class="frm-tbl2">
    <tr  class="grey_">
      <td width="25%" class="label">Title:*</td>
      <td width="75%"><input name="title" type="text" class="txt medium" id="title" lang="R" title="Title" value="<?=$title?>" /></td>
    </tr>
       <?php if($_GET[id] and file_exists(UP_FILES_FS_PATH."/thumb/".$image)){?>
    <tr>
      <td valign="top"  class="label"></td>
      <td><img src="<?=SITE_PATH."uploaded_files/thumb/".$image?>"/> </td>
    </tr>
    <?php } ?>
     <tr>
      <td width="25%" valign="top"  class="label">Image:</td>
      <td width="75%"><input type="text" name="image" value="<?=$image?>" class="txt medium" id="upimg" />
     <img  class="img-click" onClick="window.open('<?=SITE_PATH_ADM."crop/imageupload.php?imgid=upimg&image=news"?>','mywindow','width=800,height=400,left=200,scrollbars=yes, top=100,screenX=0,screenY=100')" src="<?=SITE_PATH_ADM?>images/clickhere.png" alt="" /></td>
   </tr>
    <tr>
      <td  class="label">Date:*</td> 
       <td><? //$cms->cal("date",$date, 'input', "yyyy-mm-dd")?>  <input type="text" name="date" id="invdate2"  value="<?=$date?>" class="txt" /></td>
    </tr>
    <tr>
      <td width="25%"  class="label">Status:<span>*</span></td>
      <td width="75%"><select name="status"  class="txt" title="Status" lang="R" xml:lang="R">
        <option value="Active" <?=(($status=='Active')?'selected="selected"':'')?>>Active</option>
        <option value="Inactive" <?=(($status=='Inactive')?'selected="selected"':'')?>>Inactive</option>
      </select></td>
    </tr>
	<?php /*?><tr class="grey_">
	  <td colspan="2" valign="top" class="label">Short Description:</td>
    </tr>
	<tr>
	  <td colspan="2" valign="top" class="label"><?=$adm->get_editor_s('sort_desc', $sort_desc, SITE_SUB_PATH, 500, 200)?></td>
    </tr><?php */?>
	<tr>
	  <td valign="top" class="label">Description:</td>
	  <td valign="top">&nbsp;</td>
    </tr>
	<tr class="grey_">
	  <td colspan="2" class="label"><?=$adm->get_editor('body', $body, SITE_SUB_PATH)?></td>
    </tr>
	
	<tr>
	  <td>&nbsp;</td>
	  <td>
	  <input type="submit" name="Submit" class="uibutton  loading"  value="&nbsp;&nbsp;&nbsp;Submit&nbsp;&nbsp;&nbsp;" /></td>
    </tr>	
  </table>
 
 <script type="text/javascript">
$('.upimg').popupWindow({ 
centerScreen:1 
}); 
</script>