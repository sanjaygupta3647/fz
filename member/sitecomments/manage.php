<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php 
	 
	if($action=='del'){
 		$cms->db_query("delete from #_faq where pid in ($id)");
		$adm->sessset('Record has been deleted', 'e');
		$cms->redir(SITE_PATH_MEM.CPAGE, true);
		exit;
	}
	if($cms->is_post_back()){
		if($arr_ids) {
			$str_adm_ids = implode(",",$arr_ids);
			switch ($_POST['action']){
				case "Copy":
					
					$adm->sessset(count($arr_ids).' Item(s) Copied', 's');
					break;
				case "delete":
					$cms->db_query("delete from #_review where pid in ($str_adm_ids)");
					$adm->sessset(count($arr_ids).' Item(s) Delete', 'e');
					break;
				case "Inactive":
					$cms->db_query("update #_review set status = 'Inactive' where pid in ($str_adm_ids)");
					$adm->sessset(count($arr_ids).' Item(s) Inactive', 'e');
					break;
				case "Active":
					$cms->db_query("update #_review set status = 'Active' where pid in ($str_adm_ids)");
					$adm->sessset(count($arr_ids).' Item(s) Active', 's');
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
	$sql = " from #_review where type='store' and 1 $cond ";
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
      <td width="25%" align="center"><?=$adm->orders('Title',true)?></td> 
 	  <td width="15%" align="center"><?=$adm->orders('Comment',true)?></td>
	   <td width="15%" align="center"><?=$adm->orders('Star',true)?></td>
	   <td width="15%" align="center"><?=$adm->orders('Staus',true)?></td>
      <td width="12%" align="center"><?=$adm->norders('Action',true)?></td>
    </tr>
    <?php if($reccnt){ if($start){$nums= $start+1;}else { $nums= 1;}  while ($line = $cms->db_fetch_array($result)){@extract($line);?>
     <tr <?=$adm->even_odd($nums)?>>
    <td align="center"><?=$nums?></td>
    <td align="center"><?=$adm->check_input($pid)?></td>
    <td align="center"><?=$title?></td>  
	 <td align="center"><?=substr($comment,0,25)?>..</td>  
	  <td align="center"><?=$star?>/5</td> 
    <td align="center" class="<?=strtolower($status)?>"><?=$status?></td>
	<td align="center"><?=$adm->action(SITE_PATH_MEM.CPAGE."?mode=add&start=".$_GET['start'],$pid)?></td>


    </tr>
    <?php $nums++;}}else{ echo $adm->rowerror(7);}?>   
  </table>
 