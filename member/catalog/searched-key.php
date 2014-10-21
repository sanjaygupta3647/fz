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
        <div class="unvrl-btn" style="width: 150px;">   
	    <a href="#" onclick="PrintDiv();" class="ub">
        <img src="<?=SITE_PATH_MEM?>images/print.jpg" alt=""> </a>
        <div style="float:left;"><img src="<?=SITE_PATH_MEM?>images/back2.png" style="float:left;" width="20" height="20" />
        <a href="javascript:void(0)" onclick="javascript:formback();" class="ub">Back</a></div> 
        
        </div> 
      </div>
      <div class="cl"></div>
    </header> 
    
 <div class="cl"></div><?
$order_ = true; 
/// echo $_POST['action'];die;
 
 
$id=$_SESSION[store_id];
$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
$columns = "select * ";
$sql = "from #_searchkey where store_id = '".$_SESSION[store_id]."' and keywords!='' ";
 
$sql_count = "select count(*) ".$sql; 
  
$sql .= " group by keywords limit $start, $pagesize ";
$sql = $columns.$sql;
$result = $cms->db_query($sql);
$reccnt = $cms->db_scalar($sql_count);
?>
<div class="content">
<div class="div-tbl">
<div class="cl"></div> 
<?php $hedtitle = "Searched Keywords"; ?>   
    <? //$adm->h1_tag('Dashboard &rsaquo; Orders Manager',$others)?> 
      <?=$adm->alert()?>
      <div class="title"  id="innertit">
        <? //$adm->heading('Orders Manager :- '.ucfirst($status))?> 
        <h2><?=$cms->breadcrumbs()?></h2>
      </div>
        <div class="tbl-contant"  id="divToPrint">
        <table id="myTable" width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="data-tbl">
         <thead> <tr class="t-hdr">
            <td width="10%" align="center"><?=$adm->orders('#',false)?></td> 
			<td width="35%" align="center"><?=$adm->orders('Keywords',true)?></td> 
			<td width="20%" align="center"><?=$adm->orders('Count',true)?></td> 
            <td width="35%" align="center"><?=$adm->orders('Last Date',true)?></td>
          </tr></thead>
		  <tbody>
          <?php if($reccnt){ $nums=1; while ($line = $cms->db_fetch_array($result)){@extract($line);?>
          <tr <?=$adm->even_odd($nums)?>>
            <td align="center"><?=$nums?></td> 
			<td align="center"><?=$keywords?></td>
            <td align="center"><?=$cms->getSingleresult(" SELECT count(*) FROM #_searchkey where keywords = '".$keywords."' and store_id = '".$_SESSION[store_id]."' ")?></td>
            <td align="center" valign="top"><?=date('j F, Y', strtotime($dt))?></td>
			 
          </tr>
          <?php $nums++;}}else{ echo $adm->rowerror(4);}?>
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