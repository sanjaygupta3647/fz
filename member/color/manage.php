<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php 
	if($action=='del'){
		$cms->db_query("delete from #_color where pid in ($id) and store_user_id = '".$_SESSION[uid]."'");
		$adm->sessset('Record has been deleted', 'e');
		$cms->redir(SITE_PATH_MEM.CPAGE, true);
		exit;
	}
	if($cms->is_post_back()){
		if($arr_ids) {
			$str_adm_ids = implode(",",$arr_ids);
			switch ($_POST['action']){
				case "delete":
					$cms->db_query("delete from #_color where pid in ($str_adm_ids) and store_user_id = '".$_SESSION[uid]."'");
					$adm->sessset(count($arr_ids).' Item(s) Delete', 'e');
					break;
				case "Inactive":
					$cms->db_query("update #_color set status = 'Inactive' where pid in ($str_adm_ids) and store_user_id = '".$_SESSION[uid]."'");
					$adm->sessset(count($arr_ids).' Item(s) Inactive', 'e');
					break;
				case "Active":
					$cms->db_query("update #_color set status = 'Active' where pid in ($str_adm_ids) and store_user_id = '".$_SESSION[uid]."'");
					$adm->sessset(count($arr_ids).' Item(s) Active', 's');
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
	$sql = " from #_color where  store_user_id = '".$_SESSION[uid]."' ";
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
      <td width="10%" align="center"><?=$adm->orders('Color',true)?></td>
	  <td width="25%" align="center"><?=$adm->orders('Title',true)?></td>  
	  <td width="11%" align="center"><?=$adm->orders('Status',true)?></td>
      <td width="12%" align="center"><?=$adm->norders('Action')?></td>
    </tr>
    <?php if($reccnt){ $nums=1; while ($line = $cms->db_fetch_array($result)){@extract($line);?>
    <tr <?=$adm->even_odd($nums)?>>
    <td align="center"><?=$nums?></td>
    <td align="center"><?=$adm->check_input($pid)?></td>
	<td align="center"><div style="height:5px; width:50px;padding:10px; background-color:#<?=$colorcode?>"></div></td>
    <td align="center"><?=$name?></td>
     <td align="center" class="<?=strtolower($status)?>"><?=$status?></td>
	<td align="center"><?=$adm->action(SITE_PATH_MEM.CPAGE."?mode=add&start=".$_GET['start'],$pid)?></td>
    </tr>
    <?php $nums++;}}else{ echo $adm->rowerror(6);}?>   
  </table>
 