<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php 
 
if($cms->is_post_back()){  
$numc = mysql_num_rows($cms->db_query("select * from #_slider where slider_type='1'"));
$_POST[store_id]=0;
	if($pid){ 
	    
		$_POST['slider_type']=1;
		$cms->sqlquery("rs","slider",$_POST,'pid',$updateid);
		$adm->sessset('Record has been updated', 's'); 
	} else { 
	     if($_POST[image]){
			$_POST[image]=$_POST[image]; 
		}else{
			$_POST[image]=$_POST[color];  
		}
		   if($numc<=8){
		   $_POST['slider_type']=1;
			$cms->sqlquery("rs","slider",$_POST);
			$adm->sessset('Record has been added', 's');
			}else{
			  $adm->sessset('Record con not uploaded more than 8!','e');
			} 
		}
		$_POST = false;
		$cms->redir(SITE_PATH_ADM.CPAGE, true);
	} 
 
if(isset($pid)){
	$rsAdmin=$cms->db_query("select * from #_slider where pid='".$pid."'");
	$arrAdmin=$cms->db_fetch_array($rsAdmin); 
	 
	@extract($arrAdmin);
}
$file =$image;
$len = strlen($file);
$ext = substr($file, -4, 4);  
?>
  
  <table width="100%" border="0" align="left" cellpadding="4" cellspacing="1" class="frm-tbl2"  >
  <input type="hidden" name="store_id" value="<?=$_SESSION[store_id]?>" />
 
  <tr  class="grey_">
	  <td class="label">Order</td> 
	  <td><input name="porder" type="text" class="txt" value="<?=$porder?>" lang="R" title="Order" /></td>
	</tr> 
<?php $background = ($background)?$background:'color';?>
 <tr  class="grey_">
  <td class="label">Select Background</td><td>
 <input name="background" type="radio" id="radio1"   value="color" <?=($background=='color')?'checked':''?>>Color	&nbsp;&nbsp; 
 <input name="background" type="radio" id="radio2"   value="image" <?=($background=='image')?'checked':''?>> Image</td>
 </tr>   
	 <tr  class="grey_ color" <?=($background=='color')?'':'style="display:none;"'?>>
	  <td class="label">Background Color</td> 
	  <td><input name="color" class="color" value="<?=$color?>" lang="R"></td>
	</tr>
	 
	<?php if($image  and is_file($_SERVER['DOCUMENT_ROOT'].SITE_SUB_PATH."uploaded_files/orginal/".$image)==true){?>
          <tr class="grey_ image1" <?=($background=='image')?'':'style="display:none;"'?>>
            <td valign="top" class="label">&nbsp;</td>
            <td valign="top"><img src="<?=SITE_PATH?>uploaded_files/orginal/<?=$image?>" width="100"> &nbsp;&nbsp;
            </td>
          </tr>
    <?php } ?>
	<tr class="grey_ image1" <?=($background=='image')?'':'style="display:none;"'?>>
      <td width="25%" valign="top"  class="label">Background Image: </td>
      <td width="75%">
      <input type="text" name="image" value="<?=$image?>" class="txt medium" id="upimg" />
      
       <img  class="img-click" onClick="window.open('<?=SITE_PATH_MEM."crop/imageupload.php?imgid=upimg&image=slider"?>','mywindow','width=800,height=400,left=200,scrollbars=yes, top=100,screenX=0,screenY=100')" src="<?=SITE_PATH_MEM?>images/clickhere.png" alt="" />
       <span style="color:#000; margin:0 0 0 100px;"><strong style="color:#F00;font-size: 20px;">*</strong>Image Format must be <b style="color:#F00;font-size: 15px;">.png</b> and Image size 704 x 330px</span>
    </td>
   </tr> 
   
    <tr>
	<?php 
	   if($side_image  and is_file($_SERVER['DOCUMENT_ROOT'].SITE_SUB_PATH."uploaded_files/orginal/".$side_image)==true){?>
	   <tr>
		<td valign="top" class="label">&nbsp;</td>
		<td valign="top"><img src="<?=SITE_PATH?>uploaded_files/orginal/<?=$side_image?>" width="100"> &nbsp;&nbsp;</td>		
	   </tr>
      <?php } ?>
      <td width="25%" valign="top"  class="label">Slider Right Image :</td>
      <td width="75%">
      <input type="text" name="side_image" value="<?=$side_image?>" class="txt medium" id="upimg1" />
      
       <img  class="img-click" onClick="window.open('<?=SITE_PATH_MEM."crop/imageupload.php?imgid=upimg1&image=slider"?>','mywindow','width=800,height=400,left=200,scrollbars=yes, top=100,screenX=0,screenY=100')" src="<?=SITE_PATH_MEM?>images/clickhere.png" alt="" />
       <span style="color:#000; margin:0 0 0 100px;"><strong style="color:#F00;font-size: 20px;">*</strong>Image Format must be <b style="color:#F00;font-size: 15px;">.png</b> and Image size 300 x 300px</span>
    </td>
   </tr> 
     <tr  class="grey_">
	  <td class="label">Banner Heading:</td> 
	  <td><input name="title" type="text"  value="<?=$title?>"  class="txt medium" /></td>
	</tr>
	
	   <tr  class="grey_">
	  <td class="label">Cotaints:</td> 
	  <td>  
	  <textarea   cols="20"  name="contents" title="Contents"  class="txt medium" /><?=$contents?></textarea></td>
	</tr>   
   <tr  class="grey_">
	  <td class="label">Link Url:</td> 
	  <td><input name="linkurl" type="text"  value="<?=$linkurl?>"   class="txt medium" /></td>
	</tr>
	<tr>
	  <td>&nbsp;</td>
	  <td><input type="submit" name="Submit" class="uibutton  loading" value="&nbsp;&nbsp;&nbsp;Submit&nbsp;&nbsp;&nbsp;" /></td>
    </tr>	
  </table>
  <script type="text/javascript">
   $(document).ready(function(){
	 
	$("#radio1").click(function(){
		$(".color").show();
		$(".image1").hide(); 
	});
	$("#radio2").click(function(){
		$(".color").hide();
		$(".image1").show(); 
	});
	 
  });
  </script>
 
 