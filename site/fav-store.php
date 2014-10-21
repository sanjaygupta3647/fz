<?php  
if(!$_SESSION[userid]){ 
	$redpath2 = SITE_PATH;
	$cms->redir($redpath2,true);die;
}
$rsAdmin2=$cms->db_query("select * from #_members where pid='".$_SESSION[userid]."'");
$result=$cms->db_fetch_array($rsAdmin2);
extract($result);
?>
<div class="tabdiv_right3 3">
          <h2>Your favourite store(s)</h2>
          <div class="tabdiv_right1_info"><?php
	 
	 $ordercheck=$cms->db_query("select store_id from #_member_access where user_id = '".$_SESSION['userid']."' ");
	 if(mysql_num_rows($ordercheck)){?> 
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td align="left" valign="top" bgcolor="#EFEFEF" class="store_like_class">Stores You Like are here:</td>
                    </tr>
                    <tr>
                      <td align="left" valign="top" bgcolor="#f3f3f3"><table width="100%" border="0" cellspacing="5" cellpadding="5" class="fav_store">
                          <?php
		 $i = 1;
	 while($res =$cms->db_fetch_array($ordercheck)){?>
	 <tr>
	 <td width="3%" align="center" valign="middle"><?=$i?></td>
	 <?php $web = $cms->getSingleresult("select title from #_store_detail where pid='".$res[store_id]."'");
	       $store_url = $cms->getSingleresult("select store_url from #_store_detail where pid='".$res[store_id]."'");
		   $theme = $cms->getSingleresult("select theme from #_store_detail where pid='".$res[store_id]."'"); ?>
	 <td width="17%" align="left" valign="top"><?=$web?></td>
	 <td width="80%" align="left" valign="middle">Click <a class="id_click_link" onClick='return confirm("Are you sure to leave this store, you will be logout form this site.");' href="http://<?=$store_url?>.fizzkart.com/<?=$theme?>"> here</a> to go <?=$web?> website
	 </td> 
	 </tr>
	 <tr bgcolor="#fff">
     <td colspan="3" align="left" valign="top">&nbsp;</td>
     </tr>
	 <?php  $i++;
	 } ?>
	 </table><?php
	 } 
	 ?>
                        </table></td>
                    </tr>
                    </table> </td>
             </tr>
            </table> 
          </div>
        </div>