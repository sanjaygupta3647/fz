<?php 
    $cms->pageView($current_store_user_id);
	putenv("TZ=Asia/Calcutta");	 
 	if(count($items) >= 1)
	{		
		$page = $items[0].".php";
	} 
	if($items[0]!="" && file_exists("site/".$page)){
		$loadpage=$page;
	}else{		
		$loadpage="index.php";
		
	}
	$loadpage="site/".$loadpage; 

ob_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head profile="http://dublincore.org/documents/dcq-html/">
<title>%%title%%</title>
<link rel="schema.DC" href="http://purl.org/dc/elements/1.1/" />
<link rel="schema.DCTERMS" href="http://purl.org/dc/terms/" />
<!-- Start: Meta Info -->
<!--<meta property="og:image" content="" />-->
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<meta name="DC.title" content="%%title%%" />
<meta name="DC.creator" content="Fizzkart CDI" />
<meta name="DC.subject" content="Meta-data" />
<meta name="DC.description" content="%%description%%" />
<meta name="DC.publisher" content="Fizzkart CDI" />
<meta name="DC.contributor" content="Fizzkart CDI" />
<meta name="DC.date" content="%%datetime%%" scheme="DCTERMS.W3CDTF" />
<meta name="DC.type" content="Text" scheme="DCTERMS.DCMIType" />
<meta name="DC.format" content="text/html" scheme="DCTERMS.IMT" />
<meta name="DC.identifier" content="%%uri%%" scheme="DCTERMS.URI" />
<meta name="DC.source" content="http://www.w3.org/TR/html401/struct/global.html#h-7.4.4" scheme="DCTERMS.URI" />
<meta name="DC.language" content="%%lang%%" scheme="DCTERMS.RFC3066" />
<meta name="DC.relation" content="http://dublincore.org/" scheme="DCTERMS.URI" />
<meta name="DC.coverage" content="Fizzkart CDI" scheme="DCTERMS.TGN" />
<meta name="DC.rights" content="All rights reserved" />
<meta name="author" content="Fizzkart CDI" />
<meta name="keywords" content="%%keywords%%" />
<meta name="description" content="%%description%%" />
<!-- End: Meta Info -->
<!--favicon-->
<link rel="icon" href="<?=$file_url?>images/favicon.ico" />
<link rel="shortcut icon" href="<?=$file_url?>images/favicon.ico" />
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>

<?php include_once "common_css.php"; ?>
</head> 
<body>
<p id="back-top">
		<a href="#top"><span></span></a>
	</p>
    <div id="wrapper">
	<div class="mainarea">
    	 <?php include "header.php"; ?>
        
         <?php include_once $loadpage; ?> 
        
    </div>
</div>
<?php include "footer.php"; ?>  
<?php include_once "common_js.php"; ?>  
</body>
</html>
<?php 
	//---- this script to parse all content and parse to replace keys  
	$templateContent = ob_get_contents();
	ob_end_clean();
	$templateContent = str_replace("%%title%%",$metaTitle,$templateContent);
	if($items[0]=="detail" || $items[0]=="event" || $items[0]=="article" || $items[0]=="page" || $items[0]=="partner_detail"){
		$templateContent = str_replace("%%pagetitle%%",$metaTitle . " - ",$templateContent);
	}else{
		$templateContent = str_replace("%%pagetitle%%","",$templateContent);
	}
	$templateContent = str_replace("%%description%%",$metaIntro,$templateContent);
	$metaDate=str_replace(' ','TO',$metaDate) . '+00:00';
	$templateContent = str_replace("%%datetime%%",$metaDate,$templateContent);
	$metaURI="http://www." . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	$templateContent = str_replace("%%uri%%",$metaURI,$templateContent);
	$templateContent = str_replace("%%lang%%",$_SESSION['lang'],$templateContent);
	$templateContent = str_replace("%%keywords%%",$metaKeyword,$templateContent);
	echo $templateContent;
	 
?>
