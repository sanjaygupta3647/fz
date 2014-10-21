<?php  
if(!$_SESSION[userid]){ 
	$redpath2 = SITE_PATH;
	$cms->redir($redpath2,true);die;
}
$rsAdmin2=$cms->db_query("select * from #_members where pid='".$_SESSION[userid]."'");
$result=$cms->db_fetch_array($rsAdmin2);
extract($result);
?>
<div class="tabdiv_right1 1">
  <h2>Welcome 
    <?=$fname."  ".$lname;?> !
  </h2>
  <div class="tabdiv_right1_info">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <th align="left" valign="top" bgcolor="ffefdc" class="thead-of_details">Personal details of your account are given below :</th>
      </tr>
      <tr>
        <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td align="left" valign="top"><table width="100%" border="0" cellspacing="5" cellpadding="5" class="details_text">
                  <tr bgcolor="#FFFFFF">
                    <td width="20%" align="left" valign="top"><b>First Name :</b></td>
                    <td width="60%" align="left" valign="top"><?=$fname?></td>
                    <td width="20%" align="center" valign="top" class="edit_detail_button"> <div class="tabdiv_left4"><a href="javascript:void(0)" lang="edit-profile" class="noclass"  id="4">Edit Details</a></div><!--<a href="#">Edit Details</a> --></td>
                  </tr>
                </table></td>
            </tr>
            <tr bgcolor="#FFFFFF">
              <td align="left" valign="top"><table width="100%" border="0" cellspacing="5" cellpadding="5" class="details_text">
                  <tr bgcolor="#FFF8F0">
                    <td width="20%" align="left" valign="top"><b>Last Name :</b></td>
                    <td width="80%" align="left" valign="top"> <?=$lname?></td>
                  </tr>
                  <tr bgcolor="#FFFFFF">
                    <td width="20%" align="left" valign="top"><b>Email :</b></td>
                    <td width="80%" align="left" valign="top"><?=$email?></td>
                  </tr>
                  <tr bgcolor="#FFF8F0">
                    <td width="20%" align="left" valign="top"><b>Gender :</b></td>
                    <td width="80%" align="left" valign="top"><?=$gender?></td>
                  </tr>
                  <tr bgcolor="#FFFFFF">
                    <td width="20%" align="left" valign="top"><b>Mobile :</b></td>
                    <td width="80%" align="left" valign="top"><?=$mob?></td>
                  </tr>
                  <tr bgcolor="#FFF8F0">
                    <td width="20%" align="left" valign="top"><b>City :</b></td>
                    <td width="80%" align="left" valign="top"><?=$city?></td>
                  </tr>
                  <tr bgcolor="#FFFFFF">
                    <td width="20%" align="left" valign="top"><b>State :</b></td>
                    <td width="80%" align="left" valign="top"><?=$state?></td>
                  </tr>
                  <tr bgcolor="#FFFFFF">
                    <td align="left" valign="top"><b>Zip code :</b></td>
                    <td align="left" valign="top"><?=$zipcode?></td>
                  </tr>
                  <tr bgcolor="#FFF8F0">
                    <td width="20%" align="left" valign="top"><b>Address :</b></td>
                    <td width="80%" align="left" valign="top"><?=$address?></td>
                  </tr>
                </table></td>
            </tr>
          </table></td>
      </tr>
    </table>
  </div>
</div>
