<?php include("../../lib/opin.inc.php");
if($_GET[sub_cat_id])
{  
?><span id="sub-cat-pro-backup" style="margin-left:50px">
<a target="_blank" href="http://fizzkart.com/ms_file/xls?store_user_id=<?=$_SESSION[uid]?>&cat_id=<?=$_GET[sub_cat_id]?>" > Download backup of <?=$cms->getSingleresult("select name from #_category where pid='".$_GET[sub_cat_id]."'")?> product(s) </a></span>
<?php }?>


