<? if($items[3])
	{  
	  
      $rsAdmin=$cms->db_query("select user_name from #_store_user where user_name='".$items[3]."'");
	  if(mysql_num_rows($rsAdmin)){
	 				 $er= '<p align="left" style="color:red; margin:10px 0; display:block; " >This user name is already exist!</p>'; 
	  }else{
	     $er= '<p align="left" style="color:green; margin:10px 0; display:block; " >This user name is available!</p>';
	  } 	
	} 
	echo $er;
?>

