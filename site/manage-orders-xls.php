<?php 
$header = "User Name \t Order ID \t Amount \t Time \t Status\n ";   
if($_SESSION[uid]){  
			$prodQry = $cms->db_query("select * from #_order_summary where store_id='".$_SESSION[uid]."' ");   
			 while($rows = mysql_fetch_object($prodQry)){ 
			    $fname=$cms->getSingleresult("select fname from #_members where pid='".$rows->uid."' "); 
				$lname=$cms->getSingleresult("select lname from #_members where pid='".$rows->uid."' "); 
				$name=$fname." ".$lname;
				$date = date('j F, Y, h:m:s a', strtotime($rows->submitdate));
				$row .= $cms->removeSlash($name)."\t";  
				$row .= $cms->removeSlash($rows->orderid)."\t"; 
				$row .= $cms->removeSlash($rows->totalCost)."\t";
				$row .= $date."\t";
				if(!$rows->status) $rows->status = 'NA';
				$row .= $cms->removeSlash($rows->status)."\n";  
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