
<?php 
@extract($_GET); 
if($prod_id) {
				 $title = $cms->getSingleresult("select title  from #_products_user where pid='$prod_id'"); 
				 $check=$cms->db_query("select proid from #_cart where proid = '".$prod_id."' and ssid = '".session_id()."' ");
				 if(mysql_num_rows($check)){
					?><div class="main_popup_div"><p style="color:red"><span></span><?=$title?> Product is already in cart! </p></div> <?php   
				   }else{
			 
					?><div class="main_popup_div"><p><span></span><?=$title?>Product Successfully Added in Your Cart</p></div> <?php   
			  
		           } 
		
}
 
?>