<?php include("../../lib/opin.inc.php")?>
<?php define("CPAGE","catalog/")?>
<?php include("../inc/header.inc.php")?>
<div class="main">
<header>
     
      <div class="hrd-right-wrap">
        <?php /*?><nav>
          <ul>
            <li> <a href="<?=SITE_PATH_ADM?>"></a> </li>
            <li> <a href="<?=SITE_PATH_ADM?>catalog/collections.php">Products</a> </li>
            <li> <a href="<?=SITE_PATH_ADM?>catalog/manage-category.php">Category</a> </li>
            <li> <a href="<?=SITE_PATH_ADM?>setting.php?mode=true">Setting</a> </li>
           <!-- <li> <a href="">System</a> </li>-->
          </ul>
        </nav><?php */?>
        
        <div class="brdcm" id="hed-tit">Banner</div>
        <div class="unvrl-btn"> 
        
         <?php if(!$_GET[id]){?>
        <a href="javascript:void(0)" class="ub"   onclick="javascript:submitions('delete');">
        <img src="<?=SITE_PATH_ADM?>images/delete.png" alt=""></a>
        <?php /*?><a href="javascript:void(0)" class="ub">
        <img src="<?=SITE_PATH_ADM?>images/cancel.png" alt=""></a><?php */?>
        <a href="javascript:void(0)"  onclick="javascript:submitions('Active');"class="ub">
        <img src="<?=SITE_PATH_ADM?>images/active.png" alt=""></a>
        <a href="javascript:void(0)" onClick="javascript:submitions('Inactive');" class="ub">
        <img src="<?=SITE_PATH_ADM?>images/inactive.png" alt=""></a><?php }?>
        <?php /*?><a href="javascript:void(0)" class="ub">
        <img src="<?=SITE_PATH_ADM?>images/restore.png" alt=""></a><?php */?>
       <?php if($_GET[id]){?>
        <a href="javascript:void(0)" onclick="javascript:formback();" class="ub">
        <img src="<?=SITE_PATH_ADM?>images/back.png" alt=""></a><?php }?>
        
        </div> 
      </div>
      <div class="cl"></div>
    </header> 
    
 <div class="cl"></div><?
$order_ = true;
 
 
if($cms->is_post_back()){
	if($arr_ids) {
		$str_adm_ids = implode(",",$arr_ids);
		switch ($_POST['action']){
			case "delete":
				$cms->db_query("delete from #_orders where pid in ($str_adm_ids)");
				$adm->sessset(count($arr_ids).' Item(s) Delete', 'e');
				break;
			case "delivered":
				$cms->db_query("update #_orders set status = 'delivered' where pid in ($str_adm_ids)");
				$adm->sessset('Order has been delivered', 's');
				break;
			case "process":
				$cms->db_query("update #_orders set status = 'process' where pid in ($str_adm_ids)");
				$adm->sessset('Order is in process', 's');
				break;
			case "canceled":
				$cms->db_query("update #_orders set status = 'canceled' where pid in ($str_adm_ids)");
				$adm->sessset('Order has been canceled', 'e');
				break;	
						
			default:
		}
	}
	$cms->redir(SITE_PATH_ADM.CPAGE."/manage-orders.php", true);
	exit;
}
$cond = " and status = '$status' ";  
$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
$columns = "select * ";
$sql = " from #_orders where 1 ". $cond;
//$order_by == '' ? $order_by = 'pid' : true;
//$order_by2 == '' ? $order_by2 = 'desc' : true;
$sql_count = "select count(*) ".$sql; 
//$sql .= "order by $order_by $order_by2 ";
$sql .= "group by `orderid` ";
$sql .= "limit $start, $pagesize ";
$sql = $columns.$sql;
$result = $cms->db_query($sql);
$reccnt = $cms->db_scalar($sql_count);
?>
<div class="content">
<div class="div-tbl">
<div class="cl"></div>
   
<?php $hedtitle = "Order Management"; ?>   
    <? //$adm->h1_tag('Dashboard &rsaquo; Orders Manager',$others)?>
    
      <?=$adm->alert()?>
      <div class="title"  id="innertit">
        <?=$adm->heading('Orders Manager :- '.ucfirst($status))?> 
      </div>
        <div class="tbl-contant">
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="data-tbl">
          <tr class="t-hdr">
            <td width="3%" align="center"><?=$adm->orders('#',false)?></td>
            <td width="3%" align="center" valign="middle"><?=$adm->check_all()?></td>
            <td width="29%" align="center"><?=$adm->orders('Order ID',true)?></td>
            <td width="36%" align="center"><?=$adm->orders('User name',true)?></td>
            <td width="15%" align="center"><?=$adm->orders('Status',true)?></td>
          </tr>
          <?php if($reccnt){ $nums=1; while ($line = $cms->db_fetch_array($result)){@extract($line);?>
          <tr <?=$adm->even_odd($nums)?>>
            <td align="center"><?=$nums?></td>
            <td align="center"><?=$adm->check_input($pid)?></td>
            <td align="center"><a href="view-orders.php?orderid=<?=$orderid?>" target="_blank"><?=$orderid?></a></td>
            <td align="center" valign="top"><?=$cms->getSingleresult("select name from #_members where `pid`='".$uid."'")?></td>
            <td align="center" class="<?=strtolower($status)?>"><?=$status?></td>
          </tr>
          <?php $nums++;}}else{ echo $adm->rowerror(5);}?>
        </table>
      </div>
        </div>
<?php include("../inc/footer.inc.php")?>
</div>
<div class="cl"></div>
</div>
</div>

<script type="text/javascript">
var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
var Accordion1 = new Spry.Widget.Accordion("Accordion1");
</script>
</body>
</html>