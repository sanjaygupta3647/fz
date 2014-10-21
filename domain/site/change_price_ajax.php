<?php  
  @extract($_GET); 
  if($proid) {  
		 $check=$cms->db_query("select pid from #_product_price where proid ='".$proid."' and dsize = '$dsize'");  
		 if(mysql_num_rows($check)){
		       $pro_pi=$cms->db_fetch_array($check);  
			   $price = $cms->getBothPriceSize($pro_pi[pid],$current_store_user_id); 
			   if($price[1]>0 && $price[1]< $price[0]){?>
              <span style="font-size: 12px; color:#FF0000; text-decoration:line-through; margin-right:5px;" >
              <?=$cms->price_format($price[0])?>
              </span>
              <?php  } 
				 $cost = $price[0];
				 if($price[1]>0 && $price[1]< $price[0]){
					$cost = $price[1];
				 } 
			  ?>
              <span>  
              <?=$cms->price_format($cost)?> 
			 
              /-</span> 
			  
		<?php  } 
		
	}
 
?>

