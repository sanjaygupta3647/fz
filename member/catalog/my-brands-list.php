<?php include("../../lib/opin.inc.php")?>
<?php define("CPAGE","catalog/")?>
<?php include("../inc/header.inc.php")?>
<?php 
	$catts[] = 0;
	$rsAdmin=$cms->db_query("select cat_id from #_store_menu where store_user_id='".$_SESSION[uid]."' and parent!='0'");
	while($arrAdmin=$cms->db_fetch_array($rsAdmin)){
		@extract($arrAdmin);
		$catts[] = $cat_id;
	}	
 
	$start = intval($start);
	$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
	$columns = "select * ";
	$sql = " from #_request_brand where store_user_id = '".$_SESSION[uid]."' and status = 'Active' ";
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
       
        
        <div class="brdcm" id="hed-tit">Banner</div>
          
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
        <? //=$adm->heading('Store Management')?>
		 <h2><?=$cms->breadcrumbs()?></h2>
      </div>
      <div class="tbl-contant">
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0"  class="data-tbl">
          <tr class="t-hdr">
            <td width="2%" align="center"><?=$adm->orders('#',false)?></td>
             <td width="15%" align="center"><?=$adm->orders('Brand Name',true)?></td>
			 <td width="15%" align="center"><?=$adm->orders('Remain Product',true)?></td> 
             <td width="15%" align="center"><?=$adm->orders('Added Product',true)?></td> 
          </tr>
          <?php if($reccnt){ if($start){$nums= $start+1;}else { $nums= 1;}  while ($line = $cms->db_fetch_array($result)){@extract($line);?>
          <tr <?=$adm->even_odd($nums)?>>
            <td align="center"><?=$nums?></td>
            <td align="center"><?=$cms->getSingleresult("select title from #_store_detail where store_user_id = '$brand_id' ")?></td>
			<?php 
			$listbrandprod = array();
			$listbrandprod[] = 0;
			 $listbrandqry=$cms->db_query("select prod_id from fz_barnds_product where brand_id = '$brand_id' and store_user_id = '".$_SESSION[uid]."' "); 
				if(mysql_num_rows($listbrandqry)){
					while($RS=$cms->db_fetch_array($listbrandqry)){
												$listbrandprod[] = $RS[prod_id];
											} 
				}
			 $Recount  = $cms->getSingleresult("select count(*) from #_products_user where store_user_id  = '$brand_id' and cat_id in (".implode(',',$catts).") and pid not in (".implode(',',$listbrandprod).")  ");
             $Adcount  = $cms->getSingleresult("select count(pid) from #_products_user where store_user_id  = '$brand_id' and cat_id in (".implode(',',$catts).") and pid  in (".implode(',',$listbrandprod).")  ");
			 
			?>
            <td align="center"> <a href="<?=SITE_PATH_MEM?>product-brand?soterId=<?=$brand_id?>">View(<?=$Recount?>)</a> </td>
            <td align="center"> <a href="<?=SITE_PATH_MEM?>product-brand?soterId=<?=$brand_id?>&type=added">View(<?=$Adcount?>)</a> </td>
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
</body>
</html>
