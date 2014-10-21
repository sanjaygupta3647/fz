<?php		
if($_POST[marketserach]){ 
$url = SITE_PATH."store-market/country/80/city/".(int)$_POST['city']."/store/".(int)$_POST['store']."/market/".(int)$_POST['market'];
header("Location:".$url); die('Could not redirect!');
} 
$cond = "";
// for city
if($items[4]>0){
	$cond .= " and city_id = '".$items[4]."'";
}
// for store
if($items[6]>0){ 	
	$cond .= " and plan_id in ('".implode(',',$cms->getPlanIdByCat($items[6]))."')";
}
// for market
//if($items[4]>0){$cond .= " and city_id = '".$items[4]."'";}

?>
<div  class="left_matter_area">
  <div class="main_body_text">
    <table width="100%" border="0" cellspacing="1" cellpadding="0">
      <tr>
        <td height="30" align="center" class="enq_text_fild">Search By Market</td>
      </tr>
      <tr>
        <td align="left" valign="top">
		<form action="" method="post" >
            <input type="hidden" name="marketserach" value="1" />
		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td width="33%" height="22" class="text_v10">Select City : </td>
              <td width="67%" ><?php 		  
							  $sql_city1="select pid,city from fz_city where country_id='80'";
							  $sql_city1_query=$cms->db_query($sql_city1);
				?>
                  <select  name="city" id="city_id2" class="enq_text_fild" style="width: 161px;">
                    <option value="">--Select-- </option>
                    <?php while($city_array=$cms->db_fetch_array($sql_city1_query)){?>
                    <option value="<?php echo $city_array['pid']; ?>" <? if($items[4]==$city_array['pid']) echo 'selected'; ?>><?php echo $city_array['city']; ?></option>
                    <?php }?>
                  </select></td>
            </tr>
            <tr>
              <td height="22" class="text_v10" >Market : </td>
              <td ><div id="marketDiv">
			          <select name="market" class="enq_text_fild" lang="R" title="Market"> 
					  <? $rsAdmin=$cms->db_query("select pid,market_name from #_market where city_id='".$items[4]."'");
					  if(mysql_num_rows($rsAdmin)){
					  while($arrAdmin=$cms->db_fetch_array($rsAdmin))
						{?>
						  <option value="<?=$arrAdmin[pid]?>"  <? if($items[8]==$arrAdmin['pid']) echo 'selected'; ?> ><?=$arrAdmin[market_name]?></option> <?  
						}
						}
					   ?>
					  </select>
                    
                  </div></td>
            </tr>
            <tr>
              <td height="22" class="text_v10" >Store : </td>
              <td > <select class="enq_text_fild" name="store" id="store">
                    <option class="border_pro_radi5" value="">Select Store</option>
                    <?php $result=$cms->db_query("select pid,name from fz_category where parentId='0'");
					  while($res=mysql_fetch_array($result))
					  {
					  ?>
                    <option value="<?php echo $res['pid']?>" <? if($items[6]==$res['pid']) echo 'selected'; ?>><?php echo $res['name']?></option>
                    <?php
					  
					  }
					  ?>
                  </select>
              </td>
            </tr>
            <tr>
              <td height="22">&nbsp;</td>
              <td align="left" valign="bottom"><a href="#">
                <input type="image"  src="<?=SITE_PATH?>images/search2.png" width="28" height="28" name="market_search"/>
                </a></td>
            </tr>
		
          </table></form>
		  </td>
      </tr>
    </table>
  </div>
   
</div>
<div  class="main_matter_area"> 
  <div class="main_text_area1">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="30" align="center" class="enq_text_fild2">Your Store Search</td>
      </tr>
      <tr>
        <td align="center" valign="top">
			<?php 
			$search = "select pid,title,plan_id,image,theme  from #_store_detail where 1 ".$cond; 
			$data_visited=$cms->db_query($search);
			if(mysql_num_rows($data_visited))
			{
			while($re_visited=$cms->db_fetch_array($data_visited))
			{ 
 			$img = SITE_PATH."uploaded_files/orginal/no-img.gif";
			if(file_exists(UP_FILES_FS_PATH.'/orginal/'.$re_visited['image']) && $re_visited['image']!="")
			{
			$img = SITE_PATH."uploaded_files/orginal/".$re_visited['image'];
			}
			//$catname = $cms->getSingleresult("select name from #_category where pid = '".$re_visited['cat_id']."'")
			?>
			 <div class="store_logo"><a  href="<?=SITE_PATH?><?=$adm->baseurl($re_visited['title'])?>" target="_blank"><img src="<?=$img?>" height="60" width="60" /></a></div>
			<?php
			}
			}
			else
			{
				?><div class="no-record">No Record Found!</div><?
			}
			?> 
          </td>
      </tr>
    </table>
  </div>
