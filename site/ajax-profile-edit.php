<?php 
	//print_r($_POST);
	$cms->sqlquery("rs","members",$_POST,'pid',$_SESSION[userid]); 
	echo '<p style="color:green;">Record has been updated</p>';
?>
 