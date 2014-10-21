<?php 
if($cms->is_post_back()){ 
 	$_POST['store_user_id']  =  $_SESSION[uid]; 
	$check = $cms->getSingleresult("select count(*) from fz_discount where store_user_id ='".$_SESSION[uid]."'");
	if($check){ 
		$cms->sqlquery("rs","discount",$_POST,'store_user_id',$_SESSION[uid]);
		$adm->sessset('Record has been updated', 's');
		
	}else{   
		$cms->sqlquery("rs","discount",$_POST);
		$adm->sessset('Record has been added', 's'); 
	} 
	$cms->redir(SITE_PATH_MEM.CPAGE, true);die;
} 
 
$rsAdmin=$cms->db_query("select * from #_discount where store_user_id = '".$_SESSION[uid]."'  ");

$arrAdmin=$cms->db_fetch_array($rsAdmin);
//print_r($arrAdmin);
@extract($arrAdmin);
 
?>

  <table width="98%" border="0" align="left" cellpadding="4"  cellspacing="1" class="frm-tbl2"> 
   
   <tr>
      <td width="25%" valign="top"  class="label">Range1: </td>
      <td width="75%">
      <input type="text" value="<?=$range11?>" name="range11" class="txt small"  /> To <input type="text" value="<?=$range12?>" name="range12"  class="txt small"  />
      discount % <select  class="txt small" name= "discount1">
	  <?php for($i=0;$i<100;$i++){?> <option value="<?=$i?>" <?=($i==$discount1)?'selected="selected"':''?>><?=$i?> %</option><?php } ?>
	  </select>
      </td>
   </tr> 
   <tr>
      <td width="25%" valign="top"  class="label">Range2: </td>
      <td width="75%">
      <input type="text" value="<?=$range21?>" name="range21" class="txt small"  /> To <input type="text" value="<?=$range22?>" name="range22"  class="txt small"  />
      discount % <select  class="txt small" name= "discount2">
	  <?php for($i=0;$i<100;$i++){?> <option value="<?=$i?>" <?=($i==$discount2)?'selected="selected"':''?>><?=$i?> %</option><?php } ?>
	  </select>
	  
	   
      </td>
   </tr> 
   <tr>
      <td width="25%" valign="top"  class="label">Range3: </td>
      <td width="75%">
      <input type="text" value="<?=$range31?>" name="range31" class="txt small"  /> To<input type="text" value="<?=$range32?>" name="range32"  class="txt small"  />
        discount % <select  class="txt small" name= "discount3">
	  <?php for($i=0;$i<100;$i++){?> <option value="<?=$i?>" <?=($i==$discount3)?'selected="selected"':''?>><?=$i?> %</option><?php } ?>
	  </select>
      </td>
   </tr> 
   <tr>
      <td width="25%" valign="top"  class="label">Range4: </td>
      <td width="75%">
      <input type="text" value="<?=$range41?>" name="range41" class="txt small"  /> To <input type="text" value="<?=$range42?>" name="range42"  class="txt small"  />  discount % <select  class="txt small" name= "discount4">
	  <?php for($i=0;$i<100;$i++){?> <option value="<?=$i?>" <?=($i==$discount4)?'selected="selected"':''?>><?=$i?> %</option><?php } ?>
	  </select>
      </td>
   </tr> 
   <tr>
      <td width="25%" valign="top"  class="label">Range5: </td>
      <td width="75%">
      <input type="text" value="<?=$range51?>" name="range51" class="txt small"  /> To <input type="text" value="<?=$range52?>" name="range52"  class="txt small"  />
        discount % <select  class="txt small" name= "discount5">
	  <?php for($i=0;$i<100;$i++){?> <option value="<?=$i?>" <?=($i==$discount5)?'selected="selected"':''?>><?=$i?> %</option><?php } ?>
	  </select>
      </td>
   </tr> 
   <tr>
      <td width="25%" valign="top"  class="label">Range6: </td>
      <td width="75%">
     <input type="text" value="<?=$range61?>" name="range61" class="txt small"  /> To <input type="text" value="<?=$range62?>" name="range62"  class="txt small"  />
       discount % <select  class="txt small" name= "discount6">
	  <?php for($i=0;$i<100;$i++){?> <option value="<?=$i?>" <?=($i==$discount6)?'selected="selected"':''?>><?=$i?> %</option><?php } ?>
	  </select>
      </td>
   </tr> 
    <tr>
      <td width="25%" valign="top"  class="label">Range7: </td>
      <td width="75%">
      <input type="text" value="<?=$range71?>" name="range71" class="txt small"  />
       To <input type="text" value="<?=$range72?>" name="range72"  class="txt small"  />
        discount % <select  class="txt small" name= "discount7">
	  <?php for($i=0;$i<100;$i++){?> <option value="<?=$i?>" <?=($i==$discount7)?'selected="selected"':''?>><?=$i?> %</option><?php } ?>
	  </select>
      </td>
   </tr> 
    <tr>
      <td width="25%" valign="top"  class="label">Range8: </td>
      <td width="75%">
      <input type="text" value="<?=$range81?>" name="range81" class="txt small"  />
       To <input type="text" value="<?=$range82?>" name="range82"  class="txt small"  />
        discount % <select  class="txt small" name= "discount8">
	  <?php for($i=0;$i<100;$i++){?> <option value="<?=$i?>" <?=($i==$discount8)?'selected="selected"':''?>><?=$i?> %</option><?php } ?>
	  </select>
      </td>
   </tr>  
	<tr>
	  <td>&nbsp;</td>
	  <td><input type="submit" name="Submit" class="uibutton  loading" value="&nbsp;&nbsp;&nbsp;Submit&nbsp;&nbsp;&nbsp;" /></td>
    </tr>	
  </table>
 