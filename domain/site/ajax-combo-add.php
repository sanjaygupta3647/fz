<?php 
 $comboprod = $cms->getSingleresult("select comboprod from #_combo_prod where pid='".$_GET[pid]."' "); 
 $prod_id = $cms->getSingleresult("select prod_id from #_combo_prod where pid='".$_GET[pid]."' ");  
 $check=$cms->db_query("select proid from #_cart where proid = '".$prod_id."' and ssid = '".session_id()."' "); 
 $cat_id = $cms->getSingleresult("select cat_id  from #_products_user where pid='$prod_id' "); 
 $get_store_user_id = $cms->getSingleresult("select store_user_id  from #_products_user where pid='$prod_id' "); 
 if($get_store_user_id!=$_GET[current_store_user_id]){
	$cond = " brand_id = '$get_store_user_id', cat_id = '$cat_id',";
 }else{
	$cond = " brand_id = '0', cat_id = '$cat_id',";
 }
 if(!mysql_num_rows($check)){ 
	       $dsize=@explode("$$",$prod_id); 
			   if($dsize[1]!='NA'){
				   $size=$dsize[1];
			   }else{
			   $size='';
			   }
		   $color = $cms->getSingleresult("select color from #_products_user where pid='".$_GET[pid]."' ");  
		   $getPrice = $cms->getPrice($prod_id,$_GET[current_store_user_id]);
		   $insertQry = "insert into #_cart set proid = '".$prod_id."', $cond dsize='$size',color='$color', comboid = '".$_GET[pid]."', urls = '".$cms->curPageURL()."',store_user_id = '".$_GET[current_store_user_id]."', ssid = '".session_id()."',qty = 1, price ='$getPrice' ";  	
		   $cms->db_query($insertQry);
 }
 if($comboprod){  
		 $cmb = @explode(",",$comboprod);
		 foreach($cmb as $val){
		  $dsize=@explode("$$",$val);
		   if($dsize[1]!='NA'){
				   $size=$dsize[1];
			   }else{
			   $size='';
			   }
		  $check=$cms->db_query("select proid from #_cart where proid = '".$val."' and dsize='$size' and ssid = '".session_id()."' "); 
			 if(!mysql_num_rows($check)){ 
				   $color = $cms->getSingleresult("select color from #_products_user where pid='$val' "); 
				   $getPrice = $cms->getPriceSize($val,$current_store_user_id,$size); 
				   $insertQry = "insert into #_cart set proid = '".$val."', dsize='$size', $cond color='$color', comboid = '".$_GET[pid]."', urls = '".$cms->curPageURL()."',store_user_id = '".$_GET[current_store_user_id]."', ssid = '".session_id()."',qty = 1, price ='$getPrice' ";  	
				   $cms->db_query($insertQry);
			  } 
	     }	 
 }
 echo "done";
?>