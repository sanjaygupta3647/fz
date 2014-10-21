<?php 
if($cms->is_post_back()){ 
 	$_POST['store_user_id']  =  $_SESSION[uid]; 
	if($id){ 
		$cms->sqlquery("rs","shipping",$_POST,'pid',$updateid);
		$adm->sessset('Record has been updated', 's');
		
	} else {  
			$cms->sqlquery("rs","shipping",$_POST);
			$adm->sessset('Record has been added', 's'); 
		}
		 
	$cms->redir($path, true);
}
	
	
 
if(isset($id)){
	$rsAdmin=$cms->db_query("select * from #_shipping where pid='".$id."'"); 
	$arrAdmin=$cms->db_fetch_array($rsAdmin);
	//print_r($arrAdmin);
	@extract($arrAdmin);
}
?>

  <table width="98%" border="0" align="left" cellpadding="4"  cellspacing="1" class="frm-tbl2">
   <?php
   if(isset($id)){?>
	  <tr>
      <td width="25%" valign="top"  class="label">Shipping Type: </td>
      <td width="75%"> <?=ucfirst($type)?> Wise </td>
   </tr> 
   <?php
   }else{?>
   <tr>
      <td width="25%" valign="top"  class="label">Shipping Type: </td>
      <td width="75%">
      <select name="type" class="txt small" lang="R" title="Shipping Type">
		   <option value="">Please Select </option>
		  <option value="cost" <?=(($type=='cost')?'selected="selected"':'')?>>Cost wise</option>
		  <option value="weight" <?=(($type=='weight')?'selected="selected"':'')?>>Weight wise</option>
		  <option value="quantity <?=(($type=='quantity')?'selected="selected"':'')?>">Quantity wise</option>
	  </select>
      </td>
   </tr> <?php
  }?>
   
   <tr>
      <td width="25%" valign="top"  class="label">Range1: </td>
      <td width="75%">
      <input type="text" value="<?=$range11?>" name="range11" class="txt small"  /> To <input type="text" value="<?=$range12?>" name="range12"  class="txt small"  />
      Shipping Charge <select  class="txt small" name= "shipping1">
	  <?php for($i=0;$i<100;$i++){?> <option value="<?=$i?>" <?=($i==$shipping1)?'selected="selected"':''?>><?=$i?> %</option><?php } ?>
	  </select> 
	  
      </td>
   </tr> 
   <tr>
      <td width="25%" valign="top"  class="label">Range2: </td>
      <td width="75%">
      <input type="text" value="<?=$range21?>" name="range21" class="txt small"  /> To <input type="text" value="<?=$range22?>" name="range22"  class="txt small"  />
      Shipping Charge <select  class="txt small" name= "shipping2">
	  <?php for($i=0;$i<100;$i++){?> <option value="<?=$i?>" <?=($i==$shipping2)?'selected="selected"':''?>><?=$i?> %</option><?php } ?>
	  </select>
      </td>
   </tr> 
   <tr>
      <td width="25%" valign="top"  class="label">Range3: </td>
      <td width="75%">
      <input type="text" value="<?=$range31?>" name="range31" class="txt small"  /> To<input type="text" value="<?=$range32?>" name="range32"  class="txt small"  />
        Shipping Charge <select  class="txt small" name= "shipping3">
	  <?php for($i=0;$i<100;$i++){?> <option value="<?=$i?>" <?=($i==$shipping3)?'selected="selected"':''?>><?=$i?> %</option><?php } ?>
	  </select>
      </td>
   </tr> 
   <tr>
      <td width="25%" valign="top"  class="label">Range4: </td>
      <td width="75%">
      <input type="text" value="<?=$range41?>" name="range41" class="txt small"  /> To <input type="text" value="<?=$range42?>" name="range42"  class="txt small"  />  Shipping Charge <select  class="txt small" name= "shipping4">
	  <?php for($i=0;$i<100;$i++){?> <option value="<?=$i?>" <?=($i==$shipping4)?'selected="selected"':''?>><?=$i?> %</option><?php } ?>
	  </select>
      </td>
   </tr> 
   <tr>
      <td width="25%" valign="top"  class="label">Range5: </td>
      <td width="75%">
      <input type="text" value="<?=$range51?>" name="range51" class="txt small"  /> To <input type="text" value="<?=$range52?>" name="range52"  class="txt small"  />
        Shipping Charge <select  class="txt small" name= "shipping5">
	  <?php for($i=0;$i<100;$i++){?> <option value="<?=$i?>" <?=($i==$shipping5)?'selected="selected"':''?>><?=$i?> %</option><?php } ?>
	  </select>
      </td>
   </tr> 
   <tr>
      <td width="25%" valign="top"  class="label">Range6: </td>
      <td width="75%">
     <input type="text" value="<?=$range61?>" name="range61" class="txt small"  /> To <input type="text" value="<?=$range62?>" name="range62"  class="txt small"  />
        Shipping Charge <select  class="txt small" name= "shipping6">
	  <?php for($i=0;$i<100;$i++){?> <option value="<?=$i?>" <?=($i==$shipping6)?'selected="selected"':''?>><?=$i?> %</option><?php } ?>
	  </select>
      </td>
   </tr> 
    <tr>
      <td width="25%" valign="top"  class="label">Range7: </td>
      <td width="75%">
      <input type="text" value="<?=$range71?>" name="range71" class="txt small"  />
       To <input type="text" value="<?=$range72?>" name="range72"  class="txt small"  />
        Shipping Charge <select  class="txt small" name= "shipping7">
	  <?php for($i=0;$i<100;$i++){?> <option value="<?=$i?>" <?=($i==$shipping7)?'selected="selected"':''?>><?=$i?> %</option><?php } ?>
	  </select>
      </td>
   </tr> 
    <tr>
      <td width="25%" valign="top"  class="label">Range8: </td>
      <td width="75%">
      <input type="text" value="<?=$range81?>" name="range81" class="txt small"  />
       To <input type="text" value="<?=$range82?>" name="range82"  class="txt small"  />
        Shipping Charge <select  class="txt small" name= "shipping8">
	  <?php for($i=0;$i<100;$i++){?> <option value="<?=$i?>" <?=($i==$shipping8)?'selected="selected"':''?>><?=$i?> %</option><?php } ?>
	  </select>
      </td>
   </tr>  
	<tr>
	  <td>&nbsp;</td>
	  <td><input type="submit" name="Submit" class="uibutton  loading" value="&nbsp;&nbsp;&nbsp;Submit&nbsp;&nbsp;&nbsp;" /></td>
    </tr>	
  </table>
 