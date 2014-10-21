<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php 
if($cms->is_post_back()){  
	$_POST[url] = $adm->baseurl($pagename);
	$_POST[store_user_id] = $_SESSION[uid];

	if(count($_POST[color]))$_POST[color] = @implode(',',$_POST[color]); 
	if(count($_POST[size])) $_POST[size] = @implode(',',$_POST[size]); 

	if($_POST[offerprice]>$_POST[price]){
	  
	$adm->sessset('Offer price Can not Greater Than The Price.', 's');
	$cms->redir($path, true);
	}
	if($updateid){
		$cms->sqlquery("rs","products",$_POST,'pid',$updateid); 
		$adm->sessset('Record has been updated', 's');
	}else{
		$_POST[submitdate] = time();
		$cms->sqlquery("rs","products",$_POST);
		$updateid = mysql_insert_id();
		$adm->sessset('Record has been added', 's');
	}
	if($updateid){
		 $cms->db_query("delete from #_admin_product_feature where `prod_id`='".$updateid."'");
		 if(count($_POST[ftitle])){
			foreach($_POST[ftitle] as $key=>$val){
			 $arr = array();
			 $arr[prod_id] =$updateid;
			 $arr[ftitle] = $val;
			 $arr[fdescription] =$_POST[fdescription][$key]; 
			 $cms->sqlquery("rs","admin_product_feature",$arr);
			 }
		 }
	 
	}
	
	if(count($_POST[dprice])){ 
		foreach($_POST[dprice] as $key=> $val){
			 if(trim($val)!=""){
				if($_POST[price_pid][$key]){
					if(!$_POST[dprice][$key]){ $_POST[price][$key] = "0.0";} 
					if(!$_POST[dofferprice][$key]){ $_POST[dofferprice][$key] = "0.0";} 
					$qry = "update  #_prod_price_admin set 
					proid= '$updateid',dsize =  '".$_POST[dsize][$key]."', 
					dprice = '$val',dofferprice = '".$_POST[dofferprice][$key]."' , store_id='".$_SESSION[uid]."' where pid = '".$_POST[price_pid][$key]."'"; 
					$cms->db_query($qry);

				}else{ 
					if(!$_POST[dprice][$key]){ $_POST[price][$key] = "0.0";} 
					if(!$_POST[dofferprice][$key]){ $_POST[dofferprice][$key] = "0.0";} 
					$qry = "insert into #_prod_price_admin set 
					proid= '$updateid',dsize =  '".$_POST[dsize][$key]."', 
					dprice = '$val',dofferprice = '".$_POST[dofferprice][$key]."' , store_id='".$_SESSION[uid]."'"; 
					$cms->db_query($qry);
				}
				 
			 }
		 }
		 $_POST = false; 
	}
	if(isset($_GET['start']) && $_GET['start'] > 0) {
		$path = SITE_PATH_ADM.CPAGE."/index.php?start=".$_GET['start'];
	} else {
		$path = SITE_PATH_ADM.CPAGE;
	}
	$cms->redir($path, true);
}	
if(isset($id)){
	$rsAdmin=$cms->db_query("select * from #_products where pid='".$id."'");
	$arrAdmin=$cms->db_fetch_array($rsAdmin); 
	@extract($arrAdmin);
}
?>   <table width="100%" border="0" align="left" cellpadding="4" cellspacing="1" class="frm-tbl2">
  
    <tr  class="grey_">
      <td width="25%" class="label">Select Parent Category:</td>
      <td width="75%">
	  <? $rsAdmin=$cms->db_query("select pid,name from #_category where parentId='0' order by name");
	    $catPar = $cms->getSingleresult("SELECT parentId  FROM #_category WHERE pid = '".$cat_id."' ");
		if($catPar){
			$pname = stripslashes($cms->getSingleresult("SELECT name  FROM #_category WHERE pid = '".$catPar."' "))." => ";
		}
	    $catPar = ($catPar)?$catPar:$cat_id;?>
      <select name="pcat_id" class="txt medium" id="pcatId" lang="R" title="Parent Category">
      <option value="0")?>---Select Category--</option> <?php      
	  while($arrAdmin=$cms->db_fetch_array($rsAdmin)){
			@extract($arrAdmin);
			?>
				<optgroup label="<?=stripslashes($name)?>"><?php			   
				$rsAdmin2=$cms->db_query("select pid,name from #_category where parentId='$pid' order by name" );
				if(mysql_num_rows($rsAdmin2)){
					while($arrAdmin3=$cms->db_fetch_array($rsAdmin2)){?> 						 
						  <option value="<?=$arrAdmin3[pid]?>" <?=(($arrAdmin3[pid]==$catPar)?'selected="selected"':'')?>>
						  <?=stripslashes($arrAdmin3[name])?></option>  <?php
						  }
					}
				}?>
				</optgroup><?php
				
	    ?>
	  </select>	      
      </td>
    </tr>
    
    <tr id="subcat">
      <td width="25%"  class="label">Product Sub Category:</td>
      <td width="75%"><div id="ajaxDiv"><?=$pname.$cms->getSingleresult("SELECT name  FROM #_category WHERE pid = '".$cat_id."' ")?></div></td>
    </tr> 
    
   <tr>
      <td width="25%"  class="label">Name:</td>
      <td width="75%"><input type="text" name="title"  lang="R" title="Name" class="txt medium" value="<?=$title?>" /></td>
    </tr>
	<tr  class="grey_">
      <td width="25%" valign="top" class="label">Meta title:</td>
      <td width="75%"><textarea name="meta_title" cols="80" rows="5" id="meta_title"><?=$meta_title?></textarea></td>
    </tr>
    
   <tr>
      <td width="25%" valign="top"  class="label">Meta keywords :</td>
      <td width="75%"><textarea name="meta_keyword" cols="80" rows="5" id="meta_keyword"><?=$meta_keyword?></textarea></td>
    </tr>
	<tr  class="grey_">
	  <td valign="top" class="label">Meta description :</td>
	
	  <td><textarea name="meta_description" cols="80" rows="5" id="meta_description"><?=$meta_description?></textarea></td>
    </tr>
	<tr>
      <td width="25%"  class="label">Product Code:</td>
      <td width="75%"><input type="text" name="pcode"   title="Product Code" class="txt medium" value="<?=$pcode?>" /></td>
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
	 
	<tr>
	  <td valign="top" class="label">&nbsp;</td>
	  <td valign="top">&nbsp;</td>
    </tr>
	<tr class="specificationtr" <?php if(!$id){?> style="display:none;"<?php }?>>
	  <td valign="top" class="label">Feature Detail:</td>
	  <td valign="top">	 
		<?php if($id){ ?><span style="cursor:pointer; color:blue;" id='change' title="<?=$catPar?>">Change Specification</span><?php }?>
		<div id="ajaxDiv2">
		<?php 
		$qry = $cms->db_query("select * from #_admin_product_feature where prod_id = '$id'");
		if(mysql_num_rows($qry)){
			while($resQ = $cms->db_fetch_array($qry)){extract($resQ)?>
			<?=$ftitle?> <input type="hidden" name="ftitle[]" value="<?=$ftitle?>"> 
			<input type="text" name="fdescription[]" style="margin:10px;" title="description" class="txt medium" value="<?=$fdescription?>" /><br /><?php			
			}
		}
		?>
		</div>		 
      </td>
	</tr> 
	
	<tr>
	  <td valign="top" class="label">Short description:</td>
	  <td valign="top">
		 <?=$adm->get_editor('body1', stripslashes($body1))?> 
      </td>
	</tr> 

		<tr  class="grey_">
      <td width="25%" class="label">Select Color:<?=$_SESSION[uid]?></td>
      <td width="75%"> 
			<?php
			$clr = array();
		    $clr = @explode(',',$color);
			$dimQ=$cms->db_query("select name from #_color where status='Active' and store_user_id =0 order by name");
			 while($res=$cms->db_fetch_array($dimQ)){?>
			     <input name="color[]"  type="checkbox" value="<?=$res[name]?>" <?=(in_array($res[name],$clr))?'checked="checked"':''?>> <?=$res[name]?> &nbsp; &nbsp;
				 
			 <?php
			 }?> 
          
      </td>
    </tr>



	<?php 
	 ///$siz = array();
    /// $siz = @explode(',', $size);
	?>
	
	  
	  
  
	 <tr  class="grey_ mulprice">
      <td width="25%" class="label">Price:</td>
      <td width="75%"><?php  
	    $features=$cms->db_query("select * from #_prod_price_admin where proid='".$id."' and store_id='".$_SESSION[uid]."'");
		$cont = mysql_num_rows($features);
		while($res=$cms->db_fetch_array($features)){ @extract($res);?> 
              <div class="multidiv"> 
			  <input type="hidden" name="price_pid[]" value="<?=$pid?>">
              
              <strong >Dimension:</strong>
              <select name="dsize[]"  title="Dimension"  class="txt medium"  > 
			  <option value="">---Select---</option>
				<?php 
				$dimQ=$cms->db_query("select d_name from #_dimension where status='Active' and store_user_id ='".$_SESSION[uid]."' order by d_name");
				 while($res1=$cms->db_fetch_array($dimQ)){ 
				 ?> 
					 <option value="<?=$res1[d_name]?>"  <?=(($res1[d_name]==$dsize)?'selected="selected"':'')?>><?=$res1[d_name]?></option>
				 <?php
				 }?> </select> 
			  <strong >Price:</strong>
              <input type="text" name="dprice[]" style="margin-top:10px;" title="dprice" class="txt" value="<?=$dprice?>" />
               &nbsp;<strong>Offer Price :</strong><input type="text" name="dofferprice[]"  value="<?=$dofferprice?>"   title="offerprice" class="txt"  /></div>
              <? }?>
              <div class="addmore1"></div>
              <p style="margin-left:885px; cursor:pointer" title="Add More1" onclick="addField2();"><strong>Add More</strong></p>
      </td>
    </tr>

    
     
	 <tr>
      <td width="25%"  class="label">Delevery Time:</td>
	  <?php
	  if($dtime) $d = explode(' to ',$dtime);
	  ?>
      <td width="75%">From:  <select name="dfrom" class="txt medium" lang="R" title="Status">
	  <? for($i=0;$i<10;$i++){ ?>
	  <option value="<?=$i?>" <?=($d[0]==$i)?'selected="selected"':''?>><?=$i?></option>
	  <? }?> </select>	 To: <select name="dto" class="txt medium" lang="R" title="Status">
	  <? for($j=1;$j<=30;$j++){ ?>
	  <option value="<?=$j?>" <?=($d[1]==$j)?'selected="selected"':''?>><?=$j?></option>
	  <? }?> </select>	Day. </td>
    </tr>
	<tr>
	  <td class="label">Discount:<span>*</span></td>
	  <td>
	  	<input type="radio" value="0" name="discount"  <?=($discount==0)?'checked="checked"':''?> />No Other Discount
		  <input type="radio" name="discount" value="cost" <?=($discount=='cost')?'checked="checked"':''?>/>Price Wise
		  <input type="radio" name="discount" value="quantity" <?=($discount=='quantity')?'checked="checked"':''?>  />Quantity Wise
	  </td>
    </tr>
	<tr>
	  <td class="label">Shipping:<span>*</span></td>
	  <td>
			<input type="radio" name="shipping" value="0" <?=($shipping==0)?'checked="checked"':''?> checked="checked" />Free Shipping
			<input type="radio" name="shipping" <?=($shipping=='quantity')?'checked="checked""':''?> value="quantity" />Quantity Wise Shipping
			<input type="radio" name="shipping" <?=($shipping=='cost')?'checked="checked""':''?> value="cost"  />Price Wise Shipping
			<input type="radio" name="shipping" <?=($shipping=='weight')?'checked="checked""':''?> value="weight"  />Weight Wise Shipping
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
       <img onClick="window.open('<?=SITE_PATH_MEM."crop/imageupload.php?imgid=upimg&image=product&view=thumb&name=".$image?>','mywindow','width=900,height=400,left=200,scrollbars=yes, top=100,screenX=0,screenY=100')" src="<?=SITE_PATH_MEM?>images/clickhere.png" alt=""  class="img-click" /> <br /></td>
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
       <img onClick="window.open('<?=SITE_PATH_MEM."crop/imageupload.php?imgid=upimg2&image=product&view=big&name=".$pimage?>','mywindow','width=900,height=400,left=200,scrollbars=yes, top=100,screenX=0,screenY=100')" src="<?=SITE_PATH_MEM?>images/clickhere.png" alt="" class="img-click" /> <br /></td>
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
       <img onClick="window.open('<?=SITE_PATH_MEM."crop/imageupload.php?imgid=upimg3&image=product&view=big&name=".$pimage?>','mywindow','width=900,height=400,left=200,scrollbars=yes, top=100,screenX=0,screenY=100')" src="<?=SITE_PATH_MEM?>images/clickhere.png" alt="" class="img-click" /> <br /></td>
          </tr>
           
       <?php if($image4  and is_file($_SERVER['DOCUMENT_ROOT'].SITE_SUB_PATH."uploaded_files/orginal/".$image4)==true){?>
          <tr>
            <td valign="top" class="label">&nbsp;</td>
            <td valign="top"><img src="<?=SITE_PATH?>uploaded_files/orginal/<?=$image4?>" width="100"> &nbsp;&nbsp;
            </td>
          </tr>
          <?php } ?>
          <tr>
            <td valign="top" class="label">Image4:</td>
            <td valign="top"> <input type="text" name="image4" value="<?=$image4?>" class="txt medium" id="upimg4" />
       <img onClick="window.open('<?=SITE_PATH_MEM."crop/imageupload.php?imgid=upimg4&image=product&view=big&name=".$pimage?>','mywindow','width=900,height=400,left=200,scrollbars=yes, top=100,screenX=0,screenY=100')" src="<?=SITE_PATH_MEM?>images/clickhere.png" alt="" class="img-click" /> <br /></td>
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
 <script type="text/javascript">
	$("#price").blur(function(){	
	var price =  $(this).val();  
	var offerprice =  $("#offerprice").val();
	if(offerprice>price){
		alert("Offerprice can not be greater then actual price");	
		$("#offerprice").val(price);
	}
	if(!offerprice){
		$("#offerprice").val(price);
	}
	
	});
	$("#pcatId").change(function(){
		var catid = $(this).val();
			$.ajax({ 
			url: '<?=SITE_PATH_ADM.CPAGE?>/ajax.php?cat_id='+catid, 
			success: function (data) {
				$("#subcat").show();
				$("#ajaxDiv").html(data); 
			},
			error: function (request, status, error) {
			alert(request.responseText);
			}
			}); 
			
			$.ajax({ 
			url: '<?=SITE_PATH_ADM.CPAGE?>/specification.php?cat_id='+catid, 
			success: function (data) {
				$(".specificationtr").show();
				$("#ajaxDiv2").html(data); 
			},
			error: function (request, status, error) {
			alert(request.responseText);
			}
			}); 
		}); 

		$("#change").click(function(){
			var catid = $(this).attr('title');
			$.ajax({ 
			url: '<?=SITE_PATH_ADM.CPAGE?>/specification.php?cat_id='+catid, 
			success: function (data) {
				$(".specificationtr").show();
				$("#ajaxDiv2").html(data); 
			},
			error: function (request, status, error) {
			alert(request.responseText);
			}
			}); 
		}); 
 </script>
<script type="text/javascript"> 
 /* function addField(){
  var newContent = '<br /><strong style="margin-left:40px;">Title :</strong><input type="text" name="ftitle[]"  title="ftitle" class="txt medium"value="" /><br /><strong>Description :</strong><input type="text" name="fdescription[]" style="margin-top:10px;" title="description" class="txt medium" value="" /><br />';
  $(".addmore").append(newContent); 
 }*/
</script> 
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
  var newContent2 = '<div class="multidiv">'+drpnewContent+'&nbsp;<strong>Price :</strong>&nbsp;<input type="text" name="dprice[]"  title="dprice" class="txt" value="" />&nbsp;<strong>Offer Price :</strong><input type="text" name="dofferprice[]"   title="offerprice" class="txt" value="" /></div>';
  $(".addmore1").append(newContent2); 
 }
</script>