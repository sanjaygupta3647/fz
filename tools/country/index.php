<?php include("../../lib/opin.inc.php")?>
<?php define("CPAGE","gallery/")?>
<?php include("../inc/header.inc.php");?>
<?php $adm->pageAuth("Manage Country",$perm);?>
<div class="main">
<? include "../inc/header2.php"; ?>
<div class="content">
<div class="div-tbl">
<div class="cl"></div>
	<? //$adm->h1_tag('Dashboard &rsaquo; Email Alerts Manager',((!$mode)?$others:$others2))?>
<?php $hedtitle = "Country Manager"; ?>  
    <?=$adm->alert()?>
      <div class="title"  id="innertit">
       <h2 class="bradcrumb"><?php
		if($mode=='add' && $id!=''){?>
			<a href="/tools" rel="v:url" property="v:title">Home</a> »
			<a href="/tools/country" rel="v:url" property="v:title">Country </a> » 
			<a href="/tools/country/?mode=add&amp;start=&amp;id=<?=$id?>" rel="v:url" property="v:title">Edit</a>  
		<?php		
		}else if($mode=='add' && $id=='') { 
		    ?>
			<a href="/tools" rel="v:url" property="v:title">Home</a> »
			<a href="/tools/country" rel="v:url" property="v:title">Country </a> » 
			<a href="/tools/country/?mode=add" rel="v:url" property="v:title">Add</a>  
		<?php
		}else{?>
		    <a href="/tools" rel="v:url" property="v:title">Home</a> »
			<a href="/tools/country" rel="v:url" property="v:title">Country </a> »  
		<?php 
		}
		?>
	  </h2>
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
