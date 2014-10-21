<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php 
if($cms->is_post_back()){
	$_POST['store_user_id']  =  $_SESSION[uid];
 	if($id){
		$cms->sqlquery("rs","shipping_area_store",$_POST,'pid',$id);
		$adm->sessset('Record has been updated', 's');
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
	$rsAdmin=$cms->db_query("select * from #_shipping_area_store where pid='".$id."'");
	$arrAdmin=$cms->db_fetch_array($rsAdmin);
	@extract($arrAdmin);
}
?> 
  <table width="100%" border="0" align="left" cellpadding="4" cellspacing="1" class="frm-tbl2"> 
    <tr>
	   <?php  $sql_city1="select city,state from #_shipping_city where  status='Active' order by city";
		$sql_city1_query=$cms->db_query($sql_city1);
		?>
      <td width="25%"  class="label">City Name:</td>
	  
      <td width="75%">
	  <input type="text" name="city"  lang="R" title="city" class="txt medium" value="<?=$city?>" />
				 </td>
    </tr> 
	 
	<tr>
      <td width="25%"  class="label">Area Name:</td>
      <td width="75%"><input type="text" name="areaname"  lang="R" title="Area Name" class="txt medium" value="<?=$areaname?>" /></td>
    </tr> 
	  <tr>
      <td width="25%"  class="label">Expected delivery days:</td>
      <td width="75%">From:<select style="min-width:50px;"  name="day1" class="txt" lang="R" title="start day">
	  <?php for($i=0;$i<10;$i++){ ?>
	    <option value="<?=$i?>"<?php if($i==$day1){ echo 'selected="selected"';}?>><?=$i?> </option>
		<?php } ?>
	  </select> To:<select style="min-width:50px;" name="day2" class="txt" lang="R" title="start day">
	  <?php for($j=0;$j<10;$j++){ ?>
	    <option value="<?=$j?>" <?php if($j==$day2){ echo 'selected="selected"';}?>><?=$j?> </option>
		<?php } ?>
	  </select></td>
    </tr>  
	<tr>
      <td width="25%"  class="label">Pin Code:</td>
      <td width="75%"><input type="text" name="pincode" lang="R" title="Pin Code" class="txt medium"value="<?=$pincode?>" /></td>
    </tr> 
	  <tr>
      <td width="25%"  class="label">Extra Charge:</td>
      <td width="75%"><select style="min-width:50px;"  name="extracharge" class="txt" title="extracharge">
	  <?php for($i=0;$i<100;$i++){ ?>
	    <option value="<?=$i?>"<?php if($i==$extracharge){ echo 'selected="selected"';}?>><?=$i?> </option>
		<?php } ?>
	  </select>  % </td>
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
 