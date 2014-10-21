<?php 
$header = "Store/Brand Name \t Category Name \t Product Name \t Images \t Product Code \t Unit \t Price \t Offer Price\n ";   
$sql = $cms->db_query("select cat_id, name,parent from #_store_menu where store_user_id='".$_SESSION[uid]."' and parent!='0' order by name  ");
$reccnt = mysql_num_rows($sql);
if($reccnt){ 
	$data = "";
	while ($line = $cms->db_fetch_array($sql)){ 
		$prods  = array();
		$allprod =  $cms->db_query("select pid from fz_products_user  where store_user_id='".$_SESSION[uid]."' and status = 'Active' and cat_id = '".$line[cat_id]."' "); 
		if(mysql_num_rows($allprod)){
		  while($userProd=$cms->db_fetch_array($allprod)){
			$prods[] = $userProd[pid];
		  }
		} 
		$brandProds = $cms->db_query("select prod_id from #_barnds_product where store_user_id='".$_SESSION[uid]."'  and cat_id = '".$line[cat_id]."'  and status='Active' ");			
		if(mysql_num_rows($brandProds)){
		  while($res=$cms->db_fetch_array($brandProds)){
			$prods[] = $res[prod_id];
		  }
		}
		if(count($prods)){
			$prodQry = $cms->db_query("select * from #_product_price where proid in  (".implode(',',$prods).") ");   
			 while($rows = mysql_fetch_object($prodQry)){

			    $store_id=$cms->getSingleresult("select store_user_id from #_products_user where pid='".$rows->proid."' "); 
				if($_SESSION[uid]!=$store_id){
			    $brand_id=$cms->getSingleresult("select brand_id from #_barnds_product where store_user_id ='".$_SESSION[uid]."' and cat_id='$cat_id' and prod_id='".$rows->proid."' "); 
				}
				if($store_id){  
					$srore_name=$cms->getSingleresult("select title from #_store_detail where store_user_id ='$store_id' "); 
				}else{ 
					$srore_name=$cms->getSingleresult("select title from #_store_detail where store_user_id ='$brand_id' "); 
				}
				$row .= $cms->removeSlash($srore_name)."\t";     
				$parent=$cms->getSingleresult("select name from #_store_menu where   cat_id = '".$line[parent]."' "); 
				$row .= $cms->removeSlash($parent."/".$line[name])."\t"; 
				$title=$cms->getSingleresult("select title from #_products_user where  pid='".$rows->proid."' ");
				$row .= $cms->removeSlash($title)."\t"; 
				$image1=$cms->getSingleresult("select image1 from #_products_user where  pid='".$rows->proid."' ");
				$image2=$cms->getSingleresult("select image2 from #_products_user where  pid='".$rows->proid."' ");
				$image3=$cms->getSingleresult("select image3 from #_products_user where  pid='".$rows->proid."' ");
				$image4=$cms->getSingleresult("select image4 from #_products_user where  pid='".$rows->proid."' ");
				if($image1) $image = $image1; if($image2) $image .= ", ".$image2; if($image3) $image .= ", ".$image3; if($image4) $image .= ", ".$image4;
				$row .= $cms->removeSlash($image)."\t"; 
				$pcode=$cms->getSingleresult("select pcode from #_products_user where   pid = '".$rows->proid."' "); 
				if(!$pcode) {$pcode = 'NA';}
				$row .=  $cms->removeSlash($pcode)."\t"; 
				if(!$rows->dsize) $rows->dsize = 'NA';
				$row .= $cms->removeSlash($rows->dsize)."\t";
				$row .= $cms->removeSlash($rows->dprice)."\t";
				if(!$rows->dofferprice) $rows->dofferprice = 'NA';
				$row .= $cms->removeSlash($rows->dofferprice)."\n";  
			   }
		  } 
	 }
}
$all = $header.$row;
$all = str_replace("\r", "", $all);
$name=rand().'-list.xls'; 
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); 
header('Content-Disposition: attachment;filename='.$name);
header('Cache-Control: max-age=0');  
echo $all;
 
?>