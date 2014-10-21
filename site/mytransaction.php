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
	
  </div>
</div>
 