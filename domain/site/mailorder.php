<?php   
$_POST[orderid] = "100120141006"; 
$message1 = 'Dear '.$_SESSION[name].',<br />
Following are the details of shopping:
<br /><br /><br />';
$message2 = 'New Order Received ,<br />
Following are the details of shopping:
<br /><br /><br />';
 
              $message = '<table width="100%">
                  <tr class="no-border1 header-tbl">
                    <td width="28%"   bgcolor="#F4F4F4" class="label2" >Item Name</td>
                     <td width="11%"   bgcolor="#F4F4F4" class="label2">Unit Price</td>
                    <td width="13%"  bgcolor="#F4F4F4" class="label2">Quantity</td>
                    <td width="18%"   bgcolor="#F4F4F4" class="label2" >Amount</td>
                   </tr>';   
				    $rsAdmin_pros = $cms->db_query("select * from #_orders_detail where `orderid`='".$_POST[orderid]."' ");	
					$gtottal=0;
					$shippingCost = 0;
					$f=1;while($results = $cms->db_fetch_array($rsAdmin_pros))
					{ 	 
					$gtottal = $gtottal + $results[amount];
 				    $prodname = $cms->getSingleresult("select title from #_products_user where pid='".$results[proid]."'");
					$message .=  '<tr >
					<td >'.$prodname.'</td> 
 					<td>'.$cms->price_format($results[amount]).'</td>  
                    <td>'.$results[qty].'</td>
					<td>'.$cms->price_format(($results[amount]*$results[qty])).'</td>
 				</tr>';  
				  } 
			$message .=  '<tr class="border-yes">
                    <td colspan="4" >&nbsp;</td>
                  </tr>';
                $message .=  '<tr class="border-yes2">
                    <td colspan="4"><b>Sub Total (Including GST):</b>  
                     '.$cms->price_format($gtottal).'</td></tr>'; 
					 
 $message .=  '<tr class="border-yes2">
                    <td colspan="4" class="cal-left"><b>Shipping &amp; Handling:</b>'.$cms->price_format(SHIPPING_COST).'</td>
                  </tr>
                  <tr class="border-yes2">
                    <td colspan="4" class="cal-left"><b>Total:</b>'.$cms->price_format($gtottal+SHIPPING_COST).'</td>
                  </tr>  
                  </table>'; 
$storepath = SITE_PATH."domain/".$items[0];
echo $message .='<p>Order Id: '.$_POST[orderid].'</p>
<p>Stote URL: '.$storepath.'</p>
<p>Regards,<br />
'.SITE_NAME.'</p>'; 
	/*$message1 .= $message;  
	$message2 .= $message;  
	$subject = "Order confirmed: #".$orderid; 
	$headers = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";  
	$emailuser = $cms->getSingleresult("select email from #_shipping_address where orderid='".$_POST[orderid]."'");
	$emailadmin = $cms->getSingleresult("select email_id from #_store_user where pid='$current_store_id'");
	@mail($emailuser, $subject, $message1, $headers);  
	@mail(emailadmin, $subject, $message2, $headers);
	@mail(SITE_MAIL, $subject, $message2, $headers);*/
 
  ?>