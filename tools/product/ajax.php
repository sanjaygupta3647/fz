<?php include("../../lib/opin.inc.php");
if($_GET[cat_id])
{?>
      <select name="cat_id" class="txt medium" id="cat_id" lang="R" title="Category">
	  
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


?>

