<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php 
	if($action=='del'){
		$cms->db_query("delete from #_store_user where pid in ($id)");
		$adm->sessset('Record has been deleted', 'e');
		$cms->redir(SITE_PATH_ADM.CPAGE, true);
		exit;
	}
	if($cms->is_post_back()) {
		if($arr_ids) {
			$str_adm_ids = implode(",",$arr_ids);
			switch ($_POST['action']){
				case "delete":
					$cms->db_query("delete from #_store_user where pid in ($str_adm_ids)");
					$adm->sessset(count($arr_ids).' Item(s) Delete', 'e');
					break;
				case "Inactive":
					$cms->db_query("update #_store_user set status = 'Inactive' where pid in ($str_adm_ids)");
					$adm->sessset(count($arr_ids).' Item(s) Inactive', 'e');
					$cms->user_update_mail($str_adm_ids,'Inactive',$_SESSION[store_id]);
					break;
				case "Active":
					$cms->db_query("update #_store_user set status = 'Active' where pid in ($str_adm_ids)");
					$adm->sessset(count($arr_ids).' Item(s) Active', 's');
					$cms->user_update_mail($str_adm_ids,'Active',$_SESSION[store_id]);
					break;
				default:
			}
		}
		$cms->redir(SITE_PATH_ADM.CPAGE, true);
		exit;
	}
	$start = $_GET[start];  
	$start = intval($start);
	$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
	if($search){
		$pagesize = 500;
		if($_GET[type]!=""){
			$cond .= " and type='".$_GET[type]."' " ; 
		}
		if($_GET[name]!=""){
			$cond .= " and name like '%".$_GET[name]."%'"; 
		}
		if($_GET[status]!=""){
			$cond .= " and status =   '".$_GET[status]."'"; 
		}
	}  
	
	$columns = "select * ";
	$sql = " from #_store_user where 1 $cond ";
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
      <td width="2%" align="center"><?=$adm->orders('#',false)?></td>
      <td width="3%" align="center" valign="middle"><?=$adm->check_all()?></td>
      <td width="5%" align="center"><?=$adm->orders('Name',true)?></td>
	  <td width="10%" align="center"><?=$adm->orders('Type',true)?></td>
	  <td width="10%" align="center"><?=$adm->orders('Store/Brand Name',true)?></td>
      <td width="12%" align="center"><?=$adm->orders('Mobile',true)?></td>
	  <td width="12%" align="center"><?=$adm->orders('Login as Store/Brand owner',true)?></td>
      <td width="12%" align="center"><?=$adm->orders('Address',true)?></td>
      <td width="12%" align="center"><?=$adm->orders('Email',true)?></td>
      <td width="10%" align="center"><?=$adm->orders('Status',true)?></td>
      <td width="20%" align="center"><?=$adm->norders('Action')?></td>
    </tr>
    <?php if($reccnt){if($start){$nums= $start+1;}else { $nums= 1;}  while ($line = $cms->db_fetch_array($result)){@extract($line);?>
    <tr <?=$adm->even_odd($nums)?>>
    <td align="center"><?=$nums?></td>
    <td align="center"><?=$adm->check_input($pid)?></td>
    <td align="center"><?=$name?></td>
	<td align="center" ><?=ucfirst($type)?></td>
	<td align="center"><?=$cms->getSingleresult("select title from #_store_detail where store_user_id ='".$pid."'")?></td>
    <td align="center"><?=$mobile?></td>
	<td align="center"><a href="http://fizzkart.com/user-login/?user=<?=$cms->encryptcode($user_name)?>" target="_blank"><?=$user_name?> </a></td>
    <td align="center"><?=$address?></td>
    <td align="center"><?=$email_id?></td>
    <td align="center" class="<?=strtolower($status)?>"><?=$status?></td>
    <td align="center"><?=$adm->action(SITE_PATH_ADM.CPAGE."?mode=add&start=".$_GET['start']."",$pid)?></td>

    </tr>
    <?php $nums++;}}else{ echo $adm->rowerror(8);} ?>   
  </table>
 