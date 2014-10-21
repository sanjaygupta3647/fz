 <div class="cat_product_text_info_buttn_left">
<?php 
  @extract($_GET); 
  if($proid) {  
		 $check=$cms->db_query("select pid from #_product_price where proid ='".$proid."' and dsize = '$dsize'"); 
		 if(mysql_num_rows($check)){
		      $pro_pi=$cms->db_fetch_array($check);  
		      $Cprice = $cms->getBothPriceSize($pro_pi[pid],$current_store_user_id); 
						$mainprice = $Cprice[0];
						$disprice = $Cprice[1]; 
				 ?>
			   <a class="product_price product_price">
                  <?=($disprice >0 && $disprice < $mainprice)?$cms->price_format($disprice):$cms->price_format($mainprice)?>
                  /-</a>
                  <?php if($disprice < $mainprice && $disprice!=0 ){ ?>
                  <a class="product_price right_price">
                  <?=$cms->price_format($mainprice)?>
                  /-</a>
                  <?php
					} 
		}
	} 
?>
</div>

