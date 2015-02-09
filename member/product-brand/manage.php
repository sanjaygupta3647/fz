<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php 
        $numOfProducts = $cms->getSingleresult("select t1.noOfProducts from #_plans as t1, #_store_detail as t2 where t2.pid ='".$_SESSION[store_id]."' and t1.pid= t2.plan_id");
		$prod_user = $cms->getSingleresult("select count(*) from #_products_user where store_user_id ='".$_SESSION[uid]."' "); 
		$prod_brand = $cms->getSingleresult("select count(*) from #_barnds_product where store_user_id ='".$_SESSION[uid]."' ");
		$total= $prod_user + $prod_brand; 
$catts[] = 0;
$rsAdmin=$cms->db_query("select cat_id from #_store_menu where store_user_id='".$_SESSION[uid]."' and parent!='0'");
while($arrAdmin=$cms->db_fetch_array($rsAdmin)){
	@extract($arrAdmin);
	$catts[] = $cat_id;
}
   
$listbrandprod = array();
$listbrandprod[] = 0;
$listbrandqry=$cms->db_query("select prod_id from fz_barnds_product where brand_id = '$soterId' and store_user_id = '".$_SESSION[uid]."' "); 
if(mysql_num_rows($listbrandqry)){
	while($RS=$cms->db_fetch_array($listbrandqry)){
								$listbrandprod[] = $RS[prod_id];
							} 
}
	if($cms->is_post_back()){
		if($arr_ids) {
			$str_adm_ids = implode(",",$arr_ids);
			switch ($_POST['action']){
			 case "Add":
				if($total<$numOfProducts){
					if(count($arr_ids)){
							foreach($arr_ids as $val){
								$check = $cms->db_query("select * from #_product_price where proid = '".$val."' "); 
									while ($rs = $cms->db_fetch_array($check)){@extract($rs);
									$arr = array();
									$arr[offerprice] = $dofferprice;
									$arr[dimension] = $dsize;
									$arr[brand_id] = $soterId;
									$arr[cat_id] = $cms->getSingleresult("select cat_id from #_products_user where pid = '".$val."'");
									$arr[store_user_id] = $_SESSION[uid];
									$arr[prod_id] = $val; 
									$arr[submitdate] = time();
									$cms->sqlquery("rs","barnds_product",$arr); 
							}		} 
					  }else{
					  $adm->sessset('You  Are Added Maximum Number of products.', 's');
					  }	
					} 
					$adm->sessset(count($arr_ids).' Item(s) Are Added', 's');
					break;
				case "Remove":
					if(count($arr_ids)){
						foreach($arr_ids as $val){
							$arr2 = array(); 
							$arr2[prod_id] = $val;
							$arr2[brand_id] = $cms->getSingleresult("select store_user_id from #_products_user where pid = '".$val."'"); 
							$arr2[store_user_id] = $_SESSION[uid]; 
							$check = $cms->getSingleresult("select count(*) from #_barnds_product where prod_id = '".$val."' and brand_id = '".$arr2[brand_id]."' 
							and  store_user_id = '".$_SESSION[uid]."' ");
							if($check)	$cms->db_query("delete from #_barnds_product where prod_id = '".$val."' and brand_id = '".$arr2[brand_id]."' and  store_user_id = '".$_SESSION[uid]."' ");
						}
					}
					$adm->sessset(count($arr_ids).' Item(s) Are Deleted', 'e');
					break; 
				default:
			}
		}
		if($type) $c   = "&type=".$_GET[type];
		$cms->redir(SITE_PATH_MEM.CPAGE.'?soterId='.$soterId.$c, true);
		exit;
	}
 	if($accept>0){
	    if($total<$numOfProducts){
	    	$check = $cms->db_query("select * from #_product_price where proid = '".$accept."' ");
			if(mysql_num_rows($check)){
				while ($rs = $cms->db_fetch_array($check)){@extract($rs);
				$arr = array(); 
				$arr[offerprice] = $dofferprice;
				$arr[dimension] = $dsize;
				$arr[brand_id] = $soterId;
				$arr[cat_id] = $cms->getSingleresult("select cat_id from #_products_user where pid = '".$accept."'");
				$arr[store_user_id] = $_SESSION[uid];
				$arr[prod_id] = $accept; 
				$arr[submitdate] = time();
				$cms->sqlquery("rs","barnds_product",$arr);
				$lastid = mysql_insert_id();  
				}
				if($lastid){
					$adm->sessset('Product has been added to your product list', 's');
					$cms->redir(SITE_PATH_MEM.CPAGE.'?soterId='.$soterId, true);
					exit; 
				}
			}else{
				$adm->sessset('Product has not been added to your product list', 'e');
				$cms->redir(SITE_PATH_MEM.CPAGE.'?soterId='.$soterId, true);
				exit; 
			}
		}else{
		       $adm->sessset('You  Are Added Maximum Number of products.', 's'); 
		}
		 
	}  
	$start = intval($start);
	if($search){
	$pagesize = 500;
	if($_GET[cat_id]!=""){
	 $cond .= " and cat_id=".$_GET[cat_id]; 
	}
	if($_GET[title]!=""){
	 $cond .= " and title like '%".$_GET[title]."%'"; 
	}
	}else{
	$pagesize = DEF_PAGE_SIZE;
	} 
	$columns = "select * ";


if($_GET['type']=='added'){  
	$sql = " from #_products_user where store_user_id  = '$soterId' and cat_id in (".implode(',',$catts).") and pid  in (".implode(',',$listbrandprod).") $cond ";
	  
}else{  
	$sql = " from #_products_user where store_user_id  = '$soterId' and cat_id in (".implode(',',$catts).") and pid not in (".implode(',',$listbrandprod).") $cond ";
}
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
      <td width="15%" align="center"><?=$adm->orders('Name',true)?></td>  
      <td width="15%" align="center"><?=$adm->orders('Category',true)?></td>  
       <td width="15%" align="center"><?=$adm->orders('Price',true)?></td>
	     <td width="15%" align="center"><?=$adm->orders('Offer Price',true)?></td>
	  <td width="15%" align="center"><?=$adm->orders('Status',true)?></td>
      <td width="12%" align="center"><?=$adm->norders('Action')?></td>
    </tr>
    <?php if($reccnt){ $nums=1; while ($line = $cms->db_fetch_array($result)){@extract($line);?>
    <tr <?=$adm->even_odd($nums)?>>
    <td align="center"><?=$nums?></td> 
	<td align="center"><?=$adm->check_input($pid)?></td>
    <td align="center"><?=$title?></td> 
    <td align="center"><?=$cms->getSingleresult("select name  from #_category where `pid` = '$cat_id'")?></td>
    <td align="center"><?=($cms->getPriceOnly($pid,$_SESSION[uid]))?CUR.$cms->getPriceOnly($pid,$_SESSION[uid]):'NA'?></td>
	 
	<td align="center"><?=($cms->getOfferpriceOnly($pid,$_SESSION[uid]))?CUR.$cms->getOfferpriceOnly($pid,$_SESSION[uid]):'NA'?></td> 
    <td align="center" class="<?=strtolower($status)?>"><?=$status?></td>
	<td align="center"><? if(!in_array($pid,$listbrandprod)){?><a href="<?=SITE_PATH_MEM.CPAGE?>?mode=add&id=<?=$pid?>&soterId=<?=$soterId?>">View Detail</a>&nbsp;&nbsp;&nbsp;
	<?php }else{ ?>   <?=$adm->action(SITE_PATH_MEM."brands-prod/"."?soterId=".$_GET['soterId']."&type=added&mode=add&start=".$_GET['start']."",$pid)?>   <?php } ?>
	<? if(!in_array($pid,$listbrandprod)){?>
	<a href="<?=SITE_PATH_MEM.CPAGE?>?accept=<?=$pid?>&soterId=<?=$soterId?>">Accept</a><?php } ?></td>
    </tr>
    <?php $nums++;}}else{ echo $adm->rowerror(7);}?>   
  </table>
 