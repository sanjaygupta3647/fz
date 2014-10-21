<?php include("../../lib/opin.inc.php")?>
<?php define("CPAGE","catalog/")?>
<?php 
$rsAdmin2=$cms->db_query("select * from #_banner ");
if($cms->is_post_back()){  
	
 	if(mysql_num_rows($rsAdmin2)){
		$cms->db_query("update  #_banner set banner = '$banner',banner_left = '$banner_left', banner_right = '$banner_right'");
		$adm->sessset('Record has been updated', 's');
		}else{
		$cms->db_query("insert into  #_banner set  banner = '$banner',banner_left = '$banner_left', banner_right = '$banner_right'");
		$adm->sessset('Record has been added', 's');
		}
	 
	$cms->redir(SITE_PATH_ADM."/catalog/add-store-banner.php", true);
}
if(mysql_num_rows($rsAdmin2)){
	$arrAdmin=$cms->db_fetch_array($rsAdmin2); 
	@extract($arrAdmin);
}
?>
<?php include("../inc/header.inc.php")?>
<div class="main">
<header>
     
      <div class="hrd-right-wrap">
       <?php /*?> <nav>
          <ul>
            <li> <a href="<?=SITE_PATH_ADM?>"></a> </li>
            <li> <a href="<?=SITE_PATH_ADM?>catalog/collections.php">banner</a> </li>
            <li> <a href="<?=SITE_PATH_ADM?>catalog/manage-category.php">Category</a> </li>
            <li> <a href="<?=SITE_PATH_ADM?>setting.php?mode=true">Setting</a> </li>
           <!-- <li> <a href="">System</a> </li>-->
          </ul>
        </nav><?php */?>
        
        <div class="brdcm" id="hed-tit">Store Management</div>
        <div class="unvrl-btn"> 
        <a href="<?=SITE_PATH_ADM.CPAGE.'/add-store-banner.php'?>" class="ub">
        <img  src="<?=SITE_PATH_ADM?>images/add-new.png" alt=""></a> 
        <a href="javascript:void(0)" onclick="javascript:formback();" class="ub">
        <img src="<?=SITE_PATH_ADM?>images/back.png" alt=""></a> 
        
        </div> 
      </div>
      <div class="cl"></div>
    </header> 
    
 <div class="cl"></div> 
<div class="content"> 
<div class="div-tbl">
<div class="cl"></div>
    <? //$adm->h1_tag('Dashboard &rsaquo; Collection Manager',$others2)?>
   
<?php $hedtitle = "Store Management"; ?>   
      <?=$adm->alert()?>
      <div class="title"  id="innertit">
        <?=$adm->heading('Add/Update Store Detail')?>
      </div>
        <div class="tbl-contant">
        <table width="100%" border="0" align="left" cellpadding="2" cellspacing="1"  class="frm-tbl2">
        <?php if($banner   and is_file($_SERVER['DOCUMENT_ROOT'].SITE_SUB_PATH."uploaded_files/orginal/".$banner)==true){?>
          <tr>
            <td valign="top" class="label">&nbsp;</td>
            <td valign="top"><img src="<?=SITE_PATH?>uploaded_files/orginal/<?=$banner?>" width="100"> &nbsp;&nbsp;
            </td>
          </tr>
          <?php } ?>
          <tr>
            <td valign="top" class="label">Home Banner:</td>
            <td valign="top"> <input type="text" name="banner" value="<?=$banner?>" class="txt medium" id="upimg3" />
       <img onClick="window.open('<?=SITE_PATH_ADM."crop/imageupload.php?imgid=upimg3&image=product&view=big&name=".$pimage?>','mywindow','width=900,height=400,left=200,scrollbars=yes, top=100,screenX=0,screenY=100')" src="<?=SITE_PATH_ADM?>images/clickhere.png" alt="" class="img-click" /> <br /></td>
          </tr>
      
           
        <?php if($banner_left  and is_file($_SERVER['DOCUMENT_ROOT'].SITE_SUB_PATH."uploaded_files/orginal/".$banner_left)==true){?>
          <tr>
            <td valign="top" class="label">&nbsp;</td>
            <td valign="top"><img src="<?=SITE_PATH?>uploaded_files/orginal/<?=$banner_left?>" width="100"> &nbsp;&nbsp;
            </td>
          </tr>
          <?php } ?>
          <tr>
            <td valign="top" class="label">Left Banner:</td>
            <td valign="top"> <input type="text" name="banner_left" value="<?=$banner_left?>" class="txt medium" id="upimg" />
       <img onClick="window.open('<?=SITE_PATH_ADM."crop/imageupload.php?imgid=upimg&image=product&view=thumb&name=".$image?>','mywindow','width=900,height=400,left=200,scrollbars=yes, top=100,screenX=0,screenY=100')" src="<?=SITE_PATH_ADM?>images/clickhere.png" alt=""  class="img-click" /> <br /></td>
          </tr>
          
        <?php if($banner_right   and is_file($_SERVER['DOCUMENT_ROOT'].SITE_SUB_PATH."uploaded_files/orginal/".$banner_right)==true){?>
          <tr>
            <td valign="top" class="label">&nbsp;</td>
            <td valign="top"><img src="<?=SITE_PATH?>uploaded_files/orginal/<?=$banner_right?>" width="100"> &nbsp;&nbsp;
            </td>
          </tr>
          <?php } ?>
          <tr>
            <td valign="top" class="label">Right Banner:</td>
            <td valign="top"> <input type="text" name="banner_right" value="<?=$banner_right?>" class="txt medium" id="upimg2" />
       <img onClick="window.open('<?=SITE_PATH_ADM."crop/imageupload.php?imgid=upimg2&image=product&view=big&name=".$pimage?>','mywindow','width=900,height=400,left=200,scrollbars=yes, top=100,screenX=0,screenY=100')" src="<?=SITE_PATH_ADM?>images/clickhere.png" alt="" class="img-click" /> <br /></td>
          </tr> 
            <td>&nbsp;</td>
            <td><input type="submit" name="Submit" class="uibutton  loading" value="&nbsp;&nbsp;&nbsp;Submit&nbsp;&nbsp;&nbsp;" /></td>
          </tr>
        </table>
    </div>
    <div class="cl"></div>
    </div>
  </div> 
<?php include("../inc/footer.inc.php")?></div>
</div>
<div class="cl"></div>
</div>
</div>

 
</body>
</html>

