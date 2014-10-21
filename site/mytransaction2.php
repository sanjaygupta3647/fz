<?php 
 
include "site/search.inc.php";

?>
<?php  
if(!$_SESSION[userid]){ 
$redpath = SITE_PATH;
$cms->redir($redpath,true);die;
}
$rsAdmin2=$cms->db_query("select * from #_members where pid='".$_SESSION[userid]."'");
$result=$cms->db_fetch_array($rsAdmin2);
extract($result);
?>
<div class="transaction_maindiv">
  <div class="main_tabdiv">
        <div class="tabdiv_heading"><h1>Your Transcation Details</h1></div>
      <div class="tabdiv_areas">

<div  class="profile_tabs">
 <?php include "user-tabs.php";  ?> 
  <div class="selected">
   
      <?php 
	 $ordercheck=$cms->db_query("select * from #_order_summary where uid = '".$_SESSION['userid']."' || store_id = '$current_store_id' ");
	 if(mysql_num_rows($ordercheck)){?> <table border="0" style="float: left;" class="CSSTableGenerator"> 
	 <tr style="height:30px"><th align="left">Order ID</th><th align="left">Amount</th><th align="left">Date</th><th align="left">Status</th></tr> 
	 <?php
	 while($res =$cms->db_fetch_array($ordercheck)){?>
	 <tr>
	 <td>
	 <a href="<?=$redpath = SITE_PATH."mytransaction/".$res[orderid]?>" 
	 <? if($items[1]==$res[orderid]){?> style="color:green; font-size:large; background-color:#0099FF; color:#FFFFFF; padding:2px;" <?php }?>><?=$res[orderid]?></a></td>
	 <td><?=$cms->price_format($cms->getSingleresult("select amount from #_order_summary where orderid='".$res[orderid]."'"))?></td>
	 <td><?=$res[submitdate]?></td>
	 <td><?=$cms->getSingleresult("select status from #_order_summary where orderid='".$res[orderid]."'")?></td>
	 </tr>
	 <tr><td colspan="4">&nbsp;</td></tr>
	 <?php 
	 } ?>
	 </table><?php
	 } 
	  if($items[1]){
	 ?>
	 <hr />
      <table border="0" style="float: left;" class="CSSTableGenerator"> 
	  <?php 
	   $check=$cms->db_query("select * from #_orders_detail where  orderid = '".$items[1]."' ");
	   if(mysql_num_rows($check)){?>
				<tr style="height:30px"><th colspan="4" align="left"> Shopping detail for transaction id <strong><?=$items[1]?></strong></th></tr>
	           	<tr><th align="left" style="height:30px">Image</th><th align="left">Product</th><th align="left">Quantity</th><th align="left">Amount</th></tr> 
		<?php
		$total  = 0;
		while($res2 = $cms->db_fetch_array($check))
						{
						extract($res2);
						$total = $total+($qty*$amount);
						$img = $cms->getSingleresult("select image1 from #_products_user where pid='".$proid."' ");
					    $imgpro  = "uploaded_files/orginal/no-img.gif";
						if(file_exists('uploaded_files/orginal/'.$img) && $img!="")
						{
							$imgpro  = "uploaded_files/orginal/".$img;
						}
						?>
						
						<tr>
						<td><img src="<?=$imgpro?>" height="70" /></td>
						<td><a href="<?=($urls)?$urls:'#'?>"><?=$cms->getSingleresult("select title from #_products_user where 
						pid='".$proid."' ")?></a></td>
						<td>
						<?=$qty?></td>
						<td><?=$cms->price_format($qty*$amount)?><?php if($qty>1)echo " ($qty * $amount)"; ?> </td> 
						</tr>
						<tr><td colspan="5">&nbsp;</td></tr>
						<?php
						}
						$_SESSION['total'] = $total;
						$link  = SITE_PATH."".$items[0];
						?>
						<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td><strong>Total: </strong><?=$cms->price_format($total)?> </td>
						 
						 
						</tr>
						<?php
		}
		 
		else{?>
		<tr><td colspan="4"><div>No Product added to cart!</div></td></tr>
		<?php
		} 
	   ?> 
    </table> 
 <?php
  $check=$cms->db_query("select * from #_shipping_address where  orderid = '".$items[1]."' ");
  if(mysql_num_rows($check)){
	$res2 = $cms->db_fetch_array($check); extract($res2);
  }
  ?>
  <table width="50%" border="0" class="CSSTableGenerator" cellspacing="1" cellpadding="0"> 
  <tr style="height:30px"><th colspan="2" align="left"> Shipping Information of <strong><?=$items[1]?></strong></th></tr>
   <tr><td width="30%" align="left">Name:</td><td align="left"><?=$fname." ".$lname?></td></tr>
  <tr><td width="30%" align="left">Email:</td><td align="left"><?=$email?></td></tr>

   <tr><td width="30%" align="left">Mobile:</td><td align="left"><?=$mob?></td></tr>
    <tr><td width="30%" align="left">City:</td><td align="left">
	<?=$city?> </td></tr>
	<tr><td width="30%" align="left">State:</td><td align="left">
	 <?=$state?> </td></tr>
	<tr><td width="30%" align="left">Address:</td><td align="left">
	<textarea class="othr_flds" id=""  name="address"><?=nl2br($address)?></textarea></td></tr>

	<tr><td width="30%" align="left">Zipcode:</td><td align="left">
	 <?=$zipcode?> </td></tr>

	 

	 
  </table>  

	<?php	
	}?>
	 
  </div>
</div>
 