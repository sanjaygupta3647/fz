<?php include("../../lib/opin.inc.php")?>
<?php define("CPAGE","catalog/")?>
<?php include("../inc/header.inc.php")?>
<div class="main">
<header>
     
      <div class="hrd-right-wrap">
        <?php /*?><nav>
          <ul>
            <li> <a href="<?=SITE_PATH_ADM?>"></a> </li>
            <li> <a href="<?=SITE_PATH_ADM?>catalog/collections.php">Products</a> </li>
            <li> <a href="<?=SITE_PATH_ADM?>catalog/manage-category.php">Category</a> </li>
            <li> <a href="<?=SITE_PATH_ADM?>setting.php?mode=true">Setting</a> </li>
           <!-- <li> <a href="">System</a> </li>-->
          </ul>
        </nav><?php */?>
        
        <div class="brdcm" id="hed-tit">Banner</div>
        <div class="unvrl-btn" style="width: 400px;">  
        
         <?php if(!$_SESSION[store_id]){?>
        <a href="javascript:void(0)" class="ub"   onclick="javascript:submitions('delete');">
        <img src="<?=SITE_PATH_M?>images/delete.png" alt=""></a><?php }?>
        <?php /*?><a href="javascript:void(0)" class="ub">
        <img src="<?=SITE_PATH_ADM?>images/cancel.png" alt=""></a><?php */?>
		<a target="_blank" href="http://fizzkart.com/ms_file/manage-orders-xls?store_user_id=<?=$_SESSION[uid]?>" >
		 <img width="32" src="<?=SITE_PATH_MEM?>images/xls.jpg" alt=""> </a> &nbsp;
		<a href="#" onclick="PrintDiv();" class="ub">
        <img src="<?=SITE_PATH_MEM?>images/print.jpg" alt=""> </a> 

        <div style="float:left;"><img src="<?=SITE_PATH?>member/images/pending.png" style="float:left;" width="20" height="20" />
		<a href="javascript:void(0)" onclick="javascript:submitions('pending');"class="ub">Pending</a></div>
        
        <div style="float:left;"><img src="<?=SITE_PATH?>member/images/complete.png" style="float:left;" width="20" height="20" />
        <a href="javascript:void(0)" onclick="javascript:submitions('complete');"class="ub">Complete</a></div>
        
        <div style="float:left;"><img src="<?=SITE_PATH?>member/images/cancel2.png" style="float:left;" width="21" height="20" />
        <a href="javascript:void(0)" onClick="javascript:submitions('cancel');" class="ub">Cancel</a></div>
        
        <?php /*?><a href="javascript:void(0)" class="ub">
        <img src="<?=SITE_PATH_ADM?>images/restore.png" alt=""></a><?php */?>
       <?php if($_SESSION[store_id]){?>
        <div style="float:left;"><img src="<?=SITE_PATH_MEM?>images/back2.png" style="float:left;" width="20" height="20" />
        <a href="javascript:void(0)" onclick="javascript:formback();" class="ub">Back</a></div><?php }?>
        
        </div> 
      </div>
      <div class="cl"></div>
    </header> 
    
 <div class="cl"></div><?
$order_ = true; 
/// echo $_POST['action'];die;
if($cms->is_post_back()){
	if($arr_ids) {
	//$arr_ids[] = $id; 
		$str_adm_ids = implode(",",$arr_ids); 
		switch ($_POST['action']){ 
			case "delete":
				$cms->db_query("delete from #_order_summary where pid in ($str_adm_ids)");
				$adm->sessset(count($arr_ids).' Item(s) Delete', 'e');
				break;
			case "complete": 
				$cms->db_query("update #_order_summary set status = 'complete' where pid in ($str_adm_ids)");
				$adm->sessset(count($arr_ids).' Order has been completed', 's');
				break;
			case "pending": 
				$cms->db_query("update #_order_summary set status = 'pending' where pid in ($str_adm_ids)");
				$adm->sessset(count($arr_ids).' Order is in pending', 's');
				break;
			case "cancel":
				$cms->db_query("update #_order_summary set status ='cancle' where pid in ($str_adm_ids)");
				$adm->sessset(count($arr_ids).' Order has been canceled', 'e');
				break;	
						
			default:
		}
	}
	$cms->redir(SITE_PATH_MEM.CPAGE."/manage-orders.php?id=".$id, true);
	exit;
}
if($_GET[uid]){ $cond = " and uid = '".$_GET[uid]."' ";}
$id=$_SESSION[store_id];
$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
$columns = "select * ";
$sql = "from #_order_summary where store_id = '$id' $cond ";
//$order_by == '' ? $order_by = 'pid' : true;
//$order_by2 == '' ? $order_by2 = 'desc' : true;
$sql_count = "select count(*) ".$sql; 
//$sql .= "order by $order_by $order_by2 ";
 
