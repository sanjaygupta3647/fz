<?php
 $check = $cms->getSingleresult("select count(*) from #_product_compare where ssid ='".session_id()."' "); 
 if($check)  $cms->db_query("delete from #_product_compare where ssid ='".session_id()."' "); 
	echo "deleted";	 
 ?>

