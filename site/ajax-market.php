 <?php
$cityid = $cms->getSingleresult("select pid from #_city where city = '".$items[2]."'");
$rsAdmin=$cms->db_query("select pid,market_name from #_market where city_id='".$cityid."'");
if(mysql_num_rows($rsAdmin)){
while($arrAdmin=$cms->db_fetch_array($rsAdmin))
{@extract($arrAdmin);	?>
<option value="<?=$market_name?>"  ><?=$market_name?></option> <?  
}
}
?>
 
