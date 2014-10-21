<?php 
include("../../lib/opin.inc.php");
$fetch = $_GET[fetch];
$val = $cms->getSingleresult("select $fetch from #_template where title = '".$_GET[mailon]."' and store_id = '0' ");
$cont = 'src="http://fizzkart.com/images/logo.jpg"';
$hedlogo = $cms->getSingleresult("select image from #_store_detail where store_user_id = '".$_SESSION[uid]."'"); 
$img = "http://fizzkart.com/uploaded_files/orginal/".$hedlogo; 
$rep = 'src="'.$img.'" style="max-height:50px;"';
$val = str_replace($cont,$rep,$val);
echo $val;

?>

