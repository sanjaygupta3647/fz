<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php 
$cms->db_query("update #_products_inquery set `status` = 'Active' where `pid` = '$id' ");
if($cms->is_post_back()){ 
	$_POST[url] = $adm->baseurl($title);
	 
	$_POST[url] = $adm->baseurl($title);  
	if($updateid){	
		$uids =  $cms->sqlquery("rs","products_inquery",$_POST,'pid',$updateid);
		$adm->sessset('Record has been updated', 's');
	}else{
		$_POST[dd] = date("d");
		$_POST[mm] = date("m");
		$_POST[yy] = date("Y");
		
		$_POST[submitdate] = time();
		$uids =  $cms->sqlquery("rs","products_inquery",$_POST);
		$adm->sessset('Record has been added', 's');
	}
	$cms->db_query("update #_products_inquery set `body` = '".$_POST[body]."' where `pid` in ($uids)");
	$cms->redir(SITE_PATH_ADM.CPAGE, true);
}	
if(isset($id)){
	$rsAdmin=$cms->db_query("select * from #_products_inquery where pid='".$id."'");
	$arrAdmin=$cms->db_fetch_array($rsAdmin);
	@extract($arrAdmin);
}
?>
  <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css" />
  <script src="http://code.jquery.com/jquery-1.8.2.js"></script> 
  <script src="http://code.jquery.com/ui/1.9.1/jquery-ui.js"></script> 
  <script>
    $(function() {
        $( "#invdate2" ).datepicker({ dateFormat: 'yy-mm-dd' }).val();
    });</script>
  <table width="100%" border="0" align="left" cellpadding="4" cellspacing="1" class="frm-tbl2">
   <tr  class="grey_">
      <td width="25%" class="label">Product Name:*</td>
      <td width="75%"><?=$productname?></td>
    </tr>
    <tr  class="grey_">
      <td width="25%" class="label">Name:*</td>
      <td width="75%"><?=$name?></td>
    </tr>
      <tr  class="grey_">
      <td width="25%" class="label">Phone:*</td>
      <td width="75%"><?=$phone?></td>
    </tr>  
    <tr>
       <td  class="label">Email:*</td> 
       <td><?=$email?></td>
    </tr>
	<tr>
	  <td valign="top" class="label">City:</td>
	  <td valign="top"><?=$city?></td>
    </tr>
	<tr>
      <td  class="label">Address:*</td> 
       <td><?=$address?></td>
    </tr>    
	<tr>
	  <td valign="top" class="label">Pin Code:</td>
	  <td valign="top"><?=$pincode?></td>
    </tr>
	<tr>
      <td  class="label">Query:*</td> 
       <td><?=$query?></td>
    </tr> 
	<tr>
	  <td valign="top" class="label">Status:</td>
	  <td valign="top"><?=($status=='Active')?'Viewed':'Not Viewed'?></td>
    </tr>

	
	 	
  </table>
 
 