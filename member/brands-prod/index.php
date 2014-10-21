<?php include("../../lib/opin.inc.php")?>
<?php define("CPAGE","gallery/")?>
<?php include("../inc/header.inc.php");?>
<div class="main">
<header>
		<?php
		if($_GET[cat_id]){		
			$parent = $cms->getSingleresult("select parentId from #_category where pid = '".$_GET[cat_id]."'");
		}
		?>     
      <div class="hrd-right-wrap">
		 <?php
		if(!$id and !$mode){
		 ?>
         <nav style="margin-top:10px;">
          <ul>
            <li style="margin:10px;"><select  name="pcat_id" class="txt medium" id="pcatId">
			<option value="">----Select Product Category----</option><?php
			$current_plan_id = $cms->getSingleresult("select plan_id from #_store_detail where pid = '".$_SESSION[store_id]."'");
			$cateqry=$cms->db_query("select cat_id from #_store_menu where store_user_id='".$_SESSION[uid]."' and parent='0'");
			if(mysql_num_rows($cateqry)){
				while($catRes=$cms->db_fetch_array($cateqry)){?>
					<option value="<?=$catRes[cat_id]?>" <?=($parent==$catRes[cat_id])?'selected="selected"':''?>><?=$cms->getSingleresult("select name from #_category where pid = '".$catRes[cat_id]."'")?></option><?php

				}
			}
			?>
			</select>
			</li>
			<li style="margin:10px;"><div id="ajaxDiv">
			<select  name="cat_id" class="txt medium" id="cat_id">
			<option value="">----Select Product Sub Category----</option><?php 
			if($_GET[cat_id])
				{?>
					  
					  <? $rsAdmin=$cms->db_query("select pid,name from #_category where parentId='".$parent."'");
					  if(mysql_num_rows($rsAdmin)){
					  while($arrAdmin=$cms->db_fetch_array($rsAdmin))
						{@extract($arrAdmin);	?>
						  <option value="<?=$pid?>" <?=($pid==$_GET[cat_id])?'selected="selected"':''?>><?=stripslashes($name)?></option> <?  
						}
						}
						else{
						?><option value="<?=$_GET[cat_id]?>" <?=($_GET[cat_id]==$_GET[cat_id])?'selected="selected"':''?>><?=stripslashes($cms->getSingleresult("SELECT name  FROM #_category WHERE pid = '".$_GET[cat_id]."' "))?></option><?php
						}
					   ?>
					   <?php	
				}
			?>
			</select></div>
			</li>

			<li style="margin:10px;"> 
			<select  name="brand_id" class="txt medium" id="brand_id">
			<option value="">----Select Brand----</option><?php 		 
 					  $brandQury=$cms->db_query("select brand_id  from #_request_brand where store_user_id='".$_SESSION[uid]."' and status='Active'");
					  if(mysql_num_rows($brandQury)){
							while($res=$cms->db_fetch_array($brandQury)){@extract($res);	?>							
							  <option value="<?=$brand_id?>" <?=($brand_id==$_GET[brand_id])?'selected="selected"':''?>>
							  <?=stripslashes($cms->getSingleresult("select title  from #_store_detail where store_user_id='".$brand_id."'"))?></option> <?  
							}
						}
						 
					   ?>
					 
			 
			</select> 
			</li>
			 
			<li style="margin:10px;"><input type="text" id="searchTitle" name="title" value="<?=$_GET[title]?>"></li>
			<li style="margin:10px;"><input id="search"   type="button" name="search" value="search"></li>
          </ul>
        </nav> 
        <?php }?>
        <div class="brdcm" id="hed-tit">Banner</div>
        <div class="unvrl-btn"> 
         
         <?php if(!$_GET[mode]){?>
          <a href="javascript:void(0)"  onclick="javascript:submitions('Active');"class="ub">
        <img src="<?=SITE_PATH_MEM?>images/active.png" alt=""></a>
        <a href="javascript:void(0)" onClick="javascript:submitions('Inactive');" class="ub">
        <img src="<?=SITE_PATH_MEM?>images/inactive.png" alt=""></a>
        <a href="javascript:void(0)" class="ub"   onclick="javascript:submitions('delete');">
        <img src="<?=SITE_PATH_MEM?>images/delete.png" alt=""></a> <? }?>
       <?php if($_GET[mode]){?>
        <a href="javascript:void(0)" onclick="javascript:formback();" class="ub">
        <img src="<?=SITE_PATH_MEM?>images/back.png" alt=""></a><?php }?>
        
        </div> 
      </div>
      <div class="cl"></div>
    </header>

<div class="content">
<div class="div-tbl">
<div class="cl"></div>
	<? //$adm->h1_tag('Dashboard &rsaquo; Email Alerts Manager',((!$mode)?$others:$others2))?>
<?php $hedtitle = "Brand Product Manager"; ?>  
    <?=$adm->alert()?>
      <div class="title"  id="innertit">
       <? //=$adm->heading(((!$mode)?'Brand Product Manager':'Add/Update Product'))?>
	    <h2><?=$cms->breadcrumbs()?></h2>
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
$("#search").click(function(){
var searchTitle = $("#searchTitle").val();
var cat_id =$("#cat_id").val();
var brand_id =$("#brand_id").val();
var show_home =$("#show_home").val();
var ur = '?search=1';
if(cat_id){
	 ur +="&cat_id="+cat_id; 
	}
if(searchTitle){
	 ur +="&title="+trim(searchTitle); 
	}
if(brand_id){
	 ur +="&brand_id="+brand_id; 
	}
if(show_home){
 	 ur +="&show_home="+show_home; 
	}
   var red = "<?=SITE_PATH_MEM.CPAGE?>"+ur;
   window.location = red;
});
$("#pcatId").change(function(){
var catid = $(this).val();
	$.ajax({ 
	url: '<?=SITE_PATH_MEM.CPAGE?>/ajax.php?cat_id='+catid, 
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
