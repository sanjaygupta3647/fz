<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php 
   
	if($action=='del'){
		$cms->db_query("delete from #_shipping_area where pid in ($id)");
		$adm->sessset('Record has been deleted', 'e');
		$cms->redir(SITE_PATH_MEM.CPAGE, true);
		exit;
	}
	if($cms->is_post_back()){
		if($arr_ids) {
			$str_adm_ids = implode(",",$arr_ids);
			switch ($_POST['action']){ 
				case "Inactive":
					$cms->db_query("delete from #_shipping_area_store  where shipid in ($str_adm_ids) and store_user_id = '".$_SESSION[uid]."'  ");
					$adm->sessset(count($arr_ids).' Record(s) Inactive', 'e');
					break;
				case "Active":
					$results = $cms->db_query("select * from #_shipping_area where   pid in ($str_adm_ids) ");
					if(mysql_num_rows($results)){
						 while ($line3 = $cms->db_fetch_array($results)){ extract($line3);
								$count = $cms->getSingleresult(" select pid from #_shipping_area_store   where shipid = '$pid' and store_user_id = '".$_SESSION[uid]."' ");
								if(!$count){
									$arr = array();
									$arr[shipid] = $pid; $arr[store_user_id] = $_SESSION[uid]; $arr[city] = $city;  $arr[areaname] = $areaname; 
									$arr[pincode] = $pincode; $arr[day1] = $day1; $arr[day2] = $day2; $arr[status] = $status; 
									$cms->sqlquery("rs","shipping_area_store",$arr);
									$adm->sessset('Shipping Record(s) has been added', 's');
								}
						 }
					} 
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
	$sql = " from #_shipping_area where status='Active' ";
	$order_by == '' ? $order_by = 'pid' : true;
	$order_by2 == '' ? $order_by2 = 'desc' : true;
	$sql_count = "select count(*) ".$sql; 
	$sql .= " group by pincode order by $order_by $order_by2 ";
	$sql .= "limit $start, $pagesize ";
	$sql = $columns.$sql;
	$result = $cms->db_query($sql);
	$reccnt = $cms->db_scalar($sql_count);

	$ship = $cms->db_query(" select pincode from #_shipping_area_store where store_user_id = '".$_SESSION[uid]."' ");
	$mypincode[] = 0;
	if(mysql_num_rows($ship)){
		while ($rs = $cms->db_fetch_array($ship)){
			   $mypincode[] = $rs[pincode];
		}
	}

?>
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0"  class="data-tbl">
    <tr class="t-hdr">
      <td width="6%" align="center"><?=$adm->orders('#',false)?></td>
      <td width="6%" align="center" valign="middle"><?=$adm->check_all()?></td>
      <td width="15%" align="center"><?=$adm->orders('City',true)?></td>   
 	  <td width="15%" align="center"><?=$adm->orders('Area Name',true)?></td>
	  <td width="10%" align="center"><?=$adm->orders('Code',true)?></td> 
	  <td width="15%" align="center"><?=$adm->orders('Delevery Time',true)?></td> 
	  <td width="8%" align="center"><?=$adm->orders('Extra Charge',true)?></td>
	  <td width="10%" align="center"><?=$adm->orders('Status',true)?></td>
      <td width="12%" align="center"><?=$adm->norders('Action')?></td>
    </tr>
    <?php if($reccnt){ if($start){$nums= $start+1;}else { $nums= 1;} while ($line = $cms->db_fetch_array($result)){@extract($line);?>
	<?php
	$extracharge = 0;
	$check = $cms->db_query(" select * from #_shipping_area_store where store_user_id = '".$_SESSION[uid]."' and pincode = '$pincode' "); 
	if(mysql_num_rows($check)){
		 $rs = $cms->db_fetch_array($check);@extract($rs);
	}
	?>
    <tr <?=$adm->even_odd($nums)?>>
    <td align="center"><?=$nums?></td>
    <td align="center"><?=$adm->check_input($pid)?></td>
    <td align="center"><?=$city?></td>  
	 <td align="center"><?=$areaname?></td> 
    <td align="center"><?=$pincode?></td>
	<td align="center"><?=$day1?> To <?=$day2?> days</td>
	 <td align="center"><?=(int)$extracharge?> %</td>
	<?php $cond = (in_array($pincode,$mypincode))?'Added':'Not Added'; ?>
    <td align="center" ><?=$cond?></td>
	<td align="center">
	<?php if($cond=='Added') echo $adm->action_(SITE_PATH_MEM.CPAGE."?mode=add&start=".$_GET['start'],$pid); else echo"NA";?></td>
    </tr>
    <?php $nums++;}}else{ echo $adm->rowerror(7);}?>   
  </table>
