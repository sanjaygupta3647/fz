
<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php 
	if($action=='del'){
		$cms->db_query("delete from #_offer_detail where pid in ($id)");
		$adm->sessset('Record has been deleted', 'e');
		$cms->redir(SITE_PATH_MEM.CPAGE, true);
		exit;
	}
	if($cms->is_post_back()){
		if($arr_ids) {
			$str_adm_ids = implode(",",$arr_ids);
			switch ($_POST['action']){
				case "delete":
					$cms->db_query("delete from #_offer_detail where pid in ($str_adm_ids)");
					$adm->sessset(count($arr_ids).' Item(s) Delete', 'e');
					break;
				case "Inactive":
					$cms->db_query("update #_offer_detail set  status = 'Inactive' where pid in ($str_adm_ids)");
					$adm->sessset(count($arr_ids).' Item(s) Unread', 'e');
					break;
				case "Active":
					$cms->db_query("update #_offer_detail set  status = 'Active' where pid in ($str_adm_ids)");
					$adm->sessset(count($arr_ids).' Item(s) Read', 's');
					break;
				default:
			}
		}
		$cms->redir(SITE_PATH_MEM.CPAGE."?cat_id=$cat_id", true);
		exit;
	}
	$start = intval($start);
	$pagesize = DEF_PAGE_SIZE;
	$columns = "select * ";
	$sql = " from #_offer_detail where cat_id = '$cat_id' and  store_user_id = '".$_SESSION[uid]."' ";
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
	   <td width="15%" align="center"><?=$adm->orders('Title',true)?></td>
      <td width="10%" align="center"><?=$adm->orders('Type',true)?></td> 
	  <td width="5%" align="center"><?=$adm->orders('Brand',true)?></td> 
	  <td width="40%" align="center"><?=$adm->orders('Offer',true)?></td>  
	  <td width="5%" align="center"><?=$adm->orders('Priority',true)?></td>
	  <td width="10%" align="center"><?=$adm->orders('Status',true)?></td>
     
    </tr>
    <?php if($reccnt){ $nums=1; while ($line = $cms->db_fetch_array($result)){@extract($line);?>
    <tr <?=$adm->even_odd($nums)?>>
    <td align="center"><?=$nums?></td>
    <td align="center"><?=$adm->check_input($pid)?></td>
	<td align="center"><?=$title?></td>
    <td align="center">
	<?php 
	$count  = $cms->getSingleresult("select count(*) from #_offer_detail where store_user_id ='".$_SESSION[uid]."' and cat_id='$cat_id' ");
	$getpar = $cms->getSingleresult("select parent from #_store_menu where store_user_id ='".$_SESSION[uid]."' and cat_id='$cat_id' ");?>
	<a href="<?=SITE_PATH_MEM.CPAGE?>?mode=add&id=<?=$pid?>&cat_id=<?=$cat_id?>">  
	<?php
		switch ($type){
				case "freeProd":
					echo "Free Product";
					break;
				case "flatPercent":
					echo "Flat Discount";
					break;
				case "rangeQty":
					echo "Range Wise(Quantity)";
					break;
				case "rangeAmt":
					echo "Range Wise(Amount)";
					break;
				default:
			}	 
	 ?>
	</a></td> 
	<td align="center">
	<?php
    if($brand_id){
	echo $cms->getSingleresult("select title from fz_store_detail where store_user_id = '$brand_id'");
	}else{
		echo "Own Product";
	}
	?>
	 </td>
     <td align="center" ><?php
		switch ($type){
				case "freeProd":
					echo "On purchase of $onshop item(s) get $getfree items(s) free";
					break;
				case "flatPercent":
					echo " Get $flatpercent % discount on each item";
					break;
				case "rangeQty":
					echo "Get $qtyDisPercent % discount on shopping of product between $qty1 and $qty2";
					break;
				case "rangeAmt":
					echo "Get Rs $discAmt discount on shopping of product between Rs. $amount1 and Rs. $amount2";
					break;
				default:
			}	 
	 ?></td>
       <td align="center" class="<?=strtolower($status)?>"><?=$porder?></td>
	 <td align="center" class="<?=strtolower($status)?>"><?=$status?></td>
	 
    </tr>
    <?php $nums++;}}else{ echo $adm->rowerror(12);}?>   
  </table>
