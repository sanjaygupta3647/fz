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
        
        <div class="brdcm" id="hed-tit">Product Sub Category</div>
        <div class="unvrl-btn"> 
        <a href="<?=SITE_PATH_ADM.CPAGE.'/add-pro-sub-category.php?parentId='.$parentId?>" class="ub">
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
		$cms->db_query("delete from #_category where pid in ($id)");
		$adm->sessset('Record has been deleted', 'e');
		$cms->redir(SITE_PATH_ADM.CPAGE."/manage-pro-sub-category.php?parentId=".$parentId, true);
		exit;
	}
	if($cms->is_post_back()){
		if($arr_ids) {
			$str_adm_ids = implode(",",$arr_ids);
			switch ($_POST['action']){
				case "delete":
					$cms->db_query("delete from #_category where pid in ($str_adm_ids)");
					$adm->sessset(count($arr_ids).' Item(s) Delete', 'e');
					break;
				case "Inactive":
					$cms->db_query("update #_category set status = 'Inactive' where pid in ($str_adm_ids)");
					$adm->sessset(count($arr_ids).' Item(s) Inactive', 'e');
					break;
				case "Active":
					$cms->db_query("update #_category set status = 'Active' where pid in ($str_adm_ids)");
					$adm->sessset(count($arr_ids).' Item(s) Active', 's');
					break;
				default:
			}
		}
		$cms->redir(SITE_PATH_ADM.CPAGE."/manage-pro-sub-category.php?parentId=".$parentId, true);
		exit;
	}
	$cond = "";
	if($parentId)
	{
		$cond= " and parentId = '$parentId' ";
	}
	$start = intval($start);
	$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
	$columns = "select * ";
	$sql = " from #_category where 1 ".$cond;
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

<?php $hedtitle = ucfirst(strtolower(stripslashes($cms->getSingleresult("select name from #_category where pid='$parentId'"))))." Product Sub Category"; ?> 
    <? //$adm->h1_tag('Dashboard &rsaquo; Category Manager',$others)?>
      
      <?=$adm->alert()?>
      <div class="title"  id="innertit">
         <h2 class="bradcrumb"> 
			<a href="/tools" rel="v:url" property="v:title">Home</a> �<?php
			    $getuppar = $cms->getSingleresult("select parentId from #_category where pid='$parentId'");
				?><a href="/tools/catalog/manage-sub-category.php?parentId=<?=$getuppar?>" rel="v:url" property="v:title"> <?=ucfirst(strtolower($cms->getSingleresult("select name from #_category where pid='$getuppar'")))?></a>  � 
			<?php if($id){ ?>
			<a href="/tools/catalog/add-sub-category.php?id=<?=$id?>&parentId=<?=$parentId?>" rel="v:url" property="v:title"> <?=ucfirst(strtolower($cms->getSingleresult("select name from #_category where pid='$id'")))?></a>  � 

			<a href="/tools/catalog/manage-pro-sub-category.php?parentId=<?=$parentId?>" rel="v:url" property="v:title"> <?=ucfirst(strtolower($cms->getSingleresult("select name from #_category where pid='$id'")))?></a> 

			<?php }else{?>
				

			<a href="/tools/catalog/manage-pro-sub-category.php?parentId=<?=$parentId?>" rel="v:url" property="v:title"> <?=ucfirst(strtolower($cms->getSingleresult("select name from #_category where pid='$parentId'")))?></a> 
			<?php
			} ?>
	     </h2> 
      </div>
      <div class="tbl-contant">
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0"  class="data-tbl">
          <tr class="t-hdr">
            <td width="5%" align="center"><?=$adm->orders('#',false)?></td>
            <td width="5%" align="center" valign="middle"><?=$adm->check_all()?></td>
            <td width="15%" align="center"><?=$adm->orders('Product Sub Category Name',true)?></td>
            <td width="27%" align="center"><?=$adm->orders('Detail',true)?></td>
			<td width="16%" align="center"><?=$adm->orders('Specifications',true)?></td>
            <td width="16%" align="center"><?=$adm->orders('Status',true)?></td>
            <td width="17%" align="center"><?=$adm->norders('Action')?></td>
          </tr>
          <?php if($reccnt){ $nums=1; while ($line = $cms->db_fetch_array($result)){@extract($line);?>
          <tr <?=$adm->even_odd($nums)?>>
            <td align="center"><?=$nums?></td>
            <td align="center"><?=$adm->check_input($pid)?></td>
            <td align="center">
             <?=$name?>
			<?  // echo $name; 
			/*else {
				$getPid = $cms->getSingleresult("select parentId from #_cate where pid='$pid'");
				echo $cms->getSingleresult("select name from #_cate where parentId='$getPid'");
			}*/?> 
			</td>
             <td align="center"><?=$body?></td>
			 <td align="center" class="<?=strtolower($status)?>"><?=$specifications?></td>
            <td align="center" class="<?=strtolower($status)?>"><?=$status?></td>
            <td align="center">
			<?=$adm->cataction(SITE_PATH_ADM.CPAGE."/add-pro-sub-category.php",$pid."&parentId=".$parentId, CPAGE.'/manage-pro-sub-category.php',$start)?>
            </td>
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
