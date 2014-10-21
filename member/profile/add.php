<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php 
if($cms->is_post_back()){
	 	$uname=$cms->getSingleresult("select user_name from #_store_user where pid='".$_SESSION[uid]."'"); 
		$getpid=$cms->getSingleresult("select pid from #_store_user where user_name='".$user_name."'"); 
		if($getpid){
			if($user_name!=$uname){
				$err = true;
			}
		}
 		if(!$err){
	    $_POST[password]=$cms->encryptcode($_POST[password]);
		$cms->sqlquery("rs","store_user",$_POST,'pid',$_SESSION[uid]);
		$adm->sessset('Record has been updated', 's');
		$cms->redir(SITE_PATH_MEM.CPAGE, true);
		}else{
			$adm->sessset('User already exist', 'e');
		}
	  
}
 
	$rsAdmin=$cms->db_query("select * from #_store_user where pid='".$_SESSION[uid]."'");
	$arrAdmin=$cms->db_fetch_array($rsAdmin);
	@extract($arrAdmin);
 
?>
 
  <table width="100%" border="0" align="left" cellpadding="4" cellspacing="1" class="frm-tbl2">
  <tr  class="grey_">
      <td width="25%"  class="label">Name:<span>*</span></td>
      <td width="75%"><input type="text" name="name" class="txt medium"  lang="R" title="Name" value="<?=$name?>" />
	  
	  </td>
    </tr>

    <tr>
    <td width="25%" class="label">Address:<span>*</span></td>
    <td width="75%"><input class="txt medium" type="text" name="address"  lang="R" title="Address" value="<?=$address?>" /></td>
    </tr>
    <tr>
    <td width="25%" class="label">Mobile:*</td>
      <td width="75%"><input class="txt medium" type="text" name="mobile"  lang="R" title="mobile" value="<?=$mobile?>" /></td>
    </tr>
     <tr>
    <td width="25%" class="label">Phone:*</td>
      <td width="75%"><input class="txt medium" type="text" name="phone"  lang="R" title="Phone" value="<?=$phone?>" /></td>
    </tr>
    <tr  class="grey_">
    <td width="25%" class="label">Pin Code:<span>*</span></td>
      <td width="75%"><input class="txt medium" type="text" name="pincode"  lang="R" title="Pin Code" value="<?=$pincode?>" /></td>
    </tr>
     <tr  class="grey_">
    <td width="25%" class="label">Date Of Join:<span>*</span></td>
      <td width="75%"><input disabled="disabled" class="txt medium" type="text" name="date_of_join"  lang="R" title="Pin Code" value="<?=$date_of_join?>" /></td>
    </tr>
    <tr class="grey_">
	  <td class="label">User Name:<span>*</span></td>
	  <td><input class="txt medium" type="text" name="user_name"  lang="R" title="User Name" value="<?=$user_name?>" /></td>
    </tr>
    <tr class="grey_">
	  <td class="label">Password:<span>*</span></td>
	  <td><input  class="txt medium" type="password" name="password" id="pwd"  lang="R" title="Password" value="<?=$cms->decryptcode($password)?>" />
	  <input type="checkbox" id="showpass"> Show Password</td>
    </tr>
	<tr>
	  <td class="label">Email id:<span>*</span></td>
	  <td><input  class="txt medium" type="text" name="email_id"  lang="RisEmail" title="Email id" value="<?=$email_id?>" /></td>
    </tr> 
    <tr  class="grey_">
    <td width="25%" class="label">City:</td>
      <td width="75%">		<?php  $sql_city1="select pid,city from fz_city where country_id='80'";
							  $sql_city1_query=$cms->db_query($sql_city1);
							  ?>
									<select class="txt" name="city" >
									<option value="">Select</option>
										<?php while($city_array=mysql_fetch_array($sql_city1_query)){ @extract($city_array);?>
                                      <option value="<?=$pid?>" <? if($city_id == $pid) echo 'selected="selected"'; ?>><?=$city?></option>
                                      <?php }?>
									</select></td>
    </tr>
    
    <tr  class="grey_">
   <?php /*?> <td width="25%" class="label">Website:*</td>
      <td width="75%"><input class="txt medium" type="text" name="website"  title="Website" value="<?=$website?>" /></td>
    </tr><?php */?>
    <tr>
    <td width="25%" class="label">User Type:*</td>
      <td width="75%"><input class="txt medium" type="text" name="type"  lang="R" title="Type" value="<?=$type?>" /></td>
    </tr>

	<tr>
	  <td class="label">Status:<span>*</span></td>
	  <td><?=$status?>
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