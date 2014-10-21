<?php include("../../lib/opin.inc.php"); ?>
<?php define("CPAGE","gallery/")?>
<?php include("../inc/header.inc.php");?>
 <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css" />
  <script src="http://code.jquery.com/jquery-1.8.2.js"></script> 
  <script src="http://code.jquery.com/ui/1.9.1/jquery-ui.js"></script> 
  <script>
    $(function() {
        $( "#invdate1" ).datepicker({ dateFormat: 'yy-mm-dd' }).val();
    });
    $(function() {
        $( "#invdate2" ).datepicker({ dateFormat: 'yy-mm-dd' }).val();
    });
    </script>
<div class="main">
<header>
      
      <div class="hrd-right-wrap">
        <?php /*?><nav>
          <ul>
            <li> <a href="">Home</a> </li>
            <li> <a href="">Products</a> </li>
            <li> <a href="">Category</a> </li>
            <li> <a href="">Setting</a> </li>
            <li> <a href="">System</a> </li>
          </ul>
        </nav><?php */?>
       
        <div class="brdcm" id="hed-tit">Banner</div>
        <div class="unvrl-btn">
        <?php /*?><a href="<?=SITE_PATH_ADM.CPAGE.'?mode=add&catid='.$catid?>" class="ub">
        <img onclick="location.href=" src="<?=SITE_PATH_ADM?>images/add-new.png" alt=""></a>
        <a href="javascript:void(0)" class="ub"   onclick="javascript:submitions('delete');">
        <img src="<?=SITE_PATH_ADM?>images/delete.png" alt=""></a><?php */?>
       <?php /*?> <a href="#" class="ub">
        <img src="<?=SITE_PATH_ADM?>images/cancel.png" alt=""></a>
        <a href="#" class="ub">
        <img src="<?=SITE_PATH_ADM?>images/active.png" alt=""></a>
        <a href="#" class="ub">
        <img src="<?=SITE_PATH_ADM?>images/inactive.png" alt=""></a>
        <a href="#" class="ub">
        <img src="<?=SITE_PATH_ADM?>images/restore.png" alt=""></a><?php */?>
         <?php if($_GET[id]){?>
        <a href="<?=SITE_PATH_ADM.CPAGE?>" class="ub">
        <img src="<?=SITE_PATH_ADM?>images/back.png" alt=""></a><?php }?>
        
        
        </div> 
      </div>
      <div class="cl"></div>
    </header><div class="content">
<div class="div-tbl">
<div class="cl"></div>
	<? //$adm->h1_tag('Dashboard &rsaquo; Email Alerts Manager',((!$mode)?$others:$others2))?>
<?php $hedtitle = "Order Management"; ?>  
    <?=$adm->alert()?>
      <div class="title" id="innertit">
       <?=$adm->heading('Order Manager')?>
        </div>
        <? if($mode== 'detail') $file = "detail.php";  else  $file = "cart.php"; ?>
      <div class="tbl-contant"><?php  include($file);?></div>
	  <?php include("../inc/paging.inc.php")?></div>
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
