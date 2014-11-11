<?php include("../../lib/opin.inc.php")?>
<?php define("CPAGE","gallery/")?>
<?php include("../inc/header.inc.php");?>
<div class="main">
<? include "../inc/header2.php"; ?>
<div class="content">
<div class="div-tbl">
<div class="cl"></div>
	<? //$adm->h1_tag('Dashboard &rsaquo; Email Alerts Manager',((!$mode)?$others:$others2))?>
<?php $hedtitle = "Period Offers Manager"; ?>  
    <?=$adm->alert()?>
      <div class="title"  id="innertit">
       <? //=$adm->heading(((!$mode)?'Hot Deal':'Add/Update City'))?>
	    <h2 class="bradcrumb"><?php
		if($mode=='add' && $id!=''){?>
			<a href="/member" rel="v:url" property="v:title">Home</a> »
			<a href="/member/period_offer" rel="v:url" property="v:title">Period offer</a> » 
			<a href="/period_offer/?mode=add&amp;start=&amp;id=<?=$id?>" rel="v:url" property="v:title">Edit</a>  
		<?php		
		}else if($mode=='add' && $id=='') { 
		    ?>
			<a href="/member" rel="v:url" property="v:title">Home</a> »
			<a href="/member/period_offer" rel="v:url" property="v:title">Period offer</a> » 
			<a href="/member/period_offer/?mode=add" rel="v:url" property="v:title">Add</a>  
		<?php
		}else{?>
		    <a href="/member" rel="v:url" property="v:title">Home</a> »
			<a href="/member/period_offer" rel="v:url" property="v:title">Period offer</a> »  
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
<script type="text/javascript">
$(document).ready(function(){
		$(".flat").hide();  
		$(".percent").hide(); 
		$(".amount").hide();   
		$(".numofprod").show(); 
		$(".qty1").hide(); 
		<?php
		if($type=='qty') {?> $(".qty").show(); $(".flat").hide();  <?php }  
		if($type=='flat') {?> $(".flat").show(); $(".qty").hide();  $('.numofprod').hide();$("#qty11").hide();  <?php } ?>
		<?php
		if($discounttype=='amount') {?> $(".amount").show(); $(".percent").hide();$(".qty1").hide(); <?php }  
		if($discounttype=='percent') {?> $(".percent").show(); $(".amount").hide();$(".qty1").hide(); <?php } 
		if($discounttype=='qty1') {?> $(".qty1").show(); $(".amount").hide(); $(".percent").hide(); <?php }?>
		
}); 
$(".DealType").change(function(){
	var type = $(this).val(); 
	if(type=='flat'){
		$(".flat").show();
		$(".qty").hide();  
		$("#qty11").hide(); 
		$(".numofprod").hide();
	}
	if(type=='qty'){ 
		//$(".flat").hide(); 
		//$(".numofprod").hide();
		$("#qty11").show()
		$(".qty").show();  
		$(".numofprod").show(); 
	}
});
$(".DisType").change(function(){
	var type = $(this).val(); 
	if(type=='percent'){
		$(".percent").show();
		$(".amount").hide();
		$(".qty1").hide();
	}
	if(type=='amount'){
		$(".percent").hide();
		$(".amount").show();
		$(".qty1").hide();
	} 
	if(type=='qty1'){
		$(".percent").hide();
		$(".amount").hide();
		$(".qty1").show();
	}
});




</script>
</html>
