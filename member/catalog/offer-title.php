<?php include("../../lib/opin.inc.php")?>
<?php define("CPAGE","catalog/")?>
<?php 
$getpid=$cms->getSingleresult("select pid from #_offer_title where store_user_id='".$_SESSION[uid]."' ");  
if($cms->is_post_back()){ 
		$_POST[store_user_id]=$_SESSION[uid]; 
		if(!$getpid){ 
			$cms->sqlquery("rs","offer_title",$_POST); 
			$adm->sessset('Record has been added', 's');
		}
		else{ 
			$cms->sqlquery("rs","offer_title",$_POST,'pid',$getpid);
			$adm->sessset('Record has been updated', 's');
		} 
	$red = SITE_PATH_MEM.CPAGE."/offer-title.php";
	$cms->redir($red, true);
} 

 	$rsAdmin=$cms->db_query("select * from #_offer_title where store_user_id='".$_SESSION[uid]."'");
	$arrAdmin=$cms->db_fetch_array($rsAdmin);
	@extract($arrAdmin);
?>
<?php include("../inc/header.inc.php")?>

<div class="main">
  <header>
    <div class="hrd-right-wrap">
      <?php /*?> <nav>
          <ul>
            <li> <a href="<?=SITE_PATH_MEM?>"></a> </li>
            <li> <a href="<?=SITE_PATH_MEM?>catalog/collections.php">store_detail</a> </li>
            <li> <a href="<?=SITE_PATH_MEM?>catalog/manage-category.php">Category</a> </li>
            <li> <a href="<?=SITE_PATH_MEM?>setting.php?mode=true">Setting</a> </li>
           <!-- <li> <a href="">System</a> </li>-->
          </ul>
        </nav><?php */?>
      <div class="brdcm" id="hed-tit">Offer Title Management</div>
      <div class="unvrl-btn"> <a href="<?=SITE_PATH_MEM.CPAGE.'/offer-title.php'?>" class="ub"> <img src="<?=SITE_PATH_MEM?>images/back.png" alt=""></a> </div>
    </div>
    <div class="cl"></div>
  </header>
  <div class="cl"></div>
  <div class="content">
    <div class="div-tbl">
      <div class="cl"></div>
      <? //$adm->h1_tag('Dashboard &rsaquo; Collection Manager',$others2)?>
      <?php $hedtitle = "Offer Title Management"; ?>
      <?=$adm->alert()?>
      <div class="title"  id="innertit">
         <h2><?=$cms->breadcrumbs()?></h2>
      </div>
      <div class="tbl-contant">
        <table width="100%" border="0" align="left" cellpadding="2" cellspacing="1"  class="frm-tbl2">
			 
			<tr  class="grey_">
			<td width="23%" class="label">Title1:</td>
			<td width="77%">
			&nbsp;  <?=$title?>
			<input type="text" name="offer_title1"  title="Combo Offers"  alt="Combo Offers" placeholder="Combo Offers" value="<?=($offer_title1)?$offer_title1:'Combo Offers'?>" />
			</td>
			</tr>
			<tr  class="grey_">
			<td width="23%" class="offer_title2">Title2:</td>
			<td width="77%">
			&nbsp;  <?=$title?>
			<input type="text" name="offer_title2" title="Period Offers"  alt="Period Offers" placeholder="Period Offers"   value="<?=($offer_title2)?$offer_title2:'Period Offers'?>" />
			</td>
			</tr>
			<tr  class="grey_">
			<td width="23%" class="label">Title3:</td>
			<td width="77%">
			&nbsp;  <?=$title?>
			<input type="text" name="offer_title3" title="Hot Deals"  alt="Hot Deals" placeholder="Hot Deals"    value="<?=($offer_title3)?$offer_title3:'Hot Deals'?>" />
			</td>
			</tr>
		   
          <td>&nbsp;</td>
            <td><input type="submit" name="Submit" class="uibutton  loading" value="&nbsp;&nbsp;&nbsp;Submit&nbsp;&nbsp;&nbsp;" /></td>
          </tr>
        </table>
      </div>
      <div class="cl"></div>
    </div>
  </div>
  <?php include("../inc/footer.inc.php")?>
</div>
</div>
<div class="cl"></div>
</div>
</div> 
</body></html>