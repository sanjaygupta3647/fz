<?php include("../../lib/opin.inc.php")?>
<?php define("CPAGE","catalog/");$mode=true?>
<?php include("../inc/header.inc.php")?>
<div class="main">
<header>
     
      <div class="hrd-right-wrap">
        
        
        <div class="brdcm" id="hed-tit">Export XLS File <a href="xls.php"> Import XLS File </a></div>
        <div class="unvrl-btn"> 
        
        
        </div> 
      </div>
      <div class="cl"></div>
    </header> 
<?php
if($cms->is_post_back()){   
		if(count($_POST[cat_id])){
 			$xlsx = new SimpleXLSX($_FILES['file']['tmp_name']);
			 	$i = 0;
  			foreach($xlsx->rows() as $value){ 
					if($i>0 && $value[1]!=""){
				   $query = "insert into #_products_user set store_user_id = '".$_SESSION[uid]."',cat_id = '".$_POST[cat_id]."',title = '".addslashes(trim($value[1]))."',
					pcode = '".addslashes($value[2])."',
					price = '".$cms->findPrice($value[3])."', offerprice = '".$cms->findPrice($value[3])."',status='Active', image1 = '".trim($value[0])."',body1 = '".addslashes(trim($value[4]))."'
					,kf1 = '".addslashes(trim(str_replace("_x000D_","",$value[5])))."', kf2 = '".addslashes(trim(str_replace("_x000D_","",$value[6])))."', kf3 = '".addslashes(trim(str_replace("_x000D_","",$value[7])))."' ";  
				     $cms->db_query($query);
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
      <td width="75%"><div id="ajaxDiv"></div></td>
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
</script>
</body>
</html>