<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php 

if($accept>0){
		$admqry = $cms->db_query("select * from #_products_user where pid  ='$accept' ");
		$admprod = $cms->db_fetch_array($admqry);@extract($admprod); 
		$arr[store_user_id] = $_SESSION[uid];
		$arr[admin_product_id] = $pid;
		$arr[cat_id] = $cat_id;
		$arr[kf1] = $kf1;
		$arr[kf2] = $kf2;
		$arr[kf3] = $kf3;
	    $arr[meta_title] = $meta_title;
		$arr[meta_keyword] = $meta_keyword;
		$arr[meta_description] = $meta_description;
        $arr[shipping] = $shipping;
		$arr[pcode] = $pcode;
		$arr[discount] = $discount;
		$arr[combo] = $combo;
		$arr[seasional_offer] = $seasional_offer;
		$arr[hot_deal] = $hot_deal;
 		$arr[title] = $title;
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
		$arr[show_home] = $show_home;
		$arr[porder] = $porder;
		$arr[offerprice] = $offerprice;
		$arr[color] = $color;
		$cms->sqlquery("rs","products_user",$arr);
		$lastid = mysql_insert_id();
		$getallprice=$cms->db_query("select * from #_product_price where proid ='$accept' ");
		if(mysql_num_rows($getallprice)){
			while($rs=$cms->db_fetch_array($getallprice)){ 
				$prinsert = "insert into #_product_price set proid = '$lastid',store_id = '".$_SESSION[uid]."', dtitle = '".$rs[dtitle]."',
				dsize = '".$rs[dsize]."',dprice = '".$rs[dprice]."',dofferprice = '".$rs[dofferprice]."' ";
				$cms->db_query($prinsert);
			}
		}
		$features=$cms->db_query("select * from #_product_feature where prod_id='".$accept."'");
		if(mysql_num_rows($features)){
			while($res=$cms->db_fetch_array($features)){ 
				@extract($res);
				$arr2 = array();
				$arr2[prod_id] =$lastid;
				$arr2[ftitle] = $ftitle;
				$arr2[fdescription] =$fdescription;			
				$cms->sqlquery("rs","product_feature",$arr2); 
			}
		}
		$adm->sessset('Product has been added to your product list', 's');
		$cms->redir(SITE_PATH_MEM.CPAGE, true);
		exit;
	} 
	if($action=='del'){ 
		$arr_ids[] = $id; 
		$str_adm_ids = implode(",",$arr_ids);
		//$cms->product_del_mail($str_adm_ids,'del',$_SESSION[uid]);
		$cms->db_query("delete from #_product_feature where prod_id in ($str_adm_ids)"); 
		$cms->db_query("delete from #_products_user where pid in ($str_adm_ids)");
		$cms->db_query("delete from #_product_price where proid in ($str_adm_ids)");
		$adm->sessset('Record has been deleted', 'e');
		$cms->redir(SITE_PATH_MEM.CPAGE, true);
		exit;
	}
	if($cms->is_post_back() and !$_POST[search]){
		if($arr_ids) {
			$str_adm_ids = implode(",",$arr_ids);
			switch ($_POST['action']){
				case "delete":
				    //$cms->product_del_mail($str_adm_ids,'delete',$_SESSION[uid]);
					$cms->db_query("delete from #_product_feature where prod_id in ($str_adm_ids)");
					$cms->db_query("delete from #_products_user where pid in ($str_adm_ids)");
					$cms->db_query("delete from #_product_price where proid in ($str_adm_ids)");
					$adm->sessset(count($arr_ids).' Item(s) Delete', 'e');
					break;
				case "Inactive":
					$cms->db_query("update #_products_user set status = 'Inactive' where pid in ($str_adm_ids)");
					$adm->sessset(count($arr_ids).' Item(s) Inactive', 'e');
					//$cms->product_update_mail($str_adm_ids,'Inactive',$_SESSION[uid]);
					break;
				case "Active":
					$cms->db_query("update #_products_user set status = 'Active' where pid in ($str_adm_ids)");
					$adm->sessset(count($arr_ids).' Item(s) Active', 's');
					//$cms->product_update_mail($str_adm_ids,'Active',$_SESSION[uid]);
					break;
					default:
			}
		}
		$cms->redir(SITE_PATH_MEM.CPAGE, true);
		exit;
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
	if($_GET[show_home]){
		$sh  = ($_GET[show_home]=='Yes')?'1':'0';
		$cond .= " and show_home = '".$sh."' ";
 	}
	/*if($_GET[combo]){
 		$cond .= " and combo !=0";
 	}
	if($_GET[seasional_offer]){
		$sh  = ($_GET[seasional_offer]=='Yes')?'1':'0';
		$cond .= " and seasional_offer = '".$sh."' ";
 	}*/
	if($_GET[offer_type]!=""){
	    $sh  = $_GET[offer_type]; 
		$cond .= " and offer_type = '".$sh."' ";
 	}
	}else{
	$pagesize = DEF_PAGE_SIZE;
	} 
	$columns = "select * ";
	$sql = " from #_products_user where store_user_id ='".$_SESSION[uid]."' $cond ";
	$order_by == '' ? $order_by = 'pid' : true;
	$order_by2 == '' ? $order_by2 = 'desc' : true;
	$sql_count = "select count(*) ".$sql; 
	$sql .= "order by $order_by $order_by2 ";
	$sql .= "limit $start, $pagesize";
	$sql = $columns.$sql;
	$result = $cms->db_query($sql);
	$reccnt = $cms->db_scalar($sql_count);
