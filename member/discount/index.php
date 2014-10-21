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
		   <h2><?=$cms->breadcrumbs()?></h2>
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