<?php 
$header = "Name \t Email \t Confirm Orders \t Pending Orders \t Cancle Orders \t Confirm Amount \t Pending Amount \t Cancle Amount \t Status\n "; 
$arr[] = 0; 
	$qry = $cms->db_query("select user_id from #_member_access where store_id ='".$_SESSION[store_id]."'");
	if(mysql_num_rows($qry)){
		while ($res = $cms->db_fetch_array($qry)){@extract($res); 
			if($user_id) $arr[] = $user_id;
		}	
	}
if($_SESSION[uid]){  
			$prodQry = $cms->db_query("select * from #_members where pid in (".implode(',',$arr).") ");  
			 while($rows = mysql_fetch_object($prodQry)){ 
			    $fname=$cms->getSingleresult("select fname from #_members where pid='".$rows->pid."' "); 
				$lname=$cms->getSingleresult("select lname from #_members where pid='".$rows->pid."' "); 
				$name=$fname." ".$lname;
				$row .= $cms->removeSlash($name)."\t"; 
				$row .= $cms->removeSlash($rows->email)."\t"; 
				$confirm_order=$cms->getSingleresult("select count(*) from fz_order_summary where uid ='".$rows->pid."' and store_id = '".$_SESSION[uid]."' and status = 'complete'");
				$row .= $cms->removeSlash($confirm_order)."\t";  
				$pending_order=$cms->getSingleresult("select count(*) from fz_order_summary where uid ='".$rows->pid."' and store_id = '".$_SESSION[uid]."' and status = 'pending'"); 
				if(!$pending_order) {$pending_order = 'NA';}
				$row .=  $cms->removeSlash($pending_order)."\t"; 
				$cancle_order=$cms->getSingleresult("select count(*) from fz_order_summary where uid ='".$rows->pid."' and store_id = '".$_SESSION[uid]."' and status = 'cancle'");
				if(!$cancle_order) {$cancle_order = 'NA';}
				$row .=  $cms->removeSlash($cancle_order)."\t"; 
				$confirm_amount=(int)$cms->getSingleresult("select sum(paynet) from fz_order_summary where uid ='".$rows->pid."' and store_id = '".$_SESSION[uid]."' and status = 'complete'");
				if(!$confirm_amount) {$confirm_amount = 'NA';
				}else{
				$confirm_amount="Rs."." ".$confirm_amount;
				}
				$row .=  $cms->removeSlash($confirm_amount)."\t"; 
				$pending_amount=(int)$cms->getSingleresult("select sum(paynet) from fz_order_summary where uid ='".$rows->pid."' and store_id = '".$_SESSION[uid]."' and status = 'pending'");
				if(!$pending_amount) {$pending_amount = 'NA';
				}else{
				$pending_amount="Rs."." ".$pending_amount; 
				}
				$row .=  $cms->removeSlash($pending_amount)."\t"; 
				$cancle_amount=(int)$cms->getSingleresult("select sum(paynet) from fz_order_summary where uid ='".$rows->pid."' and store_id = '".$_SESSION[uid]."' and status = 'cancle'");
				if(!$cancle_amount) {$cancle_amount = 'NA';
				}else{
				$cancle_amount="Rs."." ".$cancle_amount;
				}
				$row .=  $cms->removeSlash($cancle_amount)."\t"; 
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