<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php 
	
	$start = intval($start);
	$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
	$columns = "select * ";
	$sql = " from #_contact where store_id = '".$_SESSION['store_id']."' ";
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
      <td width="15%" align="center"><?=$adm->orders('Name',true)?></td>
	  <td width="10%" align="center"><?=$adm->orders('Phone',true)?></td>      
	  <td width="10%" align="center"><?=$adm->orders('Email',true)?></td>
       <td width="29%" align="center"><?=$adm->orders('Query',true)?></td>
	  <td width="8%" align="center"><?=$adm->orders('Status',true)?></td>
      <td width="12%" align="center"><?=$adm->norders('Action')?></td>
    </tr>
    <?php if($reccnt){ $nums=1; while ($line = $cms->db_fetch_array($result)){@extract($line);?>
    <tr <?=$adm->even_odd($nums)?>>
    <td align="center"><?=$nums?></td>
	<td align="center"><?=$name?></td>     
	<td align="center"><?=$phone?></td> 
    <td align="center"><?=$email?></td>
    <td align="center"><?=substr($query,0,50)?></td>
    <td align="center" class="<?=strtolower($status)?>"><?=($status=='1')?'Viewed':'Not Viewed'?></td>
	<td align="center"><a href="<?=SITE_PATH_MEM.CPAGE?>?mode=add&id=<?=$pid?>">View</a></td>
    </tr>
    <?php $nums++;}}else{ echo $adm->rowerror(6);}?>   
  </table>
 