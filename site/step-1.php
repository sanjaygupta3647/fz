<?php 
        $metaTitle = $cms->getSingleresult("select meta_title from #_meta_info where url='member-sign-up' and store_user_id = '0'");
		$metaIntro = $cms->getSingleresult("select meta_description from #_meta_info where url='member-sign-up' and store_user_id = '0'");
		$metaKeyword = $cms->getSingleresult("select meta_keyword from #_meta_info where url='member-sign-up' and store_user_id = '0'");
if($items[1]=='skip'){
 $_SESSION[theme] =  'domain';
 $_SESSION[type] =  $items[2];
 $_SESSION[tarifid] =  $items[3];
 $_SESSION[planID] =  $items[4];
 $_SESSION[proceed] =  1;
 header("Location:".SITE_PATH."Step-2"); 
}

if($cms->is_post_back()){  
		 $_SESSION[theme] =  'domain';
		 $_SESSION[type] =  $_POST[type];
		 $_SESSION[tarifid] =  $_POST[tarifid];
		 $_SESSION[planID] =  $_POST[planID];
		 $_SESSION[proceed] =  1;
		 //print_r($_SESSION);
 		 header("Location:".SITE_PATH."Step-2"); 
}
include "site/search.inc.php";
$body = $cms->getSingleresult("SELECT body FROM `#_pages` where url ='store-registration' and status = 'Active'  and store_user_id = '0'	 ");
$heading = $cms->getSingleresult("SELECT heading FROM `#_pages` where url ='store-registration' and status = 'Active' and store_user_id = '0'");  
if(!$heading)  $heading = "Registration Step 1";
?>

<div class="row" style="margin-top:20px;">
  <div class="col-md-12 col-sm-12">
    <div class="heading2 col-md-3 col-sm-3"><?=$cms->removeSlash($heading)?></div>
    <div class="heading2 col-md-2 col-sm-3">
    <a href="<?=SITE_PATH?>renewal_account">
    Renew Account</a></div>
	<div class="heading2 col-md-3 col-sm-2">
    <a href="<?=SITE_PATH?>renewal_sms">
    Renew SMS</a></div>

	<div class="heading2 col-md-3 col-sm-3">
    <a href="<?=SITE_PATH?>renewal_product">
    Renew Product</a></div>
    <div class="subtext"><?=$cms->removeSlash($body)?></div>
  </div>
  <div class="registerarea col-md-12 col-sm-12">
    <div class="heading col-md-12 col-sm-12" style="color:#fff;font-size: 17px; padding-top:7px; padding-bottom:7px;">Enter your Details</div>
    <div class="subarea">
      <div class="stepbox">Step 1</div>
      <?php
					if($_SESSION[succ]!=""){?>
      <p style="color:green">
        <?=$_SESSION[succ]?>
      </p>
      <?php unset($_SESSION[succ]);
					}	?>
      <form method="post" action="">
        <div class="registerbox col-md-12 col-sm-12">
          <div class="leftbox col-md-3 col-sm-4">Registration for</div>
          <div class="rightbox col-md-9 col-sm-8" style="padding-left: 20px;">
            <div class="chhosebox">
              <input type="radio" id="radio1" name="type" value="store" checked="checked" />
              <label for="radio1"><span></span>Store Owner</label>
            </div>
            <div class="chhosebox">
              <input type="radio" id="radio2" name="type" value="brand" />
              <label for="radio2"><span></span> Brand Owner</label>
            </div>
          </div>
          <div class="divider"></div>
          <div class="leftbox col-md-3 col-sm-4">Please Choose a Category</div>
          <div class="rightbox col-md-9 col-sm-8">
            <?php  
							$sql=$cms->db_query("select * from #_plans  where status='Active' and type = 'store'"); 
							$i = 1;
							while($result=$cms->db_fetch_array($sql)){?>
            <div class="chhosebox3 store col-md-4 col-sm-6">
              <input type="radio" class="plan_id" id="store<?=$i?>" name="tarifid" value="<?=$result['pid']?>"  />
              <label for="store<?=$i?>"><span></span>
                <?=$result['name']?>
              </label>
            </div>
            <?php
								$i++;
							}
							?>
            <?php  
							$sql=$cms->db_query("select * from #_plans  where status='Active' and type = 'brand'"); 
							$i = 1;
							while($result=$cms->db_fetch_array($sql)){?>
            <div class="chhosebox3 brand col-md-4 col-sm-6">
              <input type="radio" class="plan_id" id="brand<?=$i?>" name="tarifid" value="<?=$result['pid']?>"  />
              <label for="brand<?=$i?>"><span></span>
                <?=$result['name']?>
              </label>
            </div>
            <?php
								$i++;
							}
							?>
            <?php  
							$sql=$cms->db_query("select * from #_plans  where status='Active' and type = 'brand-store'"); 
							$i = 1;
							while($result=$cms->db_fetch_array($sql)){?>
            <div class="chhosebox3 brand-store col-md-4 col-sm-6">
              <input class="plan_id" type="radio" id="brand-store<?=$i?>" name="tarifid" value="<?=$result['pid']?>"  />
              <label for="brand-store<?=$i?>"><span></span>
                <?=$result['name']?>
              </label>
            </div>
            <?php
								$i++;
							}
							?>
            <div class="trafibox col-md-12 col-sm-12" id="tarifplan"> </div>
			<div class="col-md-12 col-sm-12">
            <input type="submit" id="store-brand-reg" name="submit" value="Proceed to Next Step" class="proceedbtn"  />
            </div> 
		  </div>
        </div>
      </form>
    </div>
  </div>
</div>
