<?php  
$metaTitle = $cms->getSingleresult("select meta_title from #_meta_info where url='profile-edit' and store_user_id = '$current_store_user_id'");
$metaIntro = $cms->getSingleresult("select meta_description from #_meta_info where url='profile-edit' and store_user_id = '$current_store_user_id'");
$metaKeyword = $cms->getSingleresult("select meta_keyword from #_meta_info where url='profile-edit' and store_user_id = '$current_store_user_id'");
if(!$_SESSION[userid]){ 
$redpath = SITE_PATH;
$cms->redir($redpath,true);die;
}
if($cms->is_post_back()){	 
 		$cms->sqlquery("rs","members",$_POST,'pid',$_SESSION[userid]);
		$er= '<p align="left" style="color:green; margin:10px 0; display:block; " >Your profile has been updated successful.</p>'; 
		}
 
$rsAdmin2=$cms->db_query("select * from #_members where pid='".$_SESSION[userid]."'");
$result=$cms->db_fetch_array($rsAdmin2);
extract($result);
?>
<div  class="profile_tabs">
 <?php include "user-tabs.php";  ?> 
 <div class="selected">
 <form  method="post" action="" onSubmit="return formvalid(this);"  >
 <table border="0" style="float: left;" class="CSSTableGenerator">
 <tr><td colspan="2"><h1>Edit Your Profile</h1></td></tr>
 <?php
	if($er){?>
		<tr><td colspan="2"><?=$er?></td></tr>
	<?php
	}
 ?>
 <tr><td width="15%">First Name :</td><td><input class="othr_flds" type="text" name="fname" id="" title="First Name" lang="R" value="<?=$fname?>"></td></tr>
 <tr><td>Last Name :</td><td><input class="othr_flds" type="text" name="lname" id="" title="Last Name" lang="R" value="<?=$lname?>"></td></tr>
 <tr><td>Email :</td><td><input class="othr_flds" type="text" name="email" id="" title="Email" lang="RisEmail" value="<?=$email?>"></td></tr>
 <tr><td>Mobile :</td><td><input class="othr_flds" type="text" name="mob" id="" title="Mobile" lang="R" value="<?=$mob?>"></td></tr>
 <tr><td>City :</td><td>
				<?php  $sql_city1="select pid,city from #_city where country_id='80'";
				$sql_city1_query=$cms->db_query($sql_city1);
				?>
               <select class="othr_flds" lang="R" title="City" name="city" style="float:left;height:30px;width:250px;margin-left: 0px;color: black;" >
                <option value="">Select</option>
                <?php while($city_array=$cms->db_fetch_array($sql_city1_query)){  ?>
                <option value="<?=$city_array['city']?>" <? if($_POST[city]==$city_array['city'] ||$city==$city_array['city'])echo 'selected="selected"'; ?>><?php echo $city_array['city']; ?></option>
                <?php }?>
              </select></td></tr>
 <tr><td>State :</td><td> <input list="browsers" name="state" value="<?=$state?>" lang="R" title="State" class="othr_flds" placeholder="Type Your State Here">
        
        <datalist id="browsers">
          <option value="Uttar Pradesh">
          <option value="Maharashtra">
          <option value="Bihar">
          <option value="West Bengal">
          <option value="Andhra Pradesh">
          <option value="Madhya Pradesh">
          <option value="Tamil Nadu">
          <option value="Rajasthan">
          <option value="Karnataka">
		  <option value="Gujarat">
		  <option value="Odisha">
		  <option value="Kerala">
		  <option value="Jharkhand">
		  <option value="Assam">
		  <option value="Punjab">
		  <option value="Chhattisgarh">
		  <option value="Haryana">
		  <option value="Jammu and Kashmir">
		  <option value="Uttarakhand">
		  <option value="Himachal Pradesh">
		  <option value="Tripura">
		  <option value="Meghalaya">
		  <option value="Manipur">
		  <option value="Nagaland">
		  <option value="Goa">
		  <option value="Arunachal Pradesh">
		  <option value="Mizoram">
		  <option value="Sikkim">
		  <option value="Delhi">
		  <option value="Puducherry">
		  <option value="Chandigarh">
		  <option value="Andaman and Nicobar Islands">
		  <option value="Dadra and Nagar Haveli">
		  <option value="Daman and Diu">
		  <option value="Lakshadweep">  
        </datalist></td></tr>
 <tr><td>Address :</td><td><textarea name="address" lang="R" title="Address" id="textarea" cols="5" rows="4" class="area_regadress" placeholder="Your Address"><?=stripslashes($address)?></textarea></td></tr>
 <tr><td>Zipcode :</td><td><input type="text" name="zipcode" lang="R" title="Pin Code" id="textfield7" class="othr_flds" value="<?=$zipcode?>"  placeholder="Pin Code"/></td></tr>
 <?php $redpath = SITE_PATH."profile_edit"; ?>
 <tr><td>&nbsp</td><td> <input type="submit" name="button" id="button" value="Save" class="sub_regbtn"/></td></tr>
 </table>
</form>
 
  </div> 	  
 </div>
 