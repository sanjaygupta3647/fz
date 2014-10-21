<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php 
	if($accept>0){
		$admqry = $cms->db_query("select * from #_products where pid  ='$accept' ");
		$admprod = $cms->db_fetch_array($admqry);@extract($admprod); 
		$arr[store_user_id] = $_SESSION[uid];
		$arr[admin_product_id] = $pid;
		$arr[cat_id] = $cat_id;
 		$arr[title] = $title;
		$arr[kf1] = $kf1;
		$arr[kf2] = $kf2;
		$arr[kf3] = $kf3;
		$arr[meta_title] = $meta_title;
		$arr[meta_keyword] = $meta_keyword;
		$arr[meta_description] = $meta_description; 
		$arr[image1] = $image1;
		$arr[image2] = $image2;
		$arr[image3] = $image3;
		$arr[image4] = $image4;
		$arr[body1] = $body1;
		$arr[url] = $url;
		$arr[status] = $status;
		$arr[submitdate] = time();
		$arr[size] = $size;
		$arr[price] = $price;
		$arr[offerprice] = $offerprice;
		$arr[color] = $color;
		$cms->sqlquery("rs","products_user",$arr);
		$lastid = mysql_insert_id();
		$features=$cms->db_query("select * from #_admin_product_feature where prod_id='".$accept."'");
		while($res=$cms->db_fetch_array($features)){ 
			@extract($res);
			$arr2 = array();
			$arr2[prod_id] =$lastid;
			$arr2[ftitle] = $ftitle;
			$arr2[fdescription] =$fdescription; 
			$cms->sqlquery("rs","product_feature",$arr2); 
		}		
		$adm->sessset('Product has been added to your product list', 's');
		$cms->redir(SITE_PATH_MEM.CPAGE, true);
		exit;
	}
	$adminproids = array();
	$qry = $cms->db_query("select admin_product_id from #_products_user where store_user_id='".$_SESSION[uid]."' ");
	while($adminproid = $cms->db_fetch_array($qry)){$adminproids[] = $adminproid[admin_product_id];  }

 	$current_plan_id =  $cms->getSingleresult("select plan_id from #_store_detail where `store_user_id`='".$_SESSION[uid]."'");

	$cateqry=$cms->db_query("select cat_id from #_plans_category where plan_id='$current_plan_id' and parent!='0' order by pid desc");
	$subcategory = array();
	if(mysql_num_rows($cateqry)){
		while($catRes=$cms->db_fetch_array($cateqry)){  
			$scateqry=$cms->db_query("select pid,name from #_category where parentID='".$catRes[cat_id]."' order by name desc");
			if(mysql_num_rows($scateqry)){
				while($scatRes=$cms->db_fetch_array($scateqry)){
					$subcategory[] = $scatRes[pid]; 
				}			
			}else{
				$subcategory[] = $catRes[cat_id]; 			
			}

		}
	}
	$cond = "";
	  if(count($subcategory)){
		$cond = " and cat_id in (".implode(',',$subcategory).")";
	}   
	$start = intval($start);
	$pagesize = DEF_PAGE_SIZE;
	$columns = "select * ";
	$sql = " from #_products where 1 $cond ";
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
       
      <td width="15%" align="center"><?=$adm->orders('Name',true)?></td>  
      <td width="15%" align="center"><?=$adm->orders('Category',true)?></td>  
      <td width="15%" align="center"><?=$adm->orders('Price',true)?></td>
	  <td width="15%" align="center"><?=$adm->orders('Status',true)?></td>
      <td width="12%" align="center"><?=$adm->norders('Action')?></td>
    </tr>
    <?php if($reccnt){ $nums=1; while ($line = $cms->db_fetch_array($result)){@extract($line);?>
    <tr <?=$adm->even_odd($nums)?>>
    <td align="center"><?=$nums?></td> 
    <td align="center"><?=$title?></td> 
    <td align="center"><?=$cms->getSingleresult("select name  from #_category where `pid` = '$cat_id'")?></td>
    <td align="center"><?=($cms->getSingleresult("select dprice  from #_prod_price_admin where `proid` = '$pid'"))?CUR.$cms->getSingleresult("select dprice  from #_prod_price_admin where `proid` = '$pid'"):'NA'?></td> 
     <td align="center" class="<?=strtolower($status)?>"><?=$status?></td>
	<td align="center"><a href="<?=SITE_PATH_MEM.CPAGE?>?mode=add&id=<?=$pid?>">View Detail</a>&nbsp;&nbsp;&nbsp;
	<? if(!in_array($pid,$adminproids)){?>
	<a href="<?=SITE_PATH_MEM.CPAGE?>?accept=<?=$pid?>">Accept</a><? }else echo "<strong>Added</strong>";?></td>
    </tr>
    <?php $nums++;}}else{ echo $adm->rowerror(7);}?>   
  </table>
 