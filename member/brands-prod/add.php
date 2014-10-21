<?php defined('_JEXEC') or die('Restricted access'); 
 if($cms->is_post_back()){ 	 
		 foreach($_POST[dprice] as $key=> $val){  
			 
			 $cms->db_query("update #_barnds_product set offer_type= '".$_POST[offer_type]."', shipping = '".$_POST[shipping]."', offerprice = '".$_POST[dofferprice][$key]."', status = '$status',  porder = '$porder', show_home = '$show_home' where `prod_id`='".$updateid."'  and store_user_id = '".$_SESSION[uid]."' and dimension LIKE '%".$_POST[dsize][$key]."%'");	
		 } 
		 $adm->sessset('Record has been updated', 's'); 
			if(isset($_GET['start']) && $_GET['start'] > 0) {
				$path = SITE_PATH_MEM.CPAGE."/index.php?start=".$_GET['start'];
			} else {
			  if($_GET['soterId']=='' && $_GET['type']!='added' ){
				$path = SITE_PATH_MEM.CPAGE;
              }else{
              $path = SITE_PATH_MEM."product-brand/index.php?soterId=".$_GET['soterId']."&type=added&start=".$_GET['start'];
			  }

			}
			$cms->redir($path, true);
	
	  }
  	
if(isset($id)){
	$rsAdmin=$cms->db_query("select * from #_products_user where pid='".$id."'");
	$arrAdmin=$cms->db_fetch_array($rsAdmin);
	@extract($arrAdmin);
}
?>
 
  <table width="100%" border="0" align="left" cellpadding="4" cellspacing="1" class="frm-tbl2">
     
    <?php
	   $planid = $cms->getSingleresult("select plan_id  from #_store_detail where `pid` = '".$_SESSION[store_id]."'");
	   $parent  = $cms->getSingleresult("SELECT parentId  FROM #_category WHERE pid = '".$cat_id."' ");
	?>
    <tr  class="grey_">
      <td width="25%" class="label">Select Parent Category:</td>
      <td width="75%">	<?=$cms->getSingleresult("SELECT name  FROM #_category WHERE pid = '".$parent."' ")?> 
       
      
      </td>
    </tr> 
     <tr id="subcat">
      <td width="25%"  class="label">Product Sub Category:</td>
      <td width="75%"><div id="ajaxDiv"><?=$cms->getSingleresult("SELECT name  FROM #_category WHERE pid = '".$cat_id."' ")?></div></td>
    </tr> 
    
    
    <tr>
      <td width="25%"  class="label">Name:</td>
      <td width="75%"><?=$title?></td>
    </tr>
	<tr>
      <td width="25%"  class="label">Key Feature 1:</td>
      <td width="75%"><input type="text" name="kf1"  class="txt medium"value="<?=$kf1?>" /></td>
    </tr>
	<tr>
      <td width="25%"  class="label">Key Feature 2:</td>
      <td width="75%"><input type="text" name="kf2"  class="txt medium"value="<?=$kf2?>" /></td>
    </tr>
	<tr>
      <td width="25%"  class="label">Key Feature 3:</td>
      <td width="75%"><input type="text" name="kf3"  class="txt medium"value="<?=$kf3?>" /></td>
    </tr>
	 <?php
	 $porder = $cms->getSingleresult("select porder from #_barnds_product where prod_id = '$id' and store_user_id = '".$_SESSION[uid]."'");
	 $show_home = $cms->getSingleresult("select show_home from #_barnds_product where prod_id = '$id' and store_user_id = '".$_SESSION[uid]."'");
	 ?>
	<tr>
	  <td class="label">Featured Product:<span>*</span></td>
	  <td>
		  <select name="show_home" class="txt medium" lang="R" title="Status">
			  <option value="1" <?=(($show_home=='1')?'selected="selected"':'')?>>Yes</option>
			  <option value="0" <?=(($show_home=='0')?'selected="selected"':'')?>>No</option>
		  </select>	  
	  </td>
    </tr>
	<!--
	<tr>
      <td width="25%"  class="label">Order</td>
      <td width="75%"><input type="text" name="porder" title="Order" class="txt medium" value="<?=$porder?>" /></td>
    </tr>--> 
	<tr>
	  <td valign="top" class="label">&nbsp;</td>
	  <td valign="top">&nbsp;</td>
    </tr>
	<tr>
	  <td valign="top" class="label">Feature Detail:</td>
	  <td valign="top">
	  <? if(!$id){?>
        <strong style="margin-left:40px;">Title :</strong><input type="text" name="ftitle[]"  title="ftitle" class="txt medium"value="" /><br /><strong >Description :</strong><input type="text" name="fdescription[]" style="margin-top:10px;" title="description" class="txt medium" value="" /> <? }else{ 
		$features=$cms->db_query("select * from #_product_feature where prod_id='".$id."'");
		while($res=$cms->db_fetch_array($features)){ @extract($res);?> <br /><strong style="margin-left:40px;">Title :</strong><input type="text" name="ftitle[]" disabled="disabled" title="ftitle" class="txt medium"value="<?=$ftitle?>" /><br /><strong >Description :</strong><input type="text" name="fdescription[]" disabled="disabled" style="margin-top:10px;" title="description" class="txt medium" value="<?=$fdescription?>" /><br /> <? }}?>
		<div class="addmore"></div>
		<p style="float:right; margin-right:410px; cursor:pointer" title="Add More" onclick="addField();"><strong>Add More</strong></p>
      </td>
	</tr> 
	
	<tr>
	  <td valign="top" class="label">Short description:</td>
	  <td valign="top">
	  <?=$adm->get_editor('body1', stripslashes($body1))?>
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

	<tr>
	  <td class="label">Hot Deal:</td>
	  <td> <?php
	   $offer_type = $cms->getSingleresult("select offer_type from #_barnds_product where prod_id = '$id' and brand_id = '$store_user_id' and store_user_id = '".$_SESSION[uid]."'  ");
	   ?>
		  <select name="offer_type" class="txt medium" lang="R" title="offer_type">
			  <option value="none" <?=(($offer_type=='none')?'selected="selected"':'')?>>No</option>
			  <option value="hotdeal" <?=(($offer_type=='hotdeal')?'selected="selected"':'')?>>Yes</option> 
		  </select>	  
	  </td>
    </tr>
	 <?php
	   $shipping = (int)$cms->getSingleresult("select shipping from #_barnds_product where prod_id = '$id' and brand_id = '$store_user_id' and store_user_id = '".$_SESSION[uid]."'  ");
	   ?>
	 
	<tr>
	  <td class="label">Shipping Charge:<span>*</span></td>
	  <td>
			Rs. <input type="text" name="shipping" value="<?=(int)$shipping?>" class="txt" style="width:30px;"  /> 
			 
	  </td>
    </tr>
	
   <?php if($image1  and is_file($_SERVER['DOCUMENT_ROOT'].SITE_SUB_PATH."uploaded_files/orginal/".$image1)==true){?>
          <tr>
            <td valign="top" class="label">&nbsp;</td>
            <td valign="top"><img src="<?=SITE_PATH?>uploaded_files/orginal/<?=$image1?>" width="100"> &nbsp;&nbsp;
            </td>
          </tr>
          <?php } ?>
 
          
        <?php if($image2 and $id and is_file($_SERVER['DOCUMENT_ROOT'].SITE_SUB_PATH."uploaded_files/orginal/".$image2)==true){?>
          <tr>
            <td valign="top" class="label">&nbsp;</td>
            <td valign="top"><img src="<?=SITE_PATH?>uploaded_files/orginal/<?=$image2?>" width="100"> &nbsp;&nbsp;
            </td>
          </tr>
          <?php } ?>
          
          
       <?php if($image3  and is_file($_SERVER['DOCUMENT_ROOT'].SITE_SUB_PATH."uploaded_files/orginal/".$image3)==true){?>
          <tr>
            <td valign="top" class="label">&nbsp;</td>
            <td valign="top"><img src="<?=SITE_PATH?>uploaded_files/orginal/<?=$image3?>" width="100"> &nbsp;&nbsp;
            </td>
          </tr>
          <?php } ?>
          
       <?php if($image4  and is_file($_SERVER['DOCUMENT_ROOT'].SITE_SUB_PATH."uploaded_files/orginal/".$image4)==true){?>
          <tr>
            <td valign="top" class="label">&nbsp;</td>
            <td valign="top"><img src="<?=SITE_PATH?>uploaded_files/orginal/<?=$image4?>" width="100"> &nbsp;&nbsp;
            </td>
          </tr>
          <?php } ?>
                
     <?php
	 $status = $cms->getSingleresult("select status from #_barnds_product where prod_id = '$id' and store_user_id = '".$_SESSION[uid]."'");
	 ?>
        
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
  