</div>
</td>
<td align="left" valign="top">&nbsp;</td>
</tr>
<tr>
  <td align="left" valign="top">&nbsp;</td>
  <td align="left" valign="top" class="enq_text_fild"><h4 class="text_v12">&nbsp;</h4></td>
  <td align="left" valign="top">&nbsp;</td>
</tr>
<tr>
  <td align="left" valign="top">&nbsp;</td>
  <td align="center" valign="middle" bgcolor="#F2F2F2" class="enq_text_fild">Top Most Brand </td>
  <td align="left" valign="top">&nbsp;</td>
</tr>
<tr>
  <td align="left" valign="top">&nbsp;</td>
  <td align="left" valign="top">
      <!--<div id="slider12" class="slider-horizontal">
      <div class="item item-1"><a href="#"><img src="images/logo/1-1adidas.jpg" width="118" height="88" border="0" /></a></div>
      <div class="item item-1"><a href="#"><img src="images/logo/2-1nike_color.jpg" height="88" width="118" /></a></div>
      <div class="item item-1"><a href="#"><img src="images/logo/3-1puma_color.jpg" height="88" width="118" /></a></div>
      <div class="item item-1"><a href="#"><img src="images/logo/4-1woodland_color.jpg" height="88" width="118" /></a></div>
      <div class="item item-1"><a href="#"><img src="images/logo/5-1fila_color.jpg" height="88" width="118" /></a></div>
      <div class="item item-1"><a href="#"><img src="images/logo/6-1ucb_color.jpg" height="88" width="118" /></a></div>
      <div class="item item-1"><a href="#"><img src="images/logo/7-1u-s-polo_color.jpg" height="88" width="118" /></a></div>
      <div class="item item-1"><a href="#"><img src="images/logo/8-1lee.jpg" height="88" width="118" /></a></div>
      <div class="item item-1"><a href="#"><img src="images/logo/9-1wrangler.jpg" height="88" width="118" /></a></div>
      <div class="item item-1"><a href="#"><img src="images/logo/10-1fcuk.jpg" height="88" width="118" /></a></div>
      <div class="item item-1"><a href="#"><img src="images/logo/12-1allensolly_color.jpg" height="88" width="118" /></a></div>
      <div class="item item-1"><a href="#"><img src="images/logo/11-1proline_color.jpg" height="88" width="118" /></a></div>
      <div class="item item-1"><a href="#"><img src="images/logo/13-1biba_color.jpg" height="88" width="118" /></a></div>
      <div class="item item-1"><a href="#"><img src="images/logo/15-1Elle.jpg" height="88" width="118" /></a></div>
      <div class="item item-1"><a href="#"><img src="images/logo/16-1VeroModa.jpg" height="88" width="118" /></a></div>
      <div class="item item-1"><a href="#"><img src="images/logo/17-1Hidesign_color.jpg" height="88" width="118" /></a></div>
      <div class="item item-1"><a href="#"><img src="images/logo/18-1casio_color.jpg" height="88" width="118" /></a></div>
      <div class="item item-1"><a href="#"><img src="images/logo/19-1phosphorous_color.jpg" height="88" width="118" /></a></div>
      <div class="item item-1"><a href="#"><img src="images/logo/20-1bombay-dyeing_color.jpg" height="88" width="118" /></a></div>
      <div class="item item-1"><a href="#"><img src="images/logo/22-1RayBan.jpg" height="88" width="118" /></a></div>
      <div class="item item-1"><a href="#"><img src="images/logo/23-1levis_color.jpg" height="88" width="118" /></a></div>
      <div class="item item-1"><a href="#"><img src="images/logo/3-1puma_color.jpg" height="88" width="118" /></a></div>
      <div class="item item-1"><a href="#"><img src="images/logo/7-1u-s-polo_color.jpg" height="88" width="118" /></a></div>
      <div class="item item-1"><a href="#"><img src="images/logo/18-1casio_color.jpg" height="88" width="118" /></a></div>
      <div class="item item-1"><a href="#"><img src="images/logo/3-1puma_color.jpg" height="88" width="118" /></a></div>
      <div class="item item-1"><a href="#"><img src="images/logo/11-1proline_color.jpg" height="88" width="118" /></a></div>
      <div class="item item-1"><a href="#"><img src="images/logo/16-1VeroModa.jpg" height="88" width="118" /></a></div>
      <div class="item item-1"><a href="#"><img src="images/logo/11-1proline_color.jpg" height="88" width="118" /></a></div>
    </div>-->
	</td>
  <td align="left" valign="top">&nbsp;</td>
</tr>
<tr>
  <td align="left" valign="top">&nbsp;</td>
  <td width="1024" align="left" valign="top" class="text_v10">&nbsp;</td>
  <td align="left" valign="top">&nbsp;</td>
</tr>
