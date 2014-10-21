<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php 
	if($action=='del'){
		$cms->db_query("delete from #_offer where pid in ($id)");
		$adm->sessset('Record has been deleted', 'e');
		$cms->redir(SITE_PATH_MEM.CPAGE, true);
		exit;
	}
	if($cms->is_post_back()){
		if($arr_ids) {
			$str_adm_ids = implode(",",$arr_ids);
			switch ($_POST['action']){
				case "delete":
					$cms->db_query("delete from #_offer where pid in ($str_adm_ids)");
					$adm->sessset(count($arr_ids).' Item(s) Delete', 'e');
					break;
				case "Inactive":
					$cms->db_query("update #_offer set readstatus = '0' where pid in ($str_adm_ids)");
					$adm->sessset(count($arr_ids).' Item(s) Unread', 'e');
					break;
				case "Active":
					$cms->db_query("update #_offer set readstatus = '1' where pid in ($str_adm_ids)");
					$adm->sessset(count($arr_ids).' Item(s) Read', 's');
					break;
				default:
			}
		}
		$cms->redir(SITE_PATH_MEM.CPAGE, true);
		exit;
	}
	$start = intval($start);
	$pagesize = DEF_PAGE_SIZE;
	$columns = "select * ";
	$sql = " from #_offer where    store_user_id = '".$_SESSION[uid]."' ";
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
      <td width="25%" align="center"><?=$adm->orders('Category',true)?></td>  
      
	  <td width="15%" align="center"><?=$adm->orders('Status',true)?></td>
      <td width="12%" align="center"><?=$adm->norders('Action')?></td>
    </tr>
    <?php if($reccnt){ $nums=1; while ($line = $cms->db_fetch_array($result)){@extract($line);?>
    <tr <?=$adm->even_odd($nums)?>>
    <td align="center"><?=$nums?></td>
    <td align="center"><?=$adm->check_input($pid)?></td>
    <td align="center">
	<?php 
	$count  = $cms->getSingleresult("select count(*) from #_offer_detail where store_user_id ='".$_SESSION[uid]."' and cat_id='$cat_id' ");
	$getpar = $cms->getSingleresult("select parent from #_store_menu where store_user_id ='".$_SESSION[uid]."' and cat_id='$cat_id' ");?>
	<a href="<?=SITE_PATH_MEM?>offer-detail/?cat_id=<?=$cat_id?>">
	<?=$cms->getSingleresult("select name from #_store_menu where store_user_id ='".$_SESSION[uid]."' and cat_id='$getpar' ");?> =>
	<?=$cms->getSingleresult("select name from #_store_menu where store_user_id ='".$_SESSION[uid]."' and cat_id='$cat_id' ");?><?=" (".$count.")"?></a></td> 
    
     <td align="center" class="<?=strtolower($status)?>"><?=$status?></td>
	<td align="center"><?=$adm->action(SITE_PATH_MEM.CPAGE."?mode=add",$pid)?></td>
    </tr>
    <?php $nums++;}}else{ echo $adm->rowerror(5);}?>   
  </table>
