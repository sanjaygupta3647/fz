<?php include("../../lib/opin.inc.php")?>
<?php define("CPAGE","catalog/")?>
<?php 
if($cms->is_post_back()){  
 		$_POST[store_url] = $cms->baseurl21(trim(addslashes($_POST['title']))); 
		if(!$_POST[font_weight]){
			$_POST[font_weight] = "";
		}
		if(!$_POST[sfont_weight]){
			$_POST[sfont_weight] = "";
		}
		if(!$_POST[font_style]){
			$_POST[font_style] = "";
		}
		if(!$_POST[sfont_style]){
			$_POST[sfont_style] = "";
		}
		$gettitle=$cms->getSingleresult("select count(*) from #_store_detail where store_user_id!='".$_SESSION[uid]."' and title='".addslashes($title)."'"); 
 		if($gettitle){ 
				$err = true; 
		}
		if(!$err){ 
			$cms->sqlquery("rs","store_detail",$_POST,'pid',$_SESSION[store_id]);
			$adm->sessset('Record has been updated', 's');
		}
		else{
			$adm->sessset('This store/brand title is already registered', 'e');
		}
	  
	$red = SITE_PATH_MEM.CPAGE."/add-store.php";
	$cms->redir($red, true);
}
 	$rsAdmin=$cms->db_query("select * from #_store_detail where pid='".$_SESSION[store_id]."'");
	$arrAdmin=$cms->db_fetch_array($rsAdmin);
	@extract($arrAdmin);
?>
<?php include("../inc/header.inc.php")?>

