<?php
$metaTitle = $cms->getSingleresult("select meta_title from #_meta_info where url='profile' and store_user_id = '$current_store_user_id'");
$metaIntro = $cms->getSingleresult("select meta_description from #_meta_info where url='profile' and store_user_id = '$current_store_user_id'");
$metaKeyword = $cms->getSingleresult("select meta_keyword from #_meta_info where url='profile' and store_user_id = '$current_store_user_id'"); 
$value=$_COOKIE["user_id"]; 
if($value){
  $_SESSION[user_store_id]=$current_store_id;
  $_SESSION[userid]=$value; 
  $_SESSION[uid]=$value;
  }
if(!$_SESSION[userid]){ 
$redpath2 = SITE_PATH;
$cms->redir($redpath2,true);die;
}
$rsAdmin2=$cms->db_query("select * from #_members where pid='".$_SESSION[userid]."'");
$result=$cms->db_fetch_array($rsAdmin2);
extract($result);
$_SESSION[fname]=$fname;
?>

<div  class="profile_tabs">
  <?php include "user-tabs.php";  ?>
  <div class="selected">
    <table border="0" style="float: left;" class="CSSTableGenerator">
      <tr>
        <th colspan="2"><h3 class="profile_change_title">Welcome <?=$fname?></h3></th>
      </tr>
      <tr class="profile_change_name_clr">
        <td width="15%">First Name :</td>
        <td><?=$fname?></td>
      </tr>
      <tr>
        <td>Last Name :</td>
        <td><?=$lname?></td>
      </tr>
      <tr>
        <td>Email :</td>
        <td><?=$email?></td>
      </tr>
      <tr>
        <td>Mobile :</td>
        <td><?=$mob?></td>
      </tr>
      <tr>
        <td>City :</td>
        <td><?=$city?></td>
      </tr>
      <tr>
        <td>State :</td>
        <td><?=$state?></td>
      </tr>
      <tr>
        <td>Address :</td>
        <td><?=$address?></td>
      </tr>
      <tr>
        <td>Zipcode :</td>
        <td><?=$zipcode?></td>
      </tr>
      <?php $redpath = SITE_PATH."profile_edit"; ?>
      <tr>
        <td>&nbsp</td>
        <td><p><strong>To edit your profile click <a href="<?=$redpath?>" class="hyper_profile_edit">here</a></strong></p></td>
      </tr>
    </table>
  </div>
</div>
