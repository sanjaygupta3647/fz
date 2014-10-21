<?php include("../../lib/opin.inc.php")?>
<?php define("CPAGE","gallery/")?>
<?php include("../inc/header.inc.php");?>
<?php defined('_JEXEC') or die('Restricted access'); ?>
<div class="main">
  <header>
    <div class="hrd-right-wrap">
      <div class="brdcm" id="hed-tit">Shipping Management</div>
      <div class="unvrl-btn"> <a href="<?=SITE_PATH_MEM.CPAGE?>?mode=add" class="ub" > <img onclick="location.href=" src="<?=SITE_PATH_MEM?>images/add-new.png" alt=""></a>
        <?php if($_GET[id]){?>
        <a href="<?=SITE_PATH_MEM.CPAGE?>" class="ub"> <img src="<?=SITE_PATH_MEM?>images/back.png" alt=""></a>
        <?php }?>
      </div>
    </div>
    <div class="cl"></div>
  </header>
  <div class="cl"></div>
  <div class="content">
    <div class="div-tbl">
      <div class="cl"></div>
       <?php $hedtitle = "Shipping Management";  ?>
      <div class="internal-box">
        <?=$adm->alert()?>
        <div class="title">
          <? //$adm->heading('Add/Update Shipping')?>
		   <h2><?=$cms->breadcrumbs()?></h2>
        </div>
        <div class="tbl-contant">
          <?php include("manage.php"); ?>
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