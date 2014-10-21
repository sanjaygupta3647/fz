<?php include("../../lib/opin.inc.php")?>
<?php define("CPAGE","gallery/")?>
<?php include("../inc/header.inc.php");?>
<?php $adm->pageAuth("Manage Theme Color",$perm);?>
<div class="main">
<? include "../inc/header2.php"; ?>
<div class="content">
<div class="div-tbl">
<div class="cl"></div>
<? //$adm->h1_tag('Dashboard &rsaquo; Email Alerts Manager',((!$mode)?$others:$others2))?>
<?php $hedtitle = "Themes Color Management"; ?>  
    <?=$adm->alert()?>
      <div class="title"  id="innertit">
        <h2><?=$cms->breadcrumbs()?></h2>
        </div>
      <div class="tbl-contant"><?php if($mode){include("add.php");}else{include("manage.php");}?></div>
       <div class="cl"></div>
    </div>
  </div> 
<?php include("../inc/footer.inc.php")?></div>
</div>
<div class="cl"></div>
</div>
</div>
<script type="text/javascript">
	$("#header_strip").blur(function(){
		var header_strip = $(this).val();
		$("#header_strip").css('background-color', '#' + header_strip); 
	});
	$("#sstrip").blur(function(){
		var sstrip = $(this).val();
		$("#sstrip").css('background-color', '#' + sstrip); 
	});
	$("#border").blur(function(){
		var border = $(this).val();
		$("#border").css('background-color', '#' + border); 
	});
	$("#background").blur(function(){
		var background = $(this).val();
		$("#background").css('background-color', '#' + background); 
	});
	$("#footer_strip").blur(function(){
		var footer_strip = $(this).val();
		$("#footer_strip").css('background-color', '#' + footer_strip); 
	});
 </script>
</body>
</html>
