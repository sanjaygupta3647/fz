 <label>Market</label>
 <?php
$cityId = $cms->getSingleresult("select pid from #_city where city='".$items[2]."'");
$rsAdmin=$cms->db_query("select pid,market_name from #_market where city_id='".$cityId."'");
if(mysql_num_rows($rsAdmin)){?>
	<select   lang="R" title="MARKET"  id="MARKET" name="market_id"><?php
	while($arrAdmin=$cms->db_fetch_array($rsAdmin))
	{@extract($arrAdmin);	?>
	<option value="<?=$pid?>" ><?=$market_name?></option> <?  
	}?></select><?php
}else{
?> <input type="text" name="market" lang="R" title="Market" value="<?=$_POST[market]?>"><?php
}
?>
 
                                
							  
								 
							  