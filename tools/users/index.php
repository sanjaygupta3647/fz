<?php include("../../lib/opin.inc.php")?>
<?php define("CPAGE","gallery/")?>
<?php include("../inc/header.inc.php");?>
<?php $adm->pageAuth("Users Detail",$perm);?>
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
            <li style="margin:10px;">
			<select  name="type" class="txt medium" id="type">
				<option value="">----Select Store Type----</option> 
				<option value="store" <?=$_GET[type]=='store'?'selected="selected"':''?>>Store</option> 
				<option value="brand" <?=$_GET[type]=='brand'?'selected="selected"':''?>>Brand</option> 
				 
			</select>
			</li>
			<li style="margin:10px;"><div id="ajaxDiv">
			<select  name="status" class="txt medium" id="status">
			<option value="">----Status----</option> 
			<option value="Active" <?=$_GET[status]=='Active'?'selected="selected"':''?>>Active</option> 
			<option value="Inactive" <?=$_GET[status]=='Inactive'?'selected="selected"':''?>>Inactive</option>
			</select></div>
			</li>
			<li style="margin:10px;">
			<input list="browsers" type="text" id="name" name="name" value="<?=$_GET[name]?>">
			<?php  $namesq="select name from #_store_user group by name order by name";
					$namesqe=$cms->db_query($namesq);?>
					<datalist id="browsers"><?php 
					 while($na=$cms->db_fetch_array($namesqe)){  ?>
					<option value="<?=$na[name]?>">
                <?php }?></datalist>
			</li>
			<li style="margin:10px;"><input id="search"   type="button" name="search" value="search"></li>
          </ul>
        </nav> 
        <?php }?>
        <div class="brdcm" id="hed-tit">Banner</div>
        <div class="unvrl-btn"> 
         
         <?php if(!$_GET[mode]){?>
          <a href="javascript:void(0)"  onclick="javascript:submitions('Active');"class="ub">
        <img src="<?=SITE_PATH_ADM?>images/active.png" alt=""></a>
        <a href="javascript:void(0)" onClick="javascript:submitions('Inactive');" class="ub">
        <img src="<?=SITE_PATH_ADM?>images/inactive.png" alt=""></a>
        <a href="javascript:void(0)" class="ub"   onclick="javascript:submitions('delete');">
        <img src="<?=SITE_PATH_ADM?>images/delete.png" alt=""></a> <? }?>
       <?php if($_GET[mode]){?>
        <a href="javascript:void(0)" onclick="javascript:formback();" class="ub">
        <img src="<?=SITE_PATH_ADM?>images/back.png" alt=""></a><?php }?>
        
        </div> 
      </div>
      <div class="cl"></div>
    </header> 
<div class="content">
<div class="div-tbl">
<div class="cl"></div>
<?php $hedtitle = "Store Users Management"; ?>  
	<? //$adm->h1_tag('Dashboard &rsaquo; Email Alerts Manager',((!$mode)?$others:$others2))?>

    <?=$adm->alert()?>
      <div class="title"  id="innertit">
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
var name = $("#name").val();
var type =$("#type").val();
var status =$("#status").val();
var ur = '?search=1';
if(name){
	 ur +="&name="+trim(name); 
	}
	if(type){
	 ur +="&type="+trim(type); 
	}
	if(status){
	 ur +="&status="+trim(status); 
	}
   var red = "<?=SITE_PATH_ADM.CPAGE?>"+ur; 
   window.location = red;
}); 
</script>
</body>
</html>
