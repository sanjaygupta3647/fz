<!-- <link rel="stylesheet" href="<?=SITE_PATH_ADM?>css/demos.css" type="text/css" media="screen" /> -->
<table width="100%" border="0" cellpadding="0" cellspacing="0" >
<tr>
  <td valign="top"><div class="div-tbl half" style="margin-top: -10px;">
    <table width="100%" border="0" cellpadding="0" cellspacing="0" >
      <tr>
        <td width="50%" valign="top"><div class="div-tbl half">
          <table class="dasTab">
            <tr class="heading">
              <td colspan="4"><span class="tabTitle">Lifetime Sales</span></td>
            </tr>
            <?php $result2 = $cms->db_query("select sum(amount) as tots from #_orders where 1 ");
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
          <div class="div-tbl half" style="margin-top: -10px;">
            <table class="dasTab">
              <tr class="heading">
                <td colspan="4"><span class="tabTitle">Average Sales</span></td>
              </tr>
              <?php 
	if(mysql_num_rows($result2)){
	$avgorders = $cms->db_scalar("select count(*) from #_orders where 1 ");
	?>
              <tr class="tabDeferent">
                <td colspan="4" align="center" valign="middle" style="font-size:25px;"><?=CUR.number_format(($line3[tots]/$avgorders),2)?></td>
              </tr>
              <?php } else{?>
              <tr class="tabDeferent">
                <td colspan="4" >No Lifetime Sales!!</td>
              </tr>
              <?php } ?>
            </table>
          </div>
          <div class="div-tbl half" style="margin-top: -10px;">
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
              <?php $result = $cms->db_query("select * from #_orders where 1  ".$admlog." order by `pid` DESC limit 0, 5");
if(mysql_num_rows($result)){
	$nums=1; while ($line = $cms->db_fetch_array($result)){@extract($line);
$result3 = $cms->db_query("select * from #_orders where 1 and `orderid`='".$orderid."' ".$admlog." ");
$qty = $cms->db_scalar("select count(*) from #_orders where `orderid`='".$orderid."'");
	?>
              <tr class="tabDeferent">
                <td width="35" ><?=$nums?></td>
                <td width="417"><?=ucfirst($cms->getSingleresult("select name from #_members where `pid`='".$uid."'"))?></td>
                <td width="186"><?=$qty?></td>
                <td width="168"><?=CUR.number_format($amount, 2)?></td>
              </tr>
              <?php $nums++;} } else{?>
              <tr class="tabDeferent">
                <td colspan="4" >No current orders!!</td>
              </tr>
              <?php } ?>
            </table>
          </div>
          <div class="div-tbl half" style="margin-top: -10px;">
            <table class="dasTab">
              <tr class="heading">
                <td colspan="4"><span class="tabTitle">Last 5 Search Terms </span></td>
              </tr>
              <tr class="colTitle">
                <td width="35">#</td>
                <td width="417">Search Term</td>
                <td width="186">Results</td>
                <?php /*?> <td width="168">Number of Uses</td><?php */?>
              </tr>
              <?php $result = $cms->db_query("select * from #_search where 1  order by `id` DESC limit 0, 5");
