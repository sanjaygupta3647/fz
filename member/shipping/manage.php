<?php defined('_JEXEC') or die('Restricted access');  
if($cms->is_post_back()){ 
 	$_POST['store_user_id']  =  $_SESSION[uid]; 
	$check = $cms->getSingleresult("select count(*) from fz_shipping where store_user_id ='".$_SESSION[uid]."'");
	if($check){ 
		$cms->sqlquery("rs","shipping",$_POST,'store_user_id',$_SESSION[uid]);
		$adm->sessset('Shipping free amount has been updated', 's');
		
	} else {  
			$cms->sqlquery("rs","shipping",$_POST);
			$adm->sessset('Shipping free amount has been updated', 's'); 
		} 
	$cms->redir($path, true);
	
}
$rsAdmin=$cms->db_query("select * from #_shipping where store_user_id ='".$_SESSION[uid]."'"); 
$arrAdmin=$cms->db_fetch_array($rsAdmin); 
@extract($arrAdmin);?>
<table width="98%" border="0" align="left" cellpadding="4"  cellspacing="1" class="frm-tbl2"> 
  <tr>
      <td width="25%" valign="top"  class="label">&nbsp</td>
      <td width="75%">
       Please enter the amount after which shipping will be free. Rs. 0 indicate that you have not set free shipping for a renge.
      </td>
   </tr> 
   <tr>
      <td width="25%" valign="top"  class="label">Shipping Free Amount: </td>
      <td width="75%">
      Rs. <input type="text" value="<?=(int)$shipFreeAmount?>"  name="shipFreeAmount" class="txt small"  />  
      </td>
   </tr> 
   
	<tr>
	  <td>&nbsp;</td>
	  <td><input type="submit" name="Submit" class="uibutton  loading" value="&nbsp;&nbsp;&nbsp;Submit&nbsp;&nbsp;&nbsp;" /></td>
    </tr>	
  </table>
 
 