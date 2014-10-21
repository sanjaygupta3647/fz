<?php 
if($cms->is_post_back()){	
		 $rsAdmin=$cms->db_query("select user_name from #_store_user where user_name='".$_POST[user_name]."'");
	     if(!mysql_num_rows($rsAdmin)){	
		 $_POST['status'] = 'Inactive';
		$cms->sqlquery("rs","store_user",$_POST);
		$cms->sessset('Record has been added', 's');
		$_SESSION[lastId]  = mysql_insert_id();
		}else{
			$er= '<p align="left" style="color:red; margin:10px 0; display:block; " >This user name is already exist!</p>'; 
		}
}
?>

<div class="body" >
  <div class="border_box" >   
    <div class="border_box2" >
      <div class="form_textfilld1">
        <? if($_SESSION[lastId]>0){?>
        <p style="color:#009900; padding-bottom:100px;">Please <a href="<?=SITE_PATH?>registration-store" >click here</a> to create your store</p>
        <? }?>
        <form id="create-post-form" method="post" action="" onSubmit="return formvalid(this);" <? if($_SESSION[lastId]>0){?> style="display:none;" <? }?> >
          <div class="text_inn_cat">Store/Brand Registration </div>
          <ul>
            <li class="form_textfilld1">Name:
              <input class="login_text_fild" type="text" name="name" id="" title="Name" lang="R" value="<?=$_POST[name]?>" rel="Enter Name">
            </li>
            <li class="form_textfilld1">Mobile:
              <input class="login_text_fild" type="text" name="mobile"  id="Mobile" lang="R" value="<?=$_POST[mobile]?>" rel="Enter Your Mobile No" title="Mobile">
            </li>
            <li class="form_textfilld1">Phone :
              <input class="login_text_fild" type="text" name="phone" id="" title="Telephone" lang="R"  value="<?=$_POST[phone]?>" >
            </li>
            <li class="form_textfilld1">Email :
              <input class="login_text_fild" type="text" title="Email" name="email_id" id="email" value="<?=$_POST[email_id]?>"   lang="RisEmail" >
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
            <li class="form_textfilld1">Address :
              <textarea class="login_text_fild" id=""  name="address"><?=$_POST[address]?>
</textarea>
            </li>
            <li class="form_textfilld1">Pincode :
              <input class="login_text_fild " type="text" name="pincode" id="" value="<?=$_POST[pincode]?>" >
            </li>
			<li class="form_textfilld1">Username :
              <input class="login_text_fild " type="text" name="user_name" id="user_name" title="User" lang="R" value="<?=$_POST[user_name]?>" >
			  <p id="txtHint1" style="float:right;">
              <?=$er?>
              </p>
            </li> 
            <li class="form_textfilld1">User Type :
              <select class="login_text_fild" id="type" name="type">
                <option value="store" <?php if($_POST['type']=='store'); echo 'selected = "selected"' ?>>Store User</option>
                <option value="brand"<?php if($_POST['type']=='brand'); echo 'selected = "selected"' ?>>Brand</option>
                <option value="brand-store"<?php if($_POST['type']=='brand-store'); echo 'selected = "selected"' ?>>Brand cum Store</option>
              </select>
            </li>
            <li class="form_textfilld1">Password :
              <input class="login_text_fild" type="password" name="password"  title="Password" lang="R" id="" value="" rel="Enter Password!">
            </li>
            <li style="display:none" class="form_textfilld1">Website :
              <input class="login_text_fild"  type="text" name="website" id="" value="<?=$_POST[website]?>" >
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
