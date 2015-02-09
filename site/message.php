<?php
 
$metaTitle = "Fizzkart Message";
$metaIntro = $_SESSION[mess_registration];
$metaKeyword = "Fizzkart Message,Fizzkart, Message";
?>
<div class="contentarea"> 
  <div class="registerarea">
    <div class="heading">Fizzkart Message:</div>
    <div class="subarea">
    <div style="min-height:300px;">
        <div class="alert-box error" style="display:none;"><span>error: </span>Write your error message here.</div>
		<?php if($_REQUEST['AuthDesc']){ ?>
				<?=$_REQUEST['AuthDesc']?>
		<?php }else{?>
        <div class="alert-box success"><span>Congratulation </span> <br/> <?=$_SESSION[mess_registration]?> <br/> Click <a href="<?=SITE_PATH?>Step-1">here</a> to register new account.</div>
		<?php }?>
        <div class="alert-box warning" style="display:none;"><span>warning: </span>Write your warning message here.</div>
        <div class="alert-box notice" style="display:none;"><span>notice: </span>Write your notice message here.</div>
        </div>

    </div>
  </div>
</div>
