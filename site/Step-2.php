<?php  
$metaTitle = "Fizzkart Registration Store ans Personal info";
$metaKeyword = "Fizzkart Message,Fizzkart, Message"; 
$qry = $cms->db_query("SELECT noOfDays,amount FROM `#_plans_hosting` where pid ='".$_SESSION[planID]."'  ");
$payres = $cms->db_fetch_array($qry);	

$sql=$cms->db_query("select name from #_plans  where status='Active' and pid = '".$_SESSION[tarifid]."'");
$res2 = $cms->db_fetch_array($sql);	 

if(!$_SESSION[proceed]){ header("Location:".SITE_PATH."Step-1"); } 
 if($cms->is_post_back()){
 			
			$_POST[market] = trim($_POST[market]);
			$arr2[market_id] = $_POST[market_id];
			if($_POST[market]){
				$checkM = $cms->getSingleresult("select count(*) from #_market where market_name = '".$_POST[market]."'");
				if(!$checkM){
					$ar[market_name] = $_POST[market];
					$ar[country_id] = 80;
					$ar[city_id] = $_POST[city_id2];
					$cms->sqlquery("rs","market",$ar); 
					$arr2[market_id] = mysql_insert_id();
				}
			}
			
			$err = 0;
			 
			if(!$_SESSION[tarifid]){
				$err = 1;
				$errms .= "Previous session expired,please go for first step again! <br/>";
			}
			if(trim($_POST['title']=="")){
				$err = 1;
				$errms .= "Please enter store title!<br/>";
			}
			$check = $cms->getSingleresult("select count(*) from #_store_detail where title = '".addslashes($_POST['title'])."'  ");
			if($check){
				$err = 1;
				$errms .= ucfirst($_SESSION[type])." name '".$_POST['title']."' is already registeredn with us! <br/>";
			}
			$check2 = $cms->getSingleresult("select count(*) from #_store_user where user_name = '".addslashes($_POST['user_name'])."'  ");
			if($check2){
				$err = 1;
				$errms .= "User name  '".$_POST['user_name']."'  is already registeredn with us!<br/>";
			}
			if($_POST[vaucher]){
				$qry_var = $cms->db_query("SELECT voucherCode,pinfor,validtill,status,amount,pid FROM #_gift_voucher where voucherCode ='".$cms->encryptcode($_POST[voucherCode])."' and generatedByadmin='0' ");
				 if(mysql_num_rows($qry_var)){
					 $arr3 = $cms->db_fetch_array($qry_var);
					 $today = date("Y-m-d");
					 if($arr3['validtill']!='0000-00-00'){
						  if($today>$arr3['validtill']){
							 $err = 1;
							 $errms .= "Sorry this coupon is expired now!"; 
						  }
					 }
					 if($arr3['status']=='Inactive'){ 
						 $err = 1;
						 $errms .= "Sorry this coupon is expired now!"; 
					 } 
				 }else{
					$err = 1;
					$errms .= "Sorry invalid coupon code!<br/>";
				 }
				if(!$err){
					$dueAmount=$payres[amount]-$arr3['amount'];
					if($arr3['pinfor']=='freeshop'){
						$arr3['amount'] = $payres[amount];
						$dueAmount = 0;
					}
					
					$couponLog[voucherCode]=$_POST[voucherCode];
					$couponLog[plan_id] =$_SESSION[planID]; 
					$couponLog[voucherValue] =$arr3['amount'];
					$couponLog[status]="Reg";
					$couponLog[generatedByadmin]=0;
					$couponLog[total_amont] = $payres[amount]; 
					$couponLog[due_amount]=$dueAmount; 
					$couponLog[trans_status]="sucsess"; 
					 
					if(!$err){
						$cms->sqlquery("rs","voucher_log",$couponLog);  
						$couponreg = mysql_insert_id();
						if($arr3['validtill']=='0000-00-00'){  
							$cms->db_query("update #_gift_voucher set status='Inactive' where voucherCode ='".$cms->encryptcode($_POST[voucherCode])."' ");
						}
					}
				} 
			}
			if(!$err){
		    $city1=$cms->getSingleresult("select city from #_city where country_id='80' and pid='".$_POST[city_id]."'");  
			$city2=$cms->getSingleresult("select city from #_city where country_id='80' and pid='".$_POST[city_id2]."'");
			$_SESSION[user_name]=$_POST[user_name];
			$arr1[name] = $_POST[name];
			$arr1[user_name] = $_POST[user_name]; 
			$arr1[password] = $cms->encryptcode($_POST[password]);
			$arr1[mobile] = $_POST[mobile];
			$arr1[phone] = $_POST[phone];
			$arr1[email_id] = $_POST[email_id];
			$arr1[country_id] = $_POST[country_id];
			$arr1[city_id] = $_POST[city_id];
			$arr1[address] = $_POST[address];
			$arr1[pincode] = $_POST[pincode];
			$arr1[type] = $_SESSION[type];
			$arr1[status] = "Inactive";
		    $cms->sqlquery("rs","store_user",$arr1); 
 			$arr2[store_user_id] = mysql_insert_id();
			$arr2[title] = $_POST[title]; 
            $qry = $cms->db_query("SELECT noOfDays,amount,noOfMessage FROM #_plans_hosting where pid ='".$_SESSION[planID]."'  ");
			if(count($_POST[storekey])){
			foreach($_POST[storekey] as $val){
				$allkeys .= "$".$val;
			}
			$allkeys = $allkeys."$";
			} 
			$arr2[storekeys]  = $allkeys;
			$res = $cms->db_fetch_array($qry);
		    $arr2[noOfDays] = $res[noOfDays];
			$arr2[amount] = $res[amount];
			$toPay =$res[amount]; 
			if($couponLog[due_amount]){
				$toPay =$couponLog[due_amount]; 
			}
			$arr2[noOfMessage] = $res[noOfMessage];
			$arr2[city_id] = $_POST[city_id2];
			$arr2[store_url] = $cms->subdomain(trim($_POST[title]));
		    $arr2[store_user_id] = $cms->getSingleresult("select pid from #_store_user where user_name = '".$_SESSION[user_name]."'");
			$arr2[store_domain] = $_POST[store_domain]; 
			$arr2[Address] = $_POST[address2]; 
			$arr2[description] = $_POST[description];
			$arr2[tagline] = $_POST[tagline];
			$arr2[pincode] = $_POST[pincode2];
			$arr2[plan_id] = $_SESSION[tarifid];
			$arr2[theme] = $_SESSION[theme];
			$arr2[status] = "Inactive";
			$cms->sqlquery("rs","store_detail",$arr2);
            $last = mysql_insert_id();
			$order_id = $last.$cms->generateOrderid();
			$cms->db_query("update #_store_detail set order_id = '$order_id' where pid ='$last'  ");
			if($couponreg){
				$user_id = $cms->getSingleresult("SELECT pid FROM #_store_user where user_name='".$_POST[user_name]."' "); 
				$cms->db_query("update fz_voucher_log set user_id ='$user_id' where pid ='".$couponreg."'  ");
			}
			$store_url=$arr2[store_url];
            $cms->storeRegMail($city1,$city2,$store_url);
			$mess = "Thanks for Registring with us as ".$store_url.".fizzkart.com, your account will be activate soon. Admin";
			$number = $arr1[mobile];
			$_SESSION[mess_registration] = "Thanks for Registring with us as ".$store_url.".fizzkart.com, your account will be activate soon.";
			$cms->sendSms($number,$mess,0); 
			unset($_SESSION[theme]);
			unset($_SESSION[type]);
			unset($_SESSION[tarifid]);
			unset($_SESSION[planID]);
			unset($_SESSION[proceed]);
			unset($_SESSION[user_name]);
			if($toPay){ 
				/**************CC Avenue****************/ 
				$working_key='DB832F9427C63F7A77823DFBA8118E30';  
				$mr[merchant_id] = "49407";
				$mr[billing_name] = $_POST[name]; 
				$mr[redirect_url] = SITE_PATH."message";
				$mr[cancel_url] = SITE_PATH."message";
				$mr[order_id] = $order_id;
				$mr[amount] = $toPay;
				$mr[billing_address] =  $arr1[address];
				$mr[billing_city] =  $city1;
				$mr[billing_state] = '';
				$mr[billing_zip] = $_POST[pincode];
				$mr[billing_country] = "India";
				$mr[billing_tel] = $_POST[mobile];
				$mr[billing_email] = $_POST[email_id];
				$mr[currency] = "INR";  
				foreach ($mr as $key => $value){
					$merchant_data.=$key.'='.$value.'&';
				} 
				$_SESSION[encrypted_data] = $cms->encrypt($merchant_data,$working_key); 
				
				$red = SITE_PATH."cc";
				header("location: ".$red);	
				/**************CC Avenue****************/  
			}else{
				$red = SITE_PATH."message";
				header("location: ".$red);	
			}
			}
}
include "site/search.inc.php";

