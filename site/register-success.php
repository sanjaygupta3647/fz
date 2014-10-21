<?php 
        $metaTitle = $cms->getSingleresult("select meta_title from #_meta_info where url='member-sign-up' and store_user_id = '0'");
		$metaIntro = $cms->getSingleresult("select meta_description from #_meta_info where url='member-sign-up' and store_user_id = '0'");
		$metaKeyword = $cms->getSingleresult("select meta_keyword from #_meta_info where url='member-sign-up' and store_user_id = '0'");

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
?>


