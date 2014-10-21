<?php  @extract($_GET); 
  if($proid) {  
		 $check=$cms->db_query("select pid from #_product_price where proid ='".$proid."' and dsize = '$dsize'"); 
		 if(mysql_num_rows($check)){
		      $pro_pi=$cms->db_fetch_array($check); ?>
 <div style="clear:both"></div>
            <?php  $price = $cms->getBothPriceSize($proid,$current_store_user_id,$dsize); 
		    ?>
            <p>Price:
              <?php  if($price[1]>0 && $price[1]< $price[0]){ ?>
              <span  style="text-decoration:line-through; padding-right:10px; color:#FF0000">
              <?=$cms->price_format($price[0])?>
              </span>
              <?php } 
			   $cost = $price[0];
				 if($price[1]>0 && $price[1]< $price[0]){
					$cost = $price[1];
				 }?>
              <span>
              <?=$cms->price_format($cost)?> 
              </span> <br />
            </p>
			<?php  } 
		
	} 
	?>