<div class="main">
  <header>
    <div class="hrd-right-wrap">
      <?php /*?> <nav>
          <ul>
            <li> <a href="<?=SITE_PATH_MEM?>"></a> </li>
            <li> <a href="<?=SITE_PATH_MEM?>catalog/collections.php">store_detail</a> </li>
            <li> <a href="<?=SITE_PATH_MEM?>catalog/manage-category.php">Category</a> </li>
            <li> <a href="<?=SITE_PATH_MEM?>setting.php?mode=true">Setting</a> </li>
           <!-- <li> <a href="">System</a> </li>-->
          </ul>
        </nav><?php */?>
      <div class="brdcm" id="hed-tit">Store Management</div>
      <div class="unvrl-btn"> <a href="<?=SITE_PATH_MEM.CPAGE.'/add-store.php'?>" class="ub"> <img  src="<?=SITE_PATH_MEM?>images/add-new.png" alt=""></a> <a href="javascript:void(0)" onclick="javascript:formback();" class="ub"> <img src="<?=SITE_PATH_MEM?>images/back.png" alt=""></a> </div>
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
			<td width="23%" class="label">Title:</td>
			<td width="77%">
			&nbsp; <?=$title?> 
			</td>
			</tr>
		   <tr  class="grey_">
            <td width="23%" class="label">Tag Line</td>
            <td width="77%"><input    name="tagline" title="tagline"    type="text" class="txt medium" id="tagline" value="<?=$tagline?>" /></td>
          </tr>
          <tr>
            <td valign="top" class="label"> Store Owner: </td> 
            <td valign="top"> 
			<select name="store_user_id" id="store_user_id" required="required"  class="txt" title="Store Owner" lang="R">
                <?php
				$dbcat = $cms->db_query("select pid,name from #_store_user where status='Active' and pid = '$store_user_id'  order by `name` ");										
				while($dbrow1 = $cms->db_fetch_array($dbcat)){?>
                <option  value="<?php echo $dbrow1['pid']?>" <?=(($store_user_id == $dbrow1['pid'])?"selected":"")?>>
                <?=$dbrow1['name']?>
                </option>
                <?php } ?>
              </select></td>
          </tr>
		  <?php
			  
			$qry = "select type from #_store_user where pid = '$store_user_id'";
			$type = $cms->getSingleresult($qry); 
			 
		   ?>
		 <tr>
            <td valign="top" class="label">User Type:</td> 
            <td valign="top">
			  <?=($type)?$type:'NA'?>			
			</td>
          </tr>
		  		 
          <tr>
            <td valign="top" class="label">Plan Category:</td>
			
            <td valign="top">
			  <select class="txt" lang="R"  title="Plan" name="plan_id" >
 				<?php
				$sql=$cms->db_query("select pid, name from #_plans  where status = 'Active' and pid = '$plan_id'  ");
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
                 <? $rsAdmin=$cms->db_query("select pid,country from #_country where status='Active' and pid='80'");
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
            <td width="23%" class="label">Like Box Code</td>
            <td width="77%"><textarea name="likebox" id="textarea" cols="60" rows="3" ><?=$cms->removeSlash($likebox)?></textarea></td>
          </tr>
		  <tr  class="grey_">
            <td width="23%" class="label">Product Title Crediantial:*</td>
            <td width="77%">
			<p style="margin-top:10px;">Click to change color: <input class="color" name="color"  value="<?=($color)?$color:'080305'?>"> Font: 
			  <input type="checkbox" name="font_weight" value="font-weight:bold" <?=($font_weight=='font-weight:bold')?'checked':''?> > Bold &nbsp;
			  <input type="checkbox" name="font_style" value="font-style:italic" <?=($font_style=='font-style:italic')?'checked':''?> > Italic &nbsp;
			  <select name="font_size"> 
			  <?php
			  for($i=10;$i<=25;$i++){?>
				<option value="<?=$i?>"  <?=($i==$font_size)?'selected="selected"':''?> ><?=$i?> Px</option>
			  <?php
			  }
			  ?></select> SIze
			  </p>
			</td>
          </tr>
		   <tr  class="grey_">
            <td width="23%" class="label">Product Specification Crediantial:*</td>
            <td width="77%">
			<p style="margin-top:10px;">Click to change color: <input class="color" name="scolor"   value="<?=($scolor)?$scolor:'080305'?>"> Font: 
			  <input type="checkbox" name="sfont_weight" value="font-weight:bold" <?=($sfont_weight=='font-weight:bold')?'checked':''?>  > Bold &nbsp;
			  <input type="checkbox" name="sfont_style" value="font-style:italic" <?=($sfont_style=='font-style:italic')?'checked':''?> > Italic &nbsp;
			  <select name="sfont_size"> 
			  <?php
			  for($i=10;$i<=25;$i++){?>
				<option value="<?=$i?>"  <?=($i==$sfont_size)?'selected="selected"':''?> > <?=$i?> Px</option>
			  <?php
			  }
			  ?></select> SIze
			  </p>
			</td>
          </tr>

		  <tr  class="grey_">
            <td width="23%" class="label">Pin Code*</td>
            <td width="77%"><input required="required"  name="pincode" title="pincode" lang="R"  type="text" class="txt medium" id="Address" value="<?=$pincode?>" /></td>
          </tr>
          <?php if($image and is_file($_SERVER['DOCUMENT_ROOT'].SITE_SUB_PATH."uploaded_files/orginal/".$image)==true){?>
          <tr>
            <td valign="top" class="label">&nbsp;</td>
            <td valign="top"><img src="<?=SITE_PATH?>uploaded_files/orginal/<?=$image?>" width="100"> </td>
          </tr>
          <?php } ?>
          <tr>
            <td valign="top" class="label"> Image:</td>
            <td valign="top"><input type="text" name="image" value="<?=$image?>" class="txt medium" id="upimg" />
              <img  class="img-click" onClick="window.open('<?=SITE_PATH_MEM."crop/imageupload.php?imgid=upimg&image=collection"?>','mywindow','width=800,height=400,left=200,scrollbars=yes, top=100,screenX=0,screenY=100')" src="<?=SITE_PATH_MEM?>images/clickhere.png" alt="" /></td>
          </tr>
          <tr  class="grey_">
            <td width="23%" class="label">Store URL:</td>
            <td width="77%"><input  disabled="disabled" name="store_url" title="Store URL"    type="text" class="txt medium" id="Store URL" value="<?=$store_url?>" />(Note: It will be ganerated automatically)</td>
          </tr>
          <tr>
            <td class="label">Popular:<span></span></td>
            <td><?=($our_popular_store=='1')?'Yes':'No'?></td>           
          </tr>
          <tr>
            <td class="label">Most Visited:<span></span></td>
            <td><?=($most_visited=='1')?'Yes':'No'?></td>
          </tr>
          <tr>
            <td class="label">Status:<span></span></td>
            <td><?=$status?></td>
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
						url: '<?=SITE_PATH_MEM.CPAGE?>/ajax.php?country_id='+country_id, 
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