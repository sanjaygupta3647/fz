<?php
mysql_connect("localhost","root");
mysql_select_db("fizzkart");
$header = "pid \t admin_product_id \t store_user_id \t cat_id \t combo \t brand_id \t title \t meta_title \t meta_keyword \t meta_description \t pcode \t kf1 \t kf2 \t kf3 \t hot_deal \t seasional_offer \t clicks \t image1 \t image2 \t image3 \t image4 \t body1 \t url \t status \t show_home \t porder \t submitdate \t size \t  price \t offerprice \t shipping \t discount \t color \t title1 \t disc1 \t  title2 \t disc2 \t title3 \t disc3 \t  title4 \t disc4 \t  title5 \t disc5 \t \n ";  
$user_query = mysql_query("select * FROM fz_products_user  where  store_user_id  = '2'   "); 
$data = "";
while($rows = mysql_fetch_object($user_query)){    
	$row = ""; 
	$row .= $rows->pid."\t";
	$row .= $rows->admin_product_id."\t";
	$row .= $rows->store_user_id."\t";
	$row .= $rows->cat_id."\t";
	$row .= $rows->combo."\t";
	$row .= $rows->brand_id."\t";
	$row .= $rows->title."\t";
	$row .= $rows->meta_title."\t";
	$row .= $rows->meta_keyword."\t";
	$row .= $rows->meta_description."\t";
	$row .= $rows->pcode."\t";
	$row .= $rows->kf1."\t";
	$row .= $rows->kf2."\t";
	$row .= $rows->kf3."\t";
	$row .= $rows->hot_deal."\t";
	$row .= $rows->seasional_offer."\t";
	$row .= $rows->clicks."\t";
	$row .= $rows->image1."\t";
	$row .= $rows->image2."\t";
	$row .= $rows->image3."\t";
	$row .= $rows->image4."\t";
    $row .= "'".$rows->body1."'"."\t";
	//$row .= " \t";
	$row .= $rows->url."\t";
	$row .= $rows->status."\t";
	$row .= $rows->show_home."\t";
	$row .= $rows->porder."\t";
	$row .= $rows->submitdate."\t";
	$row .= $rows->size."\t";
	$row .= $rows->price."\t";
	$row .= $rows->offerprice."\t";
	$row .= $rows->shipping."\t";
	$row .= $rows->discount."\t";
	$row .= $rows->color."\t";
	$inerQery = mysql_query("select ftitle,fdescription FROM fz_product_feature where prod_id = '".$rows->pid."' ");
	if(mysql_num_rows($inerQery)){
		while($ks = mysql_fetch_object($inerQery)){
			$row .= $ks->ftitle."\t";
			$row .= $ks->fdescription."\t";
		}
	}
	$data .= trim($row)."\n";
}
$data = str_replace("\r", "", $data);
$name=rand().'-list.xls';
header("Content-type:application/vnd.ms-excel;name='excel'");
header("Content-Disposition: attachment; filename=$name");
header("Pragma: no-cache");
header("Expires: 0");

echo $header.$data;
?>