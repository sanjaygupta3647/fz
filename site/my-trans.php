<link rel="stylesheet" type="text/css" media="all" href="<?=SITE_PATH?>calender/calendar-blue2.css" title="summer" />
<script type="text/javascript" src="<?=SITE_PATH?>calender/calendar.js"></script>
<script type="text/javascript" src="<?=SITE_PATH?>calender/calendar-en.js"></script>
<script type="text/javascript" src="<?=SITE_PATH?>calender/calendar-setup.js"></script>
<div class="tabdiv_right2 2" >
  <h2>My Transaction</h2>
  <div class="tabdiv_right1_info">
    <?php  
	if($_GET[dayfrom]!=""){  
		$datefrom= date("Y-m-d", strtotime(trim($_GET[dayfrom]))); 
		$datefrom=$datefrom." 00:00:00"; 
		$cond .= " and  submitdate >= '$datefrom'";
	}
	if($_GET[dayto]!=""){ 
		 $dayto= date("Y-m-d", strtotime(trim($_GET[dayto]))); 
		 $dayto=$dayto." 00:00:00"; 
		 $cond .= " and  submitdate <= '$dayto'  ";
 	}
	if($_GET[transid]!=""){  
		 $cond .= " and  orderid = '".$_GET[transid]."'";
 	} 
	include "site/Paging.php";  
	
	$Obj=new Paging(" select * from  fz_order_summary where uid = '".$_SESSION['userid']."' $cond ");
	$Obj->setLimit(3);//set record limit per page
	$limit=$Obj->getLimit();
	$offset=$Obj->getOffset($_REQUEST["page"]);  
	$searchqry = " select * from  fz_order_summary where uid = '".$_SESSION['userid']."' $cond ";
	$sql=" select * from  fz_order_summary where uid = '".$_SESSION['userid']."' $cond  limit $offset, $limit";
	$searchexe = $cms->db_query($sql);
	$count = mysql_num_rows($searchexe);
 	  
	  ?>
    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <th align="left" valign="top" bgcolor="#FFEBD7" class="thead-of_details">Last Visited Store:&nbsp;&nbsp;
          <? $user_store_id1=$cms->getSingleresult("select user_store_id from #_user_log where userid='".$_SESSION['userid']."'");
	 echo $cms->getSingleresult("select name from #_store_user where pid='$user_store_id1'");
	  ?>
        </th>
      </tr>
      <tr >
        <th align="left" valign="top" bgcolor="#FFFFFF"class="trans-text_style"> </th>
      </tr>
      <tr>
        <th align="left" valign="top" bgcolor="#FFEBD7" class="thead-of_details">Details of your transactions are given below :<br />
          &nbsp;&nbsp;&nbsp;&nbsp; 
          <form name="" action="" method="get">
           <div style="float:left; margin:0 20px 0 0;"><span style="float:left;">From :</span>
            <input name="dayfrom" type="text"  id="dayfrom" size="8" readonly class="border04" value="<?=$dt?>" />
            <img src="<?=SITE_PATH?>calender/calendar.gif" name="dateon_button" width="16" height="16" id="dateon_button" title="Date selector" onmouseover="this.style.background='red';" 	onmouseout="this.style.background=''" /></div>
            <script type="text/javascript">
					Calendar.setup(
					{ inputField:"dayfrom",ifFormat:"%y-%m-%d",button:"dateon_button",step:1});
					</script>
            <div style="float:left; margin:0 20px 0 0;"><span style="float:left;">To :</span>
            <input name="dayto" type="text"  id="dayto" size="8" readonly class="border04" value="<?=$dt?>" />
            <img src="<?=SITE_PATH?>calender/calendar.gif" name="dateon_button1" width="16" height="16" id="dateon_button1" title="Date selector" onmouseover="this.style.background='red';" 	onmouseout="this.style.background=''" /></div> </font></span>
            <script type="text/javascript">
					Calendar.setup(
					{ inputField:"dayto",ifFormat:"%y-%m-%d",button:"dateon_button1",step:1});
					</script>
           <div><span style="float:left;">Order Id</span>
            <input type="text" name="transid" size="13" value="" />
            <input name="Submit2" type="submit" value="SEARCH" class="button sproceedbtn"/></div>
          </form></th>
      </tr>
      <td align="left" valign="top"><table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="trans-text_style">
            <thead>
              <tr>
                <th width="25%" height="30" align="center" valign="middle" bgcolor="#FFEBD7">Order id</th>
                <th width="25%" height="30" align="center" valign="middle" bgcolor="#FFEBD7">Amount</th>
                <th width="25%" height="30" align="center" valign="middle" bgcolor="#FFEBD7">Date & Time</th>
                <th width="25%" height="30" align="center" valign="middle" bgcolor="#FFEBD7">Status</th>
              </tr>
            </thead>
            <?php $nums=1;
	 while($res =$cms->db_fetch_array($searchexe)){  ?>
            <tr>
              <td height="30" align="center" valign="middle"><a class="id_control" title="<?=$res[orderid]?>"  alt="<?=$res[orderid]?>"  <? if($_GET[orderid]==$res[orderid]){?> style="color:green; font-size:large; background-color:#0099FF; color:#FFFFFF; padding:2px;" <?php }?>>
                <?=$res[orderid]?>
                </a> </td>
              <td height="30" align="center" valign="middle"><?=$cms->price_format($cms->getSingleresult("select paynet from #_order_summary where orderid='".$res[orderid]."'"))?></td>
              <td height="30" align="center" valign="middle"><? echo $date = date('j F, Y', strtotime($res[submitdate]));?></td>
              <td height="30" align="center" valign="middle"><?=$cms->getSingleresult("select status from #_order_summary where orderid='".$res[orderid]."'")?></td>
            
			</tr>
            <?php  $nums++;}?> 
			<td align="center" colspan="4"><?php if($nums==1){ 
			echo "No Record Found";}?> </td>
            <td align="center">
              </td>
			  <tr><td colspan="4"><?php $Obj->getPageNo(); ?></td></tr>
          </table>
         </td>
      </tr>
    </table>
    <?php
	if($_GET[orderid]){?>
    <div class="detail_of-this_id_main_div" id="show_detail" >
      <!--     Ajax Part  -->
      <table width="100%" border="0" cellspacing="1" cellpadding="3" class="trans-text_style">
        <?php 
	   $check=$cms->db_query("select * from #_orders_detail where  orderid = '".$_GET[orderid]."' ");
		if(mysql_num_rows($check)){?>
        <tr>
          <td colspan="4" align="left" valign="top"><h2>Shopping detail of transaction id
              <?=$_GET[orderid]; $s_id=$cms->getSingleresult("select store_id from #_orders_detail where orderid = '".$_GET[orderid]."' ");?>
              &nbsp;&nbsp;And Sotre name:&nbsp;&nbsp;
              <?=$cms->getSingleresult("select name from #_store_user where 
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
        <?php  $summury=$cms->db_query("select * from #_order_summary where  orderid = '".$_GET[orderid]."' ");
		       $summury_data = $cms->db_fetch_array($summury);
			   extract($summury_data);
			$total  = 0;
			while($res2 = $cms->db_fetch_array($check)){
				extract($res2);
				$total = $total+($qty*$amount);
				$img = $cms->getSingleresult("select image1 from #_products_user where pid='".$proid."' ");
				$imgpro  ="uploaded_files/orginal/no-img.gif";
				if(file_exists('uploaded_files/orginal/'.$img) && $img!=""){			
				$imgpro  ="uploaded_files/orginal/".$img;
				}?>
        <tr>
          <!--  <td width="25%" align="center" valign="middle" bgcolor="#F3F3F3" class="image_pad"><img src="<?=SITE_PATH.$imgpro?>" width="147" height="100"  alt=""/></td> -->
          <td width="25%" align="center" valign="middle" bgcolor="#F3F3F3"><?=$cms->getSingleresult("select name from #_store_user where pid='".$store_id."' ")?></td>
          <td width="25%" align="center" valign="middle" bgcolor="#F3F3F3"><a href="<?=($urls)?$urls:'#'?>" target="_blank">
            <?=$cms->getSingleresult("select title from #_products_user where pid='".$proid."' ")?>
            </a></td>
          <td width="25%" align="center" valign="middle" bgcolor="#F3F3F3"><?=$qty?></td>
          <td width="25%" align="center" valign="middle" bgcolor="#F3F3F3"><?=$cms->price_format($qty*$amount)?>
            <?php if($qty>1)echo "($qty * $amount)";?></td>
        </tr>
        <tr>
          <td colspan="5">&nbsp;</td>
        </tr>
        <?php
			
			}
			$_SESSION['total'] = $total;
			$link  = SITE_PATH."".$items[0];
		} 	?>
        <tr>
          <td> &nbsp;&nbsp; <?php // $Discounttotal=$comboSavng+$periodSaving+$hotdealSaving+$hotdealSaving; echo  $cms->price_format($Discounttotal)?></td>
          <td>&nbsp;&nbsp; <? //$cms->price_format($paynet)?></td>
          <td>&nbsp;&nbsp; <? //$cms->price_format($shipping)?></td>
          <td>&nbsp;&nbsp;&nbsp;<strong>Total: </strong>
            <?=$cms->price_format($total)?>
          </td>
        </tr>
      </table>
      <?php  
		$rsAdmin2=$cms->db_query("select * from #_members where pid='".$_SESSION[userid]."'");
		$result=$cms->db_fetch_array($rsAdmin2);
		extract($result); 
	 ?>
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
    <?php } ?>
    <!-- Ajax  part End  -->
  </div>
</div>
</div>
