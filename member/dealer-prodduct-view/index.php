<?php include("../../lib/opin.inc.php")?>
<?php define("CPAGE","gallery/")?>
<?php include("../inc/header.inc.php");?>
<div class="main">
 <header>
    <div class="hrd-right-wrap">
 
      <div class="brdcm" id="hed-tit">View Product</div>
      <div class="unvrl-btn">   
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
		
	$store_name=$cms->getSingleresult("select title from #_store_detail where store_user_id = '$soterId' ");
	?>
<?php $hedtitle = "Product View On ".$store_name; ?>  
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
</body>
</html>
