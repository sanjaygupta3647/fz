<?php

$metaTitle = $cms->getSingleresult("select meta_title from #_meta_info where url='".$items[1]."' and store_user_id = '$current_store_user_id'");
$metaIntro = $cms->getSingleresult("select meta_description from #_meta_info where url='".$items[1]."' and store_user_id = '$current_store_user_id'");
$metaKeyword = $cms->getSingleresult("select meta_keyword from #_meta_info where url='".$items[1]."' and store_user_id = '$current_store_user_id'");

?>
 
<div class="main_classof_innerpg">
<table width="100%" border="0" class="brdr" style=" padding:20px;  background-color:#f3f3f3;" align="center">
  <tr>
  <?php
  $heading = $cms->getSingleresult("select heading from #_pages where url='".$items[1]."' and store_user_id = '$current_store_user_id'");
  if(!$heading) $heading = str_replace('-', " ", $items[1]);
  ?>
    <td><h2><?=ucfirst($heading)?> </h2></td>
  </tr>
  <tr>
  	<?php 
	$content = $cms->getSingleresult("select body from #_pages where url='".$items[1]."' and store_user_id = '$current_store_user_id'");
	if(!$content) $content = "Coming soon...";
	?>
    <td style="text-align:justify"><?=$content?></td>
  </tr>
</table>
</div>
<div style="width:994px; height:10px;"></div>