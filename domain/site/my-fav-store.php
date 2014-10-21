<?php 
$metaTitle = $cms->getSingleresult("select meta_title from #_meta_info where url='my-fabourite-store' and store_user_id = '$current_store_user_id'");
$metaIntro = $cms->getSingleresult("select meta_description from #_meta_info where url='my-fabourite-store' and store_user_id = '$current_store_user_id'");
$metaKeyword = $cms->getSingleresult("select meta_keyword from #_meta_info where url='my-fabourite-store' and store_user_id = '$current_store_user_id'");

if(!$_SESSION[userid]){ 
$redpath = SITE_PATH;
$cms->redir($redpath,true);die;
}
$rsAdmin2=$cms->db_query("select * from #_members where pid='".$_SESSION[userid]."'");
$result=$cms->db_fetch_array($rsAdmin2);
extract($result);
?>

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
	 <td><div style="width:100px; float:left;"><?=$web?></div>
     <span style="float:left; margin:0 20px;">|</span>
	 <div style="float:left;">Click <a onClick='return confirm("Are you sure to leave this store, you will be logout form this site.");' href="http://<?=$store_url?>.fizzkart.com/<?=$theme?>"> here</a> to go <?=$web?> website</div>
	 </td> 
	 </tr>
     <!------write code here to add a table row------>
	 <?php $i++;
	 } ?>
	 </table><?php
	 } 
	 ?>
  </div>
</div>
 