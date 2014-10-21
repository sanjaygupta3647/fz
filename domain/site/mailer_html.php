<?php
 
$message = '
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Mailer:</title>
 
</head>';
$hedlogo = $cms->getSingleresult("select image from #_store_detail where store_user_id = '$current_store_user_id'"); 
$img = "http://fizzkart.com/uploaded_files/orginal/".$hedlogo; 
$store_url = $cms->getSingleresult("select store_url from #_store_detail where store_user_id = '$current_store_user_id' ").'.fizzkart.com'; 
$email_id = $cms->getSingleresult("select email_id from #_store_user where pid = '$current_store_user_id' ");
$orderid = $cms->getSingleresult("select orderid from #_order_summary where orderid='".$_SESSION['orderid']."'");
$message .=  '
<body margin:0; padding:0; font-family:"Microsoft New Tai Lue";>
<table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="top"><table width="100%" cellspacing="0" cellpadding="0" border="0">
      <tr>
        <td width="50%" align="left" valign="top" padding:15px 0 15px 15px;><img src="'.$img.'"   height="81"  alt="'.$store_url.'"/></td>
        <td width="50%" align="left" valign="top"> </td>
      </tr>
    </table>
  </tr>
  <tr>
    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" margin:0 0 0 0px; padding:0; font-size:20px; font-weight:normal;>
      <tr>
        <td align="left" valign="top">
        <h2 style="margin:15px 0 15px 0px; padding:0; font-size:16px; font-weight:bold;">Dear '.$_SESSION[fname]." ".$_SESSION[lname].',</h2>
        <p style="margin:0 0 0 0px; padding:0; font-size:20px; font-weight:normal;; ">Your order has been received. Thanks for Shopping With Us</p></td>
      </tr>
      
      <tr>
        <td align="left" valign="top" padding:10px 0 0 0; font-size:12px; font-weight:normal; text-decoration:none; color:#000;>Your Order Details are given below:</td>
      </tr>
      <tr>';
	  $message .= '<td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" background-color:#00aeef;>
          <tr background-color:#00aeef;>
            <th width="20%" align="left" valign="middle" line-height:40px; font-size:15px; font-weight:bold; color:#fff; border:1px solid #fff;>Product Name</th>
            <th width="10%" align="left" valign="middle" line-height:40px; font-size:15px; font-weight:bold; color:#fff; border:1px solid #fff;>Quantity</th>
            <th width="10%" align="left" valign="middle" line-height:40px; font-size:15px; font-weight:bold; color:#fff; border:1px solid #fff;>Price</th>
            <th width="10%" align="left" valign="middle" line-height:40px; font-size:15px; font-weight:bold; color:#fff; border:1px solid #fff;>Sub total</th>
          </tr>';
		    $rsAdmin_pros = $cms->db_query("select * from #_orders_detail where orderid='".$orderid."' ");	 
			
					$f=1;while($results = $cms->db_fetch_array($rsAdmin_pros))
					{ 	 
					$gtottal = $gtottal + $results[amount];
 				    $prodname = $cms->getSingleresult("select title from #_products_user where pid='".$results[proid]."'");
					$message .=  '<tr > 
					<td line-height:40px; font-size:14px; font-weight:normal; color:#000; background-color:#a4e6ff; border:1px solid #fff; >'.$prodname.'</td> 
					<td line-height:40px; font-size:14px; font-weight:normal; color:#000; background-color:#a4e6ff; border:1px solid #fff;>'.$results[qty].'</td>
 					<td line-height:40px; font-size:14px; font-weight:normal; color:#000; background-color:#a4e6ff; border:1px solid #fff;>Rs. '.$results[amount].'</td>  
                    <td line-height:40px; font-size:14px; font-weight:normal; color:#000; background-color:#a4e6ff; border:1px solid #fff;> Rs. '.$results[amount]*$results[qty].'</td>
 				    </tr>';  
				  }
			 $ship=$cms->db_query("select * from #_order_summary where  orderid ='".$orderid."'"); 
			 $shipcharge=$cms->db_fetch_array($ship);@extract($shipcharge); 
			 $totaldiscount=$comboSavng+$periodSaving+$hotdealSaving+$overAlldiscount;
			 $payableAmount=($totalCost-$totaldiscount)+$shipping;
			 $totalCost=$cms->price_format($totalCost);
		  
            $message .=  '<tr>
                    <td colspan="4" >&nbsp;</td>
                  </tr>';
				   $message .= '<tr>
                    <td colspan="4"><b>Sub Total (Including GST):</b>  
                     '.$totalCost.'</td></tr> 
					 <tr class="border-yes2">
					  <td colspan="4"><b>Total Discount:</b>Rs.  
                     '.$totaldiscount.'</td></tr> <tr class="border-yes2">
                    <td colspan="4" class="cal-left"><b>Shipping &amp; Handling:</b> Rs. '.$shipping.'</td>
                  </tr>
                  <tr>
                    <td colspan="4"><b>Total:</b>Rs. '.$payableAmount.'</td>
                  </tr>  '; 
       $message .=  ' </table></td>
      </tr>
<tr>
        <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr bgcolor="#e0f7ff">
        ';
		$storepath = SITE_PATH.$items[0];
 
     $message .=  '  </tr>
	 <tr bgcolor="#00aeef">
         <td> Order Id: '.$_SESSION['orderid'].' </td>
      </tr>
      <tr bgcolor="#00aeef">
        <td align="left" valign="top" class="store_url" style=" color:#fff; font-weight:bold;" >Store URL: <a href="http://'.$store_url.'" target="_blank" style="color:#fff; text-decoration:none; font-weight:normal;">'.$store_url.'</a></td>
      </tr>
      <tr bgcolor="#e0f7ff">
        <td align="left" valign="top" style="padding:10px 0;">
        <h2 style="margin:0; padding:0; font-size:16px; font-weight:bold; ">Regards,</h2>
        <p style="margin:0; padding:0; font-size:16px; font-weight: normal;">'.$store_url.'</p>
        </td>
      </tr>
  
</table>
</td>
      </tr>
      
      <tr>
        <td align="center" valign="middle"><p style="margin:0;  font-size:11px; padding:7px 2px 7px 2px; text-align:justify;">Security Alert - In case you receive a suspicious mail from anyone claiming to be a client of Fizzkart, asking for your personal information or some money by pretending to offer you a job please do not respond to such mails and bring it to the immediate notice of '.$store_url.' by writing to us at <a href="#" style="text-decoration:none; color:#00aeef;">'.$email_id.'</a>. Please note that such offers / emails are a violation of our Terms and Conditions, and '.$store_url.' does not endorse such communication with candidates. If you no longer wish to receive alerts and updates from '.$store_url.', you may <a href="#" style="text-decoration:none; color:#00aeef;">click here</a> to remove all alerts.</p></td>
      </tr>
    </table>
    </td>
  </tr>
</table>

</body>
</html>';

  
  
	$message1 .= $message;  
    $message2 .= $message;  
	$subject = "Order confirmed: #".$orderid; 
	$headers = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";  
	/*$emailuser = $cms->getSingleresult("select email from #_shipping_address where orderid='".$_SESSION['orderid']."'");
	$emailadmin = $cms->getSingleresult("select email_id from #_store_user where pid='$current_store_id'");
	@mail($emailuser, $subject, $message1, $headers);  
	@mail(emailadmin, $subject, $message2, $headers);
	@mail(SITE_MAIL, $subject, $message2, $headers);  */
  
?>