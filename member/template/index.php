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
		if(!$id && !$mode){
		 ?>
        <nav style="margin-top:10px;"></nav> 
        <?php }?>
        <div class="brdcm" id="hed-tit">Banner</div>
        <div class="unvrl-btn"> 
        
         <?php if(!$_GET[mode]){?>
		 <a href="<?=SITE_PATH_MEM.CPAGE.'/?update=1'?>" class="ub">
        <img height="50" title="Click to update mail template"  alt="Click to update mail template" src="<?=SITE_PATH_MEM?>images/template.png" alt=""></a>
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
<?php //$adm->h1_tag('Dashboard &rsaquo; Email Alerts Manager',((!$mode)?$others:$others2))?>
<?php $hedtitle = "Mail Template Manager"; ?>  
    <?=$adm->alert()?>
      <div class="title"  id="innertit">
       <? //$adm->heading(((!$mode)?'Mail Template Manager':'Add/Update Mail Template'))?>
	    <h2 class="bradcrumb"><?php
		if($mode=='add' && $id!=''){?>
			<a href="/member" rel="v:url" property="v:title">Home</a> »
			<a href="/member/template" rel="v:url" property="v:title">Template</a> » 
			<a href="/template/?mode=add&amp;start=&amp;id=<?=$id?>" rel="v:url" property="v:title">Edit</a>  
		<?php		
		}else if($mode=='add' && $id=='') { 
		    ?>
			<a href="/member" rel="v:url" property="v:title">Home</a> »
			<a href="/member/template" rel="v:url" property="v:title">Template </a> » 
			<a href="/member/template/?mode=add" rel="v:url" property="v:title">Add</a>  
		<?php
		}else{?>
		    <a href="/member" rel="v:url" property="v:title">Home</a> »
			<a href="/member/template" rel="v:url" property="v:title">Template </a> »  
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
</body>
</html>
