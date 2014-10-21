<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php 
$cms->db_query("update #_contact set `status` = '1' where `pid` = '$id' ");
 	
if(isset($id)){
	$rsAdmin=$cms->db_query("select * from #_contact where pid='".$id."'");
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
      <td width="25%" class="label">Name:*</td>
      <td width="75%"><?=$name?></td>
    </tr> 
    <tr  class="grey_">
      <td width="25%" class="label">Phone:*</td>
      <td width="75%"><?=$phone?></td>
    </tr>  
	<tr  class="grey_">
      <td width="25%" class="label">City:*</td>
      <td width="75%"><?=$city?></td>
    </tr> 
	<tr  class="grey_">
      <td width="25%" class="label">Pin Code:*</td>
      <td width="75%"><?=$pinCode?></td>
    </tr> 
    <tr>
       <td  class="label">Email:*</td> 
       <td><?=$email?></td>
    </tr>
	 
	<tr>
      <td  class="label">Query:*</td> 
       <td><?=$query?></td>
    </tr> 
	<tr>
	  <td valign="top" class="label">Status:</td>
	  <td valign="top"><?=($status=='1')?'Viewed':'Not Viewed'?></td>
    </tr>

	
	 	
  </table>
 
 