?>

<div class="row" style="margin-top:20px;">
  <div class="col-md-12 col-sm-12">
    <div class="heading col-md-3 col-sm-3">Register with us</div><br>
    <div class="subtext col-md-12 col-sm-12" style="margin-top:10px;">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum </div>
  </div>
  <div class="col-md-12 col-sm-12" style="margin-top:10px;">
    <div class="heading" style="text-align:left;color:#fff;">Plan Choosen By You :
      <?=ucfirst($_SESSION[type])?>
      /
      <?=$res2[name]?>
      for
      <?=$payres[noOfDays]?>
      Days in Rs.
      <?=$payres[amount]?>
    </div>
	
    <form class="form-horizontal" role="form" method="post" action="" onSubmit="return formvalid(this);">
      <div class="subarea">
        <div class="stepbox">Step 2</div>
        <?php					
					if($err){?>
        <p class="error_msg">
          <?=$errms?>
        </p>
        <?php
					}?>
        <div class="col-md-12 col-sm-12">
          <div class="col-md-6 col-sm-6">
          <legend>Personal Detail</legend>
          
            <div class="form-group">
				  <label for="Name" class="col-md-2 col-sm-2 control-label">Name</label>
				  <div class="col-md-10 col-sm-10">
					<input class="form-control" id="Name" type="text" name="name"  lang="RisAlpha" title="Name" value="<?=$_POST[name]?>" placeholder="Enter Your Name" />
				  </div>
			</div>
			<div class="form-group">
				  <label for="Username" class="col-md-2 col-sm-2 control-label">Username</label>
				  <div class="col-md-10 col-sm-10">
					<input type="text" id="Username" class="form-control" name="user_name"  lang="RisAlphaNum" title="Username" value="<?=$_POST[user_name]?>" id="user_name" placeholder="Choose a Username"  />
				  </div>
			</div>
            <div class="form-group">
				<span id="txtHint1">
            <?=$er?>
            </span>
			</div>
            <div class="form-group">
				  <label for="password" class="col-md-2 col-sm-2 control-label">Password</label>
				  <div class="col-md-10 col-sm-10">
					<input class="form-control" type="password" lang="R" name="password" id="password" title="password"    placeholder="Choose a Password"/>
				  </div>
			</div>
            <div class="form-group">
				  <label for="Mobile" class="col-md-2 col-sm-2 control-label">Mobile</label>
				  <div class="col-md-10 col-sm-10">
					<input type="text" class="form-control" name="mobile"  id="Mobile" lang="RisMobile"  value="<?=$_POST[mobile]?>"  title="Mobile" class="othr_flds"  placeholder="Your Mobile Number"/>
				  </div>
			</div>
			<div class="form-group">
				  <label for="Phone" class="col-md-2 col-sm-2 control-label">Phone</label>
				  <div class="col-md-10 col-sm-10">
					<input class="form-control" type="tel" name="phone" id="Phone" title="Phone"    value="<?=$_POST[phone]?>" class="othr_flds"   placeholder="Your Landline Number"/>
				  </div>
			</div>
			<div class="form-group">
				  <label for="email" class="col-md-2 col-sm-2 control-label">Email</label>
				  <div class="col-md-10 col-sm-10">
					<input class="form-control" type="email" title="Email" name="email_id" id="email" value="<?=$_POST[email_id]?>"   lang="RisEmail" class="othr_flds"   placeholder="Your Email id"/>
				  </div>
			</div>
            <div class="form-group">
					<label for="city_id222" class="col-md-2 col-sm-2 control-label">City</label>
					<?php   
								$sql_city1="select pid,city from #_city where country_id='80'";
								$sql_city1_query=$cms->db_query($sql_city1);
								?>
					<input type="hidden" name="country_id" value="80" />
					<div class="col-md-10 col-sm-10">
					<select class="form-control" lang="R" title="City"  id="city_id222" name="city_id">
					  <option value="">Select</option>
					  <?php while($city_array=$cms->db_fetch_array($sql_city1_query)){?>
					  <option value="<?=$city_array['pid']; ?>" <?php if($_POST[city_id]==$city_array[pid]){echo 'selected="selected"';} ?> ><?php echo $city_array['city']; ?></option>
					  <?php }?>
					</select>
					</div>
			</div>
            <div class="form-group">
				  <label for="address" class="col-md-2 col-sm-2 control-label">Address</label>
				  <div class="col-md-10 col-sm-10">
					<textarea class="form-control" name="address" lang="R" title="Address" id="address" placeholder="Address"><?=$_POST[address]?></textarea>
				  </div>
			</div>
            <div class="form-group">
				  <label for="textfield7" class="col-md-2 col-sm-2 control-label">Pin Code</label>
				  <div class="col-md-10 col-sm-10">
					<input class="form-control" type="text" value="<?=$_POST[pincode]?>" lang="RisNaN" title="Address Pin Code" name="pincode" id="textfield7" class="othr_flds"   placeholder="Pin Code "/>
				  </div>
			</div>
     
          </div>
          <div class="col-md-6 col-sm-6">
          <legend>Store Detail</legend>
			<div class="form-group">
				  <label for="store_name" class="col-md-2 col-sm-2 control-label">Title</label>
				  <div class="col-md-10 col-sm-10">
					<input class="form-control" type="text" name="title" title="<?=ucfirst($_SESSION[type])?> Name"  value="<?=$_POST[title]?>" id="store_name" placeholder="<?=ucfirst($_SESSION[type])?> Title"/>
				  </div>
			</div>
			<div class="form-group">
				  <label for="tagline" class="col-md-2 col-sm-2 control-label">Tag Line</label>
				  <div class="col-md-10 col-sm-10">
					<input class="form-control" type="text"  name="tagline"  title="Tag Line" id="tagline" value="<?=$_POST[tagline]?>"   placeholder="Tag Line"/>
				  </div>
			</div>
			<div class="form-group">
				  <label for="storekey" class="col-md-2 col-sm-2 control-label">Define Your Store</label>
				  <div class="col-md-10 col-sm-10">
					<select multiple class="form-control" name="storekey[]" style="height:70px;" required class="txt medium" id="storekey"  title="Storekey">
					  <?php $rsAdmin=$cms->db_query("select pid,keywords from #_storekey where status='Active'");
											  while($arrAdmin=$cms->db_fetch_array($rsAdmin)){@extract($arrAdmin);
											  ?>
					  <option value="<?=$keywords?>" <?=(@in_array($keywords,$_POST[storekey])?'selected="selected"':'')?>>
					  <?=$keywords?>
					  </option>
					  <?
											   }?>
					</select>
				  </div>
			</div>
            <div class="form-group">
				  <label for="store_url" class="col-md-2 col-sm-2 control-label">Store Url</label>
				  <div class="col-md-10 col-sm-10">
					<input class="form-control" type="text"  disabled="disabled" value="<?=$cms->subdomain(trim($_POST[title]))?>.fizzkart.com"   id="store_url" name="store_url"  placeholder="Store Url"/>
				  </div>
			</div>
			<div class="form-group">
				  <label for="store_domain" class="col-md-2 col-sm-2 control-label">Own Domain</label>
				  <div class="col-md-10 col-sm-10">
					<input class="form-control" type="text"  value=""   id="store_domain" name="store_domain"  placeholder="Please enter your own domain if you have"/>
				  </div>
			</div>
			<div class="form-group">
				  <label for="textarea" class="col-md-2 col-sm-2 control-label">Description</label>
				  <div class="col-md-10 col-sm-10">
					<textarea class="form-control" name="description" id="textarea" placeholder="Description"><?=$_POST[description]?></textarea>
				  </div>
			</div>
            <div class="form-group">
				  <label for="city_id2" class="col-md-2 col-sm-2 control-label">City</label>
				  <?php   
								  $sql_city1="select pid,city from #_city where country_id='80'";
								  $sql_city1_query=$cms->db_query($sql_city1);
								?>
				  <input type="hidden" name="country_id" value="80" />
				  <div class="col-md-10 col-sm-10">
					<select class="form-control"  lang="R" title="City" <?php if($_SESSION[type]!='brand'){?> id="city_id2" <?php }?> name="city_id2">
					  <option value="">Select</option>
					  <?php while($city_array=$cms->db_fetch_array($sql_city1_query)){?>
					  <option value="<?=$city_array['pid']?>" <?=($_POST[city_id2]==$city_array['pid'])?'selected="selected"':''?>><?php echo $city_array['city']; ?></option>
					  <?php }?>
					</select>
				  </div>
			</div>
			<div class="form-group">
            <span id="marketDiv2"></span>
			</div>
			<div class="form-group">
				<label for="textarea1" class="col-md-2 col-sm-2 control-label">Address</label>
				  <div class="col-md-10 col-sm-10">
					<textarea class="form-control" name="address2" id="textarea1"  placeholder="Address"><?=$_POST[address2]?></textarea>
				  </div>
			</div>
			<div class="form-group">
				<label for="pcode" class="col-md-2 col-sm-2 control-label">Pin Code</label>
				  <div class="col-md-10 col-sm-10">
					<input class="form-control" type="text" id="pcode" value="<?=$_POST[pincode2]?>" lang="RisNaN" title="Store Pin Code" name="pincode2"    placeholder="Pin Code"/>
				  </div>
			</div>
            <div class="form-group">
			  <div class="col-md-offset-2 col-md-10 col-sm-offset-2 col-sm-10">
				 <div class="checkbox">
					<label>
					   <input type="checkbox" name="vaucher" value="1"  <?=($regMode=='coupon')?'checked':''?>  id="vaucher"/> Do You Have Vaucher Coupon 
					</label>
				 </div>
			  </div>
		    </div>
			<div class="form-group">
			  <div class="col-md-offset-2 col-md-10 col-sm-offset-2 col-sm-10">
			  <div class="renew_submit-div3" id="renew_submit-div3" <?=($regMode=='coupon')?'':'style="display:none"'?>>
				<div class="field_div">
				  <div class="autoUpdate">
					<input type="text" name="voucherCode" value=""  id="vaucher_copon" placeholder="Enter Your Voucher Code here" />
					<span id="txtHint2">
					<?=$er?>
					</span></div>
				</div>
				<div class="status_div" style="clear: both;"> </div>
				<div class="discount_allow-div" id="dis-calc"> </div>
			  </div>
			  </div>
			</div>
          </div>
          <div class="form-group">
			  <div class="col-md-offset-5 col-md-5 col-sm-offset-5 col-sm-5">
				 <input type="submit" name="submit" id="button"  value="Submit" class="proceedbtn" />
			  </div>
		   </div>
          
        </div>
      </div>
    </form>
  </div>
</div>
<?php
$metaIntro = "Plan Choosen By You : ".ucfirst($_SESSION[type])."/".$res2[name]." for ".$payres[noOfDays]." Days in Rs. ".$payres[amount];

?>
