<?php include("../../lib/opin.inc.php")?>
<?php define("CPAGE","catalog/")?>
<?php include("../inc/header.inc.php")?>
<?php 
  
 
	$start = intval($start);
	$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
	$columns = "select * ";
	$sql = " from #_page_view where store_user_id = '".$_SESSION[uid]."'";
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
   
<?php $hedtitle = "Page View Management"; ?>    
      <?=$adm->alert()?>
      <div class="title"  id="innertit">
        <? //=$adm->heading('Page View Management')?>
		 <h2><?=$cms->breadcrumbs()?></h2>
      </div>
      <div class="tbl-contant">
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0"  class="data-tbl">
          <tr class="t-hdr">
            <td width="2%" align="center"><?=$adm->orders('#',false)?></td>
             <td width="15%" align="center"><?=$adm->orders('PC Name',true)?></td>
			 <td width="15%" align="center"><?=$adm->orders('URL',true)?></td> 
			 <td width="15%" align="center"><?=$adm->orders('Time',true)?></td>
          </tr>
          <?php if($reccnt){ if($start){$nums= $start+1;}else { $nums= 1;}  while ($line = $cms->db_fetch_array($result)){@extract($line);?>
          <tr <?=$adm->even_odd($nums)?>>
            <td align="center"><?=$nums?></td>
            <td align="center"><?=$pc_name?></td> 
			<td align="center"><a href="<?=$url?>" target="_blank"><?=$url?> </a></td>
			<td align="center"><?=$create_time?></td>
         <!--   <td align="center"> <a href="<?=SITE_PATH_MEM?>product-brand?soterId=<?=$brand_id?>">View</a> </td> -->
            
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
