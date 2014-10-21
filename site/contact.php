<?php
$metaTitle = $cms->getSingleresult("select meta_title from #_pages where url='".$items[1]."'");
$metaIntro = $cms->getSingleresult("select meta_description from #_pages where url='".$items[1]."'");
$metaKeyword = $cms->getSingleresult("select meta_keyword from #_pages where url='".$items[1]."'");
 
if($cms->is_post_back()) {
	if(strtolower($_POST['secCode'])==$_POST['captcha']){
		$_POST['ipaddress'] = $_SERVER['REMOTE_ADDR'];
		$_POST['mailto'] = SITE_MAIL;
		$uids =  $cms->sqlquery("rs","contact",$_POST); 
		if($uids){
			echo "<script>alert('Thank You For Contact With Us. We Will Get You Back Soon.')</script>";
			$headers = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$msg ='<div style="font-family:Verdana, Geneva, sans-serif; font-size:12px;">
			<p>Name: '.$_POST[name].'</p><p>Phone: '.$_POST[phone].'</p><p>Email: '.$_POST[email].'</p><p>Query: '.$_POST[query].'</p>
			<p>@Fizzkart, Admin</p></div>';
			@mail(SITE_MAIL, 'Fizzkart - New Contact Email', $msg,$headers); 
			$_POST = false;
		}
	} else {
		echo "<script>alert('Invalid Security Code')</script>";	
	} 
}
?>

<div class="body" >
  <div class="border_box" >   
    <div class="border_box2" >
      <div class="form_textfilld1">
        
        <form  method="post" action="" onSubmit="return formvalid(this);"  >
 		<input type="hidden" name="store_id" value="<?=$current_store_user_id?>" />
          <div class="text_inn_cat"> Edit Your Profile </div>
          <ul>
            <li class="form_textfilld1">Name:
              <input class="input_border input_width required" type="text" name="name" id="" title="Name" lang="R" value="<?=$_POST[name]?>" rel="Enter Name">
            </li>
            <li class="form_textfilld1">Phone:
              <input class="input_border input_width" type="text" name="phone"   title="Mobile" lang="R"  value="<?=$_POST[phone]?>" >
            </li>
             
            <li class="form_textfilld1">Email :
              <input class="input_border input_width" type="text" name="email"   title="Email" lang="RisEmail"  value="<?=$_POST[email]?>" >
            </li>
            <li class="form_textfilld1">Query :
              <textarea class="input_border input_width"  lang="R"  title="Query" name="query"><?=$_POST[query]?></textarea>
            </li>
            <li style=" height:16px;" class="form_textfilld1">Security code :
              <?php $code = rand(); ?>
			 <input class="input_border input_width" disabled="disabled" style="margin-left:5px; border:0px; text-align:center; background-color:#CCCCCC; color:#FF0000" type="text"  value="<?=$code?>" >
            
			<input type="hidden" id="captcha" name="captcha" value="<?=$code?>" />
            </li>
			<li class="form_textfilld1">Enter code :
             <input name="secCode" type="text" class="security"  title="Security Code" lang="R" value="" xml:lang="R" />
            </li>
            
            <li class="form_textfilld1">
              <input name="Submit" type="submit" class="login_button" value="Register">
            </li>
          </ul>
        </form>
      </div>
    </div>
  </div>
</div>
