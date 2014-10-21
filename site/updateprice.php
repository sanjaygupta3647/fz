<?php 
$rsAdmin=$cms->db_query("select store_user_id,title, pid, size,price,offerprice from #_products_user");
  while($arrAdmin=$cms->db_fetch_array($rsAdmin)){@extract($arrAdmin);  
		 $arr = array();
		 $store_id   = $cms->getSingleresult("select pid from #_store_detail where `store_user_id`='".$store_user_id."'");
		 $arr[store_id] = $store_id; $arr[proid] = $pid; $arr[dprice] = $price; $arr[dofferprice] = $offerprice;$arr[dtitle] = $title;
		 $dsize = array();
		 if($size){
			$dsize  = @explode($size); 
		 } 
		 if(count($dsize)){
			foreach($dsize as $val ){
				 $arr[dsize] = $val;
				 $cms->sqlquery("rs","product_price",$arr);
			}
			$arr = array();
		 }
		 $arr[dsize] = $size;
		 if(count($arr)){
			 $cms->sqlquery("rs","product_price",$arr);
		 } 
}
?>
		
		
		 
		
		
		
 