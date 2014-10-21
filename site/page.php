<?php
$metaTitle = $cms->getSingleresult("select meta_title from #_pages where url='".$items[1]."'");
$metaIntro = $cms->getSingleresult("select meta_description from #_pages where url='".$items[1]."'");
$metaKeyword = $cms->getSingleresult("select meta_keyword from #_pages where url='".$items[1]."'");

?>
<table width="100%" border="0" class="brdr" style=" padding:20px; background-color:#f3f3f3;">
  <tr>
    <td><h2><?=$cms->getSingleresult("select heading from #_pages where url='".$items[1]."' and store_user_id = '0'")?> </h2></td>
  </tr>
  <tr>
    <td style="text-align:justify"><?=$cms->getSingleresult("select body from #_pages where url='".$items[1]."' and store_user_id = '0'")?></td>
  </tr>
</table>
<div style="width:994px; height:10px;"></div>