<!-- <link rel="stylesheet" href="<?=SITE_PATH_ADM?>css/demos.css" type="text/css" media="screen" /> -->

<table width="100%" border="0" cellpadding="0" cellspacing="0" >
  <tr>
    <td valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" >
        <tr>
          <td width="51%" rowspan="7" valign="top"><div class="div-tbl">
              <table class="dasTab">
                <tr class="heading">
                  <td colspan="4"><span class="tabTitle">Lifetime Sales</span></td>
                </tr>
                <?php $result2 = $cms->db_query("select sum(paynet) as tots from #_order_summary where 1 ");
if(mysql_num_rows($result2)){
	$line3 = $cms->db_fetch_array($result2)
	?>
                <tr class="tabDeferent">
                  <td colspan="4" align="center" valign="middle" style="font-size:25px;"><?=CUR.number_format($line3[tots],2)?></td>
                </tr>
                <?php } else{?>
                <tr class="tabDeferent">
                  <td colspan="4" >No Lifetime Sales!!</td>
                </tr>
                <?php } ?>
              </table>
            </div>
						
			
            <div class="div-tbl" style="margin-top: -10px;">
              <table class="dasTab">
                <tr class="heading">
                  <td colspan="4"><span class="tabTitle">Last 5 Orders</span></td>
                </tr>
                <tr class="colTitle">
                  <td width="35">#</td>
                  <td width="417">Customer</td>
                  <td width="186">Item</td>
                  <td width="168">Grand Total</td>
                </tr>
                <?php $result = $cms->db_query("select * from #_order_summary where 1  ".$admlog." order by `orderid` DESC limit 0, 5");
if(mysql_num_rows($result)){
	$nums=1; while ($line = $cms->db_fetch_array($result)){@extract($line);
$result3 = $cms->db_query("select * from #_order_summary where 1 and `orderid`='".$orderid."' ".$admlog." ");
$qty = $cms->db_scalar("select count(*) from #_order_summary where `orderid`='".$orderid."'");
	?>
                <tr class="tabDeferent">
                  <td width="35" ><?=$nums?></td>
                  <td width="417"><?=ucfirst($cms->getSingleresult("select fname from #_members where `pid`='".$uid."'"))?></td>
                  <td width="186"><?=$qty?></td>
                  <td width="168"><?=CUR.number_format($paynet, 2)?></td>
                </tr>
                <?php $nums++;} } else{?>
                <tr class="tabDeferent">
                  <td colspan="4" >No current orders!!</td>
                </tr>
                <?php } ?>
              </table>
            </div>
            <div class="div-tbl" style="margin-top: -10px;">
              <table class="dasTab">
                <tr class="heading">
                  <td colspan="4"><span class="tabTitle">Pending Store/Brand Request</span></td>
                </tr>
                <tr class="colTitle">
                  <td width="35">#</td>
                  <td width="417">Name/Type</td> 
				  <td width="186">Join Time</td>
                  <td width="168">Status</td>
                </tr>
                <?php $result = $cms->db_query("select name,pid,type,status,date_of_join from #_store_user where status = 'Inactive'  order by `pid` DESC ");
if(mysql_num_rows($result)){
	$nums=1; while ($line = $cms->db_fetch_array($result)){@extract($line);
?>
                <tr class="tabDeferent">
                  <td width="35"><?=$nums?></td>
				  <td width="417"><a href="<?=SITE_PATH_ADM?>users/?mode=add&id=<?=$pid?>"><strong><?=$name?>/<?=$type?></strong></a></td>
                   <td width="186"><?=date("d M, Y, H:i:s",strtotime($date_of_join))?></td>
                  <td width="168"><?=$status?></td>
                </tr>
                <?php $nums++;} } else{?>
                <tr class="tabDeferent">
                  <td colspan="4" >No Pending Request!</td>
                </tr>
                <?php } ?>
              </table>
            </div>
			<div class="div-tbl" style="margin-top: -10px;">
              <table class="dasTab">
                <tr class="heading">
                  <td colspan="4"><span class="tabTitle">Last 5 Search Terms </span></td>
                </tr>
                <tr class="colTitle">
                  <td width="35">#</td>
                  <td width="417">Search Term</td>
                  <td width="186">Store/Brand</td>
                  <td width="168">Date</td>
                </tr>
                <?php $result = $cms->db_query("select * from #_searchkey where 1  order by `pid` DESC limit 0, 5");
if(mysql_num_rows($result)){
	$nums=1; while ($line = $cms->db_fetch_array($result)){@extract($line);
?>
                <tr class="tabDeferent">
                  <td width="35"><?=$nums?></td>
                  <td width="417"><?=$keywords?></td>
                  <td width="186"><?=$cms->getSingleresult(" SELECT title FROM #_store_detail where store_user_id ='$store_id' ")?></td>
                  <td width="168"><?=date('j F, Y', strtotime($dt))?></td>
                </tr>
                <?php $nums++;} } else{?>
                <tr class="tabDeferent">
                  <td colspan="4" >No current orders!!</td>
                </tr>
                <?php } ?>
              </table>
            </div></td>
          <td width="2%">&nbsp;</td>
		  <td width="51%" valign="top"><div class="div-tbl">
              <table class="dasTab">
                <tr class="heading">
                  <td colspan="4"><span class="tabTitle">Brief Details</span></td>
                </tr>
				  <tr class="colTitle">
                  <td width="35">&nbsp;</td>
                  <td width="417">Total Active Store/Brand</td> 
				  <td width="186">Total Active Users</td>
                  <td width="168">&nbsp;</td>
                </tr>  
                <?php $result21= $cms->db_query("select count(*) as tots from #_store_user where status = 'Active'");
$user_tot=mysql_num_rows($result21); 
	$line31 = $cms->db_fetch_array($result21);  
	?>
	<?php $result22= $cms->db_query("select count(*) as tots from #_members where status = 'Active'");
$member_tot=mysql_num_rows($result22);
	$line32 = $cms->db_fetch_array($result22); 
	?>
                  <tr class="tabDeferent"> 
                  <td width="35">&nbsp;</td>
                  <td width="417"><?=$line31[tots]?></td> 
				  <td width="186"><?=$line32[tots]?></td>
                  <td width="168">&nbsp;</td>
                </tr>              
				
				  <?php  if($user_tot='' || $member_tot='' ){?>
                <tr class="tabDeferent">
                  <td colspan="4" >No Active Store/Brand!!</td>
                </tr>
                <?php } ?>
              </table>
            </div>
			
 			
			<? include "quicklinks.php";?>
</td>
		  <!--- new ------------------------>
		 
			
			<!---   end  ------------>

        </tr>
		
        <tr>
		
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td valign="top"></td>
          <td width="2%" valign="top"></td>
          <td width="47%" valign="top"></td>
        </tr>
        <tr>
          <td valign="top"></td>
          <td valign="top">&nbsp;</td>
          <td valign="top"></td>
        </tr>
        <tr>
          <td valign="top">&nbsp;</td>
          <td valign="top">&nbsp;</td>
          <td valign="top">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
