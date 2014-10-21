<?php include("../../lib/opin.inc.php");
if($_GET[cat_id]){?> 
      <select name="cat_id" class="txt medium" id="subcate" lang="R" title="Product Sub Category">
	  <option value="">--Select--</option>
      <? $rsAdmin=$cms->db_query("select cat_id, name from #_store_menu where parent='".$_GET[cat_id]."' and store_user_id='".$_SESSION[uid]."' ");
	  if(mysql_num_rows($rsAdmin)){
	  while($arrAdmin=$cms->db_fetch_array($rsAdmin))
	  	{@extract($arrAdmin);	?>
	      <option value="<?=$cat_id?>"><?=$name?></option> <?  
		}
		}
		else{
		?><option value="<?=$_GET[cat_id]?>"><?=$cms->getSingleresult("SELECT name  FROM #_store_menu WHERE cat_id = '".$_GET[cat_id]."' and store_user_id='".$_SESSION[uid]."' ")?></option><?php
		}
	   ?>
	  </select><?php	
}?>

