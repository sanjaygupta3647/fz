<?php  
if(!$_SESSION[userid]){ 
	$redpath2 = SITE_PATH;
	$cms->redir($redpath2,true);die;
} 
$rsAdmin2=$cms->db_query("select * from #_members where pid='".$_SESSION[userid]."'");
$result=$cms->db_fetch_array($rsAdmin2);	 	
extract($result);	   
?>
<div class="tabdiv_right1 5">
  <h2>Welcome
    <?=$fname."  ".$lname;?> !
  </h2>
  <div class="tabdiv_right1_info">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <th align="left" valign="top" bgcolor="ffefdc" class="thead-of_details">
		<!-- Personal and Contact details of your account are given below : -->
		 <div id="succeDiv">  </div></th>
      </tr><form name="" action="" method="post">
      <tr>
        <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td align="left" valign="top"><table width="100%" border="0" cellspacing="5" cellpadding="5" class="details_text">
                   
                </table></td>
            </tr>
            <tr bgcolor="#FFFFFF">
              <td align="left" valign="top"><table width="100%" border="0" cellspacing="5" cellpadding="5" class="details_text">
                  <tr bgcolor="#FFF8F0">
                    <td width="20%" align="left" valign="top"><b>Old Password:</b></td>
                    <td width="80%" align="left" valign="top"><input type="password" name="password" id="password1" value="" size="32" /></td>
                 <input type="hidden" name="password1" id="password1" value="<?=$password?>" size="32" />
				 
				  </tr> 
                  <tr bgcolor="#FFFFFF">
                    <td width="20%" align="left" valign="top"><b>New Password:</b></td>
                    <td width="80%" align="left" valign="top"><input type="password" name="password" id="password" value="" size="32" /></td>
                  </tr>
                  
                  <tr bgcolor="#FFFFFF">
                    <td width="20%" align="left" valign="top"><b>Re-Enter Password:</b></td>
                    <td width="80%" align="left" valign="top"><input type="password" name="password-check" id="password-check" value="" size="32" /></td>
                  </tr>
                  
                  
				   <tr bgcolor="#FFF8F0">
				   <td width="20%" align="left" valign="top">&nbsp;</td>
                      <td  align="left">   
                     <input type="button" value="Submit" id="passsubmit" class="proceedbtn" />
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
