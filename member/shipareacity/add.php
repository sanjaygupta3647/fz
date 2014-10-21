<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php 
if($cms->is_post_back()){
	$_POST['store_user_id']  =  $_SESSION[uid];
 	if($updateid){
		$cms->sqlquery("rs","shipping_city",$_POST,'pid',$updateid);
		$adm->sessset('Record has been updated', 's');
	}else{
		 
		$cms->sqlquery("rs","shipping_city",$_POST);
		$adm->sessset('Record has been added', 's');
	}
	//$cms->redir(SITE_PATH_MEM.CPAGE, true);
	if(isset($_GET['start']) && $_GET['start'] > 0) {
		$path = SITE_PATH_MEM.CPAGE."/index.php?start=".$_GET['start'];
	} else {
		$path = SITE_PATH_MEM.CPAGE;
	}
	$cms->redir($path, true);
}	
if(isset($id)){
	$rsAdmin=$cms->db_query("select * from #_shipping_city where pid='".$id."'");
	$arrAdmin=$cms->db_fetch_array($rsAdmin);
	@extract($arrAdmin);
}
 
?>
 
  <table width="100%" border="0" align="left" cellpadding="4" cellspacing="1" class="frm-tbl2">
     <tr>
      <td width="25%"  class="label">City name:</td>
     <td width="75%"><?php  $sql_city1="select pid,city from #_city where country_id='80'";
		$sql_city1_query=$cms->db_query($sql_city1);
		?>
              <input type="hidden" name="country_id" class="login_text_fild" value="80" />
               
              <input type="text" name="city"  lang="R" title="City Name" class="txt medium" value="<?=$city?>" />
			  </td>
    </tr>  
    <tr>
      <td width="25%"  class="label">State Name:</td>
      <td width="75%"><select name="state" lang="R" title="State" class="txt">  
          <option value="Uttar Pradesh"<?=($state=='Uttar Pradesh')?'selected="selected"':''?>>Uttar Pradesh </option>
          <option value="Maharashtra"<?=($state=='Maharashtra')?'selected="selected"':''?>> Maharashtra</option>
          <option value="Bihar"<?=($state=='Bihar')?'selected="selected"':''?>>Bihar</option>
          <option value="West Bengal"<?=($state=='West Bengal')?'selected="selected"':''?>>West Bengal</option>
          <option value="Andhra Pradesh"<?=($state=='Andhra Pradesh')?'selected="selected"':''?>>Andhra Pradesh</option>
          <option value="Madhya Pradesh"<?=($state=='Madhya Pradesh')?'selected="selected"':''?>>Madhya Pradesh</option>
          <option value="Tamil Nadu"<?=($state=='Tamil Nadu')?'selected="selected"':''?>>Tamil Nadu</option>
          <option value="Rajasthan"<?=($state=='Rajasthan')?'selected="selected"':''?>>Rajasthan</option>
          <option value="Karnataka"<?=($state=='Karnataka')?'selected="selected"':''?>>Karnataka</option>
		  <option value="Gujarat<?=($state=='Gujarat')?'selected="selected"':''?>">Gujarat</option>
		  <option value="Odisha"<?=($state=='Odisha')?'selected="selected"':''?>>Odisha</option>
		  <option value="Kerala"<?=($state=='Kerala')?'selected="selected"':''?>>Kerala</option>
		  <option value="Jharkhand"<?=($state=='Jharkhand')?'selected="selected"':''?>>Jharkhand</option>
		  <option value="Assam"<?=($state=='Assam')?'selected="selected"':''?>>Assam</option>
		  <option value="Punjab"<?=($state=='Punjab')?'selected="selected"':''?>>Punjab</option>
		  <option value="Chhattisgarh"<?=($state=='Chhattisgarh')?'selected="selected"':''?>>
		  <option value="Haryana"<?=($state=='Haryana')?'selected="selected"':''?>>Haryana</option>
		  <option value="Jammu and Kashmir"<?=($state=='Jammu and Kashmir')?'selected="selected"':''?>>Jammu and Kashmir</option>
		  <option value="Uttarakhand"<?=($state=='Uttarakhand')?'selected="selected"':''?>>Uttarakhand</option>
		  <option value="Himachal Pradesh"<?=($state=='Himachal Pradesh')?'selected="selected"':''?>>Himachal Pradesh</option>
		  <option value="Tripura"<?=($state=='Tripura')?'selected="selected"':''?>>Tripura</option>
		  <option value="Meghalaya"<?=($state=='Meghalaya')?'selected="selected"':''?>>Meghalaya</option>
		  <option value="Manipur"<?=($state=='Manipur')?'selected="selected"':''?>>Manipur</option>
		  <option value="Nagaland"<?=($state=='Maharashtra')?'selected="selected"':''?>>Nagaland</option>
		  <option value="Goa"<?=($state=='Goa')?'selected="selected"':''?>>Goa</option>
		  <option value="Arunachal Pradesh"<?=($state=='Arunachal Pradesh')?'selected="selected"':''?>>Arunachal Pradesh</option>
		  <option value="Mizoram"<?=($state=='Mizoram')?'selected="selected"':''?>>Mizoram</option>
		  <option value="Sikkim"<?=($state=='Sikkim')?'selected="selected"':''?>>Sikkim</option>
		  <option value="Delhi"<?=($state=='Delhi')?'selected="selected"':''?>>Delhi</option>
		  <option value="Puducherry"<?=($state=='Puducherry')?'selected="selected"':''?>>Puducherry</option>
		  <option value="Chandigarh"<?=($state=='Chandigarh')?'selected="selected"':''?>>Chandigarh</option>
		  <option value="Andaman and Nicobar Islands"<?=($state=='Andaman and Nicobar Islands')?'selected="selected"':''?>>Andaman and Nicobar Islands</option>
		  <option value="Dadra and Nagar Haveli"<?=($state=='Dadra and Nagar Haveli')?'selected="selected"':''?>>Dadra and Nagar Haveli</option>
		  <option value="Daman and Diu"<?=($state=='Daman and Diu')?'selected="selected"':''?>>Daman and Diu</option>
		  <option value="Lakshadweep"<?=($state=='Lakshadweep')?'selected="selected"':''?>> Lakshadweep</option>
		 </select>
        </td>
    </tr> 
	
	<tr>
	  <td class="label">Status:<span>*</span></td>
	  <td><select name="status" class="txt" lang="R" title="Status">
	  <option value="Active" <?=(($status=='Active')?'selected="selected"':'')?>>Active</option>
	  <option value="Inactive" <?=(($status=='Inactive')?'selected="selected"':'')?>>Inactive</option>
	  </select>	  </td>
    </tr>
	 
    
	<tr>
	  <td>&nbsp;</td>
	  <td>
	  <input type="submit" name="Submit" class="uibutton  loading" value="&nbsp;&nbsp;&nbsp;Submit&nbsp;&nbsp;&nbsp;" /></td>
    </tr>	
  </table>
 