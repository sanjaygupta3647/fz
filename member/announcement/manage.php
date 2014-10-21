<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php  
	$start = intval($start);
	$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
	$columns = "select * ";
	$sql = " from #_announcement where 1 ";
	$order_by == '' ? $order_by = 'pid' : true;
	$order_by2 == '' ? $order_by2 = 'desc' : true;
	$sql_count = "select count(*) ".$sql; 
	$sql .= "order by $order_by $order_by2 ";
	$sql .= "limit $start, $pagesize ";
	$sql = $columns.$sql;
	$result = $cms->db_query($sql);
	$reccnt = $cms->db_scalar($sql_count);
?>
 
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0"  class="data-tbl">
    <tr class="t-hdr">
      <td width="6%" align="center"><?=$adm->orders('#',false)?></td> 
      <td width="25%" align="center"><?=$adm->orders('Title',true)?></td>
      <td width="29%" align="center"><?=$adm->orders('Date',true)?></td>
      
	  <td width="11%" align="center"><?=$adm->orders('Status',true)?></td>
      <td width="12%" align="center"><?=$adm->norders('Action')?></td>
    </tr>
    <?php if($reccnt){ $nums=1; while ($line = $cms->db_fetch_array($result)){@extract($line);
				 $sarr=explode(",",$store_user_id); 
				 if(in_array($_SESSION[uid],$sarr)){  ?>
    <tr <?=$adm->even_odd($nums)?>>
    <td align="center"><?=$nums?></td> 
    <td align="center"><?=$title?></td>
    <td align="center"><?=date("d M, Y h:i:s A",$submitdate)?></td>
    <td align="center" class="<?=strtolower($status)?>"><?=$status?></td>
	<td align="center"><a href="<?=SITE_PATH_MEM.CPAGE?>?mode=add&id=<?=$pid?>">View</a></td>
    </tr>
<?php $nums++; } } }else{ echo $adm->rowerror(6);}?>   
  </table>
 