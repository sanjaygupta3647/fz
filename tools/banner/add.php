<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php 
 
if($cms->is_post_back()){ 
	if($pid){ 
		$cms->sqlquery("rs","banner",$_POST,'pid',$updateid);
		$adm->sessset('Record has been updated', 's');
		
	} else { 
			$cms->sqlquery("rs","banner",$_POST);
			$adm->sessset('Record has been added', 's'); 
		}
		//$cms->redir(SITE_PATH_ADM.CPAGE, true);
	
	if(isset($_GET['start']) && $_GET['start'] > 0) {
		$path = SITE_PATH_ADM.CPAGE."/index.php?start=".$_GET['start'];
	} else {
		$path = SITE_PATH_ADM.CPAGE;
	}
	$cms->redir($path, true);	
	
}
	 
	
	
 
if(isset($pid)){
	$rsAdmin=$cms->db_query("select * from #_banner where pid='".$pid."'");
	$arrAdmin=$cms->db_fetch_array($rsAdmin); 
	@extract($arrAdmin);
}
?>
  
         <table width="100%" border="0" align="left" cellpadding="2" cellspacing="1"  class="frm-tbl2">
        <?php if($banner   and is_file($_SERVER['DOCUMENT_ROOT'].SITE_SUB_PATH."uploaded_files/orginal/".$banner)==true){?>
          <tr>
            <td valign="top" class="label">&nbsp;</td>
            <td valign="top"><img src="<?=SITE_PATH?>uploaded_files/orginal/<?=$banner?>" width="100"> &nbsp;&nbsp;
            </td>
          </tr>
          <?php } ?>
          <tr>
            <td valign="top" class="label">Home Banner:</td>
            <td valign="top"> <input type="text" name="banner" value="<?=$banner?>" class="txt medium" id="upimg3" />
       <img onClick="window.open('<?=SITE_PATH_ADM."crop/imageupload.php?imgid=upimg3&image=product&view=big&name=".$pimage?>','mywindow','width=900,height=400,left=200,scrollbars=yes, top=100,screenX=0,screenY=100')" src="<?=SITE_PATH_ADM?>images/clickhere.png" alt="" class="img-click" /> <br /></td>
          </tr>
      
           
        <?php if($banner_left  and is_file($_SERVER['DOCUMENT_ROOT'].SITE_SUB_PATH."uploaded_files/orginal/".$banner_left)==true){?>
          <tr>
            <td valign="top" class="label">&nbsp;</td>
            <td valign="top"><img src="<?=SITE_PATH?>uploaded_files/orginal/<?=$banner_left?>" width="100"> &nbsp;&nbsp;
            </td>
          </tr>
          <?php } ?>
          <tr>
            <td valign="top" class="label">Left Banner:</td>
            <td valign="top"> <input type="text" name="banner_left" value="<?=$banner_left?>" class="txt medium" id="upimg" />
       <img onClick="window.open('<?=SITE_PATH_ADM."crop/imageupload.php?imgid=upimg&image=product&view=thumb&name=".$image?>','mywindow','width=900,height=400,left=200,scrollbars=yes, top=100,screenX=0,screenY=100')" src="<?=SITE_PATH_ADM?>images/clickhere.png" alt=""  class="img-click" /> <br /></td>
          </tr>
          
        <?php if($banner_right   and is_file($_SERVER['DOCUMENT_ROOT'].SITE_SUB_PATH."uploaded_files/orginal/".$banner_right)==true){?>
          <tr>
            <td valign="top" class="label">&nbsp;</td>
            <td valign="top"><img src="<?=SITE_PATH?>uploaded_files/orginal/<?=$banner_right?>" width="100"> &nbsp;&nbsp;
            </td>
          </tr>
          <?php } ?>
          <tr>
            <td valign="top" class="label">Right Banner:</td>
            <td valign="top"> <input type="text" name="banner_right" value="<?=$banner_right?>" class="txt medium" id="upimg2" />
       <img onClick="window.open('<?=SITE_PATH_ADM."crop/imageupload.php?imgid=upimg2&image=product&view=big&name=".$pimage?>','mywindow','width=900,height=400,left=200,scrollbars=yes, top=100,screenX=0,screenY=100')" src="<?=SITE_PATH_ADM?>images/clickhere.png" alt="" class="img-click" /> <br /></td>
          </tr> 
            <td>&nbsp;</td>
            <td><input type="submit" name="Submit" class="uibutton  loading" value="&nbsp;&nbsp;&nbsp;Submit&nbsp;&nbsp;&nbsp;" /></td>
          </tr>
        </table>
     
 
 