<?php include("../../lib/opin.inc.php")?>
<?php define("CPAGE","catalog/")?>
<?php include("../inc/header.inc.php")?>
<div class="main">
<header> 
      <div class="hrd-right-wrap"> 
        <div class="brdcm" id="hed-tit">Product Category</div>
        <div class="unvrl-btn">  
         <?php if(!$_GET[id]){?>
        <a href="javascript:void(0)" class="ub"   onclick="javascript:submitions('delete');">
        <img src="<?=SITE_PATH_ADM?>images/delete.png" alt=""></a>  
         <?php }?>
        <?php /*?><a href="javascript:void(0)" class="ub">
        <img src="<?=SITE_PATH_ADM?>images/restore.png" alt=""></a><?php */?>
       <?php if($parentId){?>
        <a href="javascript:void(0)" onclick="javascript:formback();" class="ub">
        <img src="<?=SITE_PATH_ADM?>images/back.png" alt=""></a><?php }?>
        
        </div> 
      </div>
      <div class="cl"></div>
    </header>  
 <div class="cl"></div> 
<?php 
 
	if($action=='del'){
		$cms->db_query("delete from #_page_view where pid in ($id)");
		$adm->sessset('Record has been deleted', 'e');
		$cms->redir(SITE_PATH_ADM.CPAGE."/page-view-sub.php?parentId=".$parentId, true);
		exit;
	}
	if($cms->is_post_back()){
		if($arr_ids) {
			$str_adm_ids = implode(",",$arr_ids);
			switch ($_POST['action']){
				case "delete":
					$cms->db_query("delete from #_page_view where pid in ($str_adm_ids)");
					$adm->sessset(count($arr_ids).' Item(s) Delete', 'e');
					break;
				case "Inactive": 
				default:
			}
		}
		$cms->redir(SITE_PATH_ADM.CPAGE."/page-view-sub.php?parentId=".$parentId, true);
		exit;
	}
	 $cond = "";
	 $parentId=$_GET[parentId];
	 if($parentId)
	{
		$cond= " and store_user_id =$parentId ";
	}
	$start = intval($start);
	$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
	$columns = "select * ";
	$sql = " from #_page_view where 1 ".$cond;
	$order_by == '' ? $order_by = 'pid' : true;
	$order_by2 == '' ? $order_by2 = 'desc' : true;
	$sql_count = "select count(*) ".$sql; 
	$sql .= "order by $order_by $order_by2 ";
	$sql .= "limit $start, $pagesize ";
	$sql = $columns.$sql;
	$result = $cms->db_query($sql);
	$reccnt = $cms->db_scalar($sql_count);
?>
<div class="content">
<div class="div-tbl">
<div class="cl"></div>

<?php //$hedtitle = ucfirst(strtolower(stripslashes($cms->getSingleresult("select pc_name from #_page_view where store_user_id='$store_user_id'"))))." Product Category"; ?> 
    <? //$adm->h1_tag('Dashboard &rsaquo; Category Manager',$others)?> 
      <?=$adm->alert()?>
      <div class="title"  id="innertit">
        <h2><?=$cms->breadcrumbs()?></h2>
        
      </div>
      <div class="tbl-contant">
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0"  class="data-tbl">
          <tr class="t-hdr">
            <td width="5%" align="center"><?=$adm->orders('#',false)?></td>
            <td width="5%" align="center" valign="middle"><?=$adm->check_all()?></td>
            <td width="20%" align="center"><?=$adm->orders('PC Name',true)?></td>
            <td width="20%" align="center"><?=$adm->orders('URL',true)?></td>
            <td width="16%" align="center"><?=$adm->orders('Time',true)?></td> 
          </tr>
          <?php if($reccnt){if($start){$nums= $start+1;}else { $nums= 1;}  while ($line = $cms->db_fetch_array($result)){@extract($line);?>
          <tr <?=$adm->even_odd($nums)?>>
            <td align="center"><?=$nums?></td>
            <td align="center"><?=$adm->check_input($pid)?></td>
           <td align="center"><?=$pc_name?></td> 
			<td align="center"><a href="<?=$url?>" target="_blank"><?=$url?> </a></td>
			<td align="center"><?=$create_time?></td>
           <!-- <td align="center">
			<?=$adm->cataction(SITE_PATH_ADM.CPAGE."/page-view-sub.php",$pid."&parentId=".$parentId, CPAGE.'/page-view-sub.php')?>
            </td> -->
          </tr>
          <?php $nums++;}}else{ echo $adm->rowerror(5);}?>
        </table>
      </div> 
       <div class="cl"></div>
     <?php include("../inc/paging.inc.php")?>
    <div class="cl"></div>
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
