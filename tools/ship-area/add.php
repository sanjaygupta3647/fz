<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php 
if($cms->is_post_back()){
	 
 	if($updateid){
		$cms->sqlquery("rs","shipping_area",$_POST,'pid',$updateid);
		$adm->sessset('Record has been updated', 's');
	}else{
		 
		$cms->sqlquery("rs","shipping_area",$_POST);
		$adm->sessset('Record has been added', 's');
	}
	//$cms->redir(SITE_PATH_ADM.CPAGE, true);
	
	if(isset($_GET['start']) && $_GET['start'] > 0) {
		$path = SITE_PATH_ADM.CPAGE."/index.php?start=".$_GET['start'];
	} else {
		$path = SITE_PATH_ADM.CPAGE;
	}
	$cms->redir($path, true);
}	
if(isset($id)){
	$rsAdmin=$cms->db_query("select * from #_shipping_area where pid='".$id."'");
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
				<select class="txt" lang="R" title="City" name="city" style="float:left;height:30px;margin-left: 0px;color: black;" >
                <option value="">Select</option>
                <?php while($city_array=$cms->db_fetch_array($sql_city1_query)){  ?> 
                <option value="<?=$city_array[city]?>" <? if($city==$city_array[city]) {echo 'selected="selected"'; }?> >
				<?=$city_array[city]?> (<?=$city_array[state]?>) 
				</option>
                <?php }?>
              </select></td>
    </tr> 
	 
	<tr>
      <td width="25%"  class="label">Area Name:</td>
      <td width="75%"><input type="text" name="areaname"  lang="R" title="Area Name" class="txt medium" value="<?=$areaname?>" /></td>
    </tr> 
	  <tr>
      <td width="25%"  class="label">Expected Delabari days:</td>
      <td width="75%">From:<select name="day1" class="txt" lang="R" title="start day">
	  <?php for($i=0;$i<10;$i++){ ?>
	    <option value="<?=$i?>"<?php if($i==$day1){ echo 'selected="selected"';}?>><?=$i?> </option>
		<?php } ?>
	  </select> To:<select name="day2" class="txt" lang="R" title="start day">
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
 