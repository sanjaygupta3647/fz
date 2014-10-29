<?php include("../../lib/opin.inc.php")?>
<?php define("CPAGE","catalog/");
$mode=true; ?>
<?php include("../inc/header.inc.php")?>
<div class="main">
<?php
$numOfProducts = $cms->getSingleresult("select t1.noOfProducts from #_plans as t1, #_store_detail as t2 where t2.pid ='".$_SESSION[store_id]."' and t1.pid= t2.plan_id");
$total = $cms->getSingleresult("select count(*) from #_products_user where store_user_id ='".$_SESSION[uid]."' ");
if($_SESSION[usertype]!='brand' ){
	$totalBrandProduct = $cms->getSingleresult("select count(*) from #_barnds_product where store_user_id ='".$_SESSION[uid]."' ");
	if($totalBrandProduct) $total = $total+$totalBrandProduct;
}
$remain = $numOfProducts-$total;
?>
<header> 
      <div class="hrd-right-wrap">  
        <div class="brdcm" id="hed-tit">Export XLS File( <?=$remain?> Product Remain)</div>
        <div class="unvrl-btn">  
        </div> 
      </div>
      <div class="cl"></div>
    </header> 
<?php

if($cms->is_post_back()){  
		$spec = array(); 
		$rqrey = $cms->db_query("SELECT specifications FROM `#_category` where specifications!='' ");
		if(mysql_num_rows($rqrey)){
			while($re=$cms->db_fetch_array($rqrey)){
				$sc .= $re[specifications].",";	
			}
		}
		$sc = substr($sc,0,-1);
		$spec = @explode(',',$sc);  
		if(count($_POST[cat_id])){ 
 		$xlsx = new SimpleXLSX($_FILES['file']['tmp_name']); 
	     $c = count($xlsx->rows());
		 if($c >$remain){
		  $adm->sessset("its $c products, Only $remain products are allowed to upload!", 'e');  
		  $cms->redir(SITE_PATH_MEM."catalog/export-xls.php", true); die;
		 }
			$i = 0;
  			foreach($xlsx->rows() as $value){ 
					if($value[6]){
					if($i>0){  
						//$cat_id = 0;
						$cat_id = $cms->getsingleresult("select cat_id FROM #_store_menu where name = '".trim($value[3])."' and  store_user_id = '".$_SESSION[uid]."'  "); 
						if(!$cat_id) $cat_id = $cms->getsingleresult("select pid FROM #_category where name = '".trim($value[3])."' ");
						$storeids = $_SESSION[uid];
						$status =   ($value[21])?$value[21]:'Active';
						$submitdate = ($value[24])?$value[24]:time(); 
						$query = "insert into #_products_user set   
						admin_product_id  = '".trim($value[1])."',
						store_user_id = '".$storeids."',
						cat_id = '".$_POST[cat_id]."',
						combo  = '".trim($value[4])."',
						brand_id = '".trim($value[5])."',
						title = '".addslashes(trim($value[6]))."',
						meta_title = '".addslashes(trim($value[7]))."',
						meta_keyword = '".addslashes(trim($value[8]))."',
						meta_description = '".addslashes(trim($value[9]))."',
						pcode =      '".addslashes(trim($value[10]))."',
						kf1 =        '".addslashes(trim(str_replace("_x000D_","",$value[11])))."', 
						kf2 =        '".addslashes(trim(str_replace("_x000D_","",$value[12])))."', 
						kf3 =        '".addslashes(trim(str_replace("_x000D_","",$value[13])))."', 
						clicks  =    '".trim($value[14])."',
						image1 =     '".trim($value[15])."',
						image2  =    '".trim($value[16])."',
						image3  =    '".trim($value[17])."',
						image4  =    '".trim($value[18])."',
						body1 =      '".addslashes(trim(str_replace("_x000D_","",$value[19])))."',
						url  =       '".trim($value[20])."',
						status  =    '".trim($value[21])."',
						show_home  = '".trim($value[22])."',
						porder  =    '".trim($value[23])."',
						submitdate = '".trim($submitdate)."',
						 
						offer_type = '".trim($value[27])."',  
						dtime =      '".trim($value[28])."', 
						shipping  =  '".trim($value[29])."',
						discount  =  '".trim($value[30])."',
						color =      '".trim($value[31])."'";  
					 
						 
						$cms->db_query($query);
						$lastid = mysql_insert_id();
						$value[34] = trim($value[34]);
						$value[35] = trim($value[35]);
						$value[36] = trim($value[36]);
						$value[37] = trim($value[37]);
						$value[38] = trim($value[38]);
						$value[39] = trim($value[39]);
						$value[40] = trim($value[40]);
						$value[41] = trim($value[41]);
						$value[42] = trim($value[42]);
						$value[43] = trim($value[43]);
						
						if($lastid){
							$pri = trim($value[26]);
							if($pri){
								$all = explode("|||",$pri);
								foreach($all as $vals){
									 $sa = explode("$",$vals); 
									 $cms->db_query("insert into fz_product_price set proid= '".$lastid."',store_id= '".$storeids."',dtitle= '".$sa[2]."',
									 dsize= '".$sa[3]."',dprice= '".$sa[4]."',dofferprice= '".$sa[5]."'"); 
									 
								}
							}
							

							if(@in_array($value[34],$spec) && $value[34]!=""){
								$cms->db_query("insert into #_product_feature set prod_id = '$lastid', 
								ftitle= '".addslashes(trim(str_replace("_x000D_","",$value[34])))."', 
								fdescription= '".addslashes(trim(str_replace("_x000D_","",$value[35])))."' ");
							}
							if(@in_array($value[36],$spec) && $value[36]!=""){
								$cms->db_query("insert into #_product_feature set prod_id = '$lastid', 
								ftitle= '".addslashes(trim(str_replace("_x000D_","",$value[36])))."', 
								fdescription= '".addslashes(trim(str_replace("_x000D_","",$value[37])))."' ");
							}
							if(@in_array($value[38],$spec) && $value[38]!=""){
								$cms->db_query("insert into #_product_feature set prod_id = '$lastid', 
								ftitle= '".addslashes(trim(str_replace("_x000D_","",$value[38])))."', 
								fdescription= '".addslashes(trim(str_replace("_x000D_","",$value[39])))."' ");
							}
							if(@in_array($value[40],$spec) && $value[40]!=""){
								$cms->db_query("insert into #_product_feature set prod_id = '$lastid', 
								ftitle= '".addslashes(trim(str_replace("_x000D_","",$value[40])))."', 
								fdescription= '".addslashes(trim(str_replace("_x000D_","",$value[41])))."' ");
							}
							if(@in_array($value[42],$spec) && $value[42]!=""){
								$cms->db_query("insert into #_product_feature set prod_id = '$lastid', 
								ftitle= '".addslashes(trim(str_replace("_x000D_","",$value[42])))."', 
								fdescription= '".addslashes(trim(str_replace("_x000D_","",$value[43])))."' ");
							}
						} 
 					}
				 $i++;
					
			 }
			  }  
			 $adm->sessset('Record has been saved, Thanks!', 's');  
			 
		}
		
}
 
?>
<div class="content">
<div class="div-tbl">
<div class="cl"></div>
    <? //$adm->h1_tag('Dashboard &rsaquo; Order Details',$others2)?>
  <?php $hedtitle = "Add Product Via XLS ( ".$remain." Product Remain)"; ?>    
      <?=$adm->alert()?>
      <div class="title">
        <? //=$adm->heading('Export XLS')?>
		 <h2><?=$cms->breadcrumbs()?></h2>
      </div>
      <div class="tbl-contant">
   <table width="100%" border="0" align="left" cellpadding="4" cellspacing="1" class="frm-tbl2">
	  <?php
	   $planid = $cms->getSingleresult("select plan_id  from #_store_detail where `pid` = '".$_SESSION[store_id]."'");
	   $parent  = $cms->getSingleresult("SELECT parentId  FROM #_category WHERE pid = '".$cat_id."' ");
	?>
    <tr  class="grey_">
      <td width="25%" class="label">Select Parent Category:</td>
      <td width="75%">	 
      <select  name="pcat_id" class="txt medium" id="pcatId" lang="R" title="Category">
      <option value="0">---Select Category--</option> 
      <?php 
	  $rsAdmin=$cms->db_query("select cat_id,name from #_store_menu where store_user_id='".$_SESSION[uid]."' and parent='0' order by porder ");
	  while($arrAdmin=$cms->db_fetch_array($rsAdmin)){ ?>
	   <option value="<?=$arrAdmin[cat_id]?>" <?=($arrAdmin[cat_id]==$parent)?'selected="selected"':''?>>
	   <?=$cms->getSingleresult("SELECT name  FROM #_category WHERE pid = '".$arrAdmin[cat_id]."' ")?>
	   </option><?php     
 	   }?>
	  </select>	 
      </td>
    </tr> 
    
    <tr id="subcat">
      <td width="25%"  class="label">Product Sub Category:</td>
      <td width="75%"><div id="ajaxDiv"><a target="_blank" href="http://fizzkart.com/ms_file/xls?store_user_id=<?=$_SESSION[uid]?>&cat_id=0" > Download backup  of complete product(s) </a></div></td>
    </tr> 
	<tr id="subcat">
      <td width="25%"  class="label">Upload Exals File:</td>
      <td width="75%"><input type="file" class="txt medium" name="file"></td>
    </tr> 
       <tr>
          <td>&nbsp;</td>
            <td><input type="submit" name="Submit" class="uibutton  loading" value="&nbsp;&nbsp;&nbsp;Submit&nbsp;&nbsp;&nbsp;" /></td>
          </tr>
        </table> 
     
<?php include("../inc/footer.inc.php")?>
</div>
<div class="cl"></div>
</div>
</div>
<script>
$("#pcatId").change(function(){
		var catid = $(this).val();
			$.ajax({ 
			url: '<?=SITE_PATH_MEM.CPAGE?>/ajax-cat.php?cat_id='+catid, 
			success: function (data) {
				$("#subcat").show();
				$("#ajaxDiv").html(data); 
			},
			error: function (request, status, error) {
			alert(request.responseText);
			}
			}); 		
			
		}); 
 	$("body").delegate("#sub_cat_id", "change", function(){
			var sub_cat_id = $(this).val();  
			$.ajax({ 
			url: '<?=SITE_PATH_MEM.CPAGE?>/ajax-sub-cat.php?sub_cat_id='+sub_cat_id, 
			success: function (data) { 
				$("#sub-cat-pro-backup").html(data); 
			},
			error: function (request, status, error) {
			alert(request.responseText);
			}
			}); 		
			
});
</script>
</body>
</html>