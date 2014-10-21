<?php  
if(!$_SESSION[userid]){ 
	$redpath2 = SITE_PATH;
	$cms->redir($redpath2,true);die;
} if($_POST[submit]=="Update"){
   $cms->sqlquery("rs","members",$_POST,'pid',$_SESSION[userid]); 
	echo '<p style="color:green;">Record has been updated</p>';
	  }
	
$rsAdmin2=$cms->db_query("select * from #_members where pid='".$_SESSION[userid]."'");
$result=$cms->db_fetch_array($rsAdmin2);	 	
extract($result);	   
?>
<div class="tabdiv_right1 4">
  <h2>Welcome 
    <?=$fname."  ".$lname;?> !
  </h2>
  <div class="tabdiv_right1_info">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <th align="left" valign="top" bgcolor="ffefdc" class="thead-of_details">
		 Personal details of your account are given below :
		 <span id="succDiv"> <span></th>
      </tr><form name="" action="" method="post">
      <tr>
        <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td align="left" valign="top"><table width="100%" border="0" cellspacing="5" cellpadding="5" class="details_text">
                  <tr bgcolor="#FFFFFF">
				  
                    <td width="20%" align="left" valign="top"><b>First Name:</b></td>
                    <td width="80%" align="left" valign="top"><input name="fname" id="fname" type="text" lang="RisAlph" value="<?=$fname?>" /></td>
                 <!--   <td width="20%" align="center" valign="top" class="edit_detail_button"><a href="#">Edit Details</a></td> -->
                  </tr>
                </table></td>
            </tr>
            <tr bgcolor="#FFFFFF">
              <td align="left" valign="top"><table width="100%" border="0" cellspacing="5" cellpadding="5" class="details_text">
                  <tr bgcolor="#FFF8F0">
                    <td width="20%" align="left" valign="top"><b>Last Name :</b></td>
                    <td width="80%" align="left" valign="top"><input id="lname"  name="lname" lang="RisAlph" type="text" value="<?=$lname?>"/></td>
                  </tr>
                  <tr bgcolor="#FFFFFF">
                    <td width="20%" align="left" valign="top"><b>Email :</b></td>
                    <td width="80%" align="left" valign="top"><input name="email" id="email" type="text" ang="RisEmail" value="<?=$email?>"/></td>
                  </tr>
                  <tr bgcolor="#FFF8F0">
                    <td width="20%" align="left" valign="top"><b>Gender :<?=$gender?></b></td>
                    <td width="80%" align="left" valign="top">Male<input name="gender"  type="radio" lang="R" value="Male" <? if($gender=="Male"){ echo 'checked="checked"'; } ?>/>
					Female<input name="gender" type="radio" id="gender" lang="R" value="Female" <? if($gender=="Female"){ echo 'checked="checked"'; }?> /></td>
                  </tr>
                  <tr bgcolor="#FFFFFF">
                    <td width="20%" align="left" valign="top"><b>Mobile :</b></td>
                    <td width="80%" align="left" valign="top"><input name="mob" id="mob" type="text" lang="RisMobile" value="<?=$mob?>"  /></td>
                  </tr>
                  <tr bgcolor="#FFF8F0">
                    <td width="20%" align="left" valign="top"><b>City :</b></td>
                    <td width="80%" align="left" valign="top"><input name="city" id="city" type="text" lang="RisAlphaNum" value="<?=$city?>" /></td>
                  </tr>
                  <tr bgcolor="#FFFFFF">
                    <td width="20%" align="left" valign="top"><b>State :</b></td>
                    <td width="80%" align="left" valign="top"><input name="state" id="state" type="text" lang="RisAlphaNum"  value="<?=$state?>" /></td>
                  </tr>
                  <tr bgcolor="#FFFFFF">
                    <td align="left" valign="top"><b>Zip code :</b></td>
                    <td align="left" valign="top"><input name="zipcode" id="zipcode" type="text" lang="RisNaN" value="<?=$zipcode?>"/></td>
                  </tr>
                  <tr bgcolor="#FFF8F0">
                    <td width="20%" align="left" valign="top"><b>Address :</b></td>
                    <td width="80%" align="left" valign="top"><input name="address" id="address" lang="R" type="text" value="<?=$address?>" /></td>
                  </tr>
				   <tr bgcolor="#FFF8F0">
				   <td width="20%" align="left" valign="top">&nbsp;</td>
                      <td  align="left">   
                      <input type="submit"  id="profile_edit" name="submit" value="Update"  class="proceedbtn" />
					 </td>
                  </tr>
                </table></td>
				
            </tr>
          </table></td>
		 </form> 
      </tr>
    </table>
	
  </div>
</div>