if(mysql_num_rows($result)){
	$nums=1; while ($line = $cms->db_fetch_array($result)){@extract($line);
?>
              <tr class="tabDeferent">
                <td width="35"><?=$nums?></td>
                <td width="417"><?=$keyword?></td>
                <td width="186"><?=$title?></td>
                <!--  <td width="168"><?=$hits?></td>-->
              </tr>
              <?php $nums++;} } else{?>
              <tr class="tabDeferent">
                <td colspan="4" >No current orders!!</td>
              </tr>
              <?php } ?>
            </table>
          </div></td>
          <td></td>
      </tr>
      <tr>
        <td valign="top"><?php 
		
		/*?><div class="tbl-contant">
          <div class="sb-wrap-all">
            <div class="sb-wrap"><a href="<?=$adm->iurl('pages')?>" class="section-box"><img src="images/cms-manager.png" width="43" height="56" /> <span>CMS</span> Manager </a> </div>
            <div class="sb-wrap"><a href="<?=$adm->iurl('adm')?>" class="section-box"><img src="images/user_manager.png" width="55" height="54" alt="cms-user" /> <span>CMS Users</span> Manager </a> </div>
            <div class="sb-wrap"><a href="<?=$adm->iurl('member')?>" class="section-box"><img src="images/customer_manager.png" width="51" height="55" alt="customer" /> <span>Customers</span> Manager </a> </div>
            <div class="sb-wrap"><a href="<?=$adm->iurl('category')?>" class="section-box"><img src="images/category_manager.png" width="54" height="54" alt="category" /> <span>Category</span> Manager</a></div>
            <div class="sb-wrap"><a href="<?=$adm->iurl('product')?>" class="section-box"><img src="images/product_manager.png" width="59" height="56" alt="product-manager" /> <span>Products</span> Manager </a></div>
            <div class="sb-wrap"><a href="<?=$adm->iurl('header')?>" class="section-box"><img src="images/slider_manager.png" width="69" height="55" alt="Slider-manager" /> <span>Home Slider</span> Manager </a></div>
            <div class="sb-wrap"><a href="<?=$adm->iurl('orders')?>" class="section-box"><img src="images/order_manager.png" width="80" height="55" alt="Oder-manager" /> <span>Orders</span> Manager </a></div>
          </div>
        </div><?php */?></td>
        <td width="54%" valign="top"></td>
      </tr>
      <tr>
        <td valign="top"><div id="TabbedPanels2" class="TabbedPanels"  style="margin-top: -10px;">
          <ul class="TabbedPanelsTabGroup">
            <li class="TabbedPanelsTab" tabindex="0">Bestsellers</li>
            <li class="TabbedPanelsTab" tabindex="0">Most Viewed Products</li>
            <li class="TabbedPanelsTab" tabindex="0">New Customers</li>
            <li class="TabbedPanelsTab" tabindex="0">Customers</li>
          </ul>
          <div class="TabbedPanelsContentGroup">
            <div class="TabbedPanelsContent">
              <table class="dasTab">
                <tr class="colTitle">
                  <td width="35">#</td>
                  <td width="417">Product Name</td>
                  <td width="186">Price</td>
                  <td width="168">Quantity Ordered</td>
                </tr>
                <?php $result = $cms->db_query("select proid, amount from #_orders where 1 group by `proid` order by `qty` DESC limit 0, 5");
if(mysql_num_rows($result)){
	$nums=1; while ($line = $cms->db_fetch_array($result)){@extract($line);
?>
                <tr class="tabDeferent">
                  <td width="35"><?=$nums?></td>
                  <td width="417"><?=$cms->getSingleresult("select title from #_products where 1  and `pid`='".$proid."'")?></td>
                  <td width="186"><?=CUR.number_format($amount,2)?></td>
                  <td width="168"><?=$qty?></td>
                </tr>
                <?php $nums++;} } else{?>
                <tr class="tabDeferent">
                  <td colspan="4" >No current orders!!</td>
                </tr>
                <?php } ?>
              </table>
            </div>
            <div class="TabbedPanelsContent">
              <table class="dasTab">
                <tr class="colTitle">
                  <td width="35">#</td>
                  <td width="417">Product Name</td>
                  <td width="186">Price</td>
                  <td width="168">Number of Views</td>
                </tr>
                <?php $result = $cms->db_query("select * from #_products where 1 and `counter`!=''  order by `counter` DESC limit 0, 5");
if(mysql_num_rows($result)){
	$nums=1; while ($line = $cms->db_fetch_array($result)){@extract($line);
?>
                <tr class="tabDeferent">
                  <td width="35"><?=$nums?></td>
                  <td width="417"><?=$title?></td>
                  <td width="186"><?=CUR.number_format($our_price,2)?></td>
                  <td width="168"><?=$counter?></td>
                </tr>
                <?php $nums++;} } else{?>
                <tr class="tabDeferent">
                  <td colspan="4" >No current orders!!</td>
                </tr>
                <?php } ?>
              </table>
            </div>
            <div class="TabbedPanelsContent">
              <table class="dasTab">
                <tr class="colTitle">
                  <td width="35">#</td>
                  <td width="417">Customer Name</td>
                  <td width="186">Number of Orders</td>
                  <td width="168">Average Order Amount</td>
                  <td width="168">Total Order Amount</td>
                </tr>
                <?php $result = $cms->db_query("select * from  #_members where 1  and  type = 'regular'  order by `pid` DESC limit 0, 5");
