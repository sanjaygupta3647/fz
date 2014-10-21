<?php include("../../lib/opin.inc.php")?>
<?php define("CPAGE","catalog/");$mode=true?>
<?php include("../inc/header.inc.php")?>
<div class="main">
<header>
     
      <div class="hrd-right-wrap">
         
        
        <div class="brdcm" id="hed-tit"></div>
        <div class="unvrl-btn">  
        <a href="javascript:void(0)" onclick="javascript:formback();" class="ub">
        <img src="<?=SITE_PATH_MEM?>images/back.png" alt=""></a> 
        
        </div> 
      </div>
      <div class="cl"></div>
    </header> 
<?  
 if(isset($orderid)){
	$rsadm=$cms->db_query("select * from #_order_summary where orderid='".$orderid."'");
	$arradm=$cms->db_fetch_array($rsadm);
	@extract($arradm);
	
}
?>
<div class="content">
<div class="div-tbl">
<div class="cl"></div>
    <? //$adm->h1_tag('Dashboard &rsaquo; Order Details',$others2)?>
  <?php $hedtitle = "Order Management"; ?>    
      <?=$adm->alert()?>
      <div class="title">
        <?=$adm->heading('View Order Details')?>
      </div>
      <div class="tbl-contant">
      <table width="100%" border="0"   cellpadding="2" cellspacing="1"  class="data-tbl">
	    <tr>
          <td class="label2"><b>Order ID:</b></td>
          <td>&nbsp;&nbsp;<strong><?=$orderid?></strong></td>
        </tr>
		 <tr>
          <td class="label2"><b>Total Cost:</b></td>
          <td>&nbsp;&nbsp;<strong><?=$cms->price_format($totalCost)?></strong></td>
        </tr>
		<tr>
          <td class="label2"><b>Combo Saving:</b></td>
          <td>&nbsp;&nbsp; <?=($comboSavng)?$cms->price_format($comboSavng):'NA'?></td>
        </tr>
		<tr>
          <td class="label2"><b>Period Saving:</b></td>
          <td>&nbsp;&nbsp; <?=($periodSaving)?$cms->price_format($periodSaving):'NA'?></td>
        </tr>
		<tr>
          <td class="label2"><b>Hotdeal Saving:</b></td>
          <td>&nbsp;&nbsp; <?=($hotdealSaving)?$cms->price_format($hotdealSaving):'NA'?> </td>
        </tr>
		<tr>
          <td class="label2"><b>OvelAll Disscount:</b></td>
          <td>&nbsp;&nbsp; <?=($overAlldiscount)?$cms->price_format($overAlldiscount):'NA'?> </td>
        </tr>
        <tr>
            <td width="17%" class="label2"><b>Status:</b></td>
            <td width="83%">&nbsp;&nbsp;<strong><?=ucfirst($cms->getSingleresult("select status from #_order_summary where `orderid`='".$orderid."'"))?></strong></td>
          </tr>
        <tr>
          <td class="label2"><b>Order date:</b></td>
          <td>&nbsp;&nbsp;<?=date("d M, Y, h:i:s", strtotime($submitdate))?></td>
        </tr>
      
		<tr>
          <td class="label2"><b>Customer name:</b></td>
          <td>&nbsp;&nbsp;<a href="<?=SITE_PATH_MEM?>users/?mode=add&id=<?=$uid?>" target="_blank"><?=$cms->getSingleresult("select fname from #_members where `pid`='".$uid."'")?></a></td>
        </tr>
        <tr>
          <td colspan="2" class="label2">&nbsp;</td>
          </tr>
         
       
        </table><br>
 <div class="tbl-name">
       <h3>Products Details</h3></div>
     <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="data-tbl">
          <tr class="t-hdr">
            <td width="3%" align="center"><?=$adm->orders('#',false)?></td>
            <?php  $totalDiscount=$comboSavng+$periodSaving+$hotdealSaving+$overAlldiscount; $payAmount=$totalCost-$totalDiscount; ?>
            
			<td width="15%" align="center"><?=$adm->orders('Product',true)?></td>
 			<td width="10%" align="center"><?=$adm->orders('Qty',true)?></td>
			<td width="10%" align="center"><?=$adm->orders('Amount',true)?></td> 
          </tr>
          <?php 
		  $rsadm=$cms->db_query("select * from #_orders_detail where orderid='".$orderid."'");
		  $total = 0;
		  if(mysql_num_rows($rsadm)){ $nums=1; while ($line = $cms->db_fetch_array($rsadm)){@extract($line); $total = $total+$amount;?>
          <tr <?=$adm->even_odd($nums)?>>
            <td align="center"><?=$nums?></td>
            <?php /*?><td align="center"><?=$adm->check_input($pid)?></td><?php */?>
             <td align="center" valign="top"><?=$cms->getSingleresult("select title from #_products_user where `pid`='".$proid."'")?></td>
 			<td align="center" valign="top"><?=$qty?></td>
			<td align="center" valign="top"><?=$cms->price_format($amount)?></td>
            
          </tr>
          <?php $nums++;}}else{ echo $adm->rowerror(5);}?>
		  <tr <?=$adm->even_odd($nums)?>>
            <td align="center">&nbsp;</td>
			<?php
			$shipping = $cms->getSingleresult("select shipping from #_order_summary where `orderid`='".$orderid."'");
			$totalCost=$cms->getSingleresult("select totalCost from #_order_summary where `orderid`='".$orderid."'");
			//$shipping = ($shipping)?$shipping:50;
			$shipping =$shipping;
			?>
			<td align="center">Shipping: <?=$cms->price_format($shipping)?></td>  
			<td align="center" valign="top">Total: <?=$cms->price_format($totalCost)?></td>
			<td align="center" valign="top">Grand Total: <?=$cms->price_format($totalCost+$shipping)?></td> 
          </tr>
		   <tr <?=$adm->even_odd($nums)?>>
            <td align="center">&nbsp;</td> 
			<td align="center" valign="top" align="left">Total Discount: <?=$cms->price_format($totalDiscount)?></td> 
			<td align="center" valign="top" colspan="3"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			 Total Pay: <?=$cms->price_format($payAmount+$shipping)?></td> 
          </tr>
        </table>
		
       <div class="tbl-name"><div class="cl"></div>
 <h3>Shipping Details</h3></div>
     <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="data-tbl">
	<?php 
	$shippingqry = $cms->db_query("select * from #_shipping_address where `orderid`='".$orderid."'");
	$result = $cms->db_fetch_array($shippingqry);@extract($result);
	?>
	  <tr>
          <td class="label2"><b>Name:</b></td>
          <td>&nbsp;&nbsp;<strong><?=$name?></strong></td>
      </tr>
	   <tr>
          <td class="label2"><b>Email:</b></td>
          <td>&nbsp;&nbsp;<strong><?=$email?></strong></td>
      </tr>
	  <tr>
          <td class="label2"><b>City:</b></td>
          <td>&nbsp;&nbsp;<strong><?=$city?></strong></td>
      </tr>
	   <tr>
          <td class="label2"><b>State:</b></td>
          <td>&nbsp;&nbsp;<strong><?=$city?></strong></td>
      </tr>
	    <tr>
          <td class="label2"><b>Address:</b></td>
          <td>&nbsp;&nbsp;<strong><?=$address?></strong></td>
      </tr>
	   <tr>
          <td class="label2"><b>Zipcode:</b></td>
          <td>&nbsp;&nbsp;<strong><?=$zipcode?></strong></td>
      </tr>
	   <tr>
          <td class="label2"><b>Mobile</b></td>
          <td>&nbsp;&nbsp;<strong><?=$mob?></strong></td>
      </tr>
	 </table>
       
      </div>
          </div>
<?php include("../inc/footer.inc.php")?>
</div>
<div class="cl"></div>
</div>
</div> 
</body>
</html>