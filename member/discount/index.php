<?php include("../../lib/opin.inc.php")?>
<?php define("CPAGE","gallery/")?>
<?php include("../inc/header.inc.php");?>
<?php defined('_JEXEC') or die('Restricted access'); ?>
<div class="main">
  <header>
    <div class="hrd-right-wrap">
      <div class="brdcm" id="hed-tit">Discount Management</div>
      <div class="unvrl-btn">  
         
        <a href="<?=SITE_PATH_MEM.CPAGE?>" class="ub"> <img src="<?=SITE_PATH_MEM?>images/back.png" alt=""></a>
        
      </div>
    </div>
    <div class="cl"></div>
  </header>
  <div class="cl"></div>
  <div class="content">
    <div class="div-tbl">
      <div class="cl"></div>
       <?php $hedtitle = "Discount Management";  ?>
      <div class="internal-box">
        <?=$adm->alert()?>
        <div class="title">
          <? //$adm->heading('Add/Update Discount')?>
		   <h2 class="bradcrumb"><?php
		if($mode=='add' && $id!=''){?>
			<a href="/member" rel="v:url" property="v:title">Home</a> »
			<a href="/member/discount" rel="v:url" property="v:title">Discount</a> » 
			<a href="/discount/?mode=add&amp;start=&amp;id=<?=$id?>" rel="v:url" property="v:title">View</a>  
		<?php		
		}else if($mode=='add' && $id=='') { 
		    ?>
			<a href="/member" rel="v:url" property="v:title">Home</a> »
			<a href="/member/discount" rel="v:url" property="v:title">Discount</a> » 
			<a href="/member/discount/?mode=add" rel="v:url" property="v:title">Add</a>  
		<?php
		}else{?>
		    <a href="/member" rel="v:url" property="v:title">Home</a> »
			<a href="/member/discount" rel="v:url" property="v:title">Discount </a> »  
		<?php 
		}
		?>
	  </h2>
        </div>
        <div class="tbl-contant">
          <?php include("add.php"); ?>
        </div>
      </div>
      <div class="cl"></div>
    </div>
  </div>
  <?php include("../inc/footer.inc.php")?>
</div>
</div>
<div class="cl"></div>
</div>
</div> 
</body></html>