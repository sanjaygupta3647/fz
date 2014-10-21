<?php  
$metaTitle = "Fizzkart Registration Store ans Personal info";
$metaKeyword = "Fizzkart Message,Fizzkart, Message";
 
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
				$errms .= "User name  '".$_POST['user_name']."'  is already registeredn with us!";
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
			$qry_var = $cms->db_query("SELECT voucherCode,amount,pid FROM #_gift_voucher where voucherCode ='".$cms->encryptcode($_POST[voucherCode])."' ");
			$arr3 = $cms->db_fetch_array($qry_var);
		    $voucher=$cms->decryptcode($arr3[voucherCode]); 
			if($voucher==$_POST[voucherCode]){
			$user = $cms->db_query("SELECT pid FROM #_store_user where user_name='".$_POST[user_name]."' ");
			$data = $cms->db_fetch_array($user);
			$arr3[voucherCode]=$arr3[voucherCode];
			$arr3[plan_id] =$_SESSION[planID];
			$arr3[user_id] =$data[pid];
			$arr3[coupon_amount] =$arr3[amount];
			$arr3[amount] =$arr3[amount];
			$arr3[status]="Reg";
			$arr3[trans_status]="sucsess";
			$arr3[due_amount]=$res[amount]-$arr3[amount]; 
			$cms->sqlquery("rs","voucher_log",$arr3); 
			$cms->db_query("update #_gift_voucher set status='Inactive' where voucherCode ='".$cms->encryptcode($_POST[voucherCode])."' ");
				  } 
			$user = $cms->db_query("SELECT plan_id FROM #_store_detail where store_user_id='".$arr3[user_id]."' ");
			$data = $cms->db_fetch_array($user);			 
			$arr3[plan_id] =$_SESSION[planID];
			$arr3[type]="reg";
			$arr3[coupon_id] =$arr3[pid];	  
		    $arr3[total_amount] = $res[amount];
		    $cms->sqlquery("rs","reg_renewal",$arr3);
			$cms->sqlquery("rs","renewal_sms",$arr3);
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
				$_POST = false;
				$red = SITE_PATH."message";
				header("location: ".$red);				 
			}
}
include "site/search.inc.php";

?>
 
