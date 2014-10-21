<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php 
  
 if($cms->is_post_back() and !$_POST[search]){  
	
	 
	 
	 if($id){
		$cms->sqlquery("rs","sms_pack",$_POST,'pid',$updateid); 
		$adm->sessset('Record has been updated', 's');
	}else{
		$_POST[submitdate] = time();
		$cms->sqlquery("rs","sms_pack",$_POST);
		$updateid = mysql_insert_id();
		$adm->sessset('Record has been added', 's');
	} 
	//$adm->sessset($qty.' Voucher(s) Created', 's');
	
	if(isset($_GET['start']) && $_GET['start'] > 0) {
		$path = SITE_PATH_ADM.CPAGE."/index.php?start=".$_GET['start'];
	} else {
		$path = SITE_PATH_ADM.CPAGE;
	}
	$cms->redir($path, true);
     //$cms->redir(SITE_PATH_ADM.CPAGE, true);
}	
if(isset($id)){
	$rsAdmin=$cms->db_query("select * from #_sms_pack where pid='".$id."'");
	$arrAdmin=$cms->db_fetch_array($rsAdmin);
	@extract($arrAdmin);
	
	

}
?>
 
  <table width="100%" border="0" align="left" cellpadding="4" cellspacing="1" class="frm-tbl2">     
    <tr>
      <td width="25%"  class="label">SMS Pack Name: </td>
      <td width="75%"><input type="text" name="sms_pack"  lang="R" title="pack" class="txt medium" value="<?=$sms_pack?>" style="width:100px;" placeholder="SMS Pack Name" />
	   </td>
    </tr>
	 <tr>
      <td width="25%"  class="label">Enter Amount :</td>
      <td width="75%"> 
	  <input type="text" name="amount"  lang="R" title="Amount" class="txt medium" value="<?=$amount?>" style="width:100px;" placeholder="Enter Amount" />
					 </td>
    </tr>
	 
	 <tr>
      <td width="25%"  class="label">Quantity :</td>
      <td width="75%"> 
	<input type="text" name="qty"  lang="R" title="Quantity" class="txt medium" value="<?=$qty?>" style="width:100px;"  placeholder="Enter Quantity" /></td>
    </tr>
	 
	<tr>
	  <td class="label">Status:<span>*</span></td>
	  <td><select name="status" class="txt medium" lang="R" title="Status">
	  <option value="Active" <?=(($status=='Active')?'selected="selected"':'')?>>Active</option>
	  <option value="Inactive" <?=(($status=='Inactive')?'selected="selected"':'')?>>Inactive</option>
	  <option value="Block" <?=(($status=='Block')?'selected="selected"':'')?>>Block</option>
	  </select>	  </td>
    </tr>

	
    
	<tr>
	  <td>&nbsp;</td>
	  <td>
	  <input type="submit" name="Submit" class="uibutton  loading" value="&nbsp;&nbsp;&nbsp;Submit&nbsp;&nbsp;&nbsp;" /></td>
    </tr>	
  </table>
<script type="text/javascript">
$("#price").blur(function(){	
	var price =  $(this).val();  
	var offerprice =  $("#offerprice").val();
	if(offerprice>price){
		alert("Offerprice can not be greater then actual price");	
		$("#offerprice").val(price);
	}
	if(!offerprice){
		$("#offerprice").val(price);
	}
	
	}); 
 </script>
 <script type="text/javascript"> 
 function addField(){
  var newContent = '<br /><strong style="margin-left:40px;">Title :</strong><input type="text" name="ftitle[]"  title="ftitle" class="txt medium"value="" /><br /><strong>Description :</strong><input type="text" name="fdescription[]" style="margin-top:10px;" title="description" class="txt medium" value="" /><br />';
  $(".addmore").append(newContent); 
 }
</script>