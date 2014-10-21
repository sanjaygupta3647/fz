<?php
$cond = "";
$cats[] = 0;
$cats[]	= $_GET[cat_id]; 
if($_GET[store_user_id]){ $cond .= " and store_user_id = '".$_GET[store_user_id]."' "; } else { $cond .= " and store_user_id = '0' "; }
if($_GET[cat_id]){ 
	if($_GET[store_user_id]){
		$parQry = $cms->db_query("select cat_id FROM #_store_menu where parent = '".$_GET[cat_id]."' and  store_user_id = '".$_GET[store_user_id]."'    "); 
		if(mysql_num_rows($parQry)){
			while($res = mysql_fetch_object($parQry)){ 
				$cats[]	= $res->cat_id;  
			}		
		}
	}else{
		$parQry = $cms->db_query("select pid FROM #_category where parentId = '".$_GET[cat_id]."'     "); 
			if(mysql_num_rows($parQry)){
				while($res = mysql_fetch_object($parQry)){ 
					$cats[]	= $res->pid;
				}		
			} 
	}
	
$cond .= " and cat_id in (".implode(',',$cats).")   "; 
}

$header = "pid \t admin_product_id \t store_user_id \t cat_id \t combo \t brand_id \t title \t meta_title \t meta_keyword \t meta_description \t pcode \t kf1 \t kf2 \t kf3 \t clicks \t image1 \t image2 \t image3 \t image4 \t body1 \t url \t status \t show_home \t porder \t submitdate \t size \t  price \t  offertype \t deliverytime \t shipping \t discount \t color \t title1 \t disc1 \t  title2 \t disc2 \t title3 \t disc3 \t  title4 \t disc4 \t  title5 \t disc5 \t \n "; 

$qry = "select * FROM fz_products_user where 1  $cond   "; 
$user_query = $cms->db_query($qry); 
$data = "";
while($rows = mysql_fetch_object($user_query)){    
	$row = ""; 
	$row .= $rows->pid."\t";
	$row .= $rows->admin_product_id."\t";
	$row .= $rows->store_user_id."\t";
	$catname = $cms->getsingleresult("select name FROM #_store_menu where cat_id = '".$_GET[cat_id]."' and  store_user_id = '".$_GET[store_user_id]."'    "); 
	if(!$catname) $catname = $cms->getsingleresult("select name FROM #_category where pid = '".$_GET[cat_id]."' ");
	$row .= $catname."\t";
	$row .= $rows->combo."\t";
	$row .= $rows->brand_id."\t";
	$row .= $rows->title."\t";
	$row .=  str_replace("\n","",$rows->meta_title)."\t";
	$row .=  str_replace("\n","",$rows->meta_keyword)."\t";
	$row .=  str_replace("\n","",$rows->meta_description)."\t";
	$row .= $rows->pcode."\t";
	$row .= str_replace("_x000D_","",$rows->kf1)."\t";
	$row .= str_replace("_x000D_","",$rows->kf2)."\t"; 
	$row .= str_replace("_x000D_","",$rows->kf3)."\t";  
	$row .= $rows->clicks."\t";
	$row .= $rows->image1."\t";
	$row .= $rows->image2."\t";
	$row .= $rows->image3."\t";
	$row .= $rows->image4."\t";
	$des = str_replace("_x000D_","",$rows->body1);
	$des = str_replace("\n","",$des);
	$des = str_replace("\ n","",$des);
	$des = str_replace("\t","",$des);
	$des = str_replace("\r","",$des); 
	$row .= "  \t"; 
	$row .= $rows->url."\t";
	$row .= $rows->status."\t";
	$row .= $rows->show_home."\t";
	$row .= $rows->porder."\t";
	$row .= $rows->submitdate."\t";
	$row .= $rows->size."\t";
	/*
	 get price
	 
	*/
	$prQry = "select * FROM fz_product_price where proid = '".$rows->pid."' "; 
	$pricequery = $cms->db_query($prQry); 
	$pric = "";
	if(mysql_num_rows($pricequery)){
		while($r = mysql_fetch_array($pricequery)){ extract($r); 
			$pric .= $proid."$".$store_id."$".$dtitle."$".$dsize."$".$dprice."$".$dofferprice."|||";
		}
		$pric  = substr($pric,0,-3);
	} 
	$row .= $pric."\t"; 
	 
	$row .= $rows->offer_type."\t";  
	$row .= $rows->dtime."\t";
	$row .= $rows->shipping."\t";
	$row .= $rows->discount."\t";
	$row .= $rows->color."\t";
	$inerQery = mysql_query("select ftitle,fdescription FROM fz_product_feature where prod_id = '".$rows->pid."' ");
	if(mysql_num_rows($inerQery)){
		while($ks = mysql_fetch_object($inerQery)){
			$row .= str_replace("_x000D_","",$ks->ftitle)."\t"; 
			$row .= str_replace("_x000D_","",$ks->fdescription)."\t";  
		}
	}
	$data .= trim($row)."\n";
}
$data = str_replace("\r", "", $data);
$name=rand().'-list.xls'; 
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); 
header('Content-Disposition: attachment;filename='.$name);
header('Cache-Control: max-age=0');  
echo $header.$data;
?>