$sql .= "limit $start, $pagesize ";
$sql = $columns.$sql;
$result = $cms->db_query($sql);
$reccnt = $cms->db_scalar($sql_count);
?>
<div class="content">
<div class="div-tbl">
<div class="cl"></div> 
<?php $hedtitle = "Order Management"; ?>   
    <? //$adm->h1_tag('Dashboard &rsaquo; Orders Manager',$others)?> 
      <?=$adm->alert()?>
      <div class="title"  id="innertit">
        <? //$adm->heading('Orders Manager :- '.ucfirst($status))?> 
        <h2 class="bradcrumb"><?php
		if($mode=='add' && $id!=''){?>
			<a href="/member" rel="v:url" property="v:title">Home</a> »
			<a href="/member/catalog" rel="v:url" property="v:title">Manage Orders</a> » 
			<a href="/catalog/?mode=add&amp;start=&amp;id=<?=$id?>" rel="v:url" property="v:title">View</a>  
		<?php		
		}else if($mode=='add' && $id=='') { 
		    ?>
			<a href="/member" rel="v:url" property="v:title">Home</a> »
			<a href="/member/catalog" rel="v:url" property="v:title">Manage Orders</a> » 
			<a href="/member/catalog/?mode=add" rel="v:url" property="v:title">Add</a>  
		<?php
		}else{?>
		    <a href="/member" rel="v:url" property="v:title">Home</a> »
			<a href="/member/catalog" rel="v:url" property="v:title">Manage Orders</a> »  
		<?php 
		}
		?>
	  </h2>
      </div>
        <div class="tbl-contant"  id="divToPrint">
        <table id="myTable" width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="data-tbl">
         <thead> <tr class="t-hdr">
            <td width="3%" align="center"><?=$adm->orders('#',false)?></td>
            <td width="3%" align="center" valign="middle"><?=$adm->check_all()?></td>
			<td width="15%" align="center"><?=$adm->orders('User',true)?></td>
            <td width="20%" align="center"><?=$adm->orders('Order ID',true)?></td>
            <td width="20%" align="center"><?=$adm->orders('Amount',true)?></td>
			 <td width="16%" align="center"><?=$adm->orders('Time',true)?></td>
            <td width="15%" align="center"><?=$adm->orders('Status',true)?></td>
          </tr></thead>
		  <tbody>
          <?php if($reccnt){ $nums=1; while ($line = $cms->db_fetch_array($result)){@extract($line);?>
          <tr <?=$adm->even_odd($nums)?>>
            <td align="center"><?=$nums?></td>
            <td align="center"><?=$adm->check_input($pid)?></td>
			<td align="center"><?=$cms->getSingleresult("select fname from fz_members where pid = '$uid'")?> <?=$cms->getSingleresult("select lname from fz_members where pid = '$uid'")?></td>
            <td align="center"><a href="view-orders.php?orderid=<?=$orderid?>" target="_blank"><?=$orderid?></a></td>
            <td align="center" valign="top"><?=$cms->price_format($totalCost)?></td>
			<td align="center" valign="top"><?=$submitdate?></td>
            <td align="center" class="<?=strtolower($status)?>"><?=ucfirst($status)?></td>
          </tr>
          <?php $nums++;}}else{ echo $adm->rowerror(7);}?>
		  </tbody>
        </table>
      </div>
        </div>
<?php include("../inc/footer.inc.php")?>
</div>
<div class="cl"></div>
</div>
</div>

<script type="text/javascript">
 function PrintDiv() {    
           var divToPrint = document.getElementById('divToPrint');
           var popupWin = window.open('', '_blank', 'width=500,height=600');
           popupWin.document.open();
           popupWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</html>');
           popupWin.document.close();
           }
</script>
</body>
</html>