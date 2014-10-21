<?php 

	$check = $cms->getSingleresult("select count(*) from #_cart where  ssid = '".session_id()."' and proid = '".$_POST[product_id]."' "); 
	if($check){
		$comboid = $cms->getSingleresult("select comboid from #_cart where  ssid = '".session_id()."' and proid = '".$_POST[product_id]."' "); 
		if($comboid){
			$cms->db_query("delete from #_cart where comboid = '".$comboid."' and ssid ='".session_id()."' "); 
			$_SESSION['crtmsg'] = '<p style = "color:red;"> All product of this product combo has been deleted!</p>';
		}else{
			$cms->db_query("delete from #_cart where proid = '".$_POST[product_id]."' and ssid ='".session_id()."' and dsize='".$_POST[dsize]."' "); 
			$_SESSION['crtmsg'] = '<p class="successmsg2"><span class="check_imge"></span>Your Product has been removed Successfully</p>';
		}
	} 
	 
 ?>

