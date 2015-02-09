<style>
#cboxLoadedContent{ padding:10px; margin:0px;}
#cboxContent{background:#f3fff0; overflow:hidden; }
</style>
<?php
   // putenv("TZ=Asia/Calcutta");		
 	if(count($items) > 1)
	{
		$page = 'site/' . $items[1].".php";
	}else{
		die;
	} 

	if($items[1]!="" && file_exists($page)){
		$loadpage=$page;
	}else{		
		echo 'Apologies... page not found';
		die;
	}
	/*$host = $_SERVER['HTTP_HOST'];
	$hostArr = explode(".",$host);
	$base = $hostArr[0];

	$current_store_id = $cms->getSingleresult("select pid from #_store_detail where store_url = '".$base."' and status='Active'");
	$current_store_user_id = $cms->getSingleresult("select store_user_id from #_store_detail where store_url = '".$base."'  and status='Active'");
	$current_plan_id = $cms->getSingleresult("select plan_id from #_store_detail where store_url = '".$base."'");*/

	$host = $_SERVER['HTTP_HOST'];
	$hostArr = explode(".",$host); 
	$base = $hostArr[0]; 
	$store_url = $cms->getSingleresult("SELECT store_url FROM fz_store_detail WHERE store_domain ='".str_replace("www.","",$host)."' and status='Active'"); 
	if($store_url == "")
	{
		$store_url = $cms->getSingleresult("SELECT store_url FROM fz_store_detail WHERE store_url ='".$base."' and status='Active'");  
		$current_store_user_id = $cms->getSingleresult("select store_user_id from #_store_detail where store_url ='".$base."' and status='Active'"); 
		$re_noOfDays=$cms->daysLeft($current_store_user_id); 
		if($base!=$store_url || $re_noOfDays<0){
			$die = 1; 
			if($loadpage!="site/index.php") header("Location:".SITE_PATH);
		} 
	}
	else
	{
		$base=$store_url;
	} 
	$current_store_id = $cms->getSingleresult("SELECT pid FROM fz_store_detail WHERE store_url ='".$base."' and status='Active'");  
	$current_store_user_id = $cms->getSingleresult("select store_user_id from #_store_detail where store_url = '".$base."' and status='Active'");  
	$current_plan_id = $cms->getSingleresult("select plan_id from #_store_detail where store_url = '".$base."' and status='Active'"); 
 	include_once $loadpage;
?>
