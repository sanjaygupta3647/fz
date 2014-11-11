<?php include("../../lib/opin.inc.php")?>
<?php define("CPAGE","catalog/")?>
<?php include("../inc/header.inc.php");
if($_SESSION[usertype]!='brand'){
		$cms->redir(SITE_PATH_MEM);
	}
$getproduct= $cms->db_query("select prod_id from #_barnds_product where brand_id = '".$_SESSION[uid]."'");
$prod_arr = array();
if(mysql_num_rows($getproduct)){
	  while($res=$cms->db_fetch_array($getproduct)){
		$prod_arr[] = $res[prod_id];
	  }
}
if(!count($prod_arr))$prod_arr[] =0;
?>
<div class="main">
<header>
     
      <div class="hrd-right-wrap">
         
        
        <div class="brdcm" id="hed-tit">Store(s) Request</div>
        <div class="unvrl-btn">  
        </div> 
      </div>
      <div class="cl"></div>
    </header>  
 <div class="cl"></div> 
	<?php   
	 
	$start = intval($start);
	$pagesize = 1000;
	$columns = "select * ";
	$sql = "from #_request_brand where brand_id = '".$_SESSION[uid]."' ";
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

<?php $hedtitle = "All Store(s)"; ?> 
    <? //$adm->h1_tag('Dashboard &rsaquo; Category Manager',$others)?>
    <h1><? if($parentId) {echo $cms->getSingleresult("select name from #_category where pid='$parentId'");}?></h1>
     
      <?=$adm->alert()?>
      <div class="title"  id="innertit">
        <h2 class="bradcrumb"> 
					<a href="/member" rel="v:url" property="v:title">Home</a> »
					<a href="/member/catalog/store-list-brand.php" rel="v:url" property="v:title">Stores </a>  
		   </h2>
        
      </div>
      <div class="tbl-contant">
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" id="myTable" class="data-tbl">
          <thead> <tr class="t-hdr">
            <td width="5%" align="center"><?=$adm->orders('#',false)?></td> 
            <td width="37%" align="center"><?=$adm->orders('Store Name',true)?></td>  
			<td width="16%" align="center"><?=$adm->orders('View Product',true)?></td>
			<td width="16%" align="center"><?=$adm->orders('Sold Product',true)?></td> 
            <td width="16%" align="center"><?=$adm->orders('Status',true)?></td>
           </tr> </thead><tbody>
          <?php if($reccnt){ $nums=1; while ($line = $cms->db_fetch_array($result)){@extract($line);?>
          <tr <?=$adm->even_odd($nums)?>>
            <td align="center"><?=$nums?></td> 
            <td align="center">
            <a href="<?=SITE_PATH_MEM?>catalog/brand-request.php?id=<?=$pid?>">
			<?=$cms->getSingleresult("select title from #_store_detail where store_user_id = '".$store_user_id."'")?></a>
			</td> 
			 <td align="center"> 
			  <a href="http://fizzkart.com/member/catalog/product-sub-view.php?parentId=<?=$store_user_id?>">
           <?php
			$tot =$cms->getSingleresult("select count(*) from #_barnds_product where store_user_id = '$store_user_id' and brand_id='".$_SESSION[uid]."' and status='Active'  ");
			?>
			<?=$tot?></a>
			</td> 

			 <td align="center">
			 <?php
			 $totSell =$cms->getSingleresult("select count(*) from #_orders_detail where proid in  (".implode(',',$prod_arr).") and  store_id='$store_user_id'");
			 ?>
            <a href="<?=SITE_PATH_MEM?>catalog/product-sub-sells.php?storeId=<?=$store_user_id?>">
			<?=$totSell?></a>
			</td> 
            <td align="center" class="<?=strtolower($status)?>"><?=$status?></td>
             
          </tr>
          <?php $nums++;}}else{ echo $adm->rowerror(5);}?>
		  </tbody>
        </table>
      </div> 
       <div class="cl"></div>
   <?php //include("../inc/paging.inc.php")?>
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
