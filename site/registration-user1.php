<?php  
if($cms->is_post_back()){	
		 if($_POST[password]!=$_POST[repassword]){
		 $er= '<p align="left" style="color:red; margin:10px 0; display:block; ">Password does not match!</p>'; 
		 }else{
		 $rsAdmin=$cms->db_query("select email from #_members where email='".$_POST[email]."'");
	     if(!mysql_num_rows($rsAdmin)){	
		$cms->sqlquery("rs","members",$_POST);
 		$lastId  = mysql_insert_id();
		$er= '<p align="left" style="color:green; margin:10px 0; display:block; " >Thank you for successful registration.</p>';
		$_POST = false; 
		}else{
			$er= '<p align="left" style="color:red; margin:10px 0; display:block; " >This email id is already exist!</p>'; 
		}
		}
}
?>

<div class="body" >
  <div class="border_box" >   
    <div class="border_box2" >
      <div class="form_textfilld1"> 
	  <?=$er?>
        <form id="create-post-form" method="post" action="" onSubmit="return formvalid(this);" >
          <div class="text_inn_cat">Fizzkart User Registration</div>
          <ul>
            <li class="form_textfilld1">Name:
              <input class="login_text_fild" type="text" name="name" id="" title="Name" lang="R" value="<?=$_POST[name]?>" rel="Enter Name">
            </li>
			<li class="form_textfilld1">Email :
              <input class="login_text_fild" type="text" title="Email" name="email" id="email" value="<?=$_POST[email]?>"   lang="RisEmail" >
            </li>
			<li class="form_textfilld1">Password :
              <input class="login_text_fild" type="password"  name="password"  title="Password" lang="R" id="" value="">
            </li>
			 <li class="form_textfilld1">Re-enter Password :
              <input class="login_text_fild" type="password" name="repassword"  title="Repassword" lang="R" id="" value="">
            </li>
            <li class="form_textfilld1">Phone:
              <input class="login_text_fild" type="text" name="phone"  id="Mobile" lang="R" value="<?=$_POST[phone]?>"  title="Phone">
            </li> 
            <li class="form_textfilld1">City :
              <?php  $sql_city1="select pid,city from #_city where country_id='80'";
	  $sql_city1_query=$cms->db_query($sql_city1);
	  ?>
              <input type="hidden" name="country_id" class="login_text_fild" value="80" />
               
              <select class="login_text_fild" lang="R" title="City" name="city_id" >
                <option value="">Select</option>
                <?php while($city_array=$cms->db_fetch_array($sql_city1_query)){  ?>
                <option value="<?php echo $city_array['pid']; ?>" <? if($_POST[city_id]==$city_array['pid'])echo 'selected="selected"'; ?>><?php echo $city_array['city']; ?></option>
                <?php }?>
              </select>
            </li>
			
			 <li class="form_textfilld1">State:
              <input class="login_text_fild" type="text" name="state"  id="State" lang="R" value="<?=$_POST[state]?>"  title="State">
            </li>
			
            <li class="form_textfilld1">Address :
              <textarea class="login_text_fild" id=""  name="address"><?=$_POST[address]?>
</textarea>
            </li>
            <li class="form_textfilld1">Pincode :
              <input class="login_text_fild " type="text" name="zipcode" id="" value="<?=$_POST[zipcode]?>" >
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
