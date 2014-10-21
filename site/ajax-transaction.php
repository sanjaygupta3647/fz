<div class="detail_of-this_id">
  <?php   
		$rsAdmin2=$cms->db_query("select * from #_members where pid='".$_SESSION[userid]."'");
		$result=$cms->db_fetch_array($rsAdmin2);
		extract($result);
 
     	if($_GET[orderid]){
	 ?>
  <table width="100%" border="0" cellspacing="1" cellpadding="3" class="trans-text_style">
    <?php 
	   $check=$cms->db_query("select * from #_orders_detail where  orderid = '".$_GET[orderid]."' ");
	   if(mysql_num_rows($check)){?>
    <tr>
      <td colspan="4" align="left" valign="top"><h2>Shopping detail of transaction id
          <?=$_GET[orderid]; $s_id=$cms->getSingleresult("select store_id from #_orders_detail where orderid = '".$_GET[orderid]."'");?>&nbsp;&nbsp;And Sotre name:&nbsp;&nbsp;<?=$cms->getSingleresult("select name from #_store_user where 
						pid='".$s_id."' ")?>
        </h2></td>
    </tr>
    <tr>
     <!-- <th width="25%" height="30" align="center" valign="middle" bgcolor="#FFEBD7">Image</th> -->
	  <th width="25%" height="30" align="center" valign="middle" bgcolor="#FFEBD7">Store Name</th> 
      <th width="25%" height="30" align="center" valign="middle" bgcolor="#FFEBD7">Product</th>
      <th width="25%" height="30" align="center" valign="middle" bgcolor="#FFEBD7">Quantity</th>
      <th width="25%" height="30" align="center" valign="middle" bgcolor="#FFEBD7">Amount</th>
    </tr>
    <?php
		$total  = 0;
		while($res2 = $cms->db_fetch_array($check))
						{
						extract($res2);
						$total = $total+($qty*$amount);
						$img = $cms->getSingleresult("select image1 from #_products_user where pid='".$proid."' ");
					    $imgpro  ="uploaded_files/orginal/no-img.gif";
					if(file_exists('uploaded_files/orginal/'.$img) && $img!="")
						{
							$imgpro  ="uploaded_files/orginal/".$img;
						}
						 
						?>
						 
    <tr>
    <!--  <td width="25%" align="center" valign="middle" bgcolor="#F3F3F3" class="image_pad"><img src="<?=SITE_PATH.$imgpro?>" width="147" height="100"  alt=""/></td> -->
     <td width="25%" align="center" valign="middle" bgcolor="#F3F3F3"> <?=$cms->getSingleresult("select name from #_store_user where 
						pid='".$store_id."' ")?></td>
	  <td width="25%" align="center" valign="middle" bgcolor="#F3F3F3"><a href="<?=($urls)?$urls:'#'?>" target="_blank">
        <?=$cms->getSingleresult("select title from #_products_user where 
						pid='".$proid."' ")?>
        </a></td>
      <td width="25%" align="center" valign="middle" bgcolor="#F3F3F3"><?=$qty?></td>
      <td width="25%" align="center" valign="middle" bgcolor="#F3F3F3"><?=$cms->price_format($qty*$amount)?>
        <?php if($qty>1)echo " ($qty * $amount)"; ?></td>
    </tr>
    <tr>
      <td colspan="5">&nbsp;</td>
    </tr>
    <?php
						}
						$_SESSION['total'] = $total;
						$link  = SITE_PATH."".$items[0];
						} 
						?>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;&nbsp;&nbsp;<strong>Total: </strong>
        <?=$cms->price_format($total)?>
      </td>
    </tr>
  </table>
  <?php }?>
</div>
<div class="ship_detail_of-this_id">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <th align="left" valign="top" bgcolor="#f3f3f3"><h2>Personal and Contact details of your account are given below :</h2></th>
    </tr>
    <tr>
      <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="left" valign="top"><table width="100%" border="0" cellspacing="5" cellpadding="5" class="details_text">
                <tr bgcolor="#FFF8F0">
                  <td width="20%" align="left" valign="top"><b>Name :</b></td>
                  <td width="80%" align="left" valign="top"><?=$fname?></td>
                </tr>
              </table></td>
          </tr>
          <tr bgcolor="#FFFFFF">
            <td align="left" valign="top"><table width="100%" border="0" cellspacing="5" cellpadding="5" class="details_text">
                <tr bgcolor="#FFFFFF">
                  <td width="20%" align="left" valign="top"><b>Email :</b></td>
                  <td width="80%" align="left" valign="top"><?=$email?></td>
                </tr>
                <tr bgcolor="#FFF8F0">
                  <td width="20%" align="left" valign="top"><b>Gender :</b></td>
                  <td width="80%" align="left" valign="top"><?=$gender?></td>
                </tr>
                <tr bgcolor="#FFFFFF">
                  <td width="20%" align="left" valign="top"><b>Mobile :</b></td>
                  <td width="80%" align="left" valign="top"><?=$mob?></td>
                </tr>
                <tr bgcolor="#FFF8F0">
                  <td width="20%" align="left" valign="top"><b>City :</b></td>
                  <td width="80%" align="left" valign="top"><?=$city?></td>
                </tr>
                <tr bgcolor="#FFFFFF">
                  <td width="20%" align="left" valign="top"><b>State :</b></td>
                  <td width="80%" align="left" valign="top"><?=$state?></td>
                </tr>
                <tr bgcolor="#FFF8F0">
                  <td align="left" valign="top"><b>Zip code :</b></td>
                  <td align="left" valign="top"><?=$zipcode?></td>
                </tr>
                <tr bgcolor="#FFFFFF">
                  <td width="20%" align="left" valign="top"><b>Address :</b></td>
                  <td width="80%" align="left" valign="top"><textarea rows="5" cols="4" name="textarea" id="textarea" disabled><?=$address?>
</textarea></td>
                </tr>
              </table></td>
          </tr>
        </table></td>
    </tr>
  </table>
</div>
