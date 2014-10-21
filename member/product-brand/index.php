<?php include("../../lib/opin.inc.php")?>
<?php define("CPAGE","gallery/")?>
<?php include("../inc/header.inc.php");?>
<?php 
 $storeTitle=$cms->getSingleresult("select title from #_store_detail where store_user_id = '$soterId' "); 
?>
<div class="main">
 <header>
 <?php
		if($_GET[cat_id]){		
			$parent = $cms->getSingleresult("select parent from #_store_menu where cat_id = '".$_GET[cat_id]."' and store_user_id='".$_SESSION[store_id]."'  ");
		}
		?>
 <div class="hrd-right-wrap">
		 <?php
		if(!$id && !$mode){
		 ?>
         <nav style="margin-top:10px;">
          <ul>
            <li style="margin:10px;"><select  name="pcat_id" class="txt medium" id="pcatId">
			<option value="">----Select Product Category----</option><?php
			 
			$cateqry=$cms->db_query("select cat_id,name from #_store_menu where store_user_id='".$_SESSION[uid]."' and parent='0' order by porder ");
			if(mysql_num_rows($cateqry)){
				while($catRes=$cms->db_fetch_array($cateqry)){?>
					<option value="<?=$catRes[cat_id]?>" <?=($parent==$catRes[cat_id])?'selected="selected"':''?>><?=$catRes[name]?></option><?php

				}
			}
			?>
			</select>
			</li>
			<li style="margin:10px;"><div id="ajaxDiv">
			<select  name="cat_id" class="txt medium" id="subcate">
			<option value="">----Select Product Sub Category----</option><?php 
			if($_GET[cat_id])
				{?>
					  
					  <? $rsAdmin=$cms->db_query("select cat_id from #_store_menu where parent='".$parent."' and store_user_id='".$_SESSION[uid]."' ");
					  if(mysql_num_rows($rsAdmin)){
					  while($arrAdmin=$cms->db_fetch_array($rsAdmin))
						{ 	?>
						  <option value="<?=$arrAdmin[cat_id]?>" <?=($arrAdmin[cat_id]==$_GET[cat_id])?'selected="selected"':''?>>
						  <?=$cms->getSingleresult("select name from #_store_menu where cat_id = '".$arrAdmin[cat_id]."' and store_user_id='".$_SESSION[uid]."' ")?></option> <?  
						}
						}
						else{
						?><option value="<?=$_GET[cat_id]?>" <?=($_GET[cat_id]==$_GET[cat_id])?'selected="selected"':''?>><?=stripslashes($cms->getSingleresult("SELECT name  from #_store_menu where cat_id = '".$_GET[cat_id]."' and store_user_id='".$_SESSION[uid]."' "))?></option><?php
						}
					   ?>
					   <?php	
				}
			?>
			</select></div>
			</li>
			 
			<li style="margin:10px;"><input type="text" id="searchTitle" name="title" value="<?=$_GET[title]?>"></li>
			 
	 
		 
			<li style="margin:10px;"><input id="search" style="margin: 0px; width: 100px;" title="<?=$_GET[soterId]?>" lang="<?=$_GET[type]?>"  type="button" name="search" value="search"></li>
          </ul>
        </nav> 
        <?php }?> 
      <div class="brdcm" id="hed-tit"><?=$storeTitle?> Brands Product</div>
      <div class="unvrl-btn">   
	 <?php if($_GET[type]!='added'){ ?> <a href="javascript:void(0)"  onclick="javascript:submitions('Add');"class="ub">
        <img src="<?=SITE_PATH_MEM?>images/add-new2.png" alt="Add" title="Add"></a>
	 <?php } ?>
        <a href="javascript:void(0)" onClick="javascript:submitions('Remove');" class="ub">
        <img src="<?=SITE_PATH_MEM?>images/delete2.png" alt="Remove" title="Remove"></a>
	  <a href="javascript:void(0)" onclick="javascript:formback();" class="ub"> <img src="<?=SITE_PATH_MEM?>images/back.png" alt=""></a> </div>
    </div>
    <div class="cl"></div>
  </header> 
<div class="content">
<div class="div-tbl">
<div class="cl"></div>
	<?php //$adm->h1_tag('Dashboard &rsaquo; Email Alerts Manager',((!$mode)?$others:$others2)) 
		
	
	?>
<?php $hedtitle = $storeTitle." Brands Product"; ?>  
    <?=$adm->alert()?>
      <div class="title"  id="innertit">
       <?=$adm->heading(((!$mode)?'Product Manager':'Add/Update Product'))?>
        </div>
      <div class="tbl-contant"><?php if($mode){include("add.php");}else{include("manage.php");}?></div>
       <div class="cl"></div>
	   <?php include("../inc/paging.inc.php")?>
    </div>
  </div> 
<?php include("../inc/footer.inc.php")?></div>
</div>
<div class="cl"></div>
</div>
</div>

<script type="text/javascript">
var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
var Accordion1 = new Spry.Widget.Accordion("Accordion1");
</script>
<script type="text/javascript">
$("#search").click(function(){
var searchTitle = $("#searchTitle").val();
var brand_id = $("#search").attr('title'); 
var type = $("#search").attr('lang'); 
var cat_id =$("#subcate").val();
var show_home =$("#show_home").val();
var ur ='?search=1'; 
    ur +="&soterId="+brand_id; 
if(type){
 ur +="&type="+type; 
}
if(cat_id){
	 ur +="&cat_id="+cat_id; 
	}
if(searchTitle){
	 ur +="&title="+trim(searchTitle); 
	}
   var red = "<?=SITE_PATH_MEM.CPAGE?>"+ur;
   window.location = red; 
});
$("#pcatId").change(function(){
var catid = $(this).val();
	$.ajax({ 
	url: '<?=SITE_PATH_MEM.CPAGE?>/serch_ajax.php?cat_id='+catid, 
	success: function (data) {
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
