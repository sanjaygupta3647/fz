<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php 
 
if($cms->is_post_back()){ 
	if($pid){ 
		$cms->sqlquery("rs","image_offer",$_POST,'pid',$updateid);
		$adm->sessset('Record has been updated', 's');
		
	} else { 
			$cms->sqlquery("rs","image_offer",$_POST);
			$adm->sessset('Record has been added', 's'); 
		}
		
	//$cms->redir(SITE_PATH_MEM.CPAGE, true);
	
	if(isset($_GET['start']) && $_GET['start'] > 0) {
		$path = SITE_PATH_MEM.CPAGE."/index.php?start=".$_GET['start'];
	} else {
		$path = SITE_PATH_MEM.CPAGE;
	}
	$cms->redir($path, true);
	}
	
	
 
if(isset($pid)){
	$rsAdmin=$cms->db_query("select * from #_image_offer where pid='".$pid."'");
	$arrAdmin=$cms->db_fetch_array($rsAdmin); 
	@extract($arrAdmin);
}

?>
  
  <table width="100%" border="0" align="left" cellpadding="4" cellspacing="1" class="frm-tbl2"  >
  <input type="hidden" name="store_id" value="<?=$_SESSION[store_id]?>" />
   <tr  class="grey_">
	  <td class="label">Title:</td> 
	  <td><input name="title" type="text" class="txt medium"value="<?=$title?>" lang="R" /></td>
	</tr>
     <tr  class="grey_">
	  <td class="label">Link Url:</td> 
	  <td><input name="linkurl" type="text" placeholder="http://" class="txt medium"value="<?=$linkurl?>" lang="R" /></td>
	</tr>
	 <tr  class="grey_">
	  <td class="label">Order</td> 
	  <td><input name="porder" type="text" class="txt"value="<?=$porder?>" lang="R" /></td>
	</tr>
	 <?php if($image  and is_file($_SERVER['DOCUMENT_ROOT'].SITE_SUB_PATH."uploaded_files/orginal/".$image)==true){?>
          <tr>
            <td valign="top" class="label">&nbsp;</td>
            <td valign="top"><img src="<?=SITE_PATH?>uploaded_files/orginal/<?=$image?>" width="100"> &nbsp;&nbsp;
            </td>
          </tr>
          <?php } ?>
    <tr>
      <td width="25%" valign="top"  class="label">Image: </td>
      <td width="75%">
      <input type="text" name="image" value="<?=$image?>" class="txt medium" id="upimg" />
      
       <img  class="img-click" onClick="window.open('<?=SITE_PATH_MEM."crop/imageupload.php?imgid=upimg&image=slider"?>','mywindow','width=800,height=400,left=200,scrollbars=yes, top=100,screenX=0,screenY=100')" src="<?=SITE_PATH_MEM?>images/clickhere.png" alt="" />
       
    </td>
   </tr>

 
 <!--
	<tr>
	  <td>&nbsp;</td>
	  <td><form id="form1" name="form1" method="post" action="">
	    <input type="radio" name="radio" id="radio" value="radio" />
	    Ra
      </form>
	    <form id="form2" name="form1" method="post" action="">
	      <input type="radio" name="radio" id="radio2" value="radio" />
	      Ra
      </form></td>
    </tr>
	<tr>
	  <td>&nbsp;</td>
	  <td><div id="FileUpload">
                <input type="file" size="24" id="BrowserHidden" onchange="getElementById('FileField').value = getElementById('BrowserHidden').value;">
                <div id="BrowserVisible">
                  <input type="text" id="FileField">
                </div>
              </div></td>
    </tr>-->
	<tr>
	  <td>&nbsp;</td>
	  <td><input type="submit" name="Submit" class="uibutton  loading" value="&nbsp;&nbsp;&nbsp;Submit&nbsp;&nbsp;&nbsp;" /></td>
    </tr>	
  </table>
 
 