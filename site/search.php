<?php
$ssid = session_id();
$metaTitle = "Fizzkart Search Products, Brand and Stores";
$metaIntro = "Fizzkart Search Products, Brand and Stores";
$metaKeyword = "Fizzkart, Search Products, Brand and Stores";
if($_GET[key]){
	$checkkey  = $cms->getSingleresult("select count(*) from #_searchkey where keywords = '".$_GET[key]."' and searchtype ='".$_GET[searchfor]."' and store_id = '0' and  ssid = '$ssid' ");	
	if(!$checkkey){
		$cms->db_query("insert into #_searchkey set keywords = '".$_GET[key]."', store_id = '0',searchtype ='".$_GET[searchfor]."', ssid = '$ssid' ");	
	}
}
?>
<?php if($_GET[searchfor]=='product') include "site/search-prod.php"; else include "site/search-store.php"; ?>