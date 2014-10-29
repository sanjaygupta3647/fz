<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php 
    
	if($cms->is_post_back() and !$_POST[search]){
		if($arr_ids) {
			$str_adm_ids = implode(",",$arr_ids);
			switch ($_POST['action']){
				case "delete":
					$cms->db_query("delete from #_gift_voucher where pid in ($str_adm_ids)");
					$adm->sessset(count($arr_ids).' Item(s) Delete', 'e');
					break;
				case "Inactive":
					$cms->db_query("update #_gift_voucher set status = 'Inactive' where pid in ($str_adm_ids)");
					$adm->sessset(count($arr_ids).' Item(s) Inactive', 'e');
					break;
				case "Active":
					$cms->db_query("update #_gift_voucher set status = 'Active' where pid in ($str_adm_ids)");
					$adm->sessset(count($arr_ids).' Item(s) Active', 's');
					break;
				case "Block":
					$cms->db_query("update #_gift_voucher set status = 'Block' where pid in ($str_adm_ids)");
					$adm->sessset(count($arr_ids).' Item(s) Block', 's');
					break;
				default:
			}
		}
		$cms->redir(SITE_PATH_MEM.CPAGE, true);
		exit;
	}
	$start = intval($start);
	$pagesize = DEF_PAGE_SIZE;
	if($search){
		$pagesize = 1000;
		if($_GET[voucherCode]){
			$cond .=" and voucherCode ='".$cms->encryptcode($_GET[voucherCode])."'";
		}
		if($_GET[amount]){
			$cond .=" and amount = ".$_GET[amount];
		}
		if($_GET[status]){
			$cond .=" and status = '".$_GET[status]."'";
		}

	} 
	
 

	
	$columns = "select * ";
	$sql = " from #_gift_voucher where generatedByadmin ='".$_SESSION[uid]."' $cond  ";
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
      <td width="6%" align="center" valign="middle"><?=$adm->check_all()?></td>
      <td width="20%" align="center"><?=$adm->orders('Code',true)?></td>    
 	  <td width="10%" align="center"><?=$adm->orders('Amount',true)?></td>
	  <td width="25%" align="center"><?=$adm->orders('Valid Till (y-m-d)',true)?></td>
	  <td width="5%" align="center"><?=$adm->orders('Status',true)?></td>
     
    </tr>
    <?php if($reccnt){ $nums=1; while ($line = $cms->db_fetch_array($result)){@extract($line);?>
    <tr <?=$adm->even_odd($nums)?>>
    <td align="center"><?=$nums?></td>
    <td align="center"><?=$adm->check_input($pid)?></td>
    <td align="center"><?=$cms->decryptcode($voucherCode)?></td>  
	<td align="center"><?=$amount?></td>
	<td align="center"><?=($validtill!='0000-00-00')?$validtill:'One Time Use'?></td>
    <td align="center" class="<?=strtolower($status)?>"><?=$status?></td>
	 
    </tr>
    <?php $nums++;}}else{ echo $adm->rowerror(7);}?>   
  </table>
 