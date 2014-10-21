<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php 
	if($action=='del'){
		$cms->db_query("delete from #_slider where pid in ($id)");
		$rsAdminw=$cms->db_scalar("select count(*) from #_slider where pid in ($id)");
		if($rsAdminw){
			$cms->db_query("delete from #_slider where catid in ($id)");
		}			
		$adm->sessset('Record has been deleted', 'e');
		$cms->redir(SITE_PATH_MEM.CPAGE, true);
		exit;
	}
	if($cms->is_post_back()){
		if($arr_ids) {
			$str_adm_ids = implode(",",$arr_ids);
			switch ($_POST['action']){
				case "delete":
					$cms->db_query("delete from #_slider where pid in ($str_adm_ids)");  
					$adm->sessset(count($arr_ids).' Item(s) Delete', 'e');
					break;
				case "Inactive":
					$cms->db_query("update #_slider set status = 'Inactive' where pid in ($str_adm_ids)");
					$adm->sessset(count($arr_ids).' Item(s) Inactive', 'e');
					break;
				case "Active":
					$cms->db_query("update #_slider set status = 'Active' where pid in ($str_adm_ids)");
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
	$sql = " from #_slider where store_id = '".$_SESSION[store_id]."' ";
	$order_by == '' ? $order_by = 'pid' : true;
	$order_by2 == '' ? $order_by2 = 'desc' : true;
	$sql_count = "select count(*) ".$sql; 
	$sql .= "order by $order_by $order_by2 ";
	$sql .= "limit $start, $pagesize ";
	$sql = $columns.$sql;
	$result = $cms->db_query($sql);
	$reccnt = $cms->db_scalar($sql_count);
?>
 
  <table cellpadding="5" cellspacing="0" width="100%" border="0" class="data-tbl">
      <tbody>
        <tr class="t-hdr">
            <td><?=$adm->orders('#',false)?></td>
            <td><?=$adm->check_all()?></td>
            <td><?=$adm->orders('Title',true)?></td>
            <td><?=$adm->orders('Brief Details',true)?></td>
            <td><?=$adm->orders('Link Url',true)?></td>
            <td><?=$adm->orders('Order',true)?></td>
            <td><?=$adm->orders('Image',true)?></td>
            <td><?=$adm->orders('Status',true)?></td>
            <td><?=$adm->norders('Action')?></td>
        </tr>
     
	
  
	<?php if($reccnt){ $nums=1; while ($line = $cms->db_fetch_array($result)){@extract($line);
		$numc = mysql_num_rows($cms->db_query("select * from #_slider")); 
	?>
        <tr <?=$adm->even_odd($nums)?>>
            <td><?=$nums?></td>
            <td><?=$adm->check_input($pid)?></td>
          <td><?=$title?></td>
            <td><?=$alt?></td>
            <td><?=$linkurl?></td>
            <td><?=$porder?></td>
            <td><img src="<?=SITE_PATH.'uploaded_files/orginal/'.$image?>" width="100" /></td>
            <td><?=$status?></td>
            <td align="left" valign="middle"><?=$adm->action(SITE_PATH_MEM.CPAGE."?mode=add&pid=".$pid,$pid)?><!--<a href="#" class="action_buttons"><img src="<?=SITE_PATH_MEM?>images/edit.png" width="20" height="20"  alt="" align="left" /></a><a href="#" class="action_buttons"><img src="<?=SITE_PATH_MEM?>images/delete_icon.png" width="20" height="20"  alt="" align="right" /></a> --></td>
        </tr>
		 <?php $nums++;}}else{ echo $adm->rowerror(7);}?>  
        
         
    </tbody>
</table>
 
 