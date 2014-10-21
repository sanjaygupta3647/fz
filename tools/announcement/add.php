<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php  
$storeArr=array();
$rsStore=$cms->db_query("select store_user_id from #_store_detail where status='Active'"); 
while($res=$cms->db_fetch_array($rsStore)){ 
   $storeArr[]=$res[store_user_id];
} 
 
if($cms->is_post_back()){  
		$_POST[url] = $adm->baseurl($title);  
		$z=implode(",",$_POST[sendto]); 
		$_POST[store_user_id]=$z;
	if($_POST[allselect]){
		$all=implode(",",$storeArr);
		$_POST[store_user_id]=$all; 
    } 
	$_POST[submitdate] = time();
	$_POST[url] = $adm->baseurl($title);  
	$_POST[status] = 'Active';  
	$z=implode(",",$_POST[sendto]); 
	if(count($_POST[sendto])==1){
		foreach($_POST[sendto] as $val){
			if($val=='All'){
				$_POST[store_user_id] = implode(",",$storeArr);
			}else if($val=='stores'){
				$rsStore=$cms->db_query("select pid from #_store_user where status='Active' and type = 'store'"); 
				while($res=$cms->db_fetch_array($rsStore)){ 
				   $stores[]=$res[pid];
				} 
				$_POST[store_user_id] = implode(",",$stores);
			}
			else if($val=='brands'){
				$rsStore=$cms->db_query("select pid from #_store_user where status='Active' and type = 'brand'"); 
				while($res=$cms->db_fetch_array($rsStore)){ 
				   $stores[]=$res[pid];
				} 
				$_POST[store_user_id] = implode(",",$stores);
			} 
		} 
	}else{
		foreach($_POST[sendto] as $val){
			$storelist .= $val.",";
		}  
		$_POST[store_user_id] = substr($storelist,0,-1);
	} 
>>>>>>> .r947
	if($updateid){	
		$uids =  $cms->sqlquery("rs","announcement",$_POST,'pid',$updateid);
		$adm->sessset('Record has been updated', 's');
<<<<<<< .mine
	}else{
		$_POST[dd] = date("d");
		$_POST[mm] = date("m");
		$_POST[yy] = date("Y"); 
		$_POST[submitdate] = time();
=======
	}else{ 
>>>>>>> .r947
		$uids =  $cms->sqlquery("rs","announcement",$_POST);
		$adm->sessset('Record has been added', 's');
<<<<<<< .mine
	}
		$cms->db_query("update #_announcement set `body` = '".$_POST[body]."' where `pid` in ($uids)");
		$cms->redir(SITE_PATH_ADM.CPAGE, true);
=======
	} 
	$cms->redir(SITE_PATH_ADM.CPAGE, true);
>>>>>>> .r947
}	
if(isset($id)){
		$rsAdmin=$cms->db_query("select * from #_announcement where pid='".$id."'");
		$arrAdmin=$cms->db_fetch_array($rsAdmin);
		@extract($arrAdmin);
}

 if($store_user_id) $perm = explode(',',$store_user_id);
?>
   
  <table width="100%" border="0" align="left" cellpadding="4" cellspacing="1" class="frm-tbl2">
    <tr  class="grey_">
      <td width="25%" class="label">Title:*</td>
      <td width="75%"><input name="title" type="text" class="txt medium" id="title" lang="R" title="Title" value="<?=$title?>" /></td>
    </tr>
     

   <tr>
      <td width="25%"  class="label">Send To Store/Brand:<span>*</span></td>
<<<<<<< .mine
      <td width="75%"><input type="checkbox" name="allselect" > All Select:
	  <select name="sendto[]"  style="width:400px;height:200px" class="txt" title="Permission" multiple ><?php 
	  foreach($storeArr as $val){ ?> 
		    <option value="<?=$val?>" <?=(in_array($val,$perm))?'selected="selected"':''?> ><?=$cms->getSingleresult("select title from #_store_detail where store_user_id='$val'")?></option>  
<?php } ?>  
            </select>  
      <td width="75%">  
	  <select name="sendto[]"  style="width:400px;height:200px" class="txt" title="Permission" multiple >
	  <option value="All">--Send To All Stores & Brands --</option>
	  <option value="stores">--Send To All Store Only--</option>
	  <option value="brands">--Send To All Brand Only--</option>
	  <?php 
	  foreach($storeArr as $val){ ?> 
		    <option value="<?=$val?>" <?=(in_array($val,$perm))?'selected="selected"':''?> ><?=$cms->getSingleresult("select title from #_store_detail where store_user_id='$val'")?></option>  
<?php } ?>  
            </select>  
	  </td>
    </tr> 
	<tr>
	  <td valign="top" class="label">Description:</td>
	  <td valign="top"><?=$adm->get_editor('body', $body, SITE_SUB_PATH)?></td>
    </tr>
	 
	<tr>
	  <td>&nbsp;</td>
	  <td>
	  <input type="submit" name="Submit" class="uibutton  loading"  value="&nbsp;&nbsp;&nbsp;Submit&nbsp;&nbsp;&nbsp;" /></td>
    </tr>	
  </table>
 
 <script type="text/javascript">
$('.upimg').popupWindow({ 
centerScreen:1 
}); 
</script>