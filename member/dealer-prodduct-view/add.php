<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php  
if(isset($id)){
	$rsAdmin=$cms->db_query("select * from #_products_user where pid='".$id."'");
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
      <td width="25%" class="label">Select Color:</td>
      <td width="75%">
       
			<?php
			$clr = array();
		    $clr = @explode(',', $color);
			$dimQ=$cms->db_query("select name from #_color where status='Active' and store_user_id = '$store_user_id' order by name");
			 while($res=$cms->db_fetch_array($dimQ)){?>
				 <input name="color[]"  type="checkbox" value="<?=$res[name]?>" <?=(in_array($res[name],$clr))?'checked="checked"':''?>> <?=$res[name]?> &nbsp; &nbsp;
			 <?php
			 }?> 
         
      </td>
    </tr>
   <tr  class="grey_ mulprice">
      <td width="25%" class="label">Price:</td>
      <td width="75%"><?php 
	    $features=$cms->db_query("select * from #_product_price where proid='".$id."' ");
		$cont = mysql_num_rows($features);
		while($res=$cms->db_fetch_array($features)){ @extract($res);?> 
              <div class="multidiv"> 
              <strong >Dimension:</strong>
              <select name="dsize[]"   title="Dimension"  class="txt medium"  > 
					 <option value="<?=$dsize?>" ><?=$dsize?></option>
				 </select> 
			  <strong >Price:</strong>
              <input type="text" name="dprice[]" style="margin-top:10px;" alt="You can not change this price"  title="You can not change this price" class="txt" value="<?=$dprice?>" />
			  <?php
		  
			  $dofferprice = $cms->getSingleresult("select offerprice from #_barnds_product where prod_id = '$id' and brand_id = '$store_user_id' and store_user_id = '".$_SESSION[uid]."' and dimension='$dsize'");
			  ?>
               &nbsp;<strong>Offer Price :</strong><input type="text" name="dofferprice[]"  value="<?=$dofferprice?>"   title="Set your own Offerprice" class="txt"  /> </div>
              <? }?>
              <div class="addmore1"></div>
               
      </td>
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
 var drpnewContent = '<strong>Dimension :</strong><select name="dsize[]"  title="Dimension"   class="txt medium">';
 drpnewContent += '<option value="">---Select---</option>';
 <?php 
 $siz = array();
 $siz = @explode(',', $size);
$dimQ=$cms->db_query("select d_name from #_dimension where status='Active' and store_user_id = '".$_SESSION[uid]."' order by d_name"); 
while($res=$cms->db_fetch_array($dimQ)){?> 
	drpnewContent += '<option value="<?=$res[d_name]?>"><?=$res[d_name]?></option>';<?php 
 
 }?> 
 drpnewContent += '</select>'; 
 function addField2(){
  var newContent2 = '<div class="multidiv"> <strong>Price :</strong>&nbsp;<input type="text" name="dprice[]"  title="dprice" class="txt" value="" />&nbsp;<strong>Offer Price :</strong><input type="text" name="dofferprice[]"   title="offerprice" class="txt" value="" /> </div>';
  $(".addmore1").append(newContent2); 
 }
</script>
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
 