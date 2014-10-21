 <?php include("../../lib/opin.inc.php")?>
<?php define("CPAGE","catalog/");$mode=true?>
<?php include("../inc/header.inc.php")?>
<div class="main">
<header> 
      <div class="hrd-right-wrap"> 
        <div class="brdcm" id="hed-tit">Export XLS File</div>
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
			//echo"<pre>"; print_r($_FILES);print_r($xlsx->rows()); die('done');
			$i = 0;
  			foreach($xlsx->rows() as $value){ 
					if($i>0){ 
						$cat_id = 0;
						$cat_id = $cms->getsingleresult("select cat_id FROM #_store_menu where name = '".trim($value[3])."' and  
						store_user_id = '".$_SESSION[uid]."'    "); 
						if(!$cat_id) $cat_id = $cms->getsingleresult("select pid FROM #_category where name = '".trim($value[3])."' ");
						$storeids = ($value[2])?($value[2]):$_SESSION[uid];
						$status =   ($value[23])?$value[23]:'Active';
						$submitdate = ($value[26])?$value[26]:time();
						$query = "insert into #_products_user set  
						admin_product_id  = '".trim($value[1])."',
						store_user_id = '".$storeids."',
						combo  = '".trim($value[4])."',
						brand_id = '".trim($value[5])."',
						title = '".addslashes(trim($value[6]))."',
						meta_title = '".addslashes(trim($value[7]))."',
						meta_keyword = '".addslashes(trim($value[8]))."',
						meta_description = '".addslashes(trim($value[9]))."',
						pcode = '".addslashes(trim($value[10]))."',
						kf1 = '".addslashes(trim(str_replace("_x000D_","",$value[11])))."', 
						kf2 = '".addslashes(trim(str_replace("_x000D_","",$value[12])))."', 
						kf3 = '".addslashes(trim(str_replace("_x000D_","",$value[13])))."',
						hot_deal  = '".trim($value[14])."',
						seasional_offer  = '".trim($value[15])."',
						clicks  = '".trim($value[16])."',
						image1  = '".trim($value[17])."',
						image2  = '".trim($value[18])."',
						image3  = '".trim($value[19])."',
						image4  = '".trim($value[20])."',
						body1 = '".addslashes(trim(str_replace("_x000D_","",$value[21])))."',
						url  = '".trim($value[22])."',
						status  = '".trim($status)."',
						show_home  = '".trim($value[24])."',
						porder  = '".trim($value[25])."',
						submitdate  = '".trim($submitdate)."',
						size  = '".trim($value[27])."',
						price = '".$cms->findPrice($value[28])."', 
						offerprice = '".$cms->findPrice($value[29])."',
						shipping  = '".trim($value[30])."',
						discount  = '".trim($value[31])."',
						color = '".trim($value[32])."',
						cat_id = '".$cat_id."'  ";  
						$cms->db_query($query); 
						$lastid = mysql_insert_id();
						$value[33] = trim($value[33]);
						$value[34] = trim($value[34]);
						$value[35] = trim($value[35]);
						$value[36] = trim($value[36]);
						$value[37] = trim($value[37]);
						$value[38] = trim($value[38]);
						$value[39] = trim($value[39]);
						$value[40] = trim($value[40]);
						$value[41] = trim($value[41]);
						$value[42] = trim($value[42]);
						if($lastid){
							if(@in_array($value[33],$spec) && $value[33]!=""){
								$cms->db_query("insert into #_product_feature set prod_id = '$lastid', 
								ftitle= '".addslashes(trim(str_replace("_x000D_","",$value[33])))."', 
								fdescription= '".addslashes(trim(str_replace("_x000D_","",$value[34])))."' ");
							}
							if(@in_array($value[35],$spec) && $value[35]!=""){
								$cms->db_query("insert into #_product_feature set prod_id = '$lastid', 
								ftitle= '".addslashes(trim(str_replace("_x000D_","",$value[35])))."', 
								fdescription= '".addslashes(trim(str_replace("_x000D_","",$value[36])))."' ");
							}
							if(@in_array($value[37],$spec) && $value[37]!=""){
								$cms->db_query("insert into #_product_feature set prod_id = '$lastid', 
								ftitle= '".addslashes(trim(str_replace("_x000D_","",$value[37])))."', 
								fdescription= '".addslashes(trim(str_replace("_x000D_","",$value[38])))."' ");
							}
							if(@in_array($value[39],$spec) && $value[39]!=""){
								$cms->db_query("insert into #_product_feature set prod_id = '$lastid', 
								ftitle= '".addslashes(trim(str_replace("_x000D_","",$value[39])))."', 
								fdescription= '".addslashes(trim(str_replace("_x000D_","",$value[40])))."' ");
							}
							if(@in_array($value[41],$spec) && $value[41]!=""){
								$cms->db_query("insert into #_product_feature set prod_id = '$lastid', 
								ftitle= '".addslashes(trim(str_replace("_x000D_","",$value[41])))."', 
								fdescription= '".addslashes(trim(str_replace("_x000D_","",$value[42])))."' ");
							}
						} 
 					}
				 $i++;
					
			}  
			$adm->sessset('Record has been saved, Thanks!', 's');  
			 
		}
		
}
 
?>
<div class="content">
<div class="div-tbl">
<div class="cl"></div>
    <? //$adm->h1_tag('Dashboard &rsaquo; Order Details',$others2)?>
  <?php $hedtitle = "Add Product Via XLS"; ?>    
      <?=$adm->alert()?>
      <div class="title">
        <?=$adm->heading('Export XLS')?>
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
	  $rsAdmin=$cms->db_query("select cat_id from  #_plans_category  where  plan_id = '$planid' and parent != 0 ");
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