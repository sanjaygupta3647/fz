 <!-- caleder start  -->
<link rel="stylesheet" type="text/css" media="all" href="./calender/calendar-blue2.css" title="summer" />
<script type="text/javascript" src="./calender/calendar.js"></script>
<script type="text/javascript" src="./calender/calendar-en.js"></script>
<script type="text/javascript" src="./calender/calendar-setup.js"></script>
<!-- caleder end  -->
<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php 
  
 if($cms->is_post_back() and !$_POST[search]){  
	
	for($i=0;$i<(int)$_POST['qty'];$i++){
		$arr = array();
		$code = $cms->generateCode(16);
		$voucherCode = $cms->encryptcode($code);
		$arr[voucherCode] = $voucherCode;
		$arr[generatedByadmin] = $_SESSION[uid];
		$arr[validtill] = $_POST[validtill];
		$arr[amount] = $amount;
		$cms->sqlquery("rs","gift_voucher",$arr);
		 
	}	
	$adm->sessset($qty.' Voucher(s) Created', 's');
	$cms->redir(SITE_PATH_MEM.CPAGE, true);
}	
  
?>
 
  <table width="100%" border="0" align="left" cellpadding="4" cellspacing="1" class="frm-tbl2">   
  <tr  class="grey_">
		   <td width="12%" class="label">Valid Till:  &nbsp;&nbsp;
		   <td width="39%">
            <input name="validtill" type="text"  id="validtill" size="8" lang="R" readonly="readonly"  style="width:100px;color:black;" class="border04 txt medium" value="<?=$validtill?>" />
            <img src="../calender/calendar.gif" name="dateon_button" width="16" height="16" id="dateon_button" title="Date selector" onmouseover="this.style.background='red';" 	onmouseout="this.style.background=''" />
            <script type="text/javascript">
					Calendar.setup(
					{ inputField:"validtill",ifFormat:"%y-%m-%d",button:"dateon_button",step:1});
					</script>
              </td>  
	</tr>
    <tr>
      <td width="25%"  class="label">Enter Amount :</td>
      <td width="75%"><input type="text" name="amount"  value="<?=$amount?>" lang="R" title="Amount" class="txt medium" value="" style="width:100px;color:black;" placeholder="Enter Amount" />
					  </td>
    </tr>

	 <tr>
      <td width="25%"  class="label">Quantity :</td>
      <td width="75%"><input type="text" name="qty" value="<?=$amount?>" lang="R" title="Quantity" class="txt medium" value="" style="width:100px;" placeholder="Enter Quantity" /></td>
    </tr>
	 
	<tr>
	  <td class="label">Status:<span>*</span></td>
	  <td><select name="status" class="txt medium" lang="R" title="Status">
	  <option value="Active" <?=(($status=='Active')?'selected="selected"':'')?>>Active</option>
	  <option value="Inactive" <?=(($status=='Inactive')?'selected="selected"':'')?>>Inactive</option>
	  <option value="Block" <?=(($status=='Block')?'selected="selected"':'')?>>Block</option>
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

$("#change").click(function(){
	var catid = $(this).attr('title');
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
 </script>
 <script type="text/javascript"> 
 function addField(){
  var newContent = '<br /><strong style="margin-left:40px;">Title :</strong><input type="text" name="ftitle[]"  title="ftitle" class="txt medium"value="" /><br /><strong>Description :</strong><input type="text" name="fdescription[]" style="margin-top:10px;" title="description" class="txt medium" value="" /><br />';
  $(".addmore").append(newContent); 
 }
</script>