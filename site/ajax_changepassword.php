<?php 
	 $newpass=$_POST['newpass'];
	 $oldpass=$_POST['pass'];
	 $password=$cms->encryptcode($newpass);
	 $password_old = $cms->getSingleresult("select password from #_members where pid='".$_SESSION[userid]."'");
	 $password_old =$cms->decryptcode($password_old);
	 $array[password]= $password;
	// $ary[0]= $password;
	if($password_old==$oldpass){
		 $cms->sqlquery("rs","members",$array,'pid',$_SESSION[userid]); 
		 echo '<p style="color:green;">Password has been updated!</p>';
	 }else{
			 echo '<p style="color:red;">Old Password do not match!</p>';
	  }
?>
 