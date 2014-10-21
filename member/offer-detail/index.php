<?php include("../../lib/opin.inc.php")?>
<?php define("CPAGE","gallery/")?>
<?php
$getpar = $cms->getSingleresult("select parent from #_store_menu where store_user_id ='".$_SESSION[uid]."' and cat_id='$cat_id' ");
$hedtitle = $cms->getSingleresult("select name from #_store_menu where store_user_id ='".$_SESSION[uid]."' and cat_id='$getpar' ")."/" .$cms->getSingleresult("select name from #_store_menu where store_user_id ='".$_SESSION[uid]."' and cat_id='$cat_id' "); ?>
<?php include("../inc/header.inc.php");?>
<div class="main">
<header>
     
      <div class="hrd-right-wrap"> 
        <div class="brdcm" id="hed-tit"> </div>
        <div class="unvrl-btn"> 
        <a href="<?=SITE_PATH_MEM.CPAGE.'/?mode=add&cat_id='.$cat_id?>" class="ub">
        <img  src="<?=SITE_PATH_MEM?>images/add-new.png" alt=""></a>
         <?php if(!$_GET[mode]){?>
          <a href="javascript:void(0)"  onclick="javascript:submitions('Active');"class="ub">
        <img src="<?=SITE_PATH_MEM?>images/active.png" alt=""></a>
        <a href="javascript:void(0)" onClick="javascript:submitions('Inactive');" class="ub">
        <img src="<?=SITE_PATH_MEM?>images/inactive.png" alt=""></a>
        <a href="javascript:void(0)" class="ub"   onclick="javascript:submitions('delete');">
        <img src="<?=SITE_PATH_MEM?>images/delete.png" alt=""></a>
		<a href="<?=SITE_PATH_MEM?>period_offer/"  class="ub">
        <img src="<?=SITE_PATH_MEM?>images/back.png" alt=""></a><? }?>
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
    <?=$adm->alert()?>
      <div class="title"  id="innertit">
       <?=$adm->heading(((!$mode)?'Hot Deal':'Add/Update City'))?>
        </div>
      <div class="tbl-contant"><?php  if($mode){include("add.php");}else{include("manage.php");}?></div>  
       <div class="cl"></div>
       <?php include("../inc/paging.inc.php")?>
    </div>
  </div> 
<?php include("../inc/footer.inc.php")?></div>
</div>
<div class="cl"></div>
</div>
</div> 
</body>
<script type="text/javascript">
$(document).ready(function(){
		$(".offer").hide(); 
		<?php if($type){?> $(".<?=$type?>").show(); <?php } ?>
}); 
$(".DealType").change(function(){
	var type = $(this).val(); 
	$(".offer").hide();   
	$("."+type).show(); 
	 
}); 
$(document).ready(function(){
	$("#brand_id").change(function(){ 
		var brand_id = $(this).val(); 
		var cat_id = '<?=$cat_id?>';  
		$.ajax({ 
			url: '<?=SITE_PATH_MEM.CPAGE?>/ajax.php?cat_id='+cat_id+'&brand_id='+brand_id, 
			success: function (data) {
				$("#proddiv").html(data); 
			},
			error: function (request, status, error) {
				alert(request.responseText);
			}
		});  
	});
}); 
</script>
</html>
