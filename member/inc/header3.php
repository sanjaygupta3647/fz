<header>
     
      <div class="hrd-right-wrap">
        <?php /*?><nav>
          <ul>
            <li> <a href="<?=SITE_PATH_MEM?>"></a> </li>
            <li> <a href="<?=SITE_PATH_MEM?>catalog/collections.php">Products</a> </li>
            <li> <a href="<?=SITE_PATH_MEM?>catalog/manage-category.php">Category</a> </li>
            <li> <a href="<?=SITE_PATH_MEM?>setting.php?mode=true">Setting</a> </li>
           <!-- <li> <a href="">System</a> </li>-->
          </ul>
        </nav><?php */?>
        
        <div class="brdcm" id="hed-tit">Banner</div>
        <div class="unvrl-btn"> 
     <!--   <a href="<?=SITE_PATH_MEM.CPAGE.'/?mode=add'?>" class="ub">
        <img  src="<?=SITE_PATH_MEM?>images/add-new.png" alt=""></a> -->
         <?php if(!$_GET[mode]){?>
          <a href="javascript:void(0)"  onclick="javascript:submitions('Active');"class="ub">
        <img src="<?=SITE_PATH_MEM?>images/active.png" alt=""></a>
        <a href="javascript:void(0)" onClick="javascript:submitions('Inactive');" class="ub">
        <img src="<?=SITE_PATH_MEM?>images/inactive.png" alt=""></a>
        <a href="javascript:void(0)" class="ub"   onclick="javascript:submitions('delete');">
        <img src="<?=SITE_PATH_MEM?>images/delete.png" alt=""></a> <? }?>
       <?php if($_GET[mode]){?>
        <a href="javascript:void(0)" onclick="javascript:formback();" class="ub">
        <img src="<?=SITE_PATH_MEM?>images/back.png" alt=""></a><?php }?>
        
        </div> 
      </div>
      <div class="cl"></div>
    </header> 