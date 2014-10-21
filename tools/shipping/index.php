<?php include("../../lib/opin.inc.php")?> 
<?php define("CPAGE","gallery/")?>
<?php include("../inc/header.inc.php");?>
<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php 
 
if($cms->is_post_back()){  
            
			 @$cms->db_query(" delete from #_shipping ");
			foreach($_POST[ranges] as $key=>$val)
			{
				$qry = "";
				  $qry = " insert into #_shipping set ranges='".$_POST[ranges][$key]."', rangee='".$_POST[rangee][$key]."' , 
				ship='".$_POST[ship][$key]."'";
			    $cms->db_query($qry);
					$adm->sessset('Record has been updated', 's');
			}  
		 
	}  
	$rsAdmin=$cms->db_query("select * from #_shipping"); 
	while($arrAdmin=$cms->db_fetch_array($rsAdmin))
	{
		 @extract($arrAdmin); 
		 $ranges1[]=$ranges;
		 $rangee1[]=$rangee;
		 $ship1[]=$ship; 
		 $i++;
	} 
	 
?>
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
        
        <div class="brdcm" id="hed-tit">Shipping Management</div>
        <div class="unvrl-btn">
      <!--  <a href="<?=SITE_PATH_ADM.CPAGE.'?mode=add&catid='.$catid?>" class="ub">
        <img onclick="location.href=" src="<?=SITE_PATH_ADM?>images/add-new.png" alt=""></a>
        <a href="javascript:void(0)" class="ub"   onclick="javascript:submitions('delete');">
        <img src="<?=SITE_PATH_ADM?>images/delete.png" alt=""></a>-->
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
    </header> <div class="cl"></div>
<div class="content">
<div class="div-tbl">
<div class="cl"></div>
<? //$adm->h1_tag('Dashboard &rsaquo; Banner '.(($catid)?'':'Banner').' Manager',((!$mode)?$others:$others2))?>
<?php $hedtitle = "Shipping Management"; ?>
      <div class="internal-box"><?=$adm->alert()?>
      <div class="title">
        <?=$adm->heading(((!$mode)?''.(($catid)?'':'Shipping').' Manager':'Add/Update Shipping '.(($catid)?'':'Album')))?>
        </div>
       <div class="tbl-contant"><?php if($mode){include("add.php");}else{include("manage.php");}?> </div>
    </div>
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
