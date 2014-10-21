<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php  
	if($update){
		$cms->db_query(" delete from   #_template where store_id ='".$_SESSION[uid]."' ");
	} 
	$check = $cms->getSingleresult(" select count(*) from   #_template where store_id ='".$_SESSION[uid]."' ");
	if(!$check){
		$tempQuery = $cms->db_query("select *  from #_template where store_id ='0' ");
		while($line = $cms->db_fetch_array($tempQuery)){ extract($line);
			$cont = 'src="http://fizzkart.com/images/logo.jpg"';
			$hedlogo = $cms->getSingleresult("select image from #_store_detail where store_user_id = '".$_SESSION[uid]."'"); 
			$store_url = '@'.$cms->getSingleresult("select store_url from #_store_detail where store_user_id = '".$_SESSION[uid]."'").'.fizzkart.com'; 
			$img = "http://fizzkart.com/uploaded_files/orginal/".$hedlogo; 
			$rep = 'src="'.$img.'" style="max-height:50px;"';
			$body = str_replace($cont,$rep,$body);
			$body = str_replace('@fizzkart.com',$store_url,$body);
			$body = str_replace('@Fizzkart.com',$store_url,$body);
		    $cms->db_query("insert into #_template set store_id ='".$_SESSION[uid]."', title ='".addslashes($title)."' , subject ='".addslashes($subject)."', body ='".addslashes($body)."' ");
		} 
		$adm->sessset('Mail Template have been updated!', 's');
		$cms->redir(SITE_PATH_MEM.CPAGE, true);
	}
	if($action=='del'){
		$cms->db_query("delete from #_template where pid in ($id)");  
		$adm->sessset('Record has been deleted', 'e');
		$cms->redir(SITE_PATH_MEM.CPAGE, true);
		exit;
	}
	if($cms->is_post_back() and !$_POST[search]){
		if($arr_ids) {
			$str_adm_ids = implode(",",$arr_ids);
			switch ($_POST['action']){
				case "delete":
					$cms->db_query("delete from #_template where pid in ($str_adm_ids) and store_id ='".$_SESSION[uid]."'");
					$adm->sessset(count($arr_ids).' Item(s) Delete', 'e');
					break;
				case "Inactive":
					$cms->db_query("update #_template set status = 'Inactive' where pid in ($str_adm_ids) and store_id ='".$_SESSION[uid]."'");
					$adm->sessset(count($arr_ids).' Item(s) Inactive', 'e');
					break;
				case "Active":
					$cms->db_query("update #_template set status = 'Active' where pid in ($str_adm_ids) and store_id ='".$_SESSION[uid]."'");
					$adm->sessset(count($arr_ids).' Item(s) Active', 's');
					break;
				default:
			}
		}
		$cms->redir(SITE_PATH_MEM.CPAGE, true);
		exit;
	}
	 
	$pagesize = DEF_PAGE_SIZE;
	$start = intval($start);
	$columns = "select * ";
	$sql = " from #_template where store_id ='".$_SESSION[uid]."' ";
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
  <td width="10%" align="center"><?=$adm->orders('Title',true)?></td>  
  <td width="35%" align="center"><?=$adm->orders('Subject',true)?></td>  
  <td width="10%" align="center"><?=$adm->orders('Status',true)?></td>
  <td width="10%" align="center"><?=$adm->norders('Action')?></td>
</tr>
<?php if($reccnt){ $nums=1; while ($line = $cms->db_fetch_array($result)){@extract($line);?>
<tr <?=$adm->even_odd($nums)?>>
<td align="center"><?=$nums?></td>
<td align="center"><?=$adm->check_input($pid)?></td>
<td align="center"><?=$title?></td> 
<td align="center"><?=$subject?></td>
<td align="center" class="<?=strtolower($status)?>"><?=$status?></td>
<td align="center"><?=$adm->action(SITE_PATH_MEM.CPAGE."?mode=add&start=".$_GET['start'],$pid)?></td>
</tr>
<?php $nums++;}}else{ echo $adm->rowerror(7);}?>   
</table>
 