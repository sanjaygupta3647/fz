<? if($items[2])
{     
	  $checkemail = $cms->checkEmail($items[2]);
	  if($checkemail){
	  $check=$cms->getSingleresult("SELECT  count(*) from #_subscribe_list where email='".$items[2]."' ");
	  if(!$check){
					$cms->db_query("insert into #_subscribe_list set email='".$items[2]."', status = 'Active',store_id='0' ");
					echo"<font style='color:green;'>Thank you for successful subscription.</font>";
					$adminEmail = SITE_MAIL;
					$headers = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					$headers .= 'From: Fizzkart@fizzkart.com' . "\r\n" .'CC: '.$adminEmail; 				 
					$ch = $cms->db_query("select * from #_template where title ='News Letter' and store_id = '0' ");				 
					$tempRes = $cms->db_fetch_array($ch);
					$subject2 = $tempRes[subject]; 
					$mess2 = $tempRes[body]; 
					$mess2 = str_replace("%%email%%", $items[2],$mess2);
					@mail($items[2],$subject2, $mess2,$headers);
				 } 
			else echo"<font style='color:red;'>Already registered email id</font>";
	  }else{
			echo"<font style='color:red;'>Please enter a valid email id </font>";
	  }
	   
}
	 
?>

