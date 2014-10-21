<?php include("../../lib/opin.inc.php")?>
<?php define("CPAGE","catalog/");$mode=true?>
<?php include("../inc/header.inc.php");
if(isset($id)){
	$rsAdmin=$cms->db_query("select * from #_products where pid='".$id."'");
	$arrAdmin=$cms->db_fetch_array($rsAdmin);
	@extract($arrAdmin);
}
?>
<div id="container">
  <div class="container">
    <?=$adm->h1_tag('Dashboard &rsaquo; Collection Manager',$others2)?>
    <div class="internal-box">
      <?=$adm->alert()?>
      <div class="title"  id="innertit">
        <?=$adm->heading('View Collection')?>
      </div>
      <div class="internal-data">
        <table width="100%" border="0" align="left" cellpadding="2" cellspacing="1"  class="data-tbl">
        <tr>
            <td class="label">Status: </td>
            <td><?=$status?></td>
          </tr>
          <tr>
            <td valign="top" class="label"><b> Category:</b></td>
            <td valign="top"><?=$cms->getSingleresult("select name from #_cate where pid='".$catid."'"); ?></td>
          </tr>
          <tr>
            <td width="23%" class="label"><b>Collection name:</b></td>
            <td width="77%"><?=$title?></td>
          </tr>
          <?php if($image and $id and is_file($_SERVER['DOCUMENT_ROOT'].SITE_SUB_PATH."uploaded_files/small/".$image)==true){?>
          <tr>
            <td valign="top" class="label"><b>Image</b></td>
            <td valign="top"><img src="<?=SITE_PATH?>uploaded_files/small/<?=$image?>"></td>
          </tr>
          <?php } ?>
          <tr>
            <td valign="top" class="label"><b>Sise &amp; price:</b></td>
            <td valign="top"><table width="400" border="0" cellpadding="0" cellspacing="0" style="border:#F7F7F7 1px solid;">
              <tr>
                <td width="185" align="center" bgcolor="#F7F7F7"><b>Collection Size</b></td>
                <td width="215" align="center"  bgcolor="#F7F7F7"><b>Collection Price</b></td>
</tr>
<?php $dbcat22 = $cms->db_query("select * from #_size where status='Active' order by `name` asc");														
while($dbrow33= $cms->db_fetch_array($dbcat22)){ $pricess = $cms->getSingleresult("select amount from #_price where proid='".$id."' and size='".$dbrow33[pid]."'");
if($pricess){
?>
<tr>
<td align="center"><?=$dbrow33[name]?></td>
                <td align="center"><?=CUR?><?=$cms->getSingleresult("select amount from #_price where proid='".$id."' and size='".$dbrow33[pid]."'");?></td>
                </tr>
               <?php }}  ?>
            </table></td>
          </tr>
          <tr>
            <td valign="top" class="label">&nbsp;</td>
            <td valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td valign="top" class="label"><b>Short Description:</b></td>
            <td valign="top"><?=nl2br($short)?></td>
          </tr>
          <tr>
            <td class="label"><b>Winemaker's Notes:</b></td>
            <td><?=$body1?></td>
          </tr>
          <tr>
            <td class="label"><b>Harvest Notes</b></td>
            <<td><?=$body2?></td>
          </tr>
          <tr>
            <td class="label"><b>Technical Notes</b></td>
            <td><?=$body3?></td>
          </tr>
          <tr>
            <td class="label">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          
        </table>
      </div>
      <div class="internal-rnd-footer"></div>
    </div>
  </div>
</div>
</div>
<?php include("../inc/footer.inc.php")?>
