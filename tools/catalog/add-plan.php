<?php include("../../lib/opin.inc.php")?>
<?php define("CPAGE","catalog/")?>
<?php include("../inc/header.inc.php")?>
  <?php 
if($cms->is_post_back()){ 
  //echo "<pre>";print_r($_POST); die;
 	//$_POST[brands] = implode(',',$_POST[brandsID]);
	if($updateid){
		$cms->sqlquery("rs","plans",$_POST,'pid',$updateid); 
		$adm->sessset('Record has been updated', 's');
	}else{ 
		$cms->sqlquery("rs","plans",$_POST);
		$updateid = mysql_insert_id();
		$adm->sessset('Record has been added', 's');
	}
	$cms->db_query("delete from #_plans_category where plan_id = '$updateid' ");
	$cms->db_query("delete from #_plans_hosting where plan_id = '$updateid' ");
	$cms->db_query("delete from #_plans_brand where plan_id = '$updateid' ");
	foreach($_POST[parent] as $val){
		$sub_cat = "";
		$qry = "insert into #_plans_category set plan_id = '$updateid', parent = '0', cat_id = '$val' "; 
		$cms->db_query($qry);
		foreach($_POST[child] as $val2){
			if($val2[$val]!=""){
				$qry2 = "insert into #_plans_category set plan_id = '$updateid', parent = '$val', cat_id = '".$val2[$val]."' "; 
				$cms->db_query($qry2); 
			}
		} 
	}
	 
	if(count($_POST[frequency_time])){
		foreach($_POST[frequency_time] as $key=> $val){
		 if(trim($val)!=""){
		 if(!$_POST[amount][$key]) $_POST[amount][$key] = "0.0";
		   $qry = "insert into #_plans_hosting set plan_id = '$updateid', noOfDays = '$val', noOfMessage = '".$_POST[noOfMessage][$key]."', amount = '".$_POST[amount][$key]."'"; 
		  $cms->db_query($qry);
		 }
		 }
		
	}
	$cms->redir(SITE_PATH_ADM.CPAGE."/add-plan.php?id=".$updateid, true);
}	
if(isset($id)){
	$rsAdmin=$cms->db_query("select * from #_plans where pid='".$id."'");
	$arrAdmin=$cms->db_fetch_array($rsAdmin);
	@extract($arrAdmin);
}
?>
<div class="main">
  <header>
    <div class="hrd-right-wrap">
      <?php /*?><nav>
          <ul>
            <li> <a href="<?=SITE_PATH_ADM?>"></a> </li>
            <li> <a href="<?=SITE_PATH_ADM?>catalog/collections.php">Products</a> </li>
            <li> <a href="<?=SITE_PATH_ADM?>catalog/manage-category.php">Category</a> </li>
            <li> <a href="<?=SITE_PATH_ADM?>setting.php?mode=true">Setting</a> </li>
           <!-- <li> <a href="">System</a> </li>-->
          </ul>
        </nav><?php */?>
      <div class="brdcm" id="hed-tit">Tarif Plan</div>
      <div class="unvrl-btn"> <a href="<?=SITE_PATH_ADM.CPAGE.'/add-plan.php'?>" class="ub"> <img  src="<?=SITE_PATH_ADM?>images/add-new.png" alt=""></a> <a href="javascript:void(0)" onclick="javascript:formback();" class="ub"> <img src="<?=SITE_PATH_ADM?>images/back.png" alt=""></a> </div>
    </div>
    <div class="cl"></div>
  </header>
  <div class="cl"></div>

  <div class="content">
    <div class="div-tbl">
      <div class="cl"></div>
      <?  //$adm->h1_tag('Dashboard &rsaquo; Category Manager',$others2)?>
      <?php $hedtitle = "Tarif Plan Management"; ?>
      <?=$adm->alert()?>
      <div class="title"  id="innertit">
 <h2><?=$cms->breadcrumbs()?></h2>
      </div>
      <div class="tbl-contant">
        <table width="100%" border="0" align="left" cellpadding="4" cellspacing="1" class="frm-tbl2" >
		 <tr  class="grey_">
            <td width="25%" class="label">Plan Type:</td>
            <td width="75%"> 
		   <select class="txt medium" lang="R" title="Plan Type" id="type" name="type">
			<option value="">------Select Plan-----</option>
			<option value="store" <?php if($type=='store') echo 'selected = "selected"' ?>>Store User</option> 
			<option value="brand" <?php if($type=='brand') echo 'selected = "selected"' ?>>Brand</option>
			 
		   </select>
	      </td>
          </tr>
		  <tr  class="grey_ stores_qty" <?php if($type=='store' || !$id){?> style="display:none" <?php }?>>
            <td width="25%" class="label">No Of Stores:</td>
            <td width="75%"> 
		  		<input name="noOfStores" type="text" class="txt medium" id="noOfStores" value="<?=$noOfStores?>" />
	      	</td>
          </tr>
		  <tr  class="grey_ brand_qty" <?php if($type=='brand' || !$id){?> style="display:none" <?php }?>>
            <td width="25%" class="label">No Of Brands:</td>
            <td width="75%"> 
		  		<input name="noOfBrands" type="text" class="txt medium" id="noOfBrands" value="<?=$noOfBrands?>" />
	      	</td>
          </tr>
          <tr class="grey_">
            <td width="25%" class="label">Combo Plan Name:</td>
            <td width="75%"><input name="name" type="text" class="txt medium" id="name" value="<?=$name?>" /></td>
          </tr>
          <tr  class="grey_">
            <td width="25%" class="label">Categories:</td>
            <td width="75%"><table width="100%" border="1">
                <?php 
			$parray = array();
			$checkqry=$cms->db_query("select cat_id  from #_plans_category where `plan_id`='$id' and parent = '0' ");
			if(mysql_num_rows($checkqry)){
			 while($arr=$cms->db_fetch_array($checkqry)){
			 $parray[] = $arr[cat_id];
			 }
			}			
			
			$rsAdmin_=$cms->db_query("select pid,name from #_category where `status`='Active' and `parentId`='0' order by name ");
	 		 while($arrAdmin_=$cms->db_fetch_array($rsAdmin_)){ ?>
                <tr>
                  <td><input type="checkbox" name="parent[]" <? if(in_array($arrAdmin_['pid'],$parray)) echo 'checked'; ?> value="<?php echo $arrAdmin_['pid']?>" />
                    <?php echo $arrAdmin_['name']?></td>
                  <td><?php $rsAdmin_1=$cms->db_query("select pid,name from #_category where `status`='Active' and `parentId`='".$arrAdmin_['pid']."' order by name ");
			$parray2 = array();
 			$parray3=$cms->db_query("select cat_id  from #_plans_category where `plan_id`= '$id' and parent = '".$arrAdmin_['pid']."' "); 
			if(mysql_num_rows($parray3)){
			 while($arr2=$cms->db_fetch_array($parray3)){
			 $parray2[] = $arr2[cat_id];
			 }
			}	 
	 		 while($arrAdmin_1=$cms->db_fetch_array($rsAdmin_1)){ ?>
                    <input type="checkbox" <?php if(in_array($arrAdmin_1['pid'],$parray2)) echo 'checked'; ?> name="child[][<?=$arrAdmin_['pid']?>]" value="<?php echo $arrAdmin_1['pid']?>" style="margin:5px;" />
                    <?php echo $arrAdmin_1['name']; }?></td>
                </tr>
                <?php  } ?>
              </table></td>
          </tr>
            
          <tr>
            <td valign="top" class="label">Hosting Plans:</td>
            <td valign="top"><? if(!$id){?>
              <strong style="margin-left:15px;">Time in Days :</strong>
              <input type="text" name="frequency_time[]"  title="frequency_time" class="txt medium qty" value="" />
              <br />
              <strong >Amount(Rs.):</strong>
              <input type="text" name="amount[]" style="margin-top:10px;" title="amount" class="txt medium qty" value="" />
			   <br /><strong>Num. Of Message :</strong><input type="text" name="noOfMessage[]" style="margin-top:10px;" title="No Of Message" class="txt medium" value="" />
              <? }else{ 
		$features=$cms->db_query("select * from #_plans_hosting where plan_id='".$id."'");
		while($res=$cms->db_fetch_array($features)){ @extract($res);?>
              <br />
              <strong style="margin-left:15px;">Time in Days :</strong>
              <input type="text" name="frequency_time[]"  title="frequency_time[]" class="txt medium qty"value="<?=$noOfDays?>" />
              <br />
              <strong >Amount(Rs.):</strong>
              <input type="text" name="amount[]" style="margin-top:10px;" title="amount" class="txt medium qty" value="<?=$amount?>" />
              <br />
			  <strong >No. Of Message:</strong>
              <input type="text" name="noOfMessage[]" style="margin-top:10px;" title="No Of Message" class="txt medium qty" value="<?=$noOfMessage?>" />
              <br />
              <? }}?>
              <div class="addmore"></div>
              <p style="float:right; margin-right:410px; cursor:pointer" title="Add More" onclick="addField();"><strong>Add More</strong></p></td>
          </tr>
          <tr>
            <td valign="top" class="label">Description:</td>
            <td valign="top"><textarea name="body" cols="40" rows="3" id="body"><?=$body?>
