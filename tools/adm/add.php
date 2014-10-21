<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php 
if($cms->is_post_back()){
	$_POST[apassword] = base64_encode($apassword);
	if(count($_POST[permission])){
		foreach($_POST[permission] as $per){
			if($per) $p .= $per.",";
		}
		if($p){
			$_POST[permissions] = substr($p,0,-1);
		} 
	}
	if($updateid){
		if(!mysql_num_rows($rsAdmin=$cms->db_query("select * from #_administrator where ausername='".$ausername."' and aid!='".$updateid."'"))){
		$cms->sqlquery("rs","administrator",$_POST,'aid',$updateid);
		$adm->sessset('Record has been updated', 's');
		//$cms->redir(SITE_PATH_ADM.CPAGE, true);
		}else{
			$adm->sessset('User already exist', 'e');
		}
	} else {
		if(!mysql_num_rows($rsAdmin=$cms->db_query("select * from #_administrator where ausername='".$ausername."'"))){
			$_POST[submitdate] = time();
			$cms->sqlquery("rs","administrator",$_POST);
			$adm->sessset('Record has been added', 's');
			//$cms->redir(SITE_PATH_ADM.CPAGE, true);
		} else {
			$adm->sessset('User already exist', 'e');
		}
	}	
	
if(isset($_GET['start']) && $_GET['start'] > 0) {
		$path = SITE_PATH_ADM.CPAGE."/index.php?start=".$_GET['start'];
	} else {
		$path = SITE_PATH_ADM.CPAGE;
	}
	$cms->redir($path, true);	
	
}
if(isset($id)){
	$rsAdmin=$cms->db_query("select * from #_administrator where aid='".$id."'");
	$arrAdmin=$cms->db_fetch_array($rsAdmin);
	@extract($arrAdmin);
}
?>
 
  <table width="100%" border="0" align="left" cellpadding="4" cellspacing="1"  class="frm-tbl2">
    <tr>
      <td width="25%"  class="label">Username:<span>*</span></td>
      <td width="75%"><input class="txt medium" type="text" name="ausername" lang="R" title="Username" value="<?=$ausername?>" /></td>
    </tr>
    
   <tr  class="grey_">
      <td width="25%"  class="label">First name:<span>*</span></td>
      <td width="75%"><input type="text" name="afname" class="txt medium"  lang="R" title="First name" value="<?=$afname?>" /></td>
    </tr>
	<tr>
      <td width="25%" class="label">Last name:<span>*</span></td>
      <td width="75%"><input class="txt medium" type="text" name="alname"  lang="R" title="Last name" value="<?=$alname?>" /></td>
    </tr>
	<tr  class="grey_">
	  <td class="label">Email id:<span>*</span></td>
	  <td><input  class="txt medium" type="text" name="aemail"  lang="RisEmail" title="Email id" value="<?=$aemail?>" /></td>
    </tr>
	<tr>
	  <td class="label">Password:<span>*</span></td>
	  <td><input class="txt medium" type="password" name="apassword"  lang="R" title="Password" value="<?=base64_decode($apassword)?>" /></td>
    </tr>
	<tr  class="grey_">
	  <td class="label">Type:<span>*</span></td>
	  <td><select name="atype"  class="txt"  lang="R" title="Type">
	  <option value="">----Select type----</option>
	  <option value="admin" <?=(($atype=='admin')?'selected="selected"':'')?>>Admin</option>
	  
	  <?php if($_SESSION["ses_adm_type"]=='su'){?>
	  <option value="su" <?=(($atype=='su')?'selected="selected"':'')?>>Super Admin</option>
	  <?php } ?>
	  </select>
	  </td>
    </tr>

	<tr  class="grey_">
	  <td class="label">Permission:<span>*</span></td>
	  <td><select name="permission[]"  style="width:400px;height:200px" class="txt" title="Permission" multiple ><?php 
	  if($permissions) $perm = explode(',',$permissions);
	  foreach($allpage as $val){ ?> 
		<option value="<?=$val?>" <?=(in_array($val,$perm))?'selected="selected"':''?> ><?=$val?></option> <?php } ?> 
	  </select>
	  </td>
    </tr>

	<tr>
	  <td class="label">Status:<span>*</span></td>
	  <td><select name="astatus"  class="txt" lang="R" title="Status">
	  <option value="">----Select status----</option>
	  <option value="Active" <?=(($astatus=='Active')?'selected="selected"':'')?>>Active</option>
	  <option value="Inactive" <?=(($astatus=='Inactive')?'selected="selected"':'')?>>Inactive</option>
	  </select>
	  </td>
    </tr>
	<tr class="grey_">
	  <td>&nbsp;</td>
	  <td><input type="submit" name="Submit" class="uibutton  loading"  value="Submit" /></td>
    </tr>	
  </table>
 