?>
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0"  class="data-tbl">
    <tr class="t-hdr">
      <td width="6%" align="center"><?=$adm->orders('#',false)?></td>
      <td width="6%" align="center" valign="middle"><?=$adm->check_all()?></td>
      <td width="20%" align="center"><?=$adm->orders('Name',true)?></td>  
	  <td width="8%" align="center"><?=$adm->orders('Copy this',true)?></td> 
      <td width="10%" align="center"><?=$adm->orders('Sub Category',true)?></td>  
      <td width="10%" align="center"><?=$adm->orders('Price',true)?></td>
	  <td width="10%" align="center"><?=$adm->orders('Offer Price',true)?></td>
	  <td width="5%" align="center"><?=$adm->orders('Home Product',true)?></td>
      <td width="5%" align="center"><?=$adm->orders('Offer Type',true)?></td> 
	  <td width="5%" align="center"><?=$adm->orders('Status',true)?></td>
      <td width="12%" align="center"><?=$adm->norders('Action')?></td>
    </tr>
    <?php if($reccnt){ if($start){$nums= $start+1;}else { $nums= 1;} while ($line = $cms->db_fetch_array($result)){@extract($line);?>
	 
    <tr <?=$adm->even_odd($nums)?>>
    <td align="center"><?=$nums?></td>
    <td align="center"><?=$adm->check_input($pid)?></td>
    <td align="center"><?=($title)?strip_tags($title):'No Name'?></td>
	<td align="center"><a href="<?=SITE_PATH_MEM.CPAGE?>?accept=<?=$pid?>">Copy</a></td>
    <td align="center"><?=$cms->getSingleresult("select name  from #_category where `pid` = '$cat_id'")?></td>
	 <?php $price=$cms->getSingleresult("select dprice  from #_product_price where `proid` = '$pid'") ?>
    <td align="center"><?=($price)?CUR.$price:'NA'?></td> 
	<?php $offerprice=$cms->getSingleresult("select dofferprice  from #_product_price where `proid` = '$pid'");  ?>
	<td align="center"><?=($offerprice)?CUR.$offerprice:'NA'?></td> 
	<td align="center"><?=($show_home)?'Yes':'No'?></td> 
	<td align="center"><?=($offer_type)?></td>  
    <td align="center"><?=$status?></td>
	<td align="center"><?=$adm->action(SITE_PATH_MEM.CPAGE."?mode=add&start=".$_GET['start'],$pid)?></td>
    </tr>  
    <?php  $nums++;}}else{ echo $adm->rowerror(11);}?>   
  </table>
 