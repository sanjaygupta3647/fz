<tr>
  <td align="left" valign="top">&nbsp;</td>
  <td align="center" valign="middle" bgcolor="#F2F2F2" class="enq_text_fild">All Brands </td>
  <td align="left" valign="top">&nbsp;</td>
</tr>
<tr>
  <td align="left" valign="top">&nbsp;</td>
  <td align="left" valign="top">
   <div id="slider12" class="slider-horizontal" align="left">
	<?php 		  
	$brand="select pid,name,image from #_brand where status	='Active'";
	$brandEx = $cms->db_query($brand);
	while($res12=$cms->db_fetch_array($brandEx)){
	$img = SITE_PATH."uploaded_files/orginal/no-img.gif";
	if(file_exists(UP_FILES_FS_PATH.'/orginal/'.$res12['image']) && $res12['image']!="")
	{
		$img = SITE_PATH."uploaded_files/orginal/".$res12['image'];
	}

	?>
      <div class="item item-1">
	  <a href="<?=SITE_PATH?>brand/<?=$adm->baseurl($res12[name])?>/<?php echo $res12['pid'];?>">
	  <img src="<?=$img?>" width="118" height="88" border="0" />
	  </a></div> 
	  <? }?>
    </div></td>
  <td align="left" valign="top">&nbsp;</td>
</tr>
