<?php include("../../lib/opin.inc.php")?>
<?php define("CPAGE","catalog/")?>
<?php include("../inc/header.inc.php")?>
<?php 
$_SESSION[store_Id]=$_GET[parentId];
  $getproduct= $cms->db_query("select prod_id from #_barnds_product where brand_id = '".$_SESSION[uid]."'");
	$prod_arr = array();
	if(mysql_num_rows($getproduct)){
		  while($res=$cms->db_fetch_array($getproduct)){
			$prod_arr[] = $res[prod_id];
		  }
	}
 //$cond = ""; 
	//$cond= " and group by store_user_id ";
	$start = intval($start);
	/*if($search){
	$pagesize = 500;
	  
	 if($_GET[product]!=""){ 
	    $prod_id=$cms->getSingleresult("select pid from #_products_user where title='".$_GET[product]."' and store_user_id = '".$_SESSION[uid]."'"); 
		$cond .= " and prod_id='$prod_id' "; 
		 
	}  
	}else{
	$pagesize = DEF_PAGE_SIZE;
	} */
	//$start = intval($start);
	$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
	$columns = "select * ";
	$sql = " from #_barnds_product where store_user_id = '".$_SESSION[store_Id]."' and brand_id='".$_SESSION[uid]."' and status='Active' and count!='0'";
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
        <?php /*
if(!$id && !$mode){
		 ?>
         <nav style="margin-top:10px;">
          <ul>
            
			<li style="margin:10px;">
		    Enter Product Name :  &nbsp;&nbsp; 
            <input name="product" type="text"  id="product"  value="<?=$_POST[product]?>" />
            
       </li>
			<li style="margin:10px;"><input id="search" style="margin: 0px; width: 100px;" lang="<?=$_SESSION[store_Id]?>"  type="button" name="search" value="search"></li>
          </ul>
		

        </nav> 
<?php }  */ ?>
        
        <div class="brdcm" id="hed-tit">Banner</div>
          
      </div>
      <div class="cl"></div>
    </header> 
    
 <div class="cl"></div>
<div class="content">
<div class="div-tbl">
<div class="cl"></div>
    <? //$adm->h1_tag('Dashboard &rsaquo; Collection Manager',$others)?>
   
<?php $hedtitle = "Product View Management"; ?>    
      <?=$adm->alert()?>
      <div class="title"  id="innertit">
        <? //=$adm->heading('Page View Management')?>
		 <h2><?=$cms->breadcrumbs()?></h2>
      </div>
      <div class="tbl-contant">
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0"  class="data-tbl">
          <tr class="t-hdr">
            <td width="2%" align="center"><?=$adm->orders('#',false)?></td> 
			 <td width="15%" align="center"><?=$adm->orders('product name',true)?></td>
			 <td width="15%" align="center"><?=$adm->orders('View',true)?></td> 
			  
          </tr>
          <?php if($reccnt){ if($start){$nums= $start+1;}else { $nums= 1;}  while ($line = $cms->db_fetch_array($result)){@extract($line);?>
          <tr <?=$adm->even_odd($nums)?>>
            <td align="center"><?=$nums?></td> 
		<?php	$store_name=$cms->getSingleresult("select name from #_store_user where pid='".$_GET[parentId]."'");?>
			<td align="center"><a href="http://<?=$cms->baseurl21($store_name)?>.fizzkart.com/detail/<?=$cms->getSingleresult("select title from #_products_user where `pid` = '$prod_id'")?>/<?=$prod_id?>" target="_blank"> <?=$cms->getSingleresult("select title from #_products_user where `pid` = '$prod_id'")?> </a></td>
			<td align="center"><?=$count?>  </a></td>  
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
var dayfrom = $("#dayfrom").val();
var product = $("#product").val(); 
var storeId = $(this).attr("lang");
var ur = '?search=1'; 
if(product){
	 ur +="&product="+trim(product); 
	} 
	if(storeId){
     ur +="&storeId="+trim(storeId);
    }
 var red = "<?=SITE_PATH_MEM.CPAGE?>/product-sub-view.php"+ur;
   window.location = red; 
});

</script>
</body>
</html>
