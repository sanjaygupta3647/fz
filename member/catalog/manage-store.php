<?php include("../../lib/opin.inc.php")?>
<?php define("CPAGE","catalog/")?>
<?php include("../inc/header.inc.php")?>
<?php 
 

	if($action=='del'){
		$cms->db_query("delete from #_store_detail where pid in ($id)");
		$adm->sessset('Record has been deleted', 'e');
		$cms->redir(SITE_PATH_ADM.CPAGE."/collections.php", true);
		exit;
	}
	if($cms->is_post_back()){
		if($arr_ids) {
			$str_adm_ids = implode(",",$arr_ids);
			switch ($_POST['action']){
				case "delete":
					$cms->db_query("delete from #_store_detail where pid in ($str_adm_ids)");
					$adm->sessset(count($arr_ids).' Item(s) Delete', 'e');
					break;
				case "Inactive":
					$cms->db_query("update #_store_detail set status = 'Inactive' where pid in ($str_adm_ids)");
					$adm->sessset(count($arr_ids).' Item(s) Inactive', 'e');
					break;
				case "Active":
					$cms->db_query("update #_store_detail set status = 'Active' where pid in ($str_adm_ids)");
					$adm->sessset(count($arr_ids).' Item(s) Active', 's');
					break;
				default:
			}
		}
		$cms->redir(SITE_PATH_ADM.CPAGE."/manage-store.php", true);
		exit;
	}
	$start = intval($start);
	$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
	$columns = "select * ";
	$sql = " from #_store_detail where 1   ";
	$order_by == '' ? $order_by = '(pid)' : true;
	$order_by2 == '' ? $order_by2 = 'desc' : true;
	$sql_count = "select count(*) ".$sql; 
	$sql .= "order by $order_by $order_by2 ";
	$sql .= "limit $start, $pagesize ";
	$sql = $columns.$sql;
	$result = $cms->db_query($sql);
	$reccnt = $cms->db_scalar($sql_count);
?>
<div class="main">
<header>
     
      <div class="hrd-right-wrap">
       <?php /*?> <nav>
          <ul>
            <li> <a href="<?=SITE_PATH_ADM?>"></a> </li>
            <li> <a href="<?=SITE_PATH_ADM?>catalog/collections.php">store_detail</a> </li>
            <li> <a href="<?=SITE_PATH_ADM?>catalog/manage-category.php">Category</a> </li>
            <li> <a href="<?=SITE_PATH_ADM?>setting.php?mode=true">Setting</a> </li>
           <!-- <li> <a href="">System</a> </li>-->
          </ul>
        </nav><?php */?>
        
        <div class="brdcm" id="hed-tit">Banner</div>
        <div class="unvrl-btn"> 
        <a href="<?=SITE_PATH_ADM.CPAGE.'/add-store.php'?>" class="ub">
        <img  src="<?=SITE_PATH_ADM?>images/add-new.png" alt=""></a>
         <?php if(!$_GET[id]){?>
        <a href="javascript:void(0)" class="ub"   onclick="javascript:submitions('delete');">
        <img src="<?=SITE_PATH_ADM?>images/delete.png" alt=""></a>
        <?php /*?><a href="javascript:void(0)" class="ub">
        <img src="<?=SITE_PATH_ADM?>images/cancel.png" alt=""></a><?php */?>
        <a href="javascript:void(0)"  onclick="javascript:submitions('Active');"class="ub">
        <img src="<?=SITE_PATH_ADM?>images/active.png" alt=""></a>
        <a href="javascript:void(0)" onClick="javascript:submitions('Inactive');" class="ub">
        <img src="<?=SITE_PATH_ADM?>images/inactive.png" alt=""></a><?php }?>
        <?php /*?><a href="javascript:void(0)" class="ub">
        <img src="<?=SITE_PATH_ADM?>images/restore.png" alt=""></a><?php */?>
       <?php if($_GET[id]){?>
        <a href="javascript:void(0)" onclick="javascript:formback();" class="ub">
        <img src="<?=SITE_PATH_ADM?>images/back.png" alt=""></a><?php }?>
        
        </div> 
      </div>
      <div class="cl"></div>
    </header> 
    
 <div class="cl"></div>
<div class="content">
<div class="div-tbl">
<div class="cl"></div>
    <? //$adm->h1_tag('Dashboard &rsaquo; Collection Manager',$others)?>
   
<?php $hedtitle = "Store Management"; ?>    
      <?=$adm->alert()?>
      <div class="title"  id="innertit">
        <?=$adm->heading('Store Management')?>
      </div>
      <div class="tbl-contant">
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0"  class="data-tbl">
          <tr class="t-hdr">
            <td width="2%" align="center"><?=$adm->orders('#',false)?></td>
            <td width="3%" align="center" valign="middle"><?=$adm->check_all()?></td>
            <td width="15%" align="center"><?=$adm->orders('Store Url',true)?></td>
            <td width="10%" align="center"><?=$adm->orders('City',true)?></td>
            <td width="20%" align="center"><?=$adm->orders('Address',true)?></td>
            <td width="11%" align="center"><?=$adm->orders('Image',true)?></td>
            <td width="15%" align="center"><?=$adm->orders('Owner',true)?></td>
            <td width="7%" align="center"><?=$adm->orders('Popular',true)?></td>
            <td width="7%" align="center"><?=$adm->orders('Most Visited',true)?></td>
            <td width="8%" align="center"><?=$adm->orders('Status',true)?></td>
            <td width="10%" align="center"><?=$adm->norders('Action')?></td>
          </tr>
          <?php if($reccnt){ $nums=1; while ($line = $cms->db_fetch_array($result)){@extract($line);?>
          <tr <?=$adm->even_odd($nums)?>>
            <td align="center"><?=$nums?></td>
            <td align="center"><?=$adm->check_input($pid)?></td>
            <td align="center"><?=$store_url?></td>
            <td align="center"><?=$cms->getSingleresult("select city  from #_city  where  pid = '$city_id' ")?></td>
            <td align="center"><?=$Address?></td>
            <td align="center"><? if($image1  and is_file($_SERVER['DOCUMENT_ROOT'].SITE_SUB_PATH."uploaded_files/orginal/".$image1)==true){?>
            <img src="<?=SITE_PATH?>uploaded_files/orginal/<?=$image?>" width="100"><? } echo "NA";?></td>
             <td align="center"><?=$cms->getSingleresult("select name  from #_store_user  where  pid = '$store_user_id' ")?></td>
             <td align="center"><?=($our_popular_storr)?'Yes':'No'?></td>
             <td align="center"><?=($most_visited)?'Yes':'No'?></td> 
            <td align="center" class="<?=strtolower($status)?>"><?=$status?></td>
            <td align="center"><?=$adm->cataction(SITE_PATH_ADM.CPAGE."/add-store.php",$pid, CPAGE.'/manage-store.php')?></td>
          </tr>
          <?php $nums++;}}else{ echo $adm->rowerror(5);}?>
        </table>
      </div>
    </div>
<?php include("../inc/footer.inc.php")?>
</div>
<div class="cl"></div>
</div>
</div>

<script type="text/javascript">
var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
var Accordion1 = new Spry.Widget.Accordion("Accordion1");
</script>
</body>
</html>
