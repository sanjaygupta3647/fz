<?php include("../../lib/opin.inc.php")?>
<?php define("CPAGE","gallery/")?>
<?php include("../inc/header.inc.php");?>
<?php $adm->pageAuth("SMS Template",$perm);?>
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
         <nav style="margin-top:10px;">
          <ul>
             
			<li style="margin:10px;"><input type="text" id="sms_pack" placeholder="Search By sms pack Name" name="sms_pack" value="<?=$_GET[sms_pack1]?>"></li> 
			<li style="margin:10px;"><input type="text" id="amount" placeholder="Search By Amount" name="amount" value="<?=$_GET[amount]?>"></li>
			<li style="margin:10px;">
				<select name="status" id="status" class="txt medium" >
				   <option value="">--Search By Status--</option>
				  <option value="Active" <?=(($status=='Active')?'selected="selected"':'')?>>Active</option>
				  <option value="Inactive" <?=(($status=='Inactive')?'selected="selected"':'')?>>Inactive</option>
				  <option value="Block" <?=(($status=='Block')?'selected="selected"':'')?>>Block</option>
			  </select>
			</li>
			<li style="margin:10px;"><input id="search"   type="button" name="search" value="search"></li>
          </ul>
        </nav> 
        <?php }?>
        <div class="brdcm" id="hed-tit">Coupon</div>
        <div class="unvrl-btn"> 
        <a href="<?=SITE_PATH_ADM.CPAGE.'/?mode=add'?>" class="ub">
        <img  src="<?=SITE_PATH_ADM?>images/add-new.png" alt=""></a>
         <?php if(!$_GET[mode]){?>
          <a href="javascript:void(0)"  onclick="javascript:submitions('Active');"class="ub">
        <img src="<?=SITE_PATH_ADM?>images/active.png" alt=""></a>
        <a href="javascript:void(0)" onClick="javascript:submitions('Inactive');" class="ub">
        <img src="<?=SITE_PATH_ADM?>images/inactive.png" alt=""></a>

		<a href="javascript:void(0)" onClick="javascript:submitions('Block');" class="ub">
        <img src="<?=SITE_PATH_ADM?>images/block.png" alt=""></a>

        <a href="javascript:void(0)" class="ub"   onclick="javascript:submitions('delete');">
        <img src="<?=SITE_PATH_ADM?>images/delete.png" alt=""></a> <? }?>
       <?php if($_GET[mode]){?>
        <a href="javascript:void(0)" onclick="javascript:formback();" class="ub">
        <img src="<?=SITE_PATH_ADM?>images/back.png" alt=""></a><?php }?>
        
        </div> 
      </div>
      <div class="cl"></div>
    </header> 
<div class="content">
<div class="div-tbl">
<div class="cl"></div>
	<? //$adm->h1_tag('Dashboard &rsaquo; Email Alerts Manager',((!$mode)?$others:$others2))?>
<?php $hedtitle = "Coupon Manager"; ?>  
    <?=$adm->alert()?>
      <div class="title"  id="innertit">
        <h2><?=$cms->breadcrumbs()?></h2>
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
$("#search").click(function(){
var sms_pack = $("#sms_pack").val();
var amount =$("#amount").val();
var status =$("#status").val(); 
var ur = '?search=1';
if(sms_pack){
	 ur +="&sms_pack="+sms_pack; 
	}
if(amount){
	 ur +="&amount="+trim(amount); 
	}
if(status){
 	 ur +="&status="+status; 
	} 
   var red = "<?=SITE_PATH_ADM.CPAGE?>"+ur;
   window.location = red;
});
 
</script>
</body>
</html>
