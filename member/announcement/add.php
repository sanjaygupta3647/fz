<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php 
 
 
if(isset($id)){
	$rsAdmin=$cms->db_query("select * from #_announcement where pid='".$id."'");
	$arrAdmin=$cms->db_fetch_array($rsAdmin);
	@extract($arrAdmin);
}
?>
  
  <table width="100%" border="0" align="left" cellpadding="4" cellspacing="1" class="frm-tbl2">
    <tr  class="grey_">
      <td width="25%" class="label">Title:*</td>
      <td width="75%"><?=$title?></td>
    </tr> 

    <tr>
      <td  class="label">Date:*</td> 
       <td><?=date("d M, Y h:i:s A",$submitdate)?></td>
    </tr> 
	<tr>
	  <td valign="top" class="label">Description:</td>
	  <td valign="top"><?=$cms->removeSlash($body)?></td>
    </tr>
	 
	
	 	
  </table>
 
 