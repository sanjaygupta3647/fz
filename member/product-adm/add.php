<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php 
 
if(isset($id)){
	$rsAdmin=$cms->db_query("select * from #_products where pid='".$id."'");
	$arrAdmin=$cms->db_fetch_array($rsAdmin);
	@extract($arrAdmin);
}
?>
 
  <table width="100%" border="0" align="left" cellpadding="4" cellspacing="1" class="frm-tbl2">
    <tr  class="grey_">
      <td width="25%" class="label">Select Category:</td>
      <td width="75%">
      <select name="cat_id" class="txt medium" id="catId" lang="R" title="Category">
      <option value="0")?>---Select Category--</option> 
      <? $rsAdmin=$cms->db_query("select pid,name from #_category where parentId='0'");
	  while($arrAdmin=$cms->db_fetch_array($rsAdmin)){
			@extract($arrAdmin);
			?>
				<optgroup label="<?=$name?>"><?php			   
				$rsAdmin2=$cms->db_query("select pid,name from #_category where parentId='$pid'");
				if(mysql_num_rows($rsAdmin2)){
					while($arrAdmin3=$cms->db_fetch_array($rsAdmin2)){
						$prosubcat=$cms->db_query("select pid,name from #_category where parentId='".$arrAdmin3[pid]."'");
						if(mysql_num_rows($prosubcat)){
						?><optgroup label="<?=$name?> => <?=$arrAdmin3[name]?>"><?php
							while($subres=$cms->db_fetch_array($prosubcat)){?>							
								<option value="<?=$subres[pid]?>" <?=(($subres[pid]==$cat_id)?'selected="selected"':'')?>>
						  <?=$subres[name]?></option><?php
							} 
							echo "</optgroup>";
						}else{
						?>
						<option value="<?=$arrAdmin3[pid]?>" <?=(($arrAdmin3[pid]==$cat_id)?'selected="selected"':'')?>>
						  <?=$arrAdmin3[name]?></option>  <?php
						  }
					}
				}?>
				</optgroup><?php
				
	   }?>
	  </select>	
      
      </td>
    </tr>
    
   
    
   <tr>
      <td width="25%"  class="label">Name:</td>
      <td width="75%"><input type="text" name="title"  lang="R" title="Name" class="txt medium"value="<?=$title?>" /></td>
    </tr>
	 
	<tr>
	  <td valign="top" class="label">&nbsp;</td>
	  <td valign="top">&nbsp;</td>
    </tr>
	<tr>
	  <td valign="top" class="label">Short description:</td>
	  <td valign="top">
      <textarea rows="8" cols="60" name="body1"><?=$body1?></textarea>
      </td>
	</tr> 
    <tr  class="grey_">
      <td width="25%" class="label">Select Size:</td>
      <td width="75%">
        <select name="size" class="select" title="Size">
        <option value="">Select</option>
        <option value="L">Large</option>
        <option value="M">Medium</option>
        <option value="S">Small</option> 
        </select>	
      
      </td>
    </tr>
       <tr  class="grey_">
      <td width="25%" class="label">Select Color:</td>
      <td width="75%">
      
        <div id="color_picker"><div class="jColorSelect" style="width:300px;">
        <div  style="background-color:#FFFFFF;"   class="check checkblk"></div>
        <div  style="background-color:#EEEEEE;"></div>
        <div  style="background-color:#FFFF88;"></div>
        <div  style="background-color:#FF7400;"></div>
        <div  style="background-color:#CDEB8B;"></div>
        <div  style="background-color:#6BBA70;"></div>
        <div  style="background-color:#006E2E;"></div>
        <div  style="background-color:#C3D9FF;"></div>
        <div  style="background-color:#4096EE;"></div>
        <div  style="background-color:#356AA0;"></div>
        <div  style="background-color:#FF0096;"></div>
        <div  style="background-color:#B02B2C;"></div>
        <div  style="background-color:#000000;"></div></div></div>
        <input type="hidden" name="color" value="" id="output" />
       <script type="text/javascript"><!--
            $(document).ready(function(){
            
                $('#color_picker').colorPicker(
                {			
                  defaultColor:0, // index of the default color
                  columns:13,     // number of columns 
                  click:function(c){
                    $('#output').val(c);
                  }
                });
                
            }); 

	    //--></script>
      
      </td>
    </tr>
     <tr>
      <td width="25%"  class="label">Price:</td>
      <td width="75%"><input type="text" name="price"  lang="R" title="Price" class="txt medium" value="<?=$price?>" /></td>
    </tr>
    <?php if($image1  and is_file($_SERVER['DOCUMENT_ROOT'].SITE_SUB_PATH."uploaded_files/orginal/".$image1)==true){?>
          <tr>
            <td valign="top" class="label">&nbsp;</td>
            <td valign="top"><img src="<?=SITE_PATH?>uploaded_files/orginal/<?=$image1?>" width="100"> &nbsp;&nbsp;
            </td>
          </tr>
          <?php } ?>
          <tr>
            <td valign="top" class="label">Image1:</td>
            <td valign="top"> <input type="text" name="image1" value="<?=$image1?>" class="txt medium" id="upimg" />
       <img onClick="window.open('<?=SITE_PATH_ADM."crop/imageupload.php?imgid=upimg&image=product&view=thumb&name=".$image?>','mywindow','width=900,height=400,left=200,scrollbars=yes, top=100,screenX=0,screenY=100')" src="<?=SITE_PATH_ADM?>images/clickhere.png" alt=""  class="img-click" /> <br /></td>
          </tr>
          
        <?php if($image2 and $id and is_file($_SERVER['DOCUMENT_ROOT'].SITE_SUB_PATH."uploaded_files/orginal/".$image2)==true){?>
          <tr>
            <td valign="top" class="label">&nbsp;</td>
            <td valign="top"><img src="<?=SITE_PATH?>uploaded_files/orginal/<?=$image2?>" width="100"> &nbsp;&nbsp;
            </td>
          </tr>
          <?php } ?>
          <tr>
            <td valign="top" class="label">Image2:</td>
            <td valign="top"> <input type="text" name="image2" value="<?=$image2?>" class="txt medium" id="upimg2" />
       <img onClick="window.open('<?=SITE_PATH_ADM."crop/imageupload.php?imgid=upimg2&image=product&view=big&name=".$pimage?>','mywindow','width=900,height=400,left=200,scrollbars=yes, top=100,screenX=0,screenY=100')" src="<?=SITE_PATH_ADM?>images/clickhere.png" alt="" class="img-click" /> <br /></td>
          </tr>
          
          
       <?php if($image3  and is_file($_SERVER['DOCUMENT_ROOT'].SITE_SUB_PATH."uploaded_files/orginal/".$image3)==true){?>
          <tr>
            <td valign="top" class="label">&nbsp;</td>
            <td valign="top"><img src="<?=SITE_PATH?>uploaded_files/orginal/<?=$image3?>" width="100"> &nbsp;&nbsp;
            </td>
          </tr>
          <?php } ?>
          <tr>
            <td valign="top" class="label">Image3:</td>
            <td valign="top"> <input type="text" name="image3" value="<?=$image3?>" class="txt medium" id="upimg3" />
       <img onClick="window.open('<?=SITE_PATH_ADM."crop/imageupload.php?imgid=upimg3&image=product&view=big&name=".$pimage?>','mywindow','width=900,height=400,left=200,scrollbars=yes, top=100,screenX=0,screenY=100')" src="<?=SITE_PATH_ADM?>images/clickhere.png" alt="" class="img-click" /> <br /></td>
          </tr>
           
       <?php if($image4  and is_file($_SERVER['DOCUMENT_ROOT'].SITE_SUB_PATH."uploaded_files/orginal/".$image4)==true){?>
          <tr>
            <td valign="top" class="label">&nbsp;</td>
            <td valign="top"><img src="<?=SITE_PATH?>uploaded_files/orginal/<?=$image4?>" width="100"> &nbsp;&nbsp;
            </td>
          </tr>
          <?php } ?>
          <tr>
            <td valign="top" class="label">Image3:</td>
            <td valign="top"> <input type="text" name="image4" value="<?=$image3?>" class="txt medium" id="upimg4" />
       <img onClick="window.open('<?=SITE_PATH_ADM."crop/imageupload.php?imgid=upimg4&image=product&view=big&name=".$pimage?>','mywindow','width=900,height=400,left=200,scrollbars=yes, top=100,screenX=0,screenY=100')" src="<?=SITE_PATH_ADM?>images/clickhere.png" alt="" class="img-click" /> <br /></td>
          </tr>       
        
	<tr>
	  <td class="label">Status:<span>*</span></td>
	  <td><select name="status" class="select" lang="R" title="Status">
	  <option value="Active" <?=(($status=='Active')?'selected="selected"':'')?>>Active</option>
	  <option value="Inactive" <?=(($status=='Inactive')?'selected="selected"':'')?>>Inactive</option>
	  </select>	  </td>
    </tr>
	 
    
	<?php /*?><tr>
	  <td>&nbsp;</td>
	  <td>
	  <input type="submit" name="Submit" class="uibutton  loading" value="&nbsp;&nbsp;&nbsp;Submit&nbsp;&nbsp;&nbsp;" /></td>
    </tr><?php */?>	
  </table>
 <script type="text/javascript">
		 		$("#catId").change(function(){
 					var catid = $(this).val();
						$.ajax({ 
						url: '<?=SITE_PATH_ADM.CPAGE?>/ajax.php?cat_id='+catid, 
						success: function (data) {
							$("#ajaxDiv").html(data); 
						},
						error: function (request, status, error) {
						alert(request.responseText);
						}
						});  
					}); 
 </script>
 