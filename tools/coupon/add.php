<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php 
  $rsAdmin1=$cms->getSingleresult("select otp from #_admin_lostlogin where phone='$phone' order by aid DESC LIMIT 1");
 if($cms->is_post_back() and !$_POST[search]){  
	
	for($i=0;$i<(int)$_POST['qty'];$i++){
		$arr = array();
		$code = $cms->generateCode(16);
		$voucherCode = $cms->encryptcode($code);
		$arr[voucherCode] = $voucherCode;
		$arr[generatedByadmin] = 0;
		$arr[amount] = $amount;
		$cms->sqlquery("rs","gift_voucher",$arr);
		 
	}	 
	$adm->sessset($qty.' Voucher(s) Created', 's');
	$cms->redir(SITE_PATH_ADM.CPAGE, true);
}	
 
?> 
  <table width="100%" border="0" align="left" cellpadding="4" cellspacing="1" class="frm-tbl2">     
    <tr>
      <td width="25%"  class="label">Enter Amount & Quantity :</td>
      <td width="75%"><input type="text" name="amount"  lang="R" title="Amount" class="txt medium" value="" style="width:100px;" placeholder="Enter Amount" />
					  <input type="text" name="qty"  lang="R" title="Quantity" class="txt medium" value="" style="width:100px; margin-left:20px;" placeholder="Enter Quantity" /></td>
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
 </script>
 <script type="text/javascript"> 
 function addField(){
  var newContent = '<br /><strong style="margin-left:40px;">Title :</strong><input type="text" name="ftitle[]"  title="ftitle" class="txt medium"value="" /><br /><strong>Description :</strong><input type="text" name="fdescription[]" style="margin-top:10px;" title="description" class="txt medium" value="" /><br />';
  $(".addmore").append(newContent); 
 }
</script>