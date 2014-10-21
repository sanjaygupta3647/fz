<?php include("../../lib/opin.inc.php")?>
<?php define("CPAGE","gallery/")?>
<?php include("../inc/header.inc.php");?>

 

 

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
			<li style="margin:10px;"> 
			<select  name="show_home" class="txt medium" id="show_home">
			<option value="">----Home Product----</option> 		
							  <option value="Yes" <?=($_GET[show_home]=='Yes')?'selected="selected"':''?>>Yes</option>  
							  <option value="No" <?=($_GET[show_home]=='No')?'selected="selected"':''?>>No</option>  
			</select> 
			</li>
			<li style="margin:10px;"><input type="text" id="searchTitle" name="title" value="<?=$_GET[title]?>"></li>
			<li style="margin:10px;"><select name="offer_type" class="txt medium"   title="Offer Type" id="offer_type">
	  <option value="" <?=(($_GET[offer_type]=='none')?'selected="selected"':'')?>>None</option>
	  <option value="hotdeal" <?=(($_GET[offer_type]=='hotdeal')?'selected="selected"':'')?>>Hotdeal</option>
	  <option value="seasional" <?=(($_GET[offer_type]=='seasional')?'selected="selected"':'')?>>Seasional</option>
	  </select>	  </li>
	 
			<!--<li style="margin:10px;"><input type="checkbox" <?=($_GET[hot_deal]=='Yes')?'checked="checked"':''?> id="hot_deal" name="hot_deal" value="Yes"> Hot deal 
									 <input type="checkbox" <?=($_GET[seasional_offer]=='Yes')?'checked="checked"':''?> id="seasional_offer" name="seasional_offer" value="Yes"> Seasional Offer 
									 <input type="checkbox" <?=($_GET[combo]=='Yes')?'checked="checked"':''?> id="combo" name="combo" value="Yes"> Combo Offer</li> -->
			<li style="margin:10px;"><input id="search" style="margin: 0px; width: 100px;"  type="button" name="search" value="search"></li>
          </ul>
        </nav> 
        <?php }?>
        <div id="hed-tit">Product</div>
        <div class="unvrl-btn"> 
        <a href="<?=SITE_PATH_MEM.CPAGE.'/?mode=add'?>" class="ub">
        <img  src="<?=SITE_PATH_MEM?>images/add-new.png" alt=""></a>
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
<div class="main">
<div class="content">
<div class="div-tbl">
<div class="cl"></div>
	<? //$adm->h1_tag('Dashboard &rsaquo; Email Alerts Manager',((!$mode)?$others:$others2))?>
<?php $hedtitle = "Product Manager"; ?>  
    <?=$adm->alert()?>
      <div class="title"  id="innertit">
       <? //$adm->heading(((!$mode)?'Product Manager':'Add/Update Product'))?>
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
var cat_id =$("#subcate").val();
var show_home =$("#show_home").val(); 
var ur = '?search=1';
if(cat_id){
	 ur +="&cat_id="+cat_id; 
	}
if(searchTitle){
	 ur +="&title="+trim(searchTitle); 
	}
if(show_home){
 	 ur +="&show_home="+show_home; 
	}

if(offer_type){
var value = $('#offer_type').val();
  
    ur +="&offer_type="+value; 
	
}
/*
if($("#seasional_offer").attr('checked') == true){
    ur +="&seasional_offer=Yes"; 
}

if($("#combo").attr('checked') == true){
    ur +="&combo=Yes"; 
}  */
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
