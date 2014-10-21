<?php  //include "site/search.inc.php"; 
        $metaTitle = $cms->getSingleresult("select meta_title from #_meta_info where url='profile' and store_user_id = '0'");
		$metaIntro = $cms->getSingleresult("select meta_description from #_meta_info where url='profile' and store_user_id = '0'");
		$metaKeyword = $cms->getSingleresult("select meta_keyword from #_meta_info where url='profile' and store_user_id = '0'");
?> 
<div class="transaction_maindiv">
  <div class="main_tabdiv">
    <div class="tabdiv_heading">
      <h1>Your Transcation Details</h1>
    </div>
    <div class="tabdiv_areas">
      <div class="tabdiv_left">
        <div class="tabdiv_left1"><a href="javascript:void(0)" lang="profile" class="noclass active" id="1">Profile</a></div>
        <div class="tabdiv_left1"><a href="javascript:void(0)" lang="transaction"  class="noclass" id="2">My Transaction</a></div>
        <div class="tabdiv_left1"><a href="javascript:void(0)"  lang="mystore"  class="noclass" id="3">My Favourite Stores</a></div>
		<div class="tabdiv_left1"><a href="javascript:void(0)" lang="change-password"  class="noclass" id="5">Change Password</a></div> 
      </div>
      <div class="tabdiv_right">
       <?php include "site/profile-detail.php"; ?>  
        <?php //include "site/my-trans.php"; ?>
		<?php //include "site/fav-store.php"; ?> 
		<?php //include "site/profile-edit.php"; ?>
		<?php //include "site/user_password_edit.php"; ?>
      </div>
    </div>
  </div>
</div>
