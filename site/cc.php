<?php
 
// Payment information here 
$Merchant_Id = "49407";  
$Amount = '1'; 
$Order_Id = "2514254";  
$Redirect_Url = "http://fizzkart.com/message"; 
$access_code='AVLO03BK26BP54OLPB';
$WorkingKey = "AA5C06A2AA00A6C03AA8AC10DDE84CA1"; 
$Checksum = $cms->getchecksum($Merchant_Id,$Amount,$Order_Id,$Redirect_Url,$WorkingKey); 
//$course_id=$_REQUEST['course_id'];
$user_id="1005";
$billing_cust_name= "Laxmi Gupta";
$Merchant_Param="Fizzkart";
// End payment info
//https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction
//
?> 
<form name="payment" action="https://www.ccavenue.com/shopzone/cc_details.jsp">
    <input type=hidden name=access_code value=<?=$access_code?>>
	<input type=hidden name="Merchant_Id" value="<?=$Merchant_Id?>">
	<input type=hidden name="Amount" value="<?=$Amount?>">
	<input type=hidden name="Order_Id" value="<?=$Order_Id?>">
	<input type=hidden name="Redirect_Url" value="<?php echo $Redirect_Url; ?>">
	<input type=hidden name="Checksum" value="<?php echo $Checksum; ?>">
	<input type="hidden" name="course_id" value="<?php echo $course_id; ?>">
	<input type="hidden" name="user_id" value="<?php echo $user_id; ?>">	
	<input type="hidden" name="billing_cust_name" value="<?php echo $billing_cust_name; ?>"> 
	<input type="hidden" name="Merchant_Param" value="<?php echo $Merchant_Param; ?>">    
    <table align="center" width="88%" height="50%" cellpadding="15">
    <tr><td align="center"><h3>You are going to be redirect the payment gateway page to make your payment<br/> Are you ready?<br/> </h3>
    <a href="<?=SITE_PATH?>" style="text-decoration:none"><input type="button" value="Not Yet"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
  <input type="submit" nsme="submit" value="Yes Proceed"></td></tr></table>
</form>
 