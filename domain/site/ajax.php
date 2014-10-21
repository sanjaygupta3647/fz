<?php
$check = $cms->db_query("select email from #_subscribe_list where email = '".$items[2]."' and store_id ='".$items[3]."' ");
if(mysql_num_rows($check))
{
?> <p style="background-color:#FF0000; width:150px;height: 18px;
text-align: left;
padding-top: 5px;">Already Subscribed!</p><?
}
else{
	$arr[email] = $items[2]; 
	$arr[store_id] = $items[3]; 
	$uids =  $cms->sqlquery("rs","subscribe_list",$arr); 
	if($uids)
	{
	    $headers = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$msg ='<div style="font-family:Verdana, Geneva, sans-serif; font-size:12px;"> Your email :'.$items[2].' is successfully subscribed for our news letter</p><p>Thanks,</p><p>@Fizzkart, Admin</p></div>';
		@mail($items[2], 'Fizzkart - Newsletter Subscription', $msg,$headers); 
	?>
	<p style="background-color:#006600; width:150px;height: 18px;
text-align: left;
padding-top: 5px;">Subscribed Successfully!</p><?
	}
}
?>

