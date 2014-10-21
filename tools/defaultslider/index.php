<?php include("../../lib/opin.inc.php")?> 
<?php define("CPAGE","gallery/")?>
<?php include("../inc/header.inc.php");?>
<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php $adm->pageAuth("Default Slide Banner",$perm);?>
<div class="main">
<? include "../inc/header2.php"; ?>
<div class="content">
<div class="div-tbl">
<div class="cl"></div>
<? //$adm->h1_tag('Dashboard &rsaquo; Banner '.(($catid)?'':'Banner').' Manager',((!$mode)?$others:$others2))?>
<?php $hedtitle = "Default Slider Management"; ?>
      <div class="internal-box"><?=$adm->alert()?>
      <div class="title"  id="innertit">
      <!--  <?=$adm->heading(((!$mode)?''.(($catid)?'':'Banner').' Manager':'Add/Update Banner '.(($catid)?'':'Album')))?> -->
	   <h2><?=$cms->breadcrumbs()?></h2>
        </div>
       <div class="tbl-contant"><?php if($mode){include("add.php");}else{include("manage.php");}?> </div>
    </div>
    <div class="cl"></div>
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
