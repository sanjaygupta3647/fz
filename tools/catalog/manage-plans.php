<?php include("../../lib/opin.inc.php")?>
<?php define("CPAGE","catalog")?>
<?php include("../inc/header.inc.php")?>
<?php $adm->pageAuth("Manage Plan",$perm);?>
<div class="main">
<header> 
      <div class="hrd-right-wrap">
	   <?php
		if(!$id && !$mode){
		 ?>
         <nav style="margin-top:10px;">
          <ul>
            <li style="margin:10px;"><select  name="status" class="txt medium" id="status">
			<option value="">----Select Status----</option>  
					<option value="Active" <?=($_GET[status]=='Active')?'selected="selected"':''?>>Active</option> 
					<option value="Inactive" <?=($_GET[status]=='Inactive')?'selected="selected"':''?>>Inactive</option> 
			</select>
			</li>
			<li style="margin:10px;"> 
			<select  name="type" class="txt medium" id="type">
			<option value="">----Select Store Type----</option> 
						  <option value="brand" <?=($_GET[type]=='brand')?'selected="selected"':''?>> Brand </option> 
						  <option value="store" <?=($_GET[type]=='store')?'selected="selected"':''?>> Store </option>
			</select> 
			</li> 
			<li style="margin:10px;"><input type="text" id="searchTitle" name="title" placeholder="Plan Name "  value="<?=$_GET[title]?>"></li> 
			<li style="margin:10px;"><input id="search" style="margin: 0px; width: 100px;" type="button" name="search" value="search"></li>
          </ul>
        </nav> 
        <?php }?> 
        
        <div class="brdcm" id="hed-tit">Banner</div>
        <div class="unvrl-btn"> 
        <a href="<?=SITE_PATH_ADM.CPAGE.'/add-plan.php'?>" class="ub">
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
<?php 
 
	if($action=='del'){
		$cms->db_query("delete from #_plans_category where plan_id in ($id)");
		$cms->db_query("delete from #_plans_hosting where plan_id in ($id)");
		$cms->db_query("delete from #_plans where pid in ($id)");
		$adm->sessset('Record has been deleted', 'e');
		$cms->redir(SITE_PATH_ADM.CPAGE."/manage-plans.php", true);
		exit;
	}
	if($cms->is_post_back()){
		if($arr_ids) {
			$str_adm_ids = implode(",",$arr_ids);
			switch ($_POST['action']){
				case "delete":
 					$cms->db_query("delete from #_plans_category where plan_id in ($str_adm_ids)");
					$cms->db_query("delete from #_plans_hosting where plan_id in ($str_adm_ids)");
					$cms->db_query("delete from #_plans where pid in ($str_adm_ids)");
					$adm->sessset(count($arr_ids).' Item(s) Delete', 'e');
					break;
				case "Inactive":
					$cms->db_query("update #_plans set status = 'Inactive' where pid in ($str_adm_ids)");
					$adm->sessset(count($arr_ids).' Item(s) Inactive', 'e');
					break;
				case "Active":
					$cms->db_query("update #_plans set status = 'Active' where pid in ($str_adm_ids)");
					$adm->sessset(count($arr_ids).' Item(s) Active', 's');
					break;
				default:
			}
		}
		$cms->redir(SITE_PATH_ADM.CPAGE."/manage-plans.php", true);
		exit;
	} 
	$start = intval($start);
	$cond="";
	if($search){
	$pagesize = 30; 
	if($_GET[status]!=""){
	 $cond .= " and status = '".$_GET[status]."'"; 
	}
	if($_GET[type]!=""){
	 $cond .= " and type = '".$_GET[type]."'";
	}
	if($_GET[title]!=""){
	 $cond .= " and name like '%".$_GET[title]."%'"; 
	}
	}else{
	$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
	//$cond=1;
	}  
	$columns = "select * ";
	$sql = " from fz_plans where 1 $cond ";
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

<?php $hedtitle = "Plans Management"; ?> 
    <? //$adm->h1_tag('Dashboard &rsaquo; Category Manager',$others)?>
      
      <?=$adm->alert()?>
      <div class="title"  id="innertit">
        <h2 class="bradcrumb"><?php
		if($mode=='add' && $id!=''){?>
			<a href="/tools" rel="v:url" property="v:title">Home</a> »
			<a href="/tools/catalog" rel="v:url" property="v:title">Manage Plans </a> » 
			<a href="/tools/catalog/?mode=add&amp;start=&amp;id=<?=$id?>" rel="v:url" property="v:title">Edit</a>  
		<?php		
		}else if($mode=='add' && $id=='') { 
		    ?>
			<a href="/tools" rel="v:url" property="v:title">Home</a> »
			<a href="/tools/catalog" rel="v:url" property="v:title">Manage Plans </a> » 
			<a href="/tools/catalog/?mode=add" rel="v:url" property="v:title">Add</a>  
		<?php
		}else{?>
		    <a href="/tools" rel="v:url" property="v:title">Home</a> »
			<a href="/tools/catalog" rel="v:url" property="v:title">Manage Plans </a> »  
		<?php 
		}
		?>
	  </h2>
        
      </div>
      <div class="tbl-contant">
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0"  class="data-tbl">
          <tr class="t-hdr">
            <td width="5%" align="center"><?=$adm->orders('#',false)?></td>
            <td width="5%" align="center" valign="middle"><?=$adm->check_all()?></td>
            <td width="20%" align="center"><?=$adm->orders('Name',true)?></td>
            <td width="20%" align="center"><?=$adm->orders('Description',true)?></td>
			<td width="12%" align="center"><?=$adm->orders('Plan Type',true)?></td>
			<td width="12%" align="center"><?=$adm->orders('No Of Products',true)?></td>
            <td width="16%" align="center"><?=$adm->orders('Status',true)?></td>
            <td width="27%" align="center"><?=$adm->norders('Action')?></td>
          </tr>
          <?php if($reccnt){ if($start){$nums= $start+1;}else { $nums= 1;}  while ($line = $cms->db_fetch_array($result)){@extract($line);?>
          <tr <?=$adm->even_odd($nums)?>>
            <td align="center"><?=$nums?></td>
            <td align="center"><?=$adm->check_input($pid)?></td>
            <td align="center"><?=$name?></td>  
             <td align="center">
			 <?=strip_tags(substr($body,0,50))?></td>
			 <td align="center"><?=$type?></td>
			 <td align="center"><?=$noOfProducts?></td>
            <td align="center" class="<?=strtolower($status)?>"><?=$status?></td>
            <td align="center">
			<?=$adm->cataction(SITE_PATH_ADM.CPAGE."/add-plan.php",$pid, CPAGE.'/manage-plans.php',$start)?>
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
$("#search").click(function(){
var searchTitle = $("#searchTitle").val(); 
var status =$("#status").val(); 
var type =$("#type").val();
var ur ='?search=1';  
if(type){
 ur +="&type="+type; 
}
if(status){
	 ur +="&status="+status; 
	}
if(searchTitle){
	 ur +="&title="+trim(searchTitle); 
	}
   var red = "<?=SITE_PATH_ADM.CPAGE."/manage-plans.php"?>"+ur;
   window.location = red; 
});
 
</script>
 
</body>
</html>
