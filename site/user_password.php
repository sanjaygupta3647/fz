 <?php
$rsAdmin=$cms->db_query("select * from #_store_user");
	while($arrAdmin=$cms->db_fetch_array($rsAdmin))
	{
		@extract($arrAdmin);
		$update=1;
		$password2=$cms->decryptcode($password);   
		//echo $user_name. " and " .$password2 ."<br/>";
		 
	    //$cms->db_query("update fz_store_user set password='$password2' where pid='$pid'"); 
	}

/* $email = "sanaj.vcc@eee.co.in";
 $check = preg_match('/^([a-z0-9]+([_\.\-]{1}[a-z0-9]+)*){1}([@]){1}([a-z0-9]+([_\-]{1}[a-z0-9]+)*)+(([\.]{1}[a-z]{2,6}){0,3}){1}$/i', $email);
 echo ($check)?'yes':'No';
 
 /*
 $rsAdmin2=$cms->db_query("select store_url from #_store_detail ");
 $i = 1;
 while($result=$cms->db_fetch_array($rsAdmin2)){
 extract($result);
	echo $i." ==>  ".$store_url."<br/>";
	$i++;
 }
*/
 ?>
		