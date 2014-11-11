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
	<div class="unvrl-btn" style="width: 147px;"> 
	 
	 <?php if(!$_GET[mode]){?>
	 <a target="_blank" href="http://fizzkart.com/ms_file/member-xls?store_user_id=<?=$_SESSION[uid]?>" >
		 <img width="32" src="<?=SITE_PATH_MEM?>images/xls.jpg" alt=""> </a> &nbsp;
	 <a href="#" onclick="PrintDiv();" class="ub">
        <img src="<?=SITE_PATH_MEM?>images/print.jpg" alt=""> </a>
	    <? }?>
   <?php if($_GET[mode]){?>
	<a href="javascript:void(0)" onclick="javascript:formback();" class="ub">
	<img src="<?=SITE_PATH_MEM?>images/back.png" alt=""></a><?php }?>
	
	</div> 
  </div>
  <div class="cl"></div>
</header> 
<div class="content">
<div class="div-tbl">
<div class="cl"></div>
<?php $hedtitle = "Store Members"; ?>  
	<? //$adm->h1_tag('Dashboard &rsaquo; Email Alerts Manager',((!$mode)?$others:$others2))?>

    <?=$adm->alert()?>
      <div class="title"  id="innertit">
           <? //$adm->heading(((!$mode)?'Store Members':'Add/Update User'))?>
		   <h2 class="bradcrumb"><?php
		if($mode=='add' && $id!=''){?>
			<a href="/member" rel="v:url" property="v:title">Home</a> »
			<a href="/member/users" rel="v:url" property="v:title">Users</a> » 
			<a href="/users/?mode=add&amp;start=&amp;id=<?=$id?>" rel="v:url" property="v:title">View</a>  
		<?php		
		}else if($mode=='add' && $id=='') { 
		    ?>
			<a href="/member" rel="v:url" property="v:title">Home</a> »
			<a href="/member/users" rel="v:url" property="v:title">Users</a> » 
			<a href="/member/users/?mode=add" rel="v:url" property="v:title">Add</a>  
		<?php
		}else{?>
		    <a href="/member" rel="v:url" property="v:title">Home</a> »
			<a href="/member/users" rel="v:url" property="v:title">Users </a> »  
		<?php 
		}
		?>
	  </h2>
        </div>
      <div class="tbl-contant" id="divToPrint"><?php if($mode){include("add.php");}else{include("manage.php");}?></div>
       <div class="cl"></div>
    </div>
  </div> 
<?php include("../inc/footer.inc.php")?></div>
</div>
<div class="cl"></div>
</div>
</div>

<script type="text/javascript">
 function PrintDiv() {    
           var divToPrint = document.getElementById('divToPrint');
           var popupWin = window.open('', '_blank', 'width=500,height=600');
           popupWin.document.open();
           popupWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</html>');
           popupWin.document.close();
           }
</script>
</body>
</html>
