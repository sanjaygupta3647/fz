<?php include("../../lib/opin.inc.php");
if($_GET[city_id])
{?>
     <select name="market_id"   class="txt medium" id="market_id"  lang="R" title="Market"> 
	  <option value="">--------------Select------------</option>
      <? $rsAdmin=$cms->db_query("select pid,market_name from #_market where city_id='".$_GET[city_id]."'");
	  if(mysql_num_rows($rsAdmin)){
	  while($arrAdmin=$cms->db_fetch_array($rsAdmin))
	  	{@extract($arrAdmin);	?>
	      <option value="<?=$pid?>"><?=$market_name?></option> <?  
		}
		}
	   ?>
 	  </select>
 	  <?	
}


?>

