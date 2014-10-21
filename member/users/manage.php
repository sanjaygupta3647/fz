<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php 
	$arr[] = 0;
	$qry = $cms->db_query("select user_id from #_member_access where store_id ='".$_SESSION[store_id]."'");
	if(mysql_num_rows($qry)){
		while ($res = $cms->db_fetch_array($qry)){@extract($res); 
			if($user_id) $arr[] = $user_id;
		}	
	}
	if($action=='del'){
		$cms->db_query("delete from #_members where pid in ($id)");
		$adm->sessset('Record has been deleted', 'e');
		$cms->redir(SITE_PATH_MEM.CPAGE, true);
		exit;
	}
	if($cms->is_post_back()) {
		if($arr_ids) {
			$str_adm_ids = implode(",",$arr_ids);
			switch ($_POST['action']){
				case "delete":
					$cms->db_query("delete from #_members where pid in ($str_adm_ids)");
					$adm->sessset(count($arr_ids).' Item(s) Delete', 'e');
					break;
				case "Inactive":
					$cms->db_query("update #_members set status = 'Inactive' where pid in ($str_adm_ids)");
					$adm->sessset(count($arr_ids).' Item(s) Inactive', 'e');
					$cms->member_update_mail($str_adm_ids,'Inactive',$_SESSION[store_id]);
					break;
				case "Active":
					$cms->db_query("update #_members set status = 'Active' where pid in ($str_adm_ids)");
					$adm->sessset(count($arr_ids).' Item(s) Active', 's');
					$cms->member_update_mail($str_adm_ids,'Active',$_SESSION[store_id]);
					break;
					default:
			}
		}
		$cms->redir(SITE_PATH_MEM.CPAGE, true);
		exit;
	}
	$start = intval($start);
	$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
	$columns = "select * ";
	$sql = " from #_members where pid in (".implode(',',$arr).") ";
	$order_by == '' ? $order_by = 'pid' : true;
	$order_by2 == '' ? $order_by2 = 'desc' : true;
	$sql_count = "select count(*) ".$sql; 
	$sql .= "order by $order_by $order_by2 ";
	$sql .= "limit $start, $pagesize";
    $sql = $columns.$sql;
	$result = $cms->db_query($sql);
	$reccnt = $cms->db_scalar($sql_count);
?>
 
  <table id="myTable" width="100%" border="0" align="center" cellpadding="0" cellspacing="0"  class="data-tbl tablesorter">

    <thead><tr class="t-hdr">
      <td width="2%" align="center"><?=$adm->orders('Name',false)?></td>
      <td width="10%" align="center"><?=$adm->orders('Email',false)?></td>
	  <td width="8%" align="center"><?=$adm->orders('Confirm Orders',true)?></td>
	  <td width="8%" align="center"><?=$adm->orders('Pending Orders',true)?></td>
      <td width="8%" align="center"><?=$adm->orders('Cancle Orders',true)?></td>
	   
	  <td width="10%" align="center"><?=$adm->orders('Confirm Amount',true)?></td>
	  <td width="10%" align="center"><?=$adm->orders('Pending Amount',true)?></td>
	  <td width="10%" align="center"><?=$adm->orders('Cancle Amount',true)?></td> 
       
      <td width="5%" align="center"><?=$adm->orders('Status',true)?></td>
       
    </tr><thead>
    <tbody>
    <?php if($reccnt){ $nums=1; while ($line = $cms->db_fetch_array($result)){@extract($line);?>
    <tr <?=$adm->even_odd($nums)?>>
    
    <td align="center"><a href="<?=SITE_PATH_MEM?>catalog/manage-orders.php?uid=<?=$pid?>"><?=$fname." ".$lname?></a></td>
	<td align="center"><?=$email?></td>
	<td align="center"><?=$cms->getSingleresult("select count(*) from fz_order_summary where uid = '$pid' and store_id = '".$_SESSION[store_id]."' and status = 'complete'")?></td>
	<td align="center"><?=$cms->getSingleresult("select count(*) from fz_order_summary where uid = '$pid' and store_id = '".$_SESSION[store_id]."' and status = 'pending'")?></td>
	<td align="center"><?=$cms->getSingleresult("select count(*) from fz_order_summary where uid = '$pid' and store_id = '".$_SESSION[store_id]."' and status = 'cancle'")?></td>

	<td align="center">Rs. <?=(int)$cms->getSingleresult("select sum(paynet) from fz_order_summary where uid = '$pid' and store_id = '".$_SESSION[store_id]."' and status = 'complete'")?></td>
	<td align="center">Rs. <?=(int)$cms->getSingleresult("select sum(paynet) from fz_order_summary where uid = '$pid' and store_id = '".$_SESSION[store_id]."' and status = 'pending'")?></td>
	<td align="center">Rs. <?=(int)$cms->getSingleresult("select sum(paynet) from fz_order_summary where uid = '$pid' and store_id = '".$_SESSION[store_id]."' and status = 'cancle'")?></td>
	
 
    <td align="center" class="<?=strtolower($status)?>"><a href="<?=SITE_PATH_MEM.CPAGE?>?mode=add&start=<?=$_GET['start']?>&id=<?=$pid?>"><?=$status?></a></td>
    
    </tr>
    <?php $nums++;}}else{ echo $adm->rowerror(8);} ?>   
	</tbody>
  </table>
 