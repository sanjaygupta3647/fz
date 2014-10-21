<?php
 
$metaTitle = $cms->getSingleresult("select metaTitle from #_updates where url='".$items[1]."'");
$metaIntro = $cms->getSingleresult("select metaDesc from #_updates where url='".$items[1]."'");
$metaKeyword = $cms->getSingleresult("select metaKey from #_updates where url='".$items[1]."'"); 
?> 
<div class="updates_title_h3">
<div class="updates_title_h3_title">
<h3 style="margin-top:10px;margin-bottom:10px;">Fizzkart Updates </h3>

</div>
<div id="tabs">
			<?php
			$selectTab = 0;
			$updateQry=$cms->db_query("SELECT subtitle,title,url,body  FROM #_updates where store_user_id='0'  and status = 'Active' order by pid desc"); 
			if(mysql_num_rows($updateQry)){
				$i = 1;
				while($r=$cms->db_fetch_array($updateQry)){ extract($r);
						if($items[1]==$url) $selectTab = $i-1;
						$p1 .= '<li><a href="#tabs-'.$i.'">'.$subtitle.'</a></li>';
						$p2 .= '<div id="tabs-'.$i.'">
									<h2>'.$title.'</h2>	'.$body.' 
								</div>';
				$i++;
				}
			}
	?>
  			<ul> 
  				<?=$p1?> 
  			</ul>
  			<?=$p2?> 
  	</div>
</div>
 
<div style="width:994px; height:10px;"></div>