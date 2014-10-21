<?php
	$check = $cms->getSingleresult("select count(*) from #_product_compare where  ssid = '".session_id()."' and product_id = '".$_POST[product_id]."' "); 
	if($check){
		$cms->db_query("delete from #_product_compare where product_id = '".$_POST[product_id]."' and ssid ='".session_id()."' "); 
	}else{
		$totalComp = $cms->getSingleresult("select count(*) from #_product_compare where  ssid = '".session_id()."'");
		if($totalComp<4){
			$cms->db_query("insert into #_product_compare set product_id = '".$_POST[product_id]."', ssid ='".session_id()."' "); 
		}else{
			echo "no";
		}
	}
 ?>

