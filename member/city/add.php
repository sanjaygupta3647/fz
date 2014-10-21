<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php 
if($cms->is_post_back()){
	$_POST[url] = $adm->baseurl($pagename);
	if($updateid){
		$cms->sqlquery("rs","city",$_POST,'pid',$updateid);
		$cms->sessset('Record has been updated', 's');
	}else{
		$_POST[submitdate] = time();
		$cms->sqlquery("rs","city",$_POST);
		$cms->sessset('Record has been added', 's');
	}
	$cms->redir(SITE_PATH_ADM.CPAGE, true);
}	
if(isset($id)){
	$rsAdmin=$cms->db_query("select * from #_city where pid='".$id."'");
	$arrAdmin=$cms->db_fetch_array($rsAdmin);
	@extract($arrAdmin);
}
?>
 
  <table width="100%" border="0" align="left" cellpadding="4" cellspacing="1" class="frm-tbl2">
    <tr  class="grey_">
      <td width="25%" class="label">Select Country:</td>
      <td width="75%">
      <select name="cat_id" class="txt medium" lang="R" title="Category">
      <option value="")?>---Select Country--</option> 
      <? $rsAdmin=$cms->db_query("select pid,country from #_country where status='Active'");
	  while($arrAdmin=$cms->db_fetch_array($rsAdmin)){@extract($arrAdmin);
	  ?>
	  <option value="<?=$pid?>" <?=(($pid==$country_id || $pid==80 )?'selected="selected"':'')?>><?=$country?></option> 
       <?
	   }?>
	  </select>	
      
      </td>
    </tr>
   <tr>
      <td width="25%"  class="label">City Name:</td>
      <td width="75%"><input type="text" name="city"  lang="R" title="City Name" class="txt medium" value="<?=$city?>" /></td>
    </tr>
   <tr>
      <td width="25%"  class="label">Latitude:</td>
      <td width="75%"><input type="text" name="latitude"    title="Name" class="txt medium"value="<?=$latitude?>" /></td>
    </tr>
	 <tr>
      <td width="25%"  class="label">Longitude:</td>
      <td width="75%"><input type="text" name="longitude"    title="Name" class="txt medium"value="<?=$longitude?>" /></td>
    </tr> 
     <tr>
      <td width="25%"  class="label">Is Popular:</td>
      <td width="75%">
      <input type="checkbox" name="popular_city"  title="Name"  value="1" <? if($popular_city==1) echo 'checked'; ?> /></td>
    </tr> 
	  <tr>
      <td width="25%"  class="label">City Order:</td>
      <td width="75%"><input type="text" name="city_order"    title="Name" class="txt medium"value="<?=$city_order?>" /></td>
    </tr>  
	<tr>
	  <td class="label">Status:<span>*</span></td>
	  <td><select name="status" class="select" lang="R" title="Status">
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
 