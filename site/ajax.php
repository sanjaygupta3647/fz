<? if($items[2])
{?>
      <select name="market_id" class="select"> 
      <? $rsAdmin=$cms->db_query("select pid,market_name from #_market where city_id='".$items[2]."'");
	  if(mysql_num_rows($rsAdmin)){
	  while($arrAdmin=$cms->db_fetch_array($rsAdmin))
	  	{@extract($arrAdmin);	?>
	      <option value="<?=$pid?>"><?=$market_name?></option> <?  
		}
		}
	   ?>
	  </select><?	
} 
?>

