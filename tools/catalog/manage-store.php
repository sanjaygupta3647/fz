<?php include("../../lib/opin.inc.php")?>
<?php define("CPAGE","catalog/")?>
<?php include("../inc/header.inc.php")?>
<?php $adm->pageAuth("Store Detail",$perm);?>
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
	 
	 
	$start = $_GET[start]; 
	 
	$start = intval($start);
	   
	$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
	if($search){
		$pagesize = 500;
		if($_GET[type]!=""){
			$types = $cms->db_query("select pid from #_store_user where type ='".$_GET[type]."'  ");
			$pids[] = 0;
			if(mysql_num_rows($types)){
				while($rs=$cms->db_fetch_array($types)){ 
					$pids[] = $rs[pid];
				}
			}
			$cond .= " and store_user_id in (".implode(',',$pids).") " ; 
		}
		if($_GET[title]!=""){
			$cond .= " and title like '%".$_GET[title]."%'"; 
		}
		if($_GET[status]!=""){
			$cond .= " and status =   '".$_GET[status]."'"; 
		}
	}  
	$columns = "select * ";
	$sql = " from #_store_detail where 1  $cond  ";
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
        <?php
		if(!$id and !$mode){
		 ?>
         <nav style="margin-top:10px;">
          <ul>
            <li style="margin:10px;">
			<select  name="type" class="txt medium" id="type">
				<option value="">----Select Store Type----</option> 
				<option value="store" <?=$_GET[type]=='store'?'selected="selected"':''?>>Store</option> 
				<option value="brand" <?=$_GET[type]=='brand'?'selected="selected"':''?>>Brand</option>  
			</select>
			</li>
			<li style="margin:10px;"><div id="ajaxDiv">
			<select  name="status" class="txt medium" id="status">
			<option value="">----Status----</option> 
			<option value="Active" <?=$_GET[status]=='Active'?'selected="selected"':''?>>Active</option> 
			<option value="Inactive" <?=$_GET[status]=='Inactive'?'selected="selected"':''?>>Inactive</option>
			</select></div>
			</li>
			<li style="margin:10px;">
			<input list="browsers" type="text" id="title" name="title" value="<?=$_GET[title]?>">
			<?php  $namesq="select title from #_store_detail group by title order by title";
					$namesqe=$cms->db_query($namesq);?>
					<datalist id="browsers"><?php 
					 while($na=$cms->db_fetch_array($namesqe)){  ?>
					<option value="<?=$na[title]?>">
                <?php }?></datalist>
			</li>
			<li style="margin:10px;"><input id="search"   type="button" name="search" value="search"></li>
          </ul>
        </nav> 
        <?php }?>
        
        <div class="brdcm" id="hed-tit">Banner</div>
        <div class="unvrl-btn"> 
       
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
    <?php  $start=$_GET[start]; //$adm->h1_tag('Dashboard &rsaquo; Collection Manager',$others)?>
   
<?php $hedtitle = "Store Management"; ?>    
      <?=$adm->alert()?>
      <div class="title"  id="innertit">
        <h2 class="bradcrumb"> 
		 
		    <a href="/tools" rel="v:url" property="v:title">Home</a> »
			<a href="/tools/catalog/manage-store.php" rel="v:url" property="v:title">Store Detail  </a> »  
	 
		   </h2>
      </div>
      <div class="tbl-contant">
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0"  class="data-tbl">
          <tr class="t-hdr">
            <td width="2%" align="center"><?=$adm->orders('#',false)?></td>
            <td width="3%" align="center" valign="middle"><?=$adm->check_all()?></td>
            <td width="15%" align="center"><?=$adm->orders('Store Name',true)?></td>
            <td width="10%" align="center"><?=$adm->orders('Type',true)?></td>
            <td width="20%" align="center"><?=$adm->orders('Address',true)?></td>
            <td width="11%" align="center"><?=$adm->orders('Image',true)?></td>
            <td width="10%" align="center"><?=$adm->orders('Owner',true)?></td>
            <td width="7%" align="center"><?=$adm->orders('Popular',true)?></td>
            <td width="7%" align="center"><?=$adm->orders('Expired On',true)?></td>
            <td width="8%" align="center"><?=$adm->orders('Status',true)?></td>
            <td width="10%" align="center"><?=$adm->norders('Action')?></td>
          </tr>
          <?php if($reccnt){ if($start){$nums= $start+1;}else { $nums= 1;}  while ($line = $cms->db_fetch_array($result)){@extract($line);?>
          <tr <?=$adm->even_odd($nums)?>>
            <td align="center"><?=$nums?></td>
            <td align="center"><?=$adm->check_input($pid)?></td>
            <td align="center"><?=$title?></td>
            <td align="center"><?=ucfirst($cms->getSingleresult("select type  from #_store_user  where  pid = '$store_user_id' "))?></td>
            <td align="center"><?=$Address?></td>
            <td align="center"><? if($image  and is_file($_SERVER['DOCUMENT_ROOT'].SITE_SUB_PATH."uploaded_files/orginal/".$image)==true){?>
            <img src="<?=SITE_PATH?>uploaded_files/orginal/<?=$image?>" width="100"><? }else echo "NA";?></td>
             <td align="center"><?=$cms->getSingleresult("select name  from #_store_user  where  pid = '$store_user_id' ")?></td>
             <td align="center"><?=($our_popular_store)?'Yes':'No'?></td>
			 <?php
				 $Date = date("Y-m-d",strtotime($create_date));
				 $noOfDayss = $cms->daysLeft($store_user_id);
				 if($status=='Active'){
					if($noOfDayss>0) {
						$exp = date('d M, Y', strtotime($Date. ' + '.$noOfDayss.' days'));
					}else{
						$exp =  " expired before ".(-($noOfDayss))." days";
					}
				 }else{
					$exp = 'NA';
				 }
			 ?>
             <td align="center"><?=$exp?></td> 
            <td align="center" class="<?=strtolower($status)?>"><?=$status?></td>
            <td align="center"><?=$adm->cataction(SITE_PATH_ADM.CPAGE."/add-store.php",$pid, CPAGE.'/manage-store.php',$start)?></td>
          </tr>
          <?php $nums++;}}else{ echo $adm->rowerror(5);}?>
        </table>
      </div>
	   <?php include("../inc/paging.inc.php")?>
    </div>
<?php include("../inc/footer.inc.php")?>
</div>
<div class="cl"></div>
</div>
</div>

<script type="text/javascript">
$("#search").click(function(){  
var title = $("#title").val();
var type =$("#type").val();
var status =$("#status").val();
var ur = '?search=1';
if(title){
	 ur +="&title="+trim(title); 
	}
	if(type){
	 ur +="&type="+trim(type); 
	}
	if(status){
	 ur +="&status="+trim(status); 
	}
   var red = "<?=SITE_PATH_ADM.CPAGE?>/manage-store.php"+ur; 
   window.location = red;
}); 
</script>
</body>
</html>
