<?php include("../../lib/opin.inc.php");
if($_GET[cat_id])
{?>
      <select name="cat_id" class="txt medium" id="sub_cat_id" lang="R" title="Category">
	  <option value="">--- Select Sub Category ---</option>
      <? $rsAdmin=$cms->db_query("select pid,name from #_category where parentId='".$_GET[cat_id]."'");
	  if(mysql_num_rows($rsAdmin)){
	  while($arrAdmin=$cms->db_fetch_array($rsAdmin))
	  	{@extract($arrAdmin);	?>
	      <option value="<?=$pid?>"><?=$name?></option> <?  
		}
		}
		else{
		?><option value="<?=$_GET[cat_id]?>"><?=$cms->getSingleresult("SELECT name  FROM #_category WHERE pid = '".$_GET[cat_id]."' ")?></option><?php
		}
	   ?>
	  </select><?	
}


?><span id="sub-cat-pro-backup" style="margin-left:50px">
<a target="_blank" href="http://fizzkart.com/ms_file/xls?store_user_id=<?=$_SESSION[uid]?>&cat_id=<?=$_GET[cat_id]?>" > Download backup of <?=$cms->getSingleresult("select name from #_category where pid='".$_GET[cat_id]."'")?> product(s) </a></span>

