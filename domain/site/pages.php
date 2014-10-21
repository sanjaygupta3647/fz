<?php
$metaTitle = $cms->getSingleresult("select meta_title from #_pages where url='".$items[1]."'");
$metaIntro = $cms->getSingleresult("select meta_description from #_pages where url='".$items[1]."'");
$metaKeyword = $cms->getSingleresult("select meta_keyword from #_pages where url='".$items[1]."'");

?>

<table width="100%" border="0" class="brdr" style=" padding:20px; background-color:#f3f3f3;">
  <tr>
    <td><h2>Lorem Ipsum </h2></td>
  </tr>
  <tr>
    <td><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></td>
  </tr>
</table>
<div style="width:994px; height:10px;"></div>