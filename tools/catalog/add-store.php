<?php include("../../lib/opin.inc.php")?>
<?php define("CPAGE","catalog/")?>
<?php 
if($cms->is_post_back()){  
	$_POST[url] = $cms->subdomain($pagename);
	$_POST[store_url] = $cms->subdomain($_POST['title']);
	if(count($_POST[storekey])){
			foreach($_POST[storekey] as $val){
				$allkeys .= "$".$val;
			}
			$allkeys = $allkeys."$";
		}
	$_POST[storekeys]  = $allkeys;
	if($updateid){
		$check = $cms->db_query("select pid from #_store_detail where title = '".$_POST['title']."' and pid != '$updateid'  ");
		if(!mysql_num_rows($check))
		{ 	
			$cms->sqlquery("rs","store_detail",$_POST,'pid',$updateid);
			$adm->sessset('Record has been updated', 's');
		}
		else{
			$adm->sessset('This store is already registered', 's');
		}
	}else{
		$check = $cms->db_query("select pid from #_store_detail where title = '".$_POST['title']."'  ");
		if(!mysql_num_rows($check))
		{ 	
		$_POST[submitdate] = time();
		$cms->sqlquery("rs","store_detail",$_POST);
		$adm->sessset('Record has been added', 's');
		$updateid = mysql_insert_id();
		}
		else
		{
			echo "<script>alert('This store is already registered')</script>";
		}
	}
	$ids=$_GET[start];
	$red = SITE_PATH_ADM.CPAGE."/manage-store.php?start=$ids";
	$cms->redir($red, true);
}
if(isset($id)){
	$rsAdmin=$cms->db_query("select * from #_store_detail where pid='".$id."'");
	$arrAdmin=$cms->db_fetch_array($rsAdmin);
	@extract($arrAdmin);
}
?>
<?php include("../inc/header.inc.php")?>

