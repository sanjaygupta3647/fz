<?php include("../../lib/opin.inc.php")?>
<?php define("CPAGE","news/")?>
<?php include("../inc/header.inc.php")?>
<div id="container">
<div class="container">
<?=$adm->h1_tag('Dashboard &rsaquo; Service Manager',((!$mode)?$others:$others2))?>

<div class="internal-box"><?=$adm->alert()?>
      <div class="title">
        <?=$adm->heading(((!$mode)?'Service Manager':'Add/Update Service'))?>
        </div>
      <?php if($mode){include("add.php");}else{include("manage.php");}?>
      <div class="internal-rnd-footer"></div>
    </div>
  </div>
</div>
</div>
<?php include("../inc/footer.inc.php")?>