if(mysql_num_rows($result)){
	$nums=1; while ($line = $cms->db_fetch_array($result)){@extract($line);
	$totordes = $cms->db_scalar("select count(*) from #_orders where `uid`='".$pid."'");
	$totamt = $cms->getSingleresult("select sum(amount) as tot from #_orders where `uid`='".$pid."'");
?>
                <tr class="tabDeferent">
                  <td width="35"><?=$nums?></td>
                  <td width="417"><?=$name?></td>
                  <td width="168"><?=$totordes?></td>
                  <td width="186"><?=(($totordes)?CUR.number_format(($totamt/$totordes),2):'N/A')?></td>
                  <td width="168"><?=CUR.number_format($totamt,2)?></td>
                </tr>
                <?php $nums++;} } else{?>
                <tr class="tabDeferent">
                  <td colspan="4" >No current orders!!</td>
                </tr>
                <?php } ?>
              </table>
            </div>
            <div class="TabbedPanelsContent">
              <table class="dasTab">
                <tr class="colTitle">
                  <td width="35">#</td>
                  <td width="417">Customer Name</td>
                  <td width="186">Number of Orders</td>
                  <td width="168">Average Order Amount</td>
                  <td width="168">Total Order Amount</td>
                </tr>
                <?php $result = $cms->db_query("select * from  #_members where 1  and type = 'regular'   order by rand() limit 0, 5");
if(mysql_num_rows($result)){
	$nums=1; while ($line = $cms->db_fetch_array($result)){@extract($line);
	$totordes = $cms->db_scalar("select count(*) from #_orders where `uid`='".$pid."'");
	$totamt = $cms->getSingleresult("select sum(amount) as tot from #_orders where `uid`='".$pid."'");
?>
                <tr class="tabDeferent">
                  <td width="35"><?=$nums?></td>
                  <td width="417"><?=$name?></td>
                  <td width="168"><?=$totordes?></td>
                  <td width="186"><?=(($totordes)?CUR.number_format(($totamt/$totordes),2):'N/A')?></td>
                  <td width="168"><?=CUR.number_format($totamt,2)?></td>
                </tr>
                <?php $nums++;} } else{?>
                <tr class="tabDeferent">
                  <td colspan="4" >No current orders!!</td>
                </tr>
                <?php } ?>
              </table>
            </div>
          </div>
        </div></td>
        <td valign="top"><div class="div-tbl half"  style="margin-top: -10px;">
          <?php /*?><table class="dasTab">
          <tr class="heading">
            <td colspan="4"><span class="tabTitle">Notifications</span></td>
          </tr>
          <tr class="tabDeferent">
            <td height="25" colspan="4" align="left" valign="middle" style="font-size:15px;">Pending Orders: <?=$cms->db_scalar("select count(*) from #_orders where 1 and `status`='pending' and `domains`='".DOMAINS."' ".$admlog." ")?></td>
          </tr>
           <tr class="tabDeferent">
            <td height="25" colspan="4" align="left" valign="middle" style="font-size:15px;">Products out of stock: <?=$cms->db_scalar("select count(*) from #_product where 1 and `stock`='no' and `status`='Active' and `domains`='".DOMAINS."' ".$admlog." ")?></td>
          </tr>
           <tr class="tabDeferent">
            <td height="25" colspan="4" align="left" valign="middle" style="font-size:15px;">Total Products: <?=$cms->db_scalar("select count(*) from #_product where 1 and `status`='Active' and `domains`='".DOMAINS."' ".$admlog." ")?></td>
          </tr>
          <tr class="tabDeferent">
            <td height="25" colspan="4" align="left" valign="middle" style="font-size:15px;">Total Customers: <?=$cms->db_scalar("select count(*) from  #_members where 1 and `status`='Active' and `domains`='".DOMAINS."' ".$admlog." ")?></td>
          </tr>
        </table><?php */?>
        </div></td>
      </tr>
    </table>
  </div></td>
</tr>
</table>
<?php
	echo '<script type="text/javascript">';
	echo 'var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels2");';
	echo 'var Accordion1 = new Spry.Widget.Accordion("Accordion1", {useFixedPanelHeights: false});';
	echo '</script>';
?>
