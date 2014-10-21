<?php
$type = $cms->getSingleresult("select type from #_store_user where pid = '".$_SESSION[lastId]."'"); 

if($cms->is_post_back()){ 
		 
	if(!$checkbrand){ 
 	if($_POST[marketname]!=""){ 
			$arr[country_id] = 80;
			$arr[city_id] = $_POST[city_id]; 
			$arr[market_name] = $_POST[marketname];
			//$cms->sqlquery("rs","market",$arr);
			$_POST[market_id] = mysql_insert_id();
			$_POST[city_id]=$arr[city_id] ;
		}	
		$check = $cms->db_query("select pid from #_store_detail where title = '".$_POST['title']."'  ");
		if(!mysql_num_rows($check)){ 			 
				$_POST[store_url] = $adm->baseurl($_POST['title']);
				$qry = $cms->db_query("SELECT noOfDays,amount FROM `#_plans_hosting` where pid ='".$_POST[planID]."'  ");
				$res = $cms->db_fetch_array($qry);
				$_POST[noOfDays] =  $res[noOfDays];
				$_POST[amount] =  $res[amount];
				$cms->sqlquery("rs","store_detail",$_POST);
				$cms->sessset('Record has been added', 's'); 
				$last_stotrId  = mysql_insert_id();				 
				session_unset($_SESSION[lastId]);
		}
		else{
			echo "<script>alert('This store is already registered')</script>";
		}
	}
}
?>

<div class="body" >
  <div class="border_box" style="height:770px;" >
    <div class="border_box2" >
      <div class="form_textfilld1" >
        <?php if($last_stotrId){?>
        <p style="color:#009900; padding-bottom:100px;">Your store has been successfully created, Please contact to administer for login.</p>
        <?php 
		}?>
        <form action="" method="post" onSubmit="return formvalid(this);"  name="myForm" <? if($last_stotrId){?> style="display:none;" <? }?>>
          <input type="hidden" name="store_user_id" value="<?=$_SESSION[lastId]?>"  />
          <div class="text_inn_cat" style="width:400px;">Store/Brand Registration</div>
          <ul >
		  <li class="form_textfilld1">Store/Brand Name:
              <input class="login_text_fild " type="text"   lang="R" name="title" title="Store/Brand" id="store_name" value="<?=$_POST['title']?>" >
            </li>
            
            <li class="form_textfilld1">Available Tarif Plans for
              <?=ucfirst($type)?>
              :<br />
			  <select name='plan_id' class="plan_id" lang="Plan">
			  <option>---Select Tarif Plan---</option>
              <?php  
		$sql=$cms->db_query("select * from #_plans  where status='Active' and type = '$type'"); 
		while($result=$cms->db_fetch_array($sql))
		{  
			?><option value="<?php echo $result['pid']?>"><?=$result['name']?></option><?php  
        }
	   ?>
	   </select>
            </li>
			<li><div id="tarifplan"></div><br/>
			<a style="display:none;" id="tarifdetail" href="<?=SITE_PATH?>ms_file/tarif-detail/<?=$items[2]?>" rel="popuprel" class="inline_popup" w='400px' h='950px'>View More Detail</a></li>
            <li class="form_textfilld1">Store Url: 
              <input class="login_text_fild" type="text" disabled="disabled"   id="store_url" name="store_url" id="website" value="<?=$_POST[store_url]?>" title="Store Url" > 
            </li>
            <li class="form_textfilld1">Theme :
              Domain:
              <input type="radio" name="theme" value="domain" />
              &nbsp;&nbsp;&nbsp; store_theme_white:
              <input type="radio" name="theme" value="store_theme_white" />
            </li>
            <li class="form_textfilld1">Description :
              <textarea class="login_text_fild" id="" name="description" rows="3"><?=$_POST[description]?>
</textarea>
            </li>
            <li class="form_textfilld1">City :
              <?php   
	  		  $sql_city1="select pid,city from #_city where country_id='80'";
			  $sql_city1_query=$cms->db_query($sql_city1);
	  ?>
              <input type="hidden" name="country_id" value="80" />
              <select class="login_text_fild" lang="R" title="City"  id="city_id2" name="city_id">
                <option value="">Select</option>
                <?php while($city_array=$cms->db_fetch_array($sql_city1_query)){?>
                <option value="<?php echo $city_array['pid']; ?>"><?php echo $city_array['city']; ?></option>
                <?php }?>
              </select>
            </li>
            <li class="form_textfilld1">Market :
              <span class="label" id="marketDiv2">
                <select name="market_id" id="txtHint1" class="login_text_fild">
                </select>
              </span>
             
              
            </li>
			<li class="form_textfilld1"> Othet:
              <input type="checkbox" id="other_id" style="margin-top:10px;" />
              <br />
              <input type="text" name="marketname"  id="marketname" value="<?=$marketname?>" class="login_text_fild" style="display:none; margin-top:10px;" />
            </li>
            <li class="form_textfilld1">Address :
              <input class="login_text_fild " type="text" name="user_name" id="user_name" title="User"   value="<?=$_POST[user_name]?>" >
            </li>
            <li class="form_textfilld1">
              <input name="Submit" type="submit" id="store-brand-reg" class="login_button" value="Register">
            </li>
          </ul>
        </form>
      </div>
    </div>
  </div>
</div>
