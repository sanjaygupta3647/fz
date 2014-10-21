<?php include("../../lib/opin.inc.php"); 
    define("CPAGE","catalog/");
    include("../inc/header.inc.php");
	if($start){$st = "?start=$start";}
	if($rqst=='cancle'){
	    $cms->req_forbrands_member_mail($_GET[brand],'Cancle',$_SESSION[uid]);
		$cms->db_query("update #_request_brand set status='Cancle', remark = 'Cancle by store user himself' where store_user_id = '".$_SESSION[uid]."' and brand_id = '$brand' ");
		$cms->db_query("update #_barnds_product set status='Inactive' where store_user_id = '".$_SESSION[uid]."' and brand_id = '$brand' ");
		$adm->sessset('Your have successfully cancle brand request', 'e');
		$cms->redir(SITE_PATH_MEM.CPAGE."/brands-list.php".$st, true); 
		exit;			
	}
	$brandcat = array();
	$relatedplans = array();
	$listbrand = array();

	  

	$listbrandqry=$cms->db_query("select pid from fz_store_user where status = 'Active' and type != 'store' "); 
	if(mysql_num_rows($listbrandqry)){
		while($RS=$cms->db_fetch_array($listbrandqry)){
									$listbrand[] = $RS[pid];
								} 
	}
 
	$getplan = $cms->getSingleresult("select plan_id from #_store_detail where  pid = '".$_SESSION[store_id]."'");
	$brand_cat=$cms->db_query("select cat_id from #_plans_category where plan_id='".$getplan."' and parent!='0'");
								while($brand_cats=$cms->db_fetch_array($brand_cat)){
									$brandcat[] = $brand_cats[cat_id];
								}
	 
	$relatedbrandsquery=$cms->db_query("select plan_id from fz_plans_category where cat_id in  (".implode(",",$brandcat).")  and parent!='0' group by plan_id "); 
	if(mysql_num_rows($relatedbrandsquery)){
		while($RS=$cms->db_fetch_array($relatedbrandsquery)){
									$relatedplans[] = $RS[plan_id];
								} 
	} 
 	if($_GET[pid]){ 
		$plan_id = $cms->getSingleresult("select plan_id from #_store_detail where  pid = '".$_SESSION[store_id]."'");
		$noOfBrands = $cms->getSingleresult("select noOfBrands from #_plans where  pid = '".$plan_id."'");
		$requestedBrands = $cms->getSingleresult("select count(*) from #_request_brand where store_user_id ='".$_SESSION[uid]."' and status='Active' ");
		$remainBrands = $noOfBrands -$requestedBrands;
		if($rqst=='Active'){
		$cms->req_forbrands_member_mail($_GET[brand],'Active',$_SESSION[uid]);
		}
		if($remainBrands < 1){
			$adm->sessset('Your have reached to maximum request for brans', 'e'); 
			$cms->redir(SITE_PATH_MEM.CPAGE."/brands-list.php".$st, true);
			exit; 
		}
		$brandEmail =$cms->getSingleresult("select email_id from #_store_user where pid = '".$_GET[pid]."'");
		$arr[brand_id] = $_GET[pid];
		$arr[store_user_id] = $_SESSION[uid];
		$arr[status] = 'Inactive';
		$arr[email] = $brandEmail;
		$check =$cms->getSingleresult("select count(*) from #_request_brand where store_user_id = '".$_SESSION[uid]."'
							and brand_id = '".$_GET[pid]."' ");
		if(!$check){
			if($_GET[rq]!='again'){
				$cms->sqlquery("rs","request_brand",$arr);  
				$cms->req_forbrands_member_mail($_GET[brand],'Inactive',$_SESSION[uid]);
            }
		}else{
			
				$cms->db_query("update #_request_brand set status = 'Inactive', remark = 'Ractivation Request' where  store_user_id = '".$_SESSION[uid]."'
				and brand_id = '".$_GET[pid]."' ");
				
			
		} 			

	}
	 
	if($_GET[brands]){
		$cond .= " and title = '".$_GET[brands]."' " ;
	}
	 
	 
	$start = intval($start); 
	$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
	$columns = "select store_user_id,title ";
	$sql = " from #_store_detail where status = 'Active' and store_user_id in(".implode(",",$listbrand).") $cond  and plan_id in(".implode(",",$relatedplans).")  ";
	$order_by == '' ? $order_by = '(pid)' : true;
	$order_by2 == '' ? $order_by2 = 'desc' : true;
	$sql_count = "select count(*) ".$sql; 
	$sql .= "order by $order_by $order_by2 ";
	$sql .= "limit $start, $pagesize ";
	$sql = $columns.$sql;
	$result = $cms->db_query($sql);
	$reccnt = $cms->db_scalar($sql_count);  

	$requestQry = $cms->db_query("select brand_id from #_request_brand where store_user_id = '".$_SESSION[uid]."'");
	$rqst = array();
	if(mysql_num_rows($requestQry)){
		 while($get = $cms->db_fetch_array($requestQry)){
		 	$rqst[] = $get[brand_id];		 
		 }
	}
 ?>
<div class="main">
<header> 
      <div class="hrd-right-wrap"> 
         <nav style="margin-top:10px;">
          <ul>  
			<li style="margin:10px;">
			Brand: <input placeholder="Brand" type="text" id="brand"  list="browsers" name="brands"  value="<?=$_GET[brands]?>"><?php
			        $namesq="select title from #_store_detail where store_user_id in(".implode(",",$listbrand).") and plan_id in(".implode(",",$relatedplans).")";
					$namesqe=$cms->db_query($namesq);?>
					<datalist id="browsers"><?php 
					 while($na=$cms->db_fetch_array($namesqe)){  ?>
					<option value="<?=$na[title]?>">
                <?php }?></datalist>
			</li>
			<!-- <li style="margin:10px;"> 
			  <select  name="status" class="txt medium" id="status">
			  <option value="">----Select Status----</option> 		
			  <option value="Active" <?=($_GET[show_home]=='Active')?'selected="selected"':''?>>Active</option>  
			  <option value="Inactive" <?=($_GET[Inactive]=='No')?'selected="selected"':''?>>Inactive</option> 
			  <option value="Cancle" <?=($_GET[Inactive]=='Cancle')?'selected="selected"':''?>>Cancle</option> 
			</select> 
			</li> -->
			<li style="margin:10px;"><input id="search" style="margin: 0px; width: 100px;"  type="button" name="search" value="search"></li>
          </ul>
        </nav>  
        <div id="hed-tit">Banner</div>
        <div class="unvrl-btn"> 
        <a href="<?=SITE_PATH_MEM.CPAGE.'/?mode=add'?>" class="ub">
        <img  src="<?=SITE_PATH_MEM?>images/add-new.png" alt=""></a>
         <?php if(!$_GET[mode]){?>
          <a href="javascript:void(0)"  onclick="javascript:submitions('Active');"class="ub">
        <img src="<?=SITE_PATH_MEM?>images/active.png" alt=""></a>
        <a href="javascript:void(0)" onClick="javascript:submitions('Inactive');" class="ub">
        <img src="<?=SITE_PATH_MEM?>images/inactive.png" alt=""></a>
        <a href="javascript:void(0)" class="ub"   onclick="javascript:submitions('delete');">
        <img src="<?=SITE_PATH_MEM?>images/delete.png" alt=""></a> <? }?>
       <?php if($_GET[mode]){?>
        <a href="javascript:void(0)" onclick="javascript:formback();" class="ub">
        <img src="<?=SITE_PATH_MEM?>images/back.png" alt=""></a><?php }?>
        
        </div> 
      </div>
      <div class="cl"></div>
    </header> 
    
 <div class="cl"></div>
<div class="content">
<div class="div-tbl">
<div class="cl"></div>
    <? //$adm->h1_tag('Dashboard &rsaquo; Collection Manager',$others)?> 
<?php $hedtitle = "All Brands"; ?>    
      <?=$adm->alert()?>
      <div class="title"  id="innertit">
        <? //=$adm->heading('All Brands')?>
		 <h2><?=$cms->breadcrumbs()?></h2>
      </div>
      <div class="tbl-contant">
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0"  class="data-tbl">
          <tr class="t-hdr">
            <td width="2%" align="center"><?=$adm->orders('#',false)?></td>
             <td width="15%" align="center"><?=$adm->orders('Brand Name',true)?></td>
			 <td width="15%" align="center"><?=$adm->orders('Request',true)?></td> 
          </tr>
            <?php if($reccnt){ if($start){$nums= $start+1;}else { $nums= 1;}  while ($line = $cms->db_fetch_array($result)){@extract($line);?>
            <tr <?=$adm->even_odd($nums)?>>
            <td align="center"><?=$nums?></td>
            <td align="center"><?=$title?></td> 
            <td align="center"><?php 
			   if($start){$st = "&start=$start";}
			   if(in_array($store_user_id,$rqst)){
				$sta = $cms->getSingleresult("select status from #_request_brand where store_user_id = '".$_SESSION[uid]."' and brand_id = '$store_user_id' ");
				if($sta=='Active'){?>
						 
						<a href="<?=SITE_PATH_MEM.CPAGE?>/brands-list.php?brand=<?=$store_user_id?>&rqst=cancle<?=$st?>">Cancle</a><?php
					} 
					else if($sta=='Inactive'){
					?><strong>Pending</strong><?php
					} 
					else if($sta=='Cancle'){
					?><a href="<?=SITE_PATH_MEM.CPAGE?>/brands-list.php?pid=<?=$store_user_id?>&brand=<?=$store_user_id?>&rqst=Active<?=$st?>&rq=again">Again Request</a><?php
					} 
				}else
					{
					  ?><a href="<?=SITE_PATH_MEM.CPAGE?>/brands-list.php?pid=<?=$store_user_id?>&brand=<?=$store_user_id?>&rqst=Active<?=$st?>">Request</a><?php
				}
            ?>
			</td> 
          </tr>
          <?php $nums++;
 }}else{ echo $adm->rowerror(5);}?>
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
</body>
<script type="text/javascript">
$("#search").click(function(){  
var brand = $("#brand").val(); 
var status =$("#status").val(); 
var ur = '?search=1';
if(brand){
	 ur +="&brands="+trim(brand); 
	} 
	if(status){
	 ur +="&status="+trim(status); 
	}
   var red = "<?=SITE_PATH_MEM.CPAGE?>/brands-list.php"+ur; 
   window.location = red;
}); 
</script>
</html>
