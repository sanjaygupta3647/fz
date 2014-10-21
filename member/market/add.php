<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php 
if($cms->is_post_back()){
	$_POST[url] = $adm->baseurl($pagename);
	if($updateid){
		$cms->sqlquery("rs","market",$_POST,'pid',$updateid);
		$cms->sessset('Record has been updated', 's');
	}else{
		$_POST[submitdate] = time();
		$cms->sqlquery("rs","market",$_POST);
		$cms->sessset('Record has been added', 's');
	}
	$cms->redir(SITE_PATH_ADM.CPAGE, true);
}	
if(isset($id)){
	$rsAdmin=$cms->db_query("select * from #_market where pid='".$id."'");
	$arrAdmin=$cms->db_fetch_array($rsAdmin);
	@extract($arrAdmin);
}
?>
 
  <table width="100%" border="0" align="left" cellpadding="4" cellspacing="1" class="frm-tbl2">
    <tr  class="grey_">
      <td width="25%" class="label">Select Country:</td>
      <td width="75%">
      <select name="country_id" class="txt medium" id="country_id"  lang="R" title="Category">
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
   <tr  class="grey_">
      <td width="25%" class="label">Select City:</td>
      <td width="75%">
      <div id="ajaxDiv">
      <select name="city_id" class="txt medium" id="city_id"  lang="R" title="Category">
      <option value="")?>---Select City--</option> 
      <? $rsAdmin=$cms->db_query("select pid,city from #_city where country_id='80'");
	  while($arrAdmin=$cms->db_fetch_array($rsAdmin)){@extract($arrAdmin);
	  ?>
	  <option value="<?=$pid?>" <?=(($pid==$city_id )?'selected="selected"':'')?>><?=$city?></option> 
       <?
	   }?>
	  </select>	
      </div>
      </td>
    </tr>
     <tr>
      <td width="25%"  class="label">Name:</td>
      <td width="75%"><input type="text" name="market_name"  lang="R" title="Name" class="txt medium" value="<?=$market_name?>" /></td>
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
 <script type="text/javascript">
		 		$("#country_id").change(function(){
 					var country_id = $(this).val();
						$.ajax({ 
						url: '<?=SITE_PATH_ADM.CPAGE?>/ajax.php?country_id='+country_id, 
						success: function (data) {
							$("#ajaxDiv").html(data); 
						},
						error: function (request, status, error) {
						alert(request.responseText);
						}
						});  
					}); 
 </script>
 