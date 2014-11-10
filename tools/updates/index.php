<?php include("../../lib/opin.inc.php")?>
<?php define("CPAGE","gallery/")?>
<?php include("../inc/header.inc.php");?>
<?php $adm->pageAuth("Updates",$perm);?>
<div class="main">
<? include "../inc/header2.php"; ?>
<div class="content">
<div class="div-tbl">
<div class="cl"></div>
	<? //$adm->h1_tag('Dashboard &rsaquo; Email Alerts Manager',((!$mode)?$others:$others2))?>
<?php $hedtitle = "Updates Management"; ?>  
    <?=$adm->alert()?>
      <div class="title" id="innertit">
           <h2 class="bradcrumb">
		   <?php
		if($mode=='add' && $id!=''){?>
			<a href="/tools" rel="v:url" property="v:title">Home</a> »
			<a href="/tools/updates" rel="v:url" property="v:title">Updates </a> » 
			<a href="/tools/updates/?mode=add&amp;start=&amp;id=<?=$id?>" rel="v:url" property="v:title">Edit</a>  
		<?php		
		}else if($mode=='add' && $id=='') { 
		    ?>
			<a href="/tools" rel="v:url" property="v:title">Home</a> »
			<a href="/tools/updates" rel="v:url" property="v:title">Updates </a> » 
			<a href="/tools/updates/?mode=add" rel="v:url" property="v:title">Add</a>  
		<?php
		}else{?>
		    <a href="/tools" rel="v:url" property="v:title">Home</a> »
			<a href="/tools/updates" rel="v:url" property="v:title">Updates </a> »  
		<?php 
		}
		?>
		   </h2> 
        </div>
      <div class="tbl-contant" ><?php if($mode){include("add.php");}else{include("manage.php");}?></div>
       <div class="cl"></div>
    </div>
  </div> 
<?php include("../inc/footer.inc.php")?></div>
</div>
<div class="cl"></div>
</div>
</div> 
</body>
</html>