<div class="main">
  <header>
    <div class="hrd-right-wrap">
      <?php /*?> <nav>
          <ul>
            <li> <a href="<?=SITE_PATH_ADM?>"></a> </li>
            <li> <a href="<?=SITE_PATH_ADM?>catalog/collections.php">store_detail</a> </li>
            <li> <a href="<?=SITE_PATH_ADM?>catalog/manage-category.php">Category</a> </li>
            <li> <a href="<?=SITE_PATH_ADM?>setting.php?mode=true">Setting</a> </li>
           <!-- <li> <a href="">System</a> </li>-->
          </ul>
        </nav><?php */?>
      <div class="brdcm" id="hed-tit">Store Management</div>
      <div class="unvrl-btn">  <a href="javascript:void(0)" onclick="javascript:formback();" class="ub"> <img src="<?=SITE_PATH_ADM?>images/back.png" alt=""></a> </div>
    </div>
    <div class="cl"></div>
  </header>
  <div class="cl"></div>
  <div class="content">
    <div class="div-tbl">
      <div class="cl"></div>
      <? //$adm->h1_tag('Dashboard &rsaquo; Collection Manager',$others2)?>
      <?php $hedtitle = "Store Management"; ?>
      <?=$adm->alert()?>
      <div class="title"  id="innertit">
        <?=$adm->heading('Add/Update Store Detail')?>
      </div>
      <div class="tbl-contant">
        <table width="100%" border="0" align="left" cellpadding="2" cellspacing="1"  class="frm-tbl2">
			<tr  class="grey_">
			<td width="23%" class="label">Title:*</td>
			<td width="77%">
			<input required="required"  name="title" title="Title" lang="R"  type="text" class="txt medium" id="title" value="<?=$title?>" />
			</td>
			</tr>
		  <tr  class="grey_">
            <td width="23%" class="label">Tag Line</td>
            <td width="77%"><input required="required"  name="tagline" title="tagline"    type="text" class="txt medium" id="tagline" value="<?=$tagline?>" /></td>
          </tr>
		  <tr  class="grey_">
            <td width="25%" class="label">Define Your Store:</td>
            <td width="75%"> 
				<?php
				if($storekeys){
					$k = explode('$',$storekeys);
				}
				?>
                <select name="storekey[]" multiple style="height:100px;"   class="txt medium" id="storekey"  title="Storekey"> 
					  <?php $rsAdmin=$cms->db_query("select pid,keywords from #_storekey where status='Active' order by keywords");
					  while($arrAdmin=$cms->db_fetch_array($rsAdmin)){@extract($arrAdmin);
					  ?>
								  <option value="<?=$keywords?>" <?=(@in_array($keywords,$k)?'selected="selected"':'')?>>
								  <?=$keywords?>
								  </option>
								  <?
					   }?>
                </select>
               </td>
          </tr>
          <tr>
            <td valign="top" class="label"> Store Owner: </td>
			
            <td valign="top"> 
                <?=$cms->getSingleresult("select name from #_store_user where pid = '$store_user_id'");?></td>
          </tr> 
		  <?php
			if($id){
				 $qry = "select type from #_store_user where pid = '$store_user_id'";
 				$type = $cms->getSingleresult($qry); 
				if($type)
				$cond = " and type = '$type' ";?>
				<tr>
            <td valign="top" class="label">User Type:</td>
			
            <td valign="top">
			  <?=($type)?$type:'NA'?>			</td>
          </tr>
				<?php
  			}
			?>
          <tr>
            <td valign="top" class="label">Plan:</td>
			
            <td valign="top">
			  <select class="txt" lang="R"  title="Plan" name="plan_id" >
				<option value="">Select</option>
				<?php
				$sql=$cms->db_query("select pid, name from #_plans  where status = 'Active' $cond ");
				while($result=$cms->db_fetch_array($sql))
				{
				?>
				<option value="<?=$result['pid']?>"  <?=(($plan_id == $result['pid'])?"selected":"")?>><?=$result['name']?></option>
				<?php }?>
              </select>
			</td>
          </tr>
          <tr  class="grey_">
            <td width="25%" class="label">Select Country:</td>
            <td width="75%"><select name="country_id" required="required" class="txt medium" id="country_id"  lang="R" title="Category">
                <option value="")?>---Select Country--</option>
                <? $rsAdmin=$cms->db_query("select pid,country from #_country where status='Active'");
	  while($arrAdmin=$cms->db_fetch_array($rsAdmin)){@extract($arrAdmin);
	  ?>
                <option value="<?=$pid?>" <?=(($pid==$country_id || $pid==80 )?'selected="selected"':'')?>>
                <?=$country?>
                </option>
                <?
	   }?>
              </select>
            </td>
          </tr>
          <tr  class="grey_">
            <td width="25%" class="label">Select City:</td>
            <td width="75%"><div id="ajaxDiv">
                <select name="city_id" required="required" class="txt medium" id="city_id"  lang="R" title="Category">
                  <option value="")?>---Select City--</option>
                  <? $rsAdmin=$cms->db_query("select pid,city from #_city where country_id='80'");
	  while($arrAdmin=$cms->db_fetch_array($rsAdmin)){@extract($arrAdmin);
	  ?>
                  <option value="<?=$pid?>" <?=(($pid==$city_id )?'selected="selected"':'')?>>
                  <?=$city?>
                  </option>
                  <?
	   }?>
                </select>
              </div></td>
          </tr>
          <tr  class="grey_">
            <td width="23%" class="label">Address:*</td>
            <td width="77%"><input required="required"  name="Address" title="Address" lang="R"  type="text" class="txt medium" id="Address" value="<?=$Address?>" /></td>
          </tr>
		   <tr  class="grey_">
            <td width="23%" class="label">Discription</td>
            <td width="77%"><textarea name="description" id="textarea" cols="60" rows="3" ><?=$description?></textarea></td>
          </tr>
		  <tr  class="grey_">
            <td width="23%" class="label">Pin Code*</td>
            <td width="77%"><input required="required"  name="pincode" title="pincode" lang="R"  type="text" class="txt medium" id="Address" value="<?=$pincode?>" /></td>
          </tr>
          <?php if($image and $id and is_file($_SERVER['DOCUMENT_ROOT'].SITE_SUB_PATH."uploaded_files/orginal/".$image)==true){?>
          <tr>
            <td valign="top" class="label">&nbsp;</td>
            <td valign="top"><img src="<?=SITE_PATH?>uploaded_files/orginal/<?=$image?>"> </td>
          </tr>
          <?php } ?>
          <tr>
            <td valign="top" class="label"> Image:</td>
            <td valign="top"><input type="text" name="image" value="<?=$image?>" class="txt medium" id="upimg" />
              <img  class="img-click" onClick="window.open('<?=SITE_PATH_ADM."crop/imageupload.php?imgid=upimg&image=collection"?>','mywindow','width=800,height=400,left=200,scrollbars=yes, top=100,screenX=0,screenY=100')" src="<?=SITE_PATH_ADM?>images/clickhere.png" alt="" /></td>
          </tr>
          <tr  class="grey_">
            <td width="23%" class="label">Store URL:*</td>
            <td width="77%"><input  disabled="disabled" name="abc" title="Store URL"    type="text" class="txt medium" id="Store URL" value="<?=$store_url?>.fizzkart.com" />(Note: It will be ganerated automatically)</td>
          </tr>
		  
		   <tr  class="grey_">
            <td width="23%" class="label">Own Domain:</td>
            <td width="77%"><input   name="store_domain" title="Store Domain "    type="text" class="txt medium" id="Store URL" value="<?=$store_domain?>" />(Note:If you Own Domain)</td>
          </tr>
          <tr>
            <td class="label">Popular:<span>*</span></td>
            <td><select name="our_popular_store"  class="txt" lang="R" title="Status">
                <option value="1" <?=(($our_popular_store=='1')?'selected="selected"':'')?>>Yes</option>
                <option value="0" <?=(($our_popular_store=='0')?'selected="selected"':'')?>>No</option>
              </select>
            </td>
          </tr>
          <tr>
            <td class="label">Most Visited:<span>*</span></td>
            <td><select name="most_visited"  class="txt" lang="R" title="most visited">
                <option value="1" <?=(($most_visited=='1')?'selected="selected"':'')?>>Yes</option>
                <option value="0" <?=(($most_visited=='0')?'selected="selected"':'')?>>No</option>
              </select>
            </td>
          </tr>
          <tr>
            <td class="label">Status:<span>*</span></td>
            <td><select name="status"  class="txt" lang="R" title="Status">
                <option value="Active" <?=(($status=='Active')?'selected="selected"':'')?>>Active</option>
                <option value="Inactive" <?=(($status=='Inactive')?'selected="selected"':'')?>>Inactive</option>
              </select>
            </td>
          </tr>
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
$("#country_id").change(function(){
	var country_id = $(this).val();
	$.ajax({ 
		url: '<?=SITE_PATH_ADM.CPAGE?>/ajax.php?country_id='+country_id, 
		success: function (data) {
			$("#ajaxDiv").html(data); 
		},
		error: function (request, status, error) {
		alert(request.responseText);
		}
	});  
}); 
 </script>
</body></html>