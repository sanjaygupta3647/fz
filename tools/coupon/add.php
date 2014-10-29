 <!-- caleder start  -->
<link rel="stylesheet" type="text/css" media="all" href="../calender/calendar-blue2.css" title="summer" />
<script type="text/javascript" src="../calender/calendar.js"></script>
<script type="text/javascript" src="../calender/calendar-en.js"></script>
<script type="text/javascript" src="../calender/calendar-setup.js"></script>
<!-- caleder end  -->
<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php 
 $rsAdmin1=$cms->getSingleresult("select otp from #_admin_lostlogin where phone='$phone' order by aid DESC LIMIT 1");

 if($cms->is_post_back() and !$_POST[search]){ 
	 if($_POST[pinfor]=='freeshop'){
		    $arr = array();
			$code = $cms->generateCode(16);
			$voucherCode = $cms->encryptcode($code);
			$arr[voucherCode] = $voucherCode;
			$arr[generatedByadmin] = 0;
			$arr[amount] = 0;
			$arr[validtill] = $_POST[validtill];
			$arr[pinfor] = 'freeshop';
			$cms->sqlquery("rs","gift_voucher",$arr); 
			$adm->sessset('Free Shopping Voucher(s) Created', 's');
	}else{
		for($i=0;$i<(int)$_POST['qty'];$i++){
			$arr = array();
			$code = $cms->generateCode(16);
			$voucherCode = $cms->encryptcode($code);
			$arr[voucherCode] = $voucherCode;
			$arr[generatedByadmin] = 0;
			$arr[validtill] = $_POST[validtill];
			$arr[amount] = $amount;
			$cms->sqlquery("rs","gift_voucher",$arr); 
		}
		$adm->sessset($qty.' Voucher(s) Created', 's');
	}
		 
	
	$cms->redir(SITE_PATH_ADM.CPAGE, true);
}	
 
?> 
  <table width="100%" border="0" align="left" cellpadding="4" cellspacing="1" class="frm-tbl2">     
   <tr  class="grey_">
		   <td width="12%" class="label">Valid Till:  &nbsp;&nbsp;
		   <td width="39%">
            <input name="validtill" type="text"  id="validtill" size="8"   readonly="readonly"  style="width:100px;color:black;" class="border04 txt medium" value="<?=$validtill?>" />
            <img src="../calender/calendar.gif" name="dateon_button" width="16" height="16" id="dateon_button" title="Date selector" onmouseover="this.style.background='red';" 	onmouseout="this.style.background=''" />
            <script type="text/javascript">
					Calendar.setup(
					{ inputField:"validtill",ifFormat:"%y-%m-%d",button:"dateon_button",step:1});
					</script>
              </td>  
	</tr>
	<tr>
      <td width="25%"  class="label">For:</td>
      <td width="75%">  
	   <p><input type="radio" name="pinfor" class="pinfor" checked value="none"/> Paid shop </p>
	   <p><input type="radio" name="pinfor" class="pinfor" value="freeshop"/> For any ourpose free shop </p>
	  </td>
    </tr>
    <tr class="paidshop">
      <td width="25%"  class="label">Enter Amount :</td>
      <td width="75%"><input type="text" name="amount"  value="<?=$amount?>" lang="R" title="Amount" class="txt medium paid" value="" style="width:100px;color:black;" placeholder="Enter Amount" />
					  </td>
    </tr>

	 <tr class="paidshop">
      <td width="25%"  class="label">Quantity :</td>
      <td width="75%"><input type="text" name="qty" value="<?=$amount?>" lang="R" title="Quantity" class="txt medium paid" value="" style="width:100px;" placeholder="Enter Quantity" /></td>
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
 $(".pinfor").click(function(){
	var value = $(this).val();
	if(value=='freeshop'){
		$(".paidshop").hide();
		$(".paid").attr('lang','N');
	}else{
		$(".paidshop").show();
		$(".paid").attr('lang','R');
	}

 });
 </script>
 <script type="text/javascript"> 
 function addField(){
  var newContent = '<br /><strong style="margin-left:40px;">Title :</strong><input type="text" name="ftitle[]"  title="ftitle" class="txt medium"value="" /><br /><strong>Description :</strong><input type="text" name="fdescription[]" style="margin-top:10px;" title="description" class="txt medium" value="" /><br />';
  $(".addmore").append(newContent); 
 }
</script>