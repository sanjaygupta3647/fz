<?php include("../../lib/opin.inc.php")?>
<?php define("CPAGE","gallery/")?>
<?php include("../inc/header.inc.php");?>
<div class="main">
<? include "../inc/header2.php"; ?>
<div class="content">
<div class="div-tbl">
<div class="cl"></div> 
<?php $hedtitle = "Combo Product Manager"; ?>  
    <?=$adm->alert()?>
      <div class="title"  id="innertit">
       <? //=$adm->heading(((!$mode)?'Combo Manager':'Add/Update Combo Product'))?>
	    <h2 class="bradcrumb"><?php
		if($mode=='add' && $id!=''){?>
			<a href="/member" rel="v:url" property="v:title">Home</a> »
			<a href="/member/combo" rel="v:url" property="v:title">Combo</a> » 
			<a href="/combo/?mode=add&amp;start=&amp;id=<?=$id?>" rel="v:url" property="v:title">Edit</a>  
		<?php		
		}else if($mode=='add' && $id=='') { 
		    ?>
			<a href="/member" rel="v:url" property="v:title">Home</a> »
			<a href="/member/combo" rel="v:url" property="v:title">Combo</a> » 
			<a href="/member/combo/?mode=add" rel="v:url" property="v:title">Add</a>  
		<?php
		}else{?>
		    <a href="/member" rel="v:url" property="v:title">Home</a> »
			<a href="/member/combo" rel="v:url" property="v:title">Combo</a> »  
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
 
</script>
</body>
</html>