</textarea></td>
          </tr>
		  <tr>
            <td class="label">No Of Products:<span>*</span></td>
            <td><input type="text" name="noOfProducts"  title="No Of Products" lang="R" class="txt medium" value="<?=$noOfProducts?>" /></td>
          </tr>
		  
          <tr>
            <td class="label">Status:<span>*</span></td>
            <td><select name="status"  class="txt" lang="R" title="Status">
                <option value="Active" <?=(($status=='Active')?'selected="selected"':'')?>>Active</option>
                <option value="Inactive" <?=(($status=='Inactive')?'selected="selected"':'')?>>Inactive</option>
              </select></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><input type="submit" name="Submit" class="uibutton  loading" value="&nbsp;&nbsp;&nbsp;Submit&nbsp;&nbsp;&nbsp;" /></td>
          </tr>
        </table>
      </div>
      <div class="cl"></div>
    </div>
  </div>
  <?php include("../inc/footer.inc.php")?>
</div>
</div>
<div class="cl"></div>
</div>
</div>
<script type="text/javascript"> 
$("#type").change(function(){
var plan = $(this).val();
if(plan=='brand'){
	$(".stores_qty").show();
	$(".brand_qty").hide();  
}else{
	$(".stores_qty").hide();
	$(".brand_qty").show(); 
} 
});
 function addField(){
  var newContent = '<br /><strong style="margin-left:40px;">Time In Days :</strong><input type="text" name="frequency_time[]"  title="frequency_time" class="txt medium"value="" /><br /><strong>Amount(Rs.) :</strong><input type="text" name="amount[]" style="margin-top:10px;" title="amount" class="txt medium" value="" /><br /><br /><strong>Num. Of Message :</strong><input type="text" name="noOfMessage[]" style="margin-top:10px;" title="No Of Message" class="txt medium" value="" /><br />';
  $(".addmore").append(newContent); 
 }
</script> 
</body></html>