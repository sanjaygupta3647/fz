<?php include("../../lib/opin.inc.php");?> 
<?php
if($_GET[prods]){
$pro = explode(",",$_GET[prods]);
	if(count($pro)){
		$tot = 0;
		$content = "";
		foreach($pro as $val){
			if($val){
				$v = explode('$$',$val); 
				$price = $cms->getPriceSize($v[0],$_SESSION[uid],$v[1]); 
				$content .= " Rs. $price +";
				$tot  =$tot + $price;
			}  
		}
		$content = substr($content,0,-1);
	}
}

echo "$content = Rs. $tot";	
?>
 

