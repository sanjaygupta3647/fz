<?php 
 
include "site/search.inc.php";

?>
<?php  
if(!$_SESSION[userid]){ 
$redpath = SITE_PATH;
$cms->redir($redpath,true);die;
}
$rsAdmin2=$cms->db_query("select * from #_members where pid='".$_SESSION[userid]."'");
$result=$cms->db_fetch_array($rsAdmin2);
extract($result);
?>
<div class="transaction_maindiv">
  <div class="main_tabdiv">
        <div class="tabdiv_heading"><h1>Your Transcation Details</h1></div>
      <div class="tabdiv_areas">
<div  class="profile_tabs">
 <?php include "user-tabs.php";  ?> 
  
  <div class="selected">
    <?php
	 
	 $ordercheck=$cms->db_query("select store_id from #_member_access where user_id = '".$_SESSION['userid']."' ");
	 if(mysql_num_rows($ordercheck)){?> 
	 <table border="0" style="float: left;" class="CSSTableGenerator"> 
	 <tr style="height:30px; color:black"><th align="left" colspan="2">My Fabourite Store(s)</th></tr> 
	 <?php
		 $i = 1;
	 while($res =$cms->db_fetch_array($ordercheck)){?>
	 <tr>
	 <td><?=$i?></td>
	 <?php $web = $cms->getSingleresult("select title from #_store_detail where pid='".$res[store_id]."'");
	       $store_url = $cms->getSingleresult("select store_url from #_store_detail where pid='".$res[store_id]."'");
		   $theme = $cms->getSingleresult("select theme from #_store_detail where pid='".$res[store_id]."'"); ?>
	 <td><?=$web?>
	 &nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	 Click <a onClick='return confirm("Are you sure to leave this store, you will be logout form this site.");' href="http://<?=$store_url?>.fizzkart.com/<?=$theme?>"> here</a> to go <?=$web?> website
	 </td> 
	 </tr>
	 <tr><td colspan="2">&nbsp;</td></tr>
	 <?php 
	 } ?>
	 </table><?php
	 } 
	 ?>
  </div>
</div>
 
   
 