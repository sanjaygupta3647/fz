<?php include("../../lib/opin.inc.php")?>
<?php define("CPAGE","gallery/")?>
<?php include("../inc/header.inc.php");?>
<div class="main">
<header>
     
      <div class="hrd-right-wrap">
        <?php /*?><nav>
          <ul>
            <li> <a href="<?=SITE_PATH_MEM?>"></a> </li>
            <li> <a href="<?=SITE_PATH_MEM?>catalog/collections.php">Products</a> </li>
            <li> <a href="<?=SITE_PATH_MEM?>catalog/manage-category.php">Category</a> </li>
            <li> <a href="<?=SITE_PATH_MEM?>setting.php?mode=true">Setting</a> </li>
           <!-- <li> <a href="">System</a> </li>-->
          </ul>
        </nav><?php */?>
        
        <div class="brdcm" id="hed-tit">Banner</div>
          
      </div>
      <div class="cl"></div>
    </header>
<div class="content">
<div class="div-tbl">
<div class="cl"></div>
	<? //$adm->h1_tag('Dashboard &rsaquo; Email Alerts Manager',((!$mode)?$others:$others2))?>
<?php $hedtitle = "About Store Management"; ?>  
      <?=$adm->alert()?>
      <div class="title"  id="innertit">
       <? //$adm->heading(((!$mode)?'About':' Content'))?>
	    <h2 class="bradcrumb"><?php
		if($mode=='add' && $id!=''){?>
			<a href="/member" rel="v:url" property="v:title">Home</a> »
			<a href="/member/profile" rel="v:url" property="v:title">Profile</a> » 
			<a href="/profile/?mode=add&amp;start=&amp;id=<?=$id?>" rel="v:url" property="v:title">Edit</a>  
		<?php		
		}else if($mode=='add' && $id=='') { 
		    ?>
			<a href="/member" rel="v:url" property="v:title">Home</a> »
			<a href="/member/profile" rel="v:url" property="v:title">Profile </a> » 
			<a href="/member/profile/?mode=add" rel="v:url" property="v:title">Add</a>  
		<?php
		}else{?>
		    <a href="/member" rel="v:url" property="v:title">Home</a> »
			<a href="/member/profile" rel="v:url" property="v:title">Profile </a> »  
		<?php 
		}
		?>
	  </h2>
        </div>
      <div class="tbl-contant"><?php include("add.php"); ?></div>
       <div class="cl"></div>
    </div>
  </div> 
<?php include("../inc/footer.inc.php")?></div>
</div>
<div class="cl"></div>
</div>
</div>
 
</body>
</html>
