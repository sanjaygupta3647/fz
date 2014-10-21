<?php include("../../lib/opin.inc.php")?>
<?php include("../inc/header.inc.php")?>
<div id="container">
<div class="container">
<?php 
if($view and $subpageid){
$others ='<table border="0" align="right" cellpadding="0" cellspacing="0">
  <tr>
   <td  align="center" valign="bottom" onclick="javascript:formback();"><span class="back"></span></td>
    <td align="center" valign="bottom" onclick="javascript:submitions(\'Inactive\');"><span class="unpublish"></span></td>
    <td  align="center" valign="bottom" onclick="javascript:submitions(\'Active\');"><span class="publish"></span></td>
    <td align="center" valign="bottom" onclick="javascript:submitions(\'delete\');"><span class="delete"></span></td>
	<td align="center" valign="bottom" onclick="location.href=\''.SITE_PATH_ADM.CPAGE.'?mode=add&subpageid='.$subpageid.'\'"><span class="new"></span></td>
  </tr>
  <tr>
    <td align="center" valign="bottom" class="buts">Back</td>
	<td align="center" valign="bottom" class="buts">Unpublish</td>
    <td align="center" valign="bottom" class="buts">Publish</td>
    <td align="center" valign="bottom" class="buts">Delete</td>
	 <td align="center" valign="bottom" class="buts">New</td>
  </tr>
</table>';
}else{
	$others ='<table border="0" align="right" cellpadding="0" cellspacing="0">
  <tr>
   <td align="center" valign="bottom" onclick="location.href=\''.SITE_PATH_ADM.CPAGE.'?mode=add&subpageid='.$subpageid.'\'"><span class="new"></span></td>
  </tr>
  <tr>
	 <td align="center" valign="bottom" class="buts">New</td>
  </tr>
</table>';
}
?>
<?=$adm->h1_tag('Dashboard &rsaquo; CMS Manager',((!$mode)?$others:$others2))?>

<div class="internal-box"><?=$adm->alert()?>
      <div class="title">
	  <?php if(!$mode):?>
       <div class="right-links"><a href="<?=SITE_PATH_ADM.CPAGE?>"<?=((!$mode)?'class="active"':'')?>>Manage</a><a href="<?=SITE_PATH_ADM.CPAGE?>?mode=add<?=(($subpageid)?'&subpageid='.$subpageid:'')?>" <?=(($mode)?'class="active"':'')?>>&nbsp;&nbsp;Add&nbsp;&nbsp;</a></div>
		<?php endif;?>
        <?=$adm->heading(((!$mode)?'CMS Manager'.(($_GET[subpageid])?' -> '.$cms->getSingleresult("select heading from #_pages where `pid` = '".$_GET[subpageid]."'"):''):'Add/Update CMS'))?>
        </div>
      <?php if($mode){include("add.php");}else{include("manage.php");}?>
      <div class="internal-rnd-footer"></div>
    </div>
  </div>
</div>
</div>
<?php include("../inc/footer.inc.php")?>