<?php include("../../lib/opin.inc.php")?>
<?php define("CPAGE","catalog/")?>
<?php include("../inc/header.inc.php")?>
<?php 
    $_SESSION[store_Id]=$_GET[storeId];
	$getproduct= $cms->db_query("select prod_id from #_barnds_product where brand_id = '".$_SESSION[uid]."'");
	$prod_arr = array();
	if(mysql_num_rows($getproduct)){
		  while($res=$cms->db_fetch_array($getproduct)){
			$prod_arr[] = $res[prod_id];
		  }
	}
    $cond = "";
	$start = intval($start);
	if($search){
	$pagesize = 500; 
	 if($_GET[dayfrom]!="" && $_GET[dayto]!=""){
	    $_GET[dayfrom]=$_GET[dayfrom].' 00:00:00';
        $_GET[dayto]=$_GET[dayto].' 23:59:59'; 
		$cond .= " and submitdate>='".$_GET[dayfrom]."' and submitdate<'".$_GET[dayto]."' "; 
		 
	 } 
	 if($_GET[dayfrom]!="" && $_GET[dayto]==""){
		$cond .= " and submitdate>='".$_GET[dayfrom]."' ";
		//echo $cond;die;
     }
	 
	}else{
	$pagesize = DEF_PAGE_SIZE;
	} 
	$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
	$columns = "select * ";
	$sql = " from #_orders_detail where proid in  (".implode(',',$prod_arr).") and store_id = '".$_GET[storeId]."' $cond";
	$order_by == '' ? $order_by = '(pid)' : true;
	$order_by2 == '' ? $order_by2 = 'desc' : true;
	$sql_count = "select count(*) ".$sql; 
	$sql .= "order by $order_by $order_by2 ";
	$sql .= "limit $start, $pagesize ";
	$sql = $columns.$sql;
	//echo $sql;die;
	$result = $cms->db_query($sql);
	$reccnt = $cms->db_scalar($sql_count); 
 ?>
<div class="main">
<header>
     
      <div class="hrd-right-wrap">
        <?php
if(!$id && !$mode){
		 ?>
         <nav style="margin-top:10px;">
          <ul>
            
			<li style="margin:10px;">
		    Select Date :From :  &nbsp;&nbsp; 
            <input name="dayfrom" type="text"  id="dayfrom" size="8" lang="R" readonly="readonly" class="border04" value="<?=$_POST[dayfrom]?>" />
            <img src="../calender/calendar.gif" name="dateon_button" width="16" height="16" id="dateon_button" title="Date selector" onmouseover="this.style.background='red';" 	onmouseout="this.style.background=''" />
            <script type="text/javascript">
					Calendar.setup(
					{ inputField:"dayfrom",ifFormat:"%y-%m-%d",button:"dateon_button",step:1});
					</script>
            &nbsp;&nbsp;  To :
            <input name="dayto" type="text"  id="dayto" size="8" lang="R" readonly="readonly" class="border04" value="<?=$_POST[dayto]?>" />
            <img src="../calender/calendar.gif" name="dateon_button1" width="16" height="16" id="dateon_button1" title="Date selector" onmouseover="this.style.background='red';" 	onmouseout="this.style.background=''" /> </font></span>
            <script type="text/javascript">
					Calendar.setup(
					{ inputField:"dayto",ifFormat:"%y-%m-%d",button:"dateon_button1",step:1});
	 				</script> 
       </li>
			<li style="margin:10px;"><input id="search" style="margin: 0px; width: 100px;" lang="<?=$_SESSION[store_Id]?>"  type="button" name="search" value="search"></li>
          </ul>
		

        </nav> 
<?php } ?>
        
        <div class="brdcm" id="hed-tit">Banner</div>
          
      </div>
      <div class="cl"></div>
    </header> 
    
 <div class="cl"></div>
<div class="content">
<div class="div-tbl">
<div class="cl"></div>
    <? //$adm->h1_tag('Dashboard &rsaquo; Collection Manager',$others)?>
   
<?php $hedtitle = "Product Sale Management"; ?>    
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
			 <td width="20%" align="center"><?=$adm->orders('Sale Product Url',true)?></td> 
			 <td width="15%" align="center"><?=$adm->orders('Sale Date',true)?></td> 
			  
          </tr>
          <?php if($reccnt){ if($start){$nums= $start+1;}else { $nums= 1;}  while ($line = $cms->db_fetch_array($result)){@extract($line);?>
          <tr <?=$adm->even_odd($nums)?>>
            <td align="center"><?=$nums?></td> 
			<td align="center"> <?=$cms->getSingleresult("select title from #_products_user where `pid` = '$proid'")?></td>
			<td align="center">  <a href="<?=$urls?>" target="_blank"><?=$urls?></a> </td> 
			<td align="center"><?=$submitdate?></td>
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
<script type="text/javascript">

$("#search").click(function(){
var dayfrom = $("#dayfrom").val();
var dayto = $("#dayto").val(); 
var storeId = $(this).attr("lang");
var ur = '?search=1'; 
if(dayfrom){
	 ur +="&dayfrom="+trim(dayfrom); 
	}
	if(dayto){
	 ur +="&dayto="+trim(dayto); 
	}
	if(storeId){
     ur +="&storeId="+trim(storeId);
    }
 var red = "<?=SITE_PATH_MEM.CPAGE?>/product-sub-sells.php"+ur;
   window.location = red; 
});

</script>
</body>
</html>
