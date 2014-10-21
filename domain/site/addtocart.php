<?php 
  @extract($_GET);
 
 if($prod_id) {
		 $title = $cms->getSingleresult("select title  from #_products_user where pid='$prod_id' "); 
		 if($dsize==''){
			$dsize = $cms->getSingleresult("select dsize  from #_product_price where pid='$prod_id' and store_id = '".$current_store_user_id."' "); 
		 }
		 $check=$cms->db_query("select proid from #_cart where proid = '".$prod_id."' and ssid = '".session_id()."' and dsize='$dsize'  ");  
		 if(mysql_num_rows($check)){
			 if($dsize=='') $ms = "no dimension";else{ $ms = "$dsize dimension"; }
			echo "$title with $ms is already in cart!";
		 }else{ 
			 
			 $getPrice = $cms->getPriceSize($prod_id,$current_store_user_id,$dsize);  
			 $cat_id = $cms->getSingleresult("select cat_id  from #_products_user where pid='$prod_id' "); 
			 $get_store_user_id = $cms->getSingleresult("select store_user_id  from #_products_user where pid='$prod_id' "); 
			 if($get_store_user_id!=$current_store_user_id){
				$cond = " brand_id = '$get_store_user_id', cat_id = '$cat_id',";
			 }else{
				$cond = " brand_id = '0', cat_id = '$cat_id',";
			 }
			 if($getPrice!=0){
					 $urls = SITE_PATH."detail/".$adm->baseurl($title)."/".$prod_id;
					 if(!$qty) $qty=1;
					 $insertQry = "insert into #_cart set proid ='".$prod_id."', $cond urls = '".$urls."',store_user_id = '".$current_store_user_id."', ssid = '".session_id()."',qty = '$qty', 
					 price ='$getPrice',dsize='$dsize',color='$color' ";  	
					 $cms->db_query($insertQry);
					 $last = mysql_insert_id();
					 if($last){
					  echo "$title successfully added to cart!";
					 }	
				}else{
					  echo "Price not available for $title!";
				}	 
		 } 
	}
 
?>

