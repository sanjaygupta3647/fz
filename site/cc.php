<?php
$working_key='DB832F9427C63F7A77823DFBA8118E30';  
$mr[merchant_id] = "49407";
$mr[billing_name] = "Sanjay Gupta"; 
$mr[redirect_url] = SITE_PATH."payment";
$mr[cancel_url] = SITE_PATH."cancle";
$mr[order_id] = "147147147";
$mr[amount] = 1;
$mr[billing_address] = "Noida";
$mr[billing_city] = "Noida";
$mr[billing_state] = "UP";
$mr[billing_zip] = "201010";
$mr[billing_country] = "India";
$mr[billing_tel] = "9891617198";
$mr[billing_email] = "sanjay.vns1987@gmail.com";
$mr[currency] = "INR";  
foreach ($mr as $key => $value){
	$merchant_data.=$key.'='.$value.'&';
} 
$encrypted_data=$cms->encrypt($merchant_data,$working_key); // Method for encrypting the data.

?>
<form method="post" name="redirect" action="https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction"> 
<?php
$access_code='AVBG04CB39AM96GBMA';
echo "<input type=hidden name=encRequest value=$encrypted_data>";
echo "<input type=hidden name=access_code value=$access_code>";
?>
</form>
</center>
<script language='javascript'>document.redirect.submit();</script>
</body>
</html>