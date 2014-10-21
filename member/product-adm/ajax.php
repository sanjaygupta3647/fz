<?php include("../../lib/opin.inc.php");
if($_GET[cat_id])
{?>
      <select name="brand_id" class="select" lang="R" title="Brand"> 
      <? $rsAdmin=$cms->db_query("select pid,name,cat_id from #_brand where cat_id='".$_GET[cat_id]."'");
	  if(mysql_num_rows($rsAdmin)){
	  while($arrAdmin=$cms->db_fetch_array($rsAdmin))
	  	{@extract($arrAdmin);	?>
	      <option value="<?=$pid?>"><?=$name?></option> <?  
		}
		}
	   ?>
	  </select><?	
}


?>

