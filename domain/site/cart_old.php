<?php  
  if($cms->is_post_back()){
	extract($_POST);
	for($m=0; $m<sizeof($qty); $m++){  
		if($qty[$m]>0)
		{
			$cms->db_query("update #_cart set qty = '".$qty[$m]."' where id='".$iid[$m]."'");
		}
	} 
	$_SESSION['crtmsg'] ='<p style = "color:green; align:center;">Cart has been updated</p>';


	$cms->redir($cms->curPageURL(),true);	 die;
}

if($items[1]=='del' and $items[2]!=""){
	$cms->db_query("delete from #_cart where id = '".$items[2]."' ");
	$_SESSION['crtmsg'] = '<p style = "color:red;"> Item has been deleted!</p>';
	$redir = SITE_PATH."cart";
	$cms->redir($redir,true);
}

 
?> 
     <div id="container_head">
	 <form method="post" action="">
     <table width="100%" border="0" style="float: left;" class="CSSTableGenerator" cellspacing="1" cellpadding="0"> 
	  <?php 
	   $check=$cms->db_query("select * from #_cart where  ssid = '".session_id()."' ");
	   if(mysql_num_rows($check)){ 
	    if($_SESSION['crtmsg']!=""){
		?><tr><td colspan="5"><?=$_SESSION['crtmsg']?></td></tr><?php  unset($_SESSION['crtmsg']); 
		}?>
      	<tr style="color: #333333; height:30px;"><th align="left">Product</th><th align="left">Quantity</th><th align="left">Amount</th><th align="left">Action</th>
		<th>&nbsp; </th></tr> 
		<?php
		$total  = 0;
		while($res = $cms->db_fetch_array($check))
						{
						extract($res);
						$total = $total+($qty*$price);
						 
						?>
						
						<tr>
						 
						<td><a href="<?=$urls?>"><?=$cms->getSingleresult("select title from #_products_user where 
						pid='".$proid."' ")?></a></td>
						<td>
						<input name="iid[]" id="quantity" value="<?=$id?>" type="hidden"/>
						<input name="qty[]" id="quantity" value="<?=$qty?>" type="text" size="4" class="quantity-field2 qty"/></td>
						<td><?=$cms->price_format($qty*$price)?><?php if($qty>1)echo " ($qty * $price)"; ?> </td> 
						<td><a href="<?=$cms->curPageURL()?>/del/<?=$id?>"> Delete</a> </td> <td> &nbsp; </td></td></tr>
						<tr><td colspan="5">&nbsp;</td></tr>
						<?php
						}
						$_SESSION['total'] = $total;
						$link  = SITE_PATH;
						?>
						<tr>
						
						<td><a href="<?=$link?>" style="text-decoration:none">
						<input type="button" name="continue" class="mem_login" value="Continue Shopping" /></a></td>
						<td><input type="submit" class="mem_login" name="update" value="Update Items(s)" /></td>
						<td><strong>Total: </strong><?=$cms->price_format($total)?> </td>
						<td> 
						<input type="button" name="checkout" id="checkout" class="mem_login" value="Checkout Shopping" /></td>
						<td>&nbsp;</td>
						 
						</tr>
						<?php
		}
		 
		else{?>
		<tr><td colspan="4"><div>No Product added to cart!</div></td></tr>
		<?php
		}
      
	   
	   ?>
     
    </table> 
	</form>
</div>
 
