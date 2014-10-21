<?php
$metaTitle = $cms->getSingleresult("select meta_title from #_pages where url='".$items[1]."'");
$metaIntro = $cms->getSingleresult("select meta_description from #_pages where url='".$items[1]."'");
$metaKeyword = $cms->getSingleresult("select meta_keyword from #_pages where url='".$items[1]."'");

?>

<table width="100%" border="0" style="margin-bottom:20ox; margin-top:20px; margin-left:10px;">
  <tr>
    <td><h2>Store Profile</h2></td>
  </tr>
  <tr>
    <td><?=$cms->getSingleresult("select body from #_store_profile where store_id='".$_SESSION[store_id]."'")?></td>
  </tr>
</table>
