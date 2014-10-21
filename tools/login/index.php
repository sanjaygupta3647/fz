<?php include("../../lib/opin.inc.php")?>
<?php 
 $phone=$cms->getSingleresult("select phone from #_setting where `id`='1'");
  //$regdate= date("Y/m/d");
  $ip = $_SERVER['REMOTE_ADDR'];
  //$ssid = session_id();
  $hostaddress = gethostbyaddr($ip);
if($cms->is_post_back()){
	$rsCheck = $cms->db_query("select aid, ausername, atype from #_administrator where ausername='".trim($ausername)."' and apassword='".base64_encode(trim($apassword))."' and astatus='Active'");
	if(mysql_num_rows($rsCheck)){
		$arrCheck = $cms->db_fetch_array($rsCheck);
		$_SESSION["ses_adm_id"] = $arrCheck["aid"];
		$_SESSION["ses_adm_usr"] = $arrCheck["ausername"];
		$_SESSION["ses_adm_type"] = $arrCheck["atype"];
		$cms->db_query("insert into #_admin_lostlogin set ausername = '".$_SESSION["ses_adm_usr"]."', atype = '".$_SESSION["ses_adm_type"]."',phone='$phone',ip='$hostaddress',ipaddr='$ip',ssid ='$ssid' ");
		$cms->redir(SITE_PATH_ADM."content");
		exit;
	}else{
		 $adm->sessset($msg[0], 'e');
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title><?=SITE_NAME?></title>
    <!--[if IE]> <script type="text/javascript" src="js/html5.js"></script><![endif]-->
    <!--[if IE 9]><link href="css/ie9.css" rel="stylesheet" type="text/css" /><![endif]-->
    <script src="js/pie.js" type="text/javascript"></script>
    <script src="js/validate.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="css/style.css">    
</head>
<body>
<div id="wrapper">
<div class="logo"><img src="../images/logo.png"/></div>

<div class="login-form radius">
<h1>Login Here</h1>
<?=$adm->alert()?>
<form action="" method="post" onSubmit="return formvalid(this);">
<input type="text" name="ausername" title="Username" lang="R" id="" class="text-field radius1">
<input type="password" name="apassword"  title="Password" lang="R" class="text-field2 radius1">

<?php /*?><select name="domains" title="Select Domains" lang="R" class="text-field3 radius1">
<option value="">--Select one--</option>
<?php $rsCheck = $cms->db_query("select * from #_domains"); while($arrCheck = $cms->db_fetch_array($rsCheck)): @extract($arrCheck);?>
<option value="<?=$vals?>"><?=$domain?></option>
<?php endwhile; ?>
</select><?php */?>

<input type="hidden" name="domains" value="bhsportcovers.com" />

<!-- <img src="<?=SITE_PATH?>captcha/captcha.php"/>
<input type="text" name="ausername" title="Username" lang="R" id="" class="text-field4 radius1"> -->

<div class="hotspot">
<div class="remember"><input type="checkbox" disabled="disabled" class="check"> <label>Remember me</label></div>
<div class="btns">&nbsp;&nbsp;&nbsp;&nbsp;<input type="image" src="images/login.png" alt=""><!--  <input type="image" src="images/forgetp.png" alt="">--></div>
</div>
</form>
</div>
</div>
<div align="center" style="margin-top:10px; font-family:Verdana, Geneva, sans-serifl; font-size:10px;">
If you visited this place by mistake please Close this window
<br /><br />
We are looking Your IP Address For Security Purpose : <?=$_SERVER['REMOTE_ADDR']?></div>
</body>
</html>