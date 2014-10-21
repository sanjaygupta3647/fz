<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php 
	if($action=='del'){
 		$cms->db_query("delete from  #_barnds_product where prod_id in ($id)  and store_user_id = '".$_SESSION[uid]."'");
		$adm->sessset('Record has been deleted', 'e');
		$cms->redir(SITE_PATH_MEM.CPAGE, true);
		exit;
	}
	if($cms->is_post_back()){
		if($arr_ids) {
			$str_adm_ids = implode(",",$arr_ids);
			switch ($_POST['action']){
				case "delete":
					$cms->db_query("delete from  #_barnds_product where prod_id in ($str_adm_ids)  and store_user_id = '".$_SESSION[uid]."'");
					$adm->sessset(count($arr_ids).' Item(s) Delete', 'e');
					break;
				case "Inactive":
					$cms->db_query("update  #_barnds_product set status = 'Inactive' where prod_id in ($str_adm_ids) and store_user_id = '".$_SESSION[uid]."'");
					$adm->sessset(count($arr_ids).' Item(s) Inactive', 'e');
					break;
				case "Active":
					$cms->db_query("update  #_barnds_product set status = 'Active' where prod_id in ($str_adm_ids) and store_user_id = '".$_SESSION[uid]."'");
					$adm->sessset(count($arr_ids).' Item(s) Active', 's');
					break;
				default:
			}
		}
		$cms->redir(SITE_PATH_MEM.CPAGE, true);
		exit;
	}
	$pagesize = DEF_PAGE_SIZE;
	$listbrandprod = array();
	if($_GET[cat_id]){
		$catcond .= " and cat_id = '".$_GET[cat_id]."' ";
		$pagesize = 1000;
	}
	if($_GET[brand_id]){
		$catcond .= " and brand_id = '".$_GET[brand_id]."' ";
		$pagesize = 1000;
	}
	 

	$getbrands = $cms->db_query("select brand_id from fz_request_brand where status = 'Active' and store_user_id = '".$_SESSION[uid]."' "); 
	if(mysql_num_rows($getbrands)){
		while($r=$cms->db_fetch_array($getbrands)){
				$brands[] = $r[brand_id];
			} 
	}
	if(!count($brands)) $brands[] = 0;
     
	$getcatquery = $cms->db_query("select cat_id from fz_store_menu where parent != '0' and store_user_id = '".$_SESSION[uid]."' "); 
	if(mysql_num_rows($getcatquery)){
		while($r=$cms->db_fetch_array($getcatquery)){
				$cats[] = $r[cat_id];
			} 
	}
	if(!count($cats)) $cats[] = 0;

	$listbrandqry=$cms->db_query("select prod_id from fz_barnds_product where 1 $catcond and cat_id in (".implode(',',$cats).") and brand_id in (".implode(',',$brands).") and  store_user_id = '".$_SESSION[uid]."' "); 
	if(mysql_num_rows($listbrandqry)){
		while($RS=$cms->db_fetch_array($listbrandqry)){
									$listbrandprod[] = $RS[prod_id];
								} 
	}else{
		$listbrandprod[] = 0;	
	}
	if($_GET[title]){
		$cond = " and title like '%".$_GET[title]."%'"; 
	}
   	$start = intval($start);	
	$columns = "select * ";
	$sql = " from #_products_user where pid in (".implode(',',$listbrandprod)." ) $cond ";
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
      <td width="10%" align="center"><?=$adm->orders('Name',true)?></td>  
	  <td width="6%" align="center"><?=$adm->orders('Brand Name',true)?></td>  
      <td width="16%" align="center"><?=$adm->orders('Category',true)?></td> 
      <td width="13%" align="center"><?=$adm->orders('Price',true)?></td>
	  <td width="13%" align="center"><?=$adm->orders('Offer Price',true)?></td> 
	  <td width="6%" align="center"><?=$adm->orders('Multiple Price',true)?></td>
	  <td width="5%" align="center"><?=$adm->orders('Hotdeal',true)?></td>
	  <td width="5%" align="center"><?=$adm->orders('Status',true)?></td>
      <td width="12%" align="center"><?=$adm->norders('Action')?></td>
    </tr>
    <?php if($reccnt){  if($start){$nums= $start+1;}else { $nums= 1;}  while ($line = $cms->db_fetch_array($result)){@extract($line);?>
    <tr <?=$adm->even_odd($nums)?>>
    <td align="center"><?=$nums?></td>
    <td align="center"><?=$adm->check_input($pid)?></td>
    <td align="center"><?=$title?></td> 
	<?php
	 //$subcat = $cms->getSingleresult("select cat_id from #_barnds_product where prod_id = '$pid' and store_user_id = '".$_SESSION[uid]."'");
	  
	?>
	<td align="center"><?=$cms->getSingleresult("select title from #_store_detail where store_user_id = '$store_user_id'")?></td> 

	<?php $par = $cms->getSingleresult("select parentId  from #_category where pid = '$cat_id'")?>
	<?php  $parname = $cms->getSingleresult("select name  from fz_store_menu where cat_id = '$par' and store_user_id = '".$_SESSION[uid]."' ");?>
    <td align="center"><?=($parname)?$parname:'NA'?> -> <?=$cms->getSingleresult("select name  from fz_store_menu where cat_id = '$cat_id' and store_user_id = '".$_SESSION[uid]."'")?></td>
	
    
    <td align="center"><?=($cms->getPriceOnly($pid,$_SESSION[uid]))?CUR.$cms->getPriceOnly($pid,$_SESSION[uid]):'NA'?></td> 
	<?php
		$offerprice2 = $cms->getSingleresult("select offerprice from #_barnds_product where prod_id = '$pid' and store_user_id = '".$_SESSION[uid]."'");
		if($offerprice2){
			$offerprice = $offerprice2;
		}
	?>
	<td align="center"><?=($offerprice)?CUR.$offerprice:'NA'?></td>
	<?php
	 $porder = $cms->getSingleresult("select porder from #_barnds_product where prod_id = '$pid' and store_user_id = '".$_SESSION[uid]."'");
	 $show_home = $cms->getSingleresult("select show_home from #_barnds_product where prod_id = '$pid' and store_user_id = '".$_SESSION[uid]."'");
	 ?>
	 
	 
	<?php
	$status = $cms->getSingleresult("select status from #_barnds_product where prod_id = '$pid' and store_user_id = '".$_SESSION[uid]."'");
	?>
	 <td align="center">
	 <?=$cms->getSingleresult("select count(*) from #_product_price where proid = '$pid'")?></td>
	 <?php
	   $offer_type = $cms->getSingleresult("select offer_type from #_barnds_product where prod_id = '$pid' and brand_id = '$store_user_id' and store_user_id = '".$_SESSION[uid]."'  ");
	  $deal = '<b style="color:green;font-size:14px">Yes</b>';
	   ?>
	<td align="center" ><?=($offer_type=='hotdeal')?$deal:'No'?></td>
    <td align="center" class="<?=strtolower($status)?>"><?=$status?></td>
	<td align="center"><?=$adm->action(SITE_PATH_MEM.CPAGE."?mode=add&start=".$_GET['start']."",$pid)?></td>
    </tr>
    <?php $nums++;}}else{ echo $adm->rowerror(7);}?>   
  </table>
 