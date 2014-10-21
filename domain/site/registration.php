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

<div class="container" style="padding-left:20px;" > 
 <?=$er?>
  <form  method="post" action="" onSubmit="return formvalid(this);"  >
  <input type="hidden" name="store_id" value="<?=$store_id?>" />
    <!-----own  Form-->
    <div class="single_form_element">
      <label class="label" for="">Name:</label>
      <div class="label">
        <input class="input_border input_width required" type="text" name="name" id="" title="Name" lang="R" value="<?=$_POST[name]?>" rel="Enter Name">
        <span></span></div>
    </div>
	
	<div class="single_form_element">
      <label class="label" for="">Email</label>
      <div class="label">
        <input class="input_border input_width required" type="text" title="Email" name="email" id="email" value="<?=$_POST[email]?>"   lang="RisEmail" >
        <span></span></div>
    </div>
	<div class="single_form_element">
      <label class="label" for="">Password:</label>
      <div class="label">
        <input class="input_border input_width required" type="password" title="Password" name="password" id="password" value="" lang="R" >
        <span></span></div>
    </div>
	
	<div class="single_form_element">
      <label class="label" for="">Re-enter Password:</label>
      <div class="label">
        <input class="input_border input_width required" type="password" title="Re-enter password" name="repassword" id="repassword" value="" lang="R" >
        <span></span></div>
    </div>
	 
    <div class="single_form_element">
      <label class="label" for="">Phone</label>
      <div class="label">
        <input class="input_border input_width" type="text" name="phone"   title="Phone" lang="R"  value="<?=$_POST[phone]?>" >
        <span></span></div>
    </div>
    
    <div class="single_form_element select_upload"> 
      <label class="label" for="">City :</label>
      <?php  $sql_city1="select pid,city from #_city where country_id='80'";
	  $sql_city1_query=$cms->db_query($sql_city1);
	  ?>
	  <input type="hidden" name="country_id" value="80" />
	  <div class="label">
      <select class="nonzero select input_border" lang="R" title="City" name="city" >
        <option value="">Select</option>
        <?php while($city_array=$cms->db_fetch_array($sql_city1_query)){  ?>
        <option value="<?php echo $city_array['city']; ?>" <? if($_POST[city]==$city_array['city'])echo 'selected="selected"'; ?>><?php echo $city_array['city']; ?></option>
        <?php }?>
      </select>
    </div> 
	 <div class="single_form_element">
      <label class="label" for="">State</label>
      <div class="label">
        <input class="input_border input_width" type="text" name="state"   title="state" lang="R"  value="<?=$_POST[state]?>" >
        <span></span></div>
    </div>
    <div class="single_form_element"> 
      <label class="label" for="">Address :</label>
	  <div class="label">
      <textarea class="input_border input_width" id=""  name="address"><?=$_POST[address]?></textarea>
    </div>
    <div class="single_form_element">
      <label class="label" for="">Zipcode</label>
      <div class="label">
        <input class="input_border " type="text" name="zipcode" title="Zipcode" lang="R" value="<?=$_POST[zipcode]?>" >
        <span></span></div>
    </div> 
    
    <div class="single_form_submit" style=" margin:50px 0px 0px 100px;">
      <input type="submit" class="sub_but" name="submit" id="btnShowSimple" value="Submit" onClick="">
    </div>
  </form>
</div>
