<?php include("../../lib/opin.inc.php")?>
<?php define("CPAGE","catalog/")?>
<?php include("../inc/header.inc.php")?>
<?php   
 	 
	
	  
?>
<div class="main">
<header>
     
      <div class="hrd-right-wrap">
       <?php /*?> <nav>
          <ul>
            <li> <a href="<?=SITE_PATH_MEM?>"></a> </li>
            <li> <a href="<?=SITE_PATH_MEM?>catalog/collections.php">store_detail</a> </li>
            <li> <a href="<?=SITE_PATH_MEM?>catalog/manage-category.php">Category</a> </li>
            <li> <a href="<?=SITE_PATH_MEM?>setting.php?mode=true">Setting</a> </li>
           <!-- <li> <a href="">System</a> </li>-->
          </ul>
        </nav><?php */?>
        
        <div class="brdcm" id="hed-tit">Banner</div>
        <div class="unvrl-btn" style="width: 147px;"> 
		 <a target="_blank" href="http://fizzkart.com/ms_file/pricelist-xls?store_user_id=<?=$_SESSION[uid]?>" >
		 <img width="32" src="<?=SITE_PATH_MEM?>images/xls.jpg" alt=""> </a> &nbsp;
        <a href="#" onclick="PrintDiv();" class="ub">
        <img src="<?=SITE_PATH_MEM?>images/print.jpg" alt=""> </a> 
        <a href="javascript:void(0)" onclick="javascript:formback();" class="ub">
        <img src="<?=SITE_PATH_MEM?>images/back.png" alt=""> </a>
        
        </div> 
      </div>
      <div class="cl"></div>
    </header> 
    
 <div class="cl"></div>
<div class="content">
<div class="div-tbl">
<div class="cl"></div>
    <? //$adm->h1_tag('Dashboard &rsaquo; Collection Manager',$others)?>
   
<?php $hedtitle = "Price List"; ?>    
      <?=$adm->alert()?>
      <div class="title"  id="innertit">
        <? //=$adm->heading('Price List')?>
		 <h2><?=$cms->breadcrumbs()?></h2>
      </div>
      <div class="tbl-contant" id="divToPrint">
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0"  class="data-tbl">
          <tr class="t-hdr">
            <td width="2%" align="center"><?=$adm->orders('#',false)?></td> 
			<td width="15%" align="center"><?=$adm->orders('Store/Brand Name',true)?></td>
            <td width="15%" align="center"><?=$adm->orders('Category Name',true)?></td> 
            <td width="30%" align="center"><?=$adm->orders('Product Name',true)?></td>
			<td width="15%" align="center"><?=$adm->orders('Product Code',true)?></td>
			<td width="10%" align="center"><?=$adm->orders('Unit',true)?></td>
            <td width="15%" align="center"><?=$adm->orders('Price',true)?></td> 
			<td width="15%" align="center"><?=$adm->orders('Offer Price',true)?></td> 
          </tr>
          <?php 
			$sql = $cms->db_query("select cat_id, name from #_store_menu where store_user_id='".$_SESSION[uid]."' order by name  ");
			$reccnt = mysql_num_rows($sql);
			if($reccnt){ $nums=1; while ($line = $cms->db_fetch_array($sql)){@extract($line);
			$prods  = array();
			$allprod =  $cms->db_query("select pid from fz_products_user  where store_user_id='".$_SESSION[uid]."' and status = 'Active' and cat_id = '$cat_id' "); 
			if(mysql_num_rows($allprod)){
			  while($userProd=$cms->db_fetch_array($allprod)){
				$prods[] = $userProd[pid];
			  }
			} 
			$brandProds = $cms->db_query("select prod_id from #_barnds_product where store_user_id='".$_SESSION[uid]."'  and cat_id = '$cat_id'  and status='Active' ");			
			if(mysql_num_rows($brandProds)){
			  while($res=$cms->db_fetch_array($brandProds)){
				$prods[] = $res[prod_id];
			  }
			}
			if(count($prods)){
			$prodQry = $cms->db_query("select * from #_product_price where proid in  (".implode(',',$prods).") ");
			while($res123=$cms->db_fetch_array($prodQry)){ @extract($res123);
?>
          <tr <?=$adm->even_odd($nums)?>>
            <td align="center"><?=$nums?></td>  
			<?php $store_id=$cms->getSingleresult("select store_user_id from #_products_user where store_user_id ='".$_SESSION[uid]."' and cat_id='$cat_id' and pid='$proid' "); 
			      $brand_id=$cms->getSingleresult("select brand_id from #_barnds_product where store_user_id ='".$_SESSION[uid]."' and cat_id='$cat_id' and prod_id='$proid' "); 
			?>
			<td align="center"><?php if($store_id){  echo $title=$cms->getSingleresult("select title from #_store_detail where store_user_id ='$store_id' "); }else{ echo $title=$cms->getSingleresult("select title from #_store_detail where store_user_id ='$brand_id' "); }?> </td>
            <td align="center"><?=$cms->getSingleresult("select name from #_store_menu where store_user_id ='".$_SESSION[uid]."' and cat_id='$cat_id' ");?></td> 
            <td align="center"><?=strip_tags($cms->getSingleresult("select title from #_products_user where  pid='$proid' "))?></td>
			<?php $pcode=$cms->getSingleresult("select pcode from #_products_user where   pid='$proid' ");  ?>
			<td align="center"><?=strip_tags(($pcode)?$pcode:'NA')?></td> 
			<td align="center"><?=($dsize)?$dsize:'NA'?></td> 
            <td align="center"><?=($dprice!=0)?CUR.$dprice:'NA'?></td> 
			<td align="center"><?=($dofferprice!=0)?CUR.$dofferprice:'NA'?></td> 
          </tr>
          <?php
			$nums++;}
			}
          }}else{ echo $adm->rowerror(5);}?>
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
