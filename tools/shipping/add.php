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
		$cms->redir(SITE_PATH_ADM.CPAGE, true);
	}
	
	
 
if(isset($pid)){
	$rsAdmin=$cms->db_query("select * from #_banner where pid='".$pid."'");
	$arrAdmin=$cms->db_fetch_array($rsAdmin);
	@extract($arrAdmin);
}
?>
  
  <table width="100%" border="0" align="left" cellpadding="4" cellspacing="1" class="frm-tbl2"  >
  
    <tr>
      <td width="25%" valign="top"  class="label">Page: </td>
      <td width="75%"><?php if(count($allpages)) {?>
      <select name="page" class="txt">
      <?php
	  foreach($allpages as $val)
	  {?>
		<option value="<?=$val?>" <? if($val==$page) echo'selected="selected"'; ?>><?=$val?></option>
        <?php  
	  }
	  ?>
      </select>
      <?php }?>
      </td>
   </tr> 
 
    <tr>
      <td width="25%" valign="top"  class="label">Image: </td>
      <td width="75%">
      <input type="text" name="image" value="<?=$image?>" class="txt medium" id="upimg" />
      <a href="<?=SITE_PATH_ADM."crop/imageupload.php?imgid=upimg"?>" class="upimg uibutton loading" >click here</a></td>
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
 
<script type="text/javascript">
$('.upimg').popupWindow({ 
centerScreen:1 
}); 
</script>