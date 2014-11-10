<?php include("../../lib/opin.inc.php")?>
<?php define("CPAGE","catalog/")?>
<?php include("../inc/header.inc.php")?>
<?php $adm->pageAuth("E-mail Alerts",$perm);?>
<div class="main">
<header>
     
      <div class="hrd-right-wrap"> 
	  <?php
		if(!$id and !$mode){
		 ?>
         <nav style="margin-top:10px;">
          <ul>
            <li style="margin:10px;"><select  name="storeurl" class="txt medium" id="storeurl">
			<option value="">----Select Store----</option><?php
			$rsAdmins=$cms->db_query("select store_id from #_subscribe_list group by store_id");
 				while($catRes2=$cms->db_fetch_array($rsAdmins)){ 
						$url = $cms->getSingleresult("select store_url from #_store_detail where pid ='".$catRes2[store_id]."' ");
						$link  =  ($url)?$url.".fizzkart.com":"fizzkart.com";?>
						<option value="<?=$catRes2[store_id]?>" <?=($catRes2[store_id]==$storeurl)?'selected="selected"':''?> ><?=$link?></option><?php
					} 	 
					echo'</select>';  
 			?> 
			</li> 
			<li style="margin:10px;"><input type="text" id="email" name="email" placeholder="Search By Email" value="<?=$_GET[email]?>"></li>
			<li style="margin:10px;"><input id="search"   type="button" name="search" value="search"></li>
          </ul>
        </nav> 
        <?php }?>
        <div class="brdcm" id="hed-tit">Banner</div>
        <div class="unvrl-btn">  
        <a href="javascript:void(0)" class="ub"   onclick="javascript:submitions('delete');">
        <img src="<?=SITE_PATH_ADM?>images/delete.png" alt=""></a>
        <?php /*?><a href="javascript:void(0)" class="ub">
        <img src="<?=SITE_PATH_ADM?>images/cancel.png" alt=""></a><?php */?>
        <a href="javascript:void(0)"  onclick="javascript:submitions('Active');"class="ub">
        <img src="<?=SITE_PATH_ADM?>images/active.png" alt=""></a>
        <a href="javascript:void(0)" onClick="javascript:submitions('Inactive');" class="ub">
        <img src="<?=SITE_PATH_ADM?>images/inactive.png" alt=""></a> 
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
		$cms->db_query("delete from #_subscribe_list where pid in ($id)"); 
		$adm->sessset('Record has been deleted', 'e');
		$cms->redir(SITE_PATH_ADM.CPAGE."/subscribers.php", true);
		exit;
	}
	if($cms->is_post_back()){
		if($arr_ids) {
			$str_adm_ids = implode(",",$arr_ids);
			switch ($_POST['action']){
				case "delete":
 					$cms->db_query("delete from #_subscribe_list where pid in ($str_adm_ids)"); 
					$adm->sessset(count($arr_ids).' Item(s) Delete', 'e');
					break;
				case "Inactive":
					$cms->db_query("update #_subscribe_list set status = 'Inactive' where pid in ($str_adm_ids)");
					$adm->sessset(count($arr_ids).' Item(s) Inactive', 'e');
					break;
				case "Active":
					$cms->db_query("update #_subscribe_list set status = 'Active' where pid in ($str_adm_ids)");
					$adm->sessset(count($arr_ids).' Item(s) Active', 's');
					break;
				default:
			}
		}
		$cms->redir(SITE_PATH_ADM.CPAGE."/subscribers.php", true);
		exit;
	}
	$cond = "";
	if($storeurl=='0' || $storeurl > 0){ 
		$cond= " and store_id = '$storeurl' ";
	}
	if($email){ 
		$cond= " and email like '%$email%' ";
	}
	$start = intval($start);
	$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
	$columns = "select * ";
	$sql = " from #_subscribe_list where 1 ".$cond;
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

<?php $hedtitle = "Subscribe List Management"; ?> 
    <? //$adm->h1_tag('Dashboard &rsaquo; Category Manager',$others)?>
      
      <?=$adm->alert()?>
      <div class="title"  id="innertit">
        <h2 class="bradcrumb"><?php
		if($mode=='add' && $id!=''){?>
			<a href="/tools" rel="v:url" property="v:title">Home</a> »
			<a href="/tools/catalog" rel="v:url" property="v:title">Catalog </a> » 
			<a href="/tools/catalog/?mode=add&amp;start=&amp;id=<?=$id?>" rel="v:url" property="v:title">Edit</a>  
		<?php		
		}else if($mode=='add' && $id=='') { 
		    ?>
			<a href="/tools" rel="v:url" property="v:title">Home</a> »
			<a href="/tools/catalog" rel="v:url" property="v:title">Catalog </a> » 
			<a href="/tools/catalog/?mode=add" rel="v:url" property="v:title">Add</a>  
		<?php
		}else{?>
		    <a href="/tools" rel="v:url" property="v:title">Home</a> »
			<a href="/tools/catalog" rel="v:url" property="v:title">Catalog </a> »  
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
			<td width="10%" align="center"><?=$adm->orders('Email',true)?></td> 
			<td width="16%" align="center"><?=$adm->orders('Domain',true)?></td>
			<td width="10%" align="center"><?=$adm->orders('Status',true)?></td>
            <td width="15%" align="center"><?=$adm->norders('Time')?></td>
			 
          </tr>
          <?php if($reccnt){ if($start){$nums= $start+1;}else { $nums= 1;}  while ($line = $cms->db_fetch_array($result)){@extract($line);?>
          <tr <?=$adm->even_odd($nums)?>>
            <td align="center"><?=$nums?></td>
            <td align="center"><?=$adm->check_input($pid)?></td>
            <td align="center"><?=$email?></td>   
            <td align="center" class="<?=strtolower($status)?>"><?=$status?></td>
			<?php
			$url = $cms->getSingleresult("select store_url from #_store_detail where pid ='".$store_id."' ");
			$link  =  ($url)?$url.".fizzkart.com":"fizzkart.com";
			?>
			<td align="center" ><?=$link?></td>
			<td align="center" ><?=$submitdate?></td>
             
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
var storeurl = $("#storeurl").val();
var email =$("#email").val();
var ur = '?search=1';
if(storeurl){
	 ur +="&storeurl="+storeurl; 
	}
	if(email){
	 ur +="&email="+trim(email); 
	}
   var red = "<?=SITE_PATH_ADM.CPAGE?>/subscribers.php"+ur;
   window.location = red;
});
 
</script>
</body>
</html>
