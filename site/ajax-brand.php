<? if($items[2])
{?>
       <? $rsAdmin=$cms->db_query("SELECT  name,pid from #_brand where cat_id='".$items[2]."' group by name");
	  if(mysql_num_rows($rsAdmin)){
	  while($arrAdmin=$cms->db_fetch_array($rsAdmin))
	  	{@extract($arrAdmin);	
		$link = SITE_PATH."brand-product/".$adm->baseurl($name)."/".$pid."/";
		?>
	      <div class="city_link_v"><a href="<?=$link?>"><?=$name?></a></div> <?  
		}
		}
		else echo"<p style='color:red; text-align:center'>No Brand Available for <br/>current category</p>";
	   
}
	 
?>

