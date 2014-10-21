  </form>
<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php 
$order_ = true;
$hedtitle = "Cart Management";
$innertit = "Cart Manager";
 
 $cond = "";
 if($status){$cond .= " and status = '$status' " ;}
  if($from){$cond .= " and submitdate>='$from' " ;}
   if($to){$cond .= "  and submitdate <='$to' " ;}
    
 

$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
$columns = "select * ";
if($_GET[mode]=='cart'){$table = '#_orders';} else $table = '#_cart';
$sql = " from #_cart where ssid = '$ssid'   ".$cond;
//$order_by == '' ? $order_by = 'pid' : true;
//$order_by2 == '' ? $order_by2 = 'desc' : true;
$sql_count = "select count(*) ".$sql; 
//$sql .= "order by $order_by $order_by2 ";
//$sql .= "group by `orderid` ";
$sql .= "limit $start, $pagesize ";
$sql = $columns.$sql;
$result = $cms->db_query($sql);
$reccnt = $cms->db_scalar($sql_count);
?>
 
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="data-tbl">
          <tr class="t-hdr">
            <td width="3%" align="center"><?=$adm->orders('#',false)?></td>
            <td width="3%" align="center" valign="middle"><?=$adm->orders('OrderId',true)?></td>
            <td width="15%" align="center"><?=$adm->orders('Name',true)?></td>
            <td width="5%" align="center"><?=$adm->orders('Qty',true)?></td>
            <td width="15%" align="center"><?=$adm->orders('Dimension',true)?></td>
			<td width="15%" align="center"><?=$adm->orders('Amount',true)?></td>
			<td width="15%" align="center"><?=$adm->orders('Date',true)?></td>
          </tr>
          <?php if($reccnt){ $nums=1; while ($line = $cms->db_fetch_array($result)){@extract($line);?>
          <tr <?=$adm->even_odd($nums)?>>
            <td align="center"><?=$nums?></td>
            <td align="center"><?=$ssid?></td>
            <td align="center"><?=$cms->getSingleresult("select title from #_products where `pid`='".$proid."'")?></td>
			<td align="center" valign="top"><?=$qty?></td>
            <td align="center" valign="top"><?=$dimension?></td>
            <td align="center" ><?=($price)?$price:$amount?></td>
			<td align="center" valign="top"><?=($_GET[mode]!='cart')?date("Y-m-d",$submitdate):$submitdate?></td>
          </tr>
          <?php $nums++;}}else{ echo $adm->rowerror(5);}?>
        </table>
 <form>
 