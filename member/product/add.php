<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php 
 
   $numOfProducts = $cms->getSingleresult("select t1.noOfProducts from #_plans as t1, #_store_detail as t2 where t2.pid ='".$_SESSION[store_id]."' and t1.pid= t2.plan_id");
  $total = $cms->getSingleresult("select count(*) from #_products_user where store_user_id ='".$_SESSION[uid]."' ");
  if(!$id){
	 if($total>=$numOfProducts){
		$adm->sessset('You have reached to your maximum number of products', 'e');
		$cms->redir(SITE_PATH_MEM.CPAGE, true);
	 }
 }
 if($cms->is_post_back() and !$_POST[search]){  
	$checksize = $cms->array_is_unique($_POST[dsize]);
	if(!$checksize){
		$path = SITE_PATH_MEM.CPAGE."?mode=add&start=".$start."&id=".$id;
		$adm->sessset('Please make unique entry for each dimension', 'e');
		$cms->redir($path, true);
	}

	if(count($_POST[combo])){
		foreach($_POST[combo] as $val){
			$com .= $val.",";
		}
		$_POST[combo] = substr($com,0,-1);
	} 
	$_POST[url] = $adm->baseurl($pagename);
	$_POST[store_user_id] = $_SESSION[uid]; 
	$_POST[dtime]=$_POST[dfrom]." to ".$_POST[dto]; 
	if(count($_POST[color]))$_POST[color] = @implode(',',$_POST[color]); 
	if(count($_POST[size])) $_POST[size] = @implode(',',$_POST[size]); 
	if($_POST[offerprice]>$_POST[price]){ 
		$adm->sessset('Offer price Can not Greater Than The Price.', 's');
		$cms->redir($path, true);
	}
	if($updateid){ 
		$cms->sqlquery("rs","products_user",$_POST,'pid',$updateid); 
		$adm->sessset('Record has been updated', 's');
		//$cms->product_addedit_mail($updateid,'add',$_SESSION[uid]);
		$i=0; 
	}else{
		$_POST[submitdate] = time();
		$cms->sqlquery("rs","products_user",$_POST);
		$updateid = mysql_insert_id();
		$adm->sessset('Record has been added', 's');
		//$cms->product_addedit_mail($updateid,'add',$_SESSION[uid]);
		$i=0;
		
	}
	if($updateid){ 
		 $cms->db_query("delete from #_product_feature where `prod_id`='".$updateid."'");
		 for($i=1; $i<10;$i++){
			 $arr = array();
			 $arr[prod_id] =$updateid;
			 $arr[ftitle] = $_POST[title];
			 $arr[fdescription] =$_POST[fdescription.$i];  
			 if($arr[fdescription]!="" && $arr[ftitle]!=""){
				 $cms->sqlquery("rs","product_feature",$arr);
			 }
		 }  
	} 
	if(count($_POST[dprice])){ 
		foreach($_POST[dprice] as $key=> $val){
			 if(trim($val)!=""){
				if($_POST[price_pid][$key]){
					if(!$_POST[dprice][$key]){ $_POST[price][$key] = "0.0";} 
					if(!$_POST[dofferprice][$key]){ $_POST[dofferprice][$key] = "0.0";} 
					$qry = "update  #_product_price set 
					proid= '$updateid', dtitle =  '".$_POST[dtitle][$key]."' , dsize =  '".$_POST[dsize][$key]."', 
					dprice = '$val',dofferprice = '".$_POST[dofferprice][$key]."' , store_id='".$_SESSION[uid]."' where pid = '".$_POST[price_pid][$key]."'"; 
					$cms->db_query($qry);

				}else{ 
					if(!$_POST[dprice][$key]){ $_POST[price][$key] = "0.0";} 
					if(!$_POST[dofferprice][$key]){ $_POST[dofferprice][$key] = "0.0";} 
					$qry = "insert into #_product_price set 
					proid= '$updateid', dtitle =  '".$_POST[dtitle][$key]."' , dsize =  '".$_POST[dsize][$key]."', 
					dprice = '$val',dofferprice = '".$_POST[dofferprice][$key]."' , store_id='".$_SESSION[uid]."'"; 
					$cms->db_query($qry);
				}
				 
			 }
		 }
		 $_POST = false; 
	}
	
	if(isset($_GET['start']) && $_GET['start'] > 0) {
		$path = SITE_PATH_MEM.CPAGE."/index.php?start=".$_GET['start'];
	} else {
		$path = SITE_PATH_MEM.CPAGE;
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
      <td width="75%">	 
      <select  name="pcat_id" class="txt medium" id="pcatId" lang="R" title="Category">
		  <option value="0">---Select Category--</option><?php       
		  $rsAdmin=$cms->db_query("select cat_id from  #_plans_category  where  plan_id = '$planid' and parent != 0 ");
		  while($arrAdmin=$cms->db_fetch_array($rsAdmin)){ ?>
		   <option value="<?=$arrAdmin[cat_id]?>" <?=($arrAdmin[cat_id]==$parent)?'selected="selected"':''?>>
		   <?=$cms->getSingleresult("SELECT name  FROM #_category WHERE pid = '".$arrAdmin[cat_id]."' ")?>
		   </option><?php     
		   }?>
	  </select>	
      
      </td>
    </tr> 
     <tr id="subcat">
      <td width="25%"  class="label">Product Sub Category:</td>
      <td width="75%"><div id="ajaxDiv">
	  <?=$cms->getSingleresult("SELECT name  FROM #_category WHERE pid = '".$cat_id."' ")?>
		<span style="cursor:pointer; color:blue;padding-left:20px;" class="pscat">Change Sub Category</span>
	  </div></td>
    </tr>  
    <?php /*?><tr  class="grey_">
      <td width="25%" class="label">Select Brand:</td>
      <td width="75%">
      <select name="brand_id" class="select" lang="R" title="Brand">
 	   <? $rsAdmin=$cms->db_query("select t1.pid,t1.name from #_brand as t1,#_plans_brand as t2 where t2.plan_id = '$planid'  and t2.brand_id=t1.pid ");
	  while($arrAdmin=$cms->db_fetch_array($rsAdmin)){@extract($arrAdmin);
	  ?>
	  <option value="<?=$pid?>" <?=(($pid==$brand_id)?'selected="selected"':'')?>><?=$name?></option>  
      <?php
 	   }?>
	  </select>
      </td>
    </tr><?php */?>
    
    <tr>
      <td width="25%"  class="label">Name:</td>
      <td width="75%"><input type="text" name="title"  lang="R" title="Name" class="txt medium"value="<?=$title?>" />
	  </td>
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

 	<tr class="specificationtr" <?php if(!$id){?> style="display:none;"<?php }?>>
	  <td valign="top" class="label">Feature Detail:</td>
	  <td valign="top">	 
		<?php if($id){ ?><span style="cursor:pointer; color:blue;" id='change' title="<?=$parent?>">Change Specification</span><?php }?>
		<div id="ajaxDiv2">
		<?php 
		$qry = $cms->db_query("select * from #_product_feature where prod_id = '$id' and fdescription!='' and ftitle!='' ");
		 $i = 1;
		if(mysql_num_rows($qry)){
			while($resQ = $cms->db_fetch_array($qry)){extract($resQ)?>
			<?=$ftitle?> <input type="hidden" name="ftitle<?=$i?>" value="<?=$ftitle?>"> 
			<input list="browsers" type="text" name="fdescription<?=$i?>" style="margin:10px;" title="description" class="txt medium" value="<?=$fdescription?>" /><br />
			<?php $i++; ?>
			<datalist id="browsers">
			<option value="Uttar Pradesh">
			<?php
			$qry21 = $cms->db_query("select fdescription from #_product_feature group by fdescription order by fdescription");
			if(mysql_num_rows($qry21)){
			while($res2 = $cms->db_fetch_array($qry21)){?>
				<option value="<?=$res2[fdescription]?>"><?php 
				}
			}?>			 
			</datalist><?php	 
			} 
		}?>		
		</div>		 
      </td>
	</tr> 

	<tr>
	  <td class="label">Featured Product:<span>*</span></td>
	  <td>
		  <select name="show_home" class="txt medium" lang="R" title="Status">
			  <option value="1" <?=(($show_home=='1')?'selected="selected"':'')?>>Yes</option>
			  <option value="0" <?=(($show_home=='0')?'selected="selected"':'')?>>No</option>
		  </select>	  
	  </td>
    </tr>

	<tr>
      <td width="25%"  class="label">Order</td>
      <td width="75%"><input type="text" name="porder" title="Order" class="txt medium" value="<?=$porder?>" /></td>
    </tr>
	<tr>
	  <td valign="top" class="label">&nbsp;</td>
	  <td valign="top">&nbsp;</td>
    </tr>
	
	
	
	<tr>
	  <td valign="top" class="label">Full Specification:</td>
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
			$dimQ=$cms->db_query("select name from #_color where status='Active' and store_user_id = '".$_SESSION[uid]."' order by name");
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
	    $features=$cms->db_query("select * from #_product_price where proid='".$id."' and store_id='".$_SESSION[uid]."'");
		$cont = mysql_num_rows($features);
		while($res=$cms->db_fetch_array($features)){ @extract($res);?> 
              <div class="multidiv"> 
			  <input type="hidden" name="price_pid[]" value="<?=$pid?>">
              
              <strong >Dimension:</strong>
              <select name="dsize[]"  title="Dimension"  class="txt medium"  > 
			  <option value="">---Select---</option>
				<?php 
				$dimQ=$cms->db_query("select d_name from #_dimension where status='Active' and store_user_id = '".$_SESSION[uid]."' order by d_name");
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
	  <td class="label">Hot Deal:</td>
	  <td>
		  <select name="offer_type" class="txt medium" lang="R" title="offer_type">
			  <option value="none" <?=(($offer_type=='none')?'selected="selected"':'')?>>No</option>
			  <option value="hotdeal" <?=(($offer_type=='hotdeal')?'selected="selected"':'')?>>Yes</option> 
		  </select>	  
	  </td>
    </tr>
     
	  
	 
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
            <td valign="top" class="label">Image3:</td>
            <td valign="top"> <input type="text" name="image4" value="<?=$image3?>" class="txt medium" id="upimg4" />
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


$(".pscat").click(function(){
var catid = $("#pcatId").val();
	$.ajax({ 
	url: '<?=SITE_PATH_MEM.CPAGE?>/ajax.php?cat_id='+catid, 
	success: function (data) {
		$("#subcat").show();
		$("#ajaxDiv").html(data); 
	},
	error: function (request, status, error) {
	alert(request.responseText);
	}
	});  
	  
});


$("#pcatId").change(function(){
var catid = $(this).val();
	$.ajax({ 
	url: '<?=SITE_PATH_MEM.CPAGE?>/ajax.php?cat_id='+catid, 
	success: function (data) {
		$("#subcat").show();
		$("#ajaxDiv").html(data); 
	},
	error: function (request, status, error) {
	alert(request.responseText);
	}
	}); 
	
	$.ajax({ 
	url: '<?=SITE_PATH_MEM.CPAGE?>/specification.php?cat_id='+catid, 
	success: function (data) {
		$(".specificationtr").show();
		$("#ajaxDiv2").html(data); 
	},
	error: function (request, status, error) {
	alert(request.responseText);
	}
	}); 
});
$( "body" ).delegate( "#subcate", "change", function() {
var catid = $("#pcatId").val();
var subcat = $(this).val();  
	$.ajax({ 
	url: '<?=SITE_PATH_MEM.CPAGE?>/specification.php?prod_id=<?=$id?>&subcat='+subcat+'&cat_id='+catid, 
	success: function (data) { 
		$("#ajaxDiv2").html(data); 
	},
	error: function (request, status, error) {
	alert(request.responseText);
	}
	}); 
});

$("#change").click(function(){
	var catid = $("#pcatId").val();
	var subcat = $("#subcate").val();
	 if(!subcat)subcat = '<?=$cat_id?>';
	
	 
	$.ajax({ 
	url: '<?=SITE_PATH_MEM.CPAGE?>/specification.php?prod_id=<?=$id?>&subcat='+subcat+'&cat_id='+catid, 
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
 function addField(){
  var newContent = '<br /><strong style="margin-left:40px;">Title :</strong><input type="text" name="ftitle[]"  title="ftitle" class="txt medium"value="" /><br /><strong>Description :</strong><input type="text" name="fdescription[]" style="margin-top:10px;" title="description" class="txt medium" value="" /><br />';
  $(".addmore").append(newContent); 
 }
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

<script type="text/javascript">
	<?php if(!$cont){ ?>  addField2(); <?php }?>
    $(document).ready(function(){ 
	 $( "table" ).delegate( ".delmulty", "click", function() {
		$(this).parent().remove()
	 }); 
  }); 
  </script>
 