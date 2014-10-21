<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php 
	if($action=='del'){
		$cms->db_query("delete from #_gallery where pid in ($id)");
		$rsAdminw=$cms->db_scalar("select count(*) from #_gallery where catid in ($id)");
		if($rsAdminw){
			$cms->db_query("delete from #_gallery where catid in ($id)");
		}			
		$adm->sessset('Record has been deleted', 'e');
		$cms->redir(SITE_PATH_ADM.CPAGE, true);
		exit;
	}
	if($cms->is_post_back()){
		if($arr_ids) {
			$str_adm_ids = implode(",",$arr_ids);
			switch ($_POST['action']){
				case "delete":
					$cms->db_query("delete from #_gallery where pid in ($str_adm_ids)");
					
					$rsAdminw=$cms->db_scalar("select count(*) from #_gallery where catid in ($str_adm_ids)");
					if($rsAdminw){
						$cms->db_query("delete from #_gallery where catid in ($str_adm_ids)");
					}
					$adm->sessset(count($arr_ids).' Item(s) Delete', 'e');
					break;
				case "Inactive":
					$cms->db_query("update #_gallery set status = 'Inactive' where pid in ($str_adm_ids)");
					$adm->sessset(count($arr_ids).' Item(s) Inactive', 'e');
					break;
				case "Active":
					$cms->db_query("update #_gallery set status = 'Active' where pid in ($str_adm_ids)");
					$adm->sessset(count($arr_ids).' Item(s) Active', 's');
					break;
				default:
			}
		}
		$cms->redir(SITE_PATH_ADM.CPAGE, true);
		exit;
	}
	$start = intval($start);
	$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
	$columns = "select * ";
	$sql = " from #_gallery where ".(($catid)?" `catid` = '".$catid."' ":" `catid` = '0' ");
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
      <td width="3%" align="center"><?=$adm->orders('#',false)?></td>
      <td width="5%" align="center" valign="middle"><?=$adm->check_all()?></td>
      <td width="20%" align="center"><?=$adm->orders((($catid)?'Caption':'Album').' Name',true)?></td>
       <td width="11%" align="center"><?=$adm->orders('Token',true)?></td>
	  <?php if(!$catid){?>
      <td width="11%" align="center"><?=$adm->orders('Image Gallery',true)?></td>
  
	  <?php }else{?>
	  <td width="15%" align="center"><?=$adm->orders('Preview',true)?></td>
      <?php } ?>
      <td width="13%" align="center"><?=$adm->orders('Status',true)?></td>
      <td width="9%" align="center"><?=$adm->norders('Action')?></td>
    </tr>
    <?php if($reccnt){ $nums=1; while ($line = $cms->db_fetch_array($result)){@extract($line);
		$numc = mysql_num_rows($cms->db_query("select * from #_gallery where catid='".$pid."'"));
		
	?>
    <tr <?=$adm->even_odd($nums)?>>
    <td align="center"><?=$nums?></td>
    <td align="center"><?=$adm->check_input($pid)?></td>
    <td align="center"><?=$caption?></td>
     <td align="center"><?=$slug?></td>
	<?php if(!$_GET[catid]){?>
    <td align="center"><a href="<?=SITE_PATH_ADM.CPAGE?>?mode=add&catid=<?=$pid?>">Add</a> | <a href="<?=SITE_PATH_ADM.CPAGE?>?view=true&catid=<?=$pid?>">View [<?=$numc?>]</a></td>
   
	<?php }else{?>
	<td width="15%" align="center"><a href="<?=SITE_PATH."uploaded_files/big/".$image?>" target="_blank">View</a></td>
	<?php } ?>
	<td align="center" class="<?=strtolower($status)?>"><?=$status?></td>
    <td align="center"><?=$adm->action(SITE_PATH_ADM.CPAGE."?mode=add&catid=".$catid,$pid)?></td>
    </tr>
    <?php $nums++;}}else{ echo $adm->rowerror(7);}?>   
  </table>
 