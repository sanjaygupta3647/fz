<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php 
if($cms->is_post_back()){
	if($updateid){
		if(mysql_num_rows($rsAdmin=$cms->db_query("select * from #_members where email='".$email."' and pid!='".$updateid."'"))){
		$_POST['password']=$cms->encryptcode($_POST['password']);
	    $cms->sqlquery("rs","members",$_POST,'pid',$updateid);
		$adm->sessset('Record has been updated', 's');
		//$cms->redir($cms->curPageURL(), true);
		}else{
			$adm->sessset('User already exist','e');
		}
	} else {
		if(!mysql_num_rows($rsAdmin=$cms->db_query("select * from #_store_user where email='".$email."'"))){
			$_POST[submitdate] = time();
			$cms->sqlquery("rs","members",$_POST);
			$adm->sessset('Record has been added', 's');
			///$cms->redir($cms->curPageURL(), true);
		} else {
			$adm->sessset('User already exist', 'e');
		}
	}	
	
	if(isset($_GET['start']) && $_GET['start'] >0) {
		$path = SITE_PATH_MEM.CPAGE."/index.php?start=".$_GET['start'];
	} else {
		$path = SITE_PATH_MEM.CPAGE;
	}
	$cms->redir($path, true);
	
}
if(isset($id)){
	$rsAdmin=$cms->db_query("select * from #_members where pid='".$id."'");
	$arrAdmin=$cms->db_fetch_array($rsAdmin);
	@extract($arrAdmin);
}
?>
 
  <table width="100%" border="0" align="left" cellpadding="4" cellspacing="1" class="frm-tbl2">
  <tr  class="grey_">
      <td width="25%"  class="label">First Name:<span>*</span></td>
      <td width="75%"><input type="text" name="fname" class="txt medium"  lang="R" title="First Name" value="<?=$fname?>" /></td>
    </tr>
    <tr  class="grey_">
      <td width="25%"  class="label">Last Name:<span>*</span></td>
      <td width="75%"><input type="text" name="lname" class="txt medium"  lang="R" title="Last Name" value="<?=$lname?>" /></td>
    </tr>
	<tr>
        <td  width="25%"  class="label">Sex :</td>
        <td width="75%" >
        <input type="radio" name="gender" <?=($gender=='Male')?'checked="checked"':''?>   value="Male" />Male&nbsp;&nbsp;&nbsp;
        <input type="radio" name="gender"  <?=($gender=='Female')?'checked="checked"':''?>  value="Female" />Female
         </td>
      </tr>
	

	<tr>
	  <td class="label">Email id:<span>*</span></td>
	  <td  style="text-indent:5px;"><?=$email?></td>
    </tr>

	 <tr>
	  <td class="label">City:<span>*</span></td>
	  <td  width="75%"><input class="txt medium" type="text" name="city"  lang="R" title="City" value="<?=$city?>" /></td>
    </tr>

    <tr>
    <td width="25%" class="label">Address:<span>*</span></td>
    <td width="75%"><input class="txt medium" type="text" name="address"  lang="R" title="Address" value="<?=$address?>" /></td>
    </tr>
    <tr>
   
     <tr>
    <td width="25%" class="label">Phone:*</td>
      <td width="75%"><input class="txt medium" type="text" name="mob"  lang="R" title="Phone" value="<?=$mob?>" /></td>
    </tr>
    <tr  class="grey_">
    <td width="25%" class="label">Zip Code:<span>*</span></td>
      <td width="75%"><input class="txt medium" type="text" name="zipcode"  lang="R" title="Zip Code" value="<?=$zipcode?>" /></td>
    </tr>
     <tr  class="grey_">
    <td width="25%" class="label">Date Of Join:<span>*</span></td>
      <td width="75%"  style="text-indent:5px;"> <?=$submitdate?></td>
    </tr>
   
    <tr class="grey_">
	  <td class="label">Password:<span>*</span></td>
	  <td><input  class="txt medium" type="password" name="password" id="pwd"  lang="R" title="Password" value="<?=$cms->decryptcode($password)?>" />
	   <input type="checkbox" id="showpass"> Show Password</td>
    </tr> 
   
	<tr>
	  <td class="label">Status:<span>*</span></td>
	  <td><select name="status" class="txt medium" lang="R" title="Status">
	  <option value="Active" <?=(($status=='Active')?'selected="selected"':'')?>>Active</option>
	  <option value="Inactive" <?=(($status=='Inactive')?'selected="selected"':'')?>>Inactive</option>
	  </select>	
	  </td>
    </tr>
    
	<tr class="grey_">
	  <td>&nbsp;</td>
	  <td><input type="submit" name="Submit" class="uibutton  loading"  value="Submit" /></td>
    </tr>	
  </table>
   <script>
   $("#showpass").click(function(){ 
     var att = $("#pwd").attr('type');
	 if(att=='password'){
	 	$('#pwd').replaceWith($('#pwd').clone().attr('type', 'text'));
	 }else{
	 	$('#pwd').replaceWith($('#pwd').clone().attr('type', 'password'));
	 }
    
   });
   </script>