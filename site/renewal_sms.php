<?php 
$metaTitle = $cms->getSingleresult("select meta_title from #_meta_info where url='renew' and store_user_id = '0'");
$metaIntro = $cms->getSingleresult("select meta_description from #_meta_info where url='renew' and store_user_id = '0'");
$metaKeyword = $cms->getSingleresult("select meta_keyword from #_meta_info where url='renew' and store_user_id = '0'"); 
 if($cms->is_post_back()){
     @extract($_POST);   
	 if($type =='member'){ 
		$rsAdmin_login = $cms->db_query("select pid,type, status, name, email_id from #_store_user where `user_name`='".$user_name."' and  `password`='".$cms->encryptcode($password)."'");
		if(mysql_num_rows($rsAdmin_login)){
			$arrAdmin_login = $cms->db_fetch_array($rsAdmin_login); 
			$_SESSION[ren_store_id] = $cms->getSingleresult("select store_user_id from #_store_detail where `store_user_id`='".$arrAdmin_login[pid]."'"); 
			header("Location:".SITE_PATH."renewal_sms_details"); die;  
		} else {
			$er= '<p style="color:red; font-weight:bold;" >Invalid User name and password. Try again!</p>';
		} 
	} 
} 
$body = $cms->getSingleresult("SELECT body FROM `#_pages` where url ='renewal-account' and status = 'Active'  and store_user_id = '0'	 ");
$heading = $cms->getSingleresult("SELECT heading FROM `#_pages` where url ='renewal-account' and status = 'Active' and store_user_id = '0'");   
?>
 


<div class="row" style="margin-top:20px;">
  <div class="col-md-12 col-sm-12">
    <?php
			$qry = $cms->db_query("SELECT noOfDays,amount FROM `#_plans_hosting` where pid ='".$_SESSION[planID]."'  ");
			$res = $cms->db_fetch_array($qry);	

			$sql=$cms->db_query("select name from #_plans  where status='Active' and pid = '".$_SESSION[tarifid]."'");
			$res2 = $cms->db_fetch_array($sql);	
					 
			?>
    <div class="heading col-md-12 col-sm-12"><?=$cms->removeSlash($heading)?></div>
      <div class="subarea col-md-12 col-sm-12">
      <?=$cms->removeSlash($body)?> 
	  <?=$er?>
      
        <div class="divfor_left-area ornone">
        <div class="divfor_right-area">
         <h2>Fill Your Details :-</h2>
         <form action="" method="post"  autocomplete="off" >
		 <input type="hidden" name="type" value="member" />
          <div>
            <div id="label">
              <label for="textfield">Username :</label>
            </div>
            <div id="inputs">
              <input type="text" name="user_name" lang="R" title="User Name" id="textfield" class="input_pass" required>
            </div>
          </div>
          <div>
            <div id="label">
              <label for="textfield">Password :</label>
            </div>
            <div id="inputs">
              <input type="password" name="password" lang="R" title="Password"  id="textfield" class="input_pass" required>
            </div>
          </div>
          <div>
            <div id="label">
              <label for="textfield">&nbsp;</label>
            </div>
            <div id="inputs">
              <input type="submit" name="submit"  value="Login">
			  <span><a href="forgot-password?user=memberuser">Forgot Password ?</a></span>

            </div>
          </div>
          <div>
            <div id="label">
              <label for="textfield">&nbsp;</label>
            </div>
            <div id="inputs">
           
            </div>
          </div>
          </form>

        </div>
      </div>
    
  </div>
</div>
</div>

