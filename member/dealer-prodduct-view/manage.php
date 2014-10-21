<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php     
$listbrandprod[] = 0;
 $listbrandqry=$cms->db_query("select prod_id from fz_product_view where brand_id = '".$_SESSION[uid]."' and store_user_id ='$soterId' "); 
	if(mysql_num_rows($listbrandqry)){
		while($RS=$cms->db_fetch_array($listbrandqry)){
									$listbrandprod[] = $RS[prod_id];
								} 
	} 
if($cms->is_post_back()){
		if($arr_ids) {
			$str_adm_ids = implode(",",$arr_ids);
			switch ($_POST['action']){ 
				case "Remove":
					if(count($arr_ids)){
						foreach($arr_ids as $val){ 
							 	$cms->db_query("delete from #_product_view where prod_id = '".$val."' ");
						}
					}
					$adm->sessset(count($arr_ids).' Item(s) Are Deleted', 'e');
					break; 
				default:
			}
		}
		$cms->redir(SITE_PATH_MEM.CPAGE.'?soterId='.$soterId, true);
		exit;
	}
 	$soreurl=$cms->getSingleresult("select store_url from #_store_detail where store_user_id = '$soterId' ");
	$start = intval($start);
	$pagesize = DEF_PAGE_SIZE;
	$columns = "select * "; 
	$sql = " from #_products_user where store_user_id  = '".$_SESSION[uid]."' and pid in (".implode(',',$listbrandprod).") "; 
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
	   <td width="15%" align="center"><?=$adm->orders('View Times',true)?></td> 
      <!-- <td width="15%" align="center"><?=$adm->orders('Price',true)?></td>
	   <td width="15%" align="center"><?=$adm->orders('Offer Price',true)?></td> -->
    </tr>
    <?php if($reccnt){ $nums=1; while ($line = $cms->db_fetch_array($result)){@extract($line);?>
    <tr <?=$adm->even_odd($nums)?>>
    <td align="center"><?=$nums?></td> 
	<td align="center"><?=$adm->check_input($pid)?></td>
    <td align="center"><a href="http://<?=$soreurl?>.fizzkart.com/detail/<?=$title?>/<?=$pid?>" target="_blank"><?=$title?></a></td> 
    <td align="center"><?=$cms->getSingleresult("select name  from #_category where `pid` = '$cat_id'")?></td>
	 <td align="center"><?=$cms->getSingleresult("select count(*) from #_product_view where store_user_id='$soterId' and prod_id='$pid'");?></td>
   <!--  <?php $price=$cms->getSingleresult("select dprice  from #_product_price where `proid` = '$pid'") ?>
    <td align="center"><?=($price)?CUR.$price:'NA'?></td> 
	<?php $offerprice=$cms->getSingleresult("select dofferprice  from #_product_price where `proid` = '$pid'");  ?>
	<td align="center"><?=($offerprice)?CUR.$offerprice:'NA'?></td>  -->
    </tr>
    <?php $nums++;}}else{ echo $adm->rowerror(7);}?>   
  </table>
 