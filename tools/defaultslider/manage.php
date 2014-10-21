<?php defined('_JEXEC') or die('Restricted access'); ?>
<style>
span{ 
	width:5px; 
	padding:10px;
}
</style>
<?php 
	if($action=='del'){
		$cms->db_query("delete from #_slider where pid in ($id)");
		$rsAdminw=$cms->db_scalar("select count(*) from #_slider where pid in ($id)");
		if($rsAdminw){
			$cms->db_query("delete from #_slider where catid in ($id)");
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
		$cms->redir(SITE_PATH_ADM.CPAGE, true);
		exit;
	}
	$start = intval($start);
	$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
	$columns = "select * ";
	$sql = " from #_slider where store_id ='0' and slider_type='0'";
	$order_by == '' ? $order_by = 'porder' : true;
	$order_by2 == '' ? $order_by2 = 'asc' : true;
	$sql_count = "select count(*) ".$sql; 
	$sql .= "order by $order_by $order_by2 ";
	$sql .= "limit $start, $pagesize ";
	$sql = $columns.$sql;
	$result = $cms->db_query($sql);
	$reccnt = $cms->db_scalar($sql_count);
?>
 
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="data-tbl">
    <tr class="t-hdr">
      <td width="3%" align="center"><?=$adm->orders('#',false)?></td>
      <td width="5%" align="center" valign="middle"><?=$adm->check_all()?></td>
       <td width="3%" align="center"><?=$adm->orders('Banner Heading',true)?></td>   
	  <td width="20%" align="center"><?=$adm->orders('Contents',true)?></td> 
	  <td width="5%" align="center"><?=$adm->orders('Order',true)?></td> 
	  <td width="13%" align="center"><?=$adm->orders('Background Image or Color',true)?></td>
	  <td width="13%" align="center"><?=$adm->orders('Side Image',true)?></td>
	  <td width="13%" align="center"><?=$adm->orders('Link Url',true)?></td>
	  <td width="13%" align="center"><?=$adm->orders('Status',true)?></td>
      <td width="19%" align="center"><?=$adm->norders('Action')?></td>
    </tr>
    <?php if($reccnt){ $nums=1; while ($line = $cms->db_fetch_array($result)){@extract($line);
		$numc = mysql_num_rows($cms->db_query("select * from #_slider")); 
		$file =$image;
		$len = strlen($file);
		$ext = substr($file, -4, 4);
	?>
    <tr <?=$adm->even_odd($nums)?>>
    <td align="center"><?=$nums?></td>
    <td align="center"><?=$adm->check_input($pid)?></td> 
    <td align="right"><?=$title?></td> 
	 <td align="right"><?=$contents?></td> 
	<td align="center"><?=$porder?></td> 
	<td width="15%" align="center"><?php if($ext=='.jpg' || $ext=='.png' || $ext=='.jpeg' ){ ?><img src="<?=SITE_PATH.'uploaded_files/orginal/'.$image?>" width="100" /><?php }else{ ?>  <span style="background-color:#<?=$image?>"></span>   <?php   } ?></td> 
	<td width="15%" align="center"><?php if($side_image){ ?><img src="<?=SITE_PATH.'uploaded_files/orginal/'.$side_image?>" width="100" /> <?php }?></td> 
	  <td align="center"><?=$linkurl?></td>    
	<td align="center"><?=$status?></td>  
    <td align="center"><?=$adm->action(SITE_PATH_ADM.CPAGE."?mode=add&pid=".$pid,$pid)?></td>
    </tr>
    <?php $nums++;}}else{ echo $adm->rowerror(7);}?>   
  </table>
 
 