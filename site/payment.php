<?php
$working_key='DB832F9427C63F7A77823DFBA8118E30';   
 
  
 	//Working Key should be provided here.
	echo $encResponse=$_POST["encResp"];			//This is the response sent by the CCAvenue Server
	$rcvdString=$cms->decrypt($encResponse,$working_key);		//Crypto Decryption used as per the specified working key.
	$order_status="";
	$decryptValues=@explode('&', $rcvdString);
	echo "<pre>"; @print_r($decryptValues);echo "<pre>"; 
	$dataSize=@sizeof($decryptValues);
	echo "<center>";

	for($i = 0; $i < $dataSize; $i++) 
	{
		$information=@explode('=',$decryptValues[$i]);
		if($i==3)	$order_status=$information[1];
	}

	if($order_status==="Success")
	{
		echo "<br>Thank you for shopping with us. Your credit card has been charged and your transaction is successful. We will be shipping your order to you soon.";
		
	}
	else if($order_status==="Aborted")
	{
		echo "<br>Thank you for shopping with us.We will keep you posted regarding the status of your order through e-mail";
	
	}
	else if($order_status==="Failure")
	{
		echo "<br>Thank you for shopping with us.However,the transaction has been declined.";
	}
	else
	{
		echo "<br>Security Error. Illegal access detected";
	
	}

	echo "<br><br>";

	echo "<table cellspacing=4 cellpadding=4>";
	for($i = 0; $i < $dataSize; $i++) 
	{
		$information=explode('=',$decryptValues[$i]);
	    	echo '<tr><td>'.$information[0].'</td><td>'.$information[1].'</td></tr>';
	}

	echo "</table><br>";
	echo "</center>";
?>