<div class="contentarea">
        	<div class="registerheadbox">
            	<div class="heading"><img src="images/heading-arrow-icon.jpg" width="11" height="7" alt="Register with us" /> Register with us</div>
                <div class="subtext">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum </div>
            </div>
            <div class="registerarea">
				<?php
			$qry = $cms->db_query("SELECT noOfDays,amount FROM `#_plans_hosting` where pid ='".$_SESSION[planID]."'  ");
			$res = $cms->db_fetch_array($qry);	

			$sql=$cms->db_query("select name from #_plans  where status='Active' and pid = '".$_SESSION[tarifid]."'");
			$res2 = $cms->db_fetch_array($sql);	
					 
			?>
            	<div class="heading">Plan Choosen By You : <?=ucfirst($_SESSION[type])?>/<?=$res2[name]?> for <?=$res[noOfDays]?> Days in Rs. <?=$res[amount]?></div>
				<form method="post" action="" onSubmit="return formvalid(this);">
                <div class="subarea">
                	<div class="stepbox">Step 2</div><?php					
					if($err){?>
						<p class="error_msg"><?=$errms?></p>
					<?php
					}?> 
                    <div class="registerbox">
                    	<fieldset>
                        	<legend>Personal Detail</legend>
                            <div class="formarea">
                            	<label>Name</label>
                                <input type="text" name="name"  lang="RisAlpha" title="Name" value="<?=$_POST[name]?>" placeholder="Enter Your Name" />
                                <label>Username</label>
                                <input type="text" name="user_name"  lang="RisAlphaNum" title="Username" value="<?=$_POST[user_name]?>" id="user_name"   placeholder="Choose a Username"  />
								<span id="txtHint1"><?=$er?></span>
                                <label>Password</label>
                                <input type="password" lang="R" name="password" id="password" title="password"    placeholder="Choose a Password"/>
                                <label>Mobile</label>
                                <input type="text" name="mobile"  id="Mobile" lang="RisMobile"  value="<?=$_POST[mobile]?>"  title="Mobile" class="othr_flds"  placeholder="Your Mobile Number"/>
                                <label>Phone</label>
                                <input type="tel" name="phone" id="" title="Phone"    value="<?=$_POST[phone]?>" class="othr_flds"   placeholder="Your Landline Number"/>
                                <label>Email</label>
                                <input type="email" title="Email" name="email_id" id="email" value="<?=$_POST[email_id]?>"   lang="RisEmail" class="othr_flds"   placeholder="Your Email id"/>
                                <label>City</label>
								<?php   
								$sql_city1="select pid,city from #_city where country_id='80'";
								$sql_city1_query=$cms->db_query($sql_city1);
								?>
								<input type="hidden" name="country_id" value="80" />
                                 <select  lang="R" title="City"  id="city_id222" name="city_id">
									<option value="">Select</option>
									<?php while($city_array=$cms->db_fetch_array($sql_city1_query)){?>
									<option value="<?=$city_array['pid']; ?>" <?php if($_POST[city_id]==$city_array[pid]){echo 'selected="selected"';} ?> ><?php echo $city_array['city']; ?></option>
									<?php }?>
								 </select>
                              	<label>Address</label>
                                <textarea name="address" lang="R" title="Address" id="address" placeholder="Address"><?=$_POST[address]?></textarea>
                                <label>Pin Code</label>
                                <input type="text" value="<?=$_POST[pincode]?>" lang="RisNaN" title="Address Pin Code" name="pincode" id="textfield7" class="othr_flds"   placeholder="Pin Code "/>
                            </div>
                        </fieldset> 
                        <fieldset>
                        	<legend>Store Detail</legend>
                            <div class="formarea">
                            	<label>Title</label>
                                <input type="text" name="title" title="<?=ucfirst($_SESSION[type])?> Name"  value="<?=$_POST[title]?>" id="store_name"   placeholder="<?=ucfirst($_SESSION[type])?> Title"/>
                                <label>Tag Line</label>
                                <input type="text"  name="tagline"  title="Tag Line" id="tagline" value="<?=$_POST[tagline]?>"   placeholder="Tag Line"/>


								<label>Define Your Store</label> 
								<select name="storekey[]" multiple style="height:70px;" required class="txt medium" id="storekey"  title="Storekey"> 
									  <?php $rsAdmin=$cms->db_query("select pid,keywords from #_storekey where status='Active'");
									  while($arrAdmin=$cms->db_fetch_array($rsAdmin)){@extract($arrAdmin);
									  ?>
												  <option value="<?=$keywords?>" <?=(@in_array($keywords,$_POST[storekey])?'selected="selected"':'')?>>
												  <?=$keywords?>
												  </option>
												  <?
									   }?>
								</select> 
                                <label>Store Url</label>
                                <input type="text"  disabled="disabled" value="<?=$cms->subdomain(trim($_POST[title]))?>.fizzkart.com"   id="store_url" name="store_url"  placeholder="Store Url"/>
							  	
							 
							  <label>Own Domain</label>
                              <input type="text"  value=""   id="store_domain" name="store_domain"  placeholder="Please enter your own domain if you have"/>

                              <label>Description</label>
                                <textarea name="description" id="textarea" placeholder="Description"><?=$_POST[description]?></textarea>
                                <label>City</label>
                                <?php   
								  $sql_city1="select pid,city from #_city where country_id='80'";
								  $sql_city1_query=$cms->db_query($sql_city1);
								?>
							  <input type="hidden" name="country_id" value="80" />
							  <select   lang="R" title="City" <?php if($_SESSION[type]!='brand'){?> id="city_id2" <?php }?> name="city_id2">
								<option value="">Select</option>
								<?php while($city_array=$cms->db_fetch_array($sql_city1_query)){?>
								<option value="<?=$city_array['pid']?>" <?=($_POST[city_id2]==$city_array['pid'])?'selected="selected"':''?>><?php echo $city_array['city']; ?></option>
								<?php }?>
							  </select>
							    <span id="marketDiv2"></span>
                              	<label>Address</label>
                                <textarea name="address2" id="textarea"  placeholder="Address"><?=$_POST[address2]?></textarea>
                                <label>Pin Code</label>
                                <input type="text" value="<?=$_POST[pincode2]?>" lang="RisNaN" title="Store Pin Code" name="pincode2"    placeholder="Pin Code"/> 
                            </div> 
			           <input type="checkbox" name="vaucher"   id="vaucher"/> <label>Do You Have Vaucher Coupon </label>
					<div class="renew_submit-div3" id="renew_submit-div3" style="display:none">
    <div class="field_div">
     <div class="autoUpdate"> <input type="text" name="voucherCode" value=""  id="vaucher_copon" placeholder="Enter Your Voucher Code here" /><span id="txtHint2"><?=$er?>  </span></div>  
      
      </div>
      <div class="validate_div" style="display:none"> <a href="Javascript:void(0)">Validate Coupon</a> </div>
      <div class="status_div">
	    
	    <p class="red_p1 cpn" style="display:none;"> Coupon Allrady Used!</p>
        <p class="red_p cpn" style="display:none;">Invalid Coupon Code!</p>
        <p class="green_p cpn" style="display:none;">Valid Coupon Code!</p>
      </div> 
      <div class="discount_allow-div" id="dis-calc"> 
      </div> <br />
     <p id="defaltshow">Payable Amount = Rs.<?= $res[amount]?> /-</p></div>
                        </fieldset>
                        <div class="blankspace">&nbsp;</div>
                        <input type="submit" name="submit" id="button"  value="Submit" class="proceedbtn" /> 
                    </div>
                </div>
				</form>
            </div>
        </div>
<?php
$metaIntro = "Plan Choosen By You : ".ucfirst($_SESSION[type])."/".$res2[name]." for ".$res[noOfDays]." Days in Rs. ".$res[amount];

?>