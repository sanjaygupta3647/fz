<?php include("../../lib/opin.inc.php");
if($_GET[country_id])
{?>
      <select name="city_id" class="select" lang="R" title="City"> 
      <? $rsAdmin=$cms->db_query("select pid,city from #_city where country_id='".$_GET[country_id]."'");
	  if(mysql_num_rows($rsAdmin)){
	  while($arrAdmin=$cms->db_fetch_array($rsAdmin))
	  	{@extract($arrAdmin);	?>
	      <option value="<?=$pid?>"><?=$city?></option> <?  
		}
		}
	   ?>
	  </select><?	
}


?>

