<?php include("../../lib/opin.inc.php")?>
<?php define("CPAGE","catalog/")?>
<?php include("../inc/header.inc.php")?>
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
        
        <div class="brdcm" id="hed-tit">Banner</div>
        <div class="unvrl-btn"> 
        <a href="<?=SITE_PATH_ADM.CPAGE.'/add-pro-sub-category.php?parentId='.$parentId?>" class="ub">
        <img  src="<?=SITE_PATH_ADM?>images/add-new.png" alt=""></a>
         
        <a href="javascript:void(0)" onclick="javascript:formback();" class="ub">
        <img src="<?=SITE_PATH_ADM?>images/back.png" alt=""></a> 
        
        </div> 
      </div>
      <div class="cl"></div>
    </header> 
    
 <div class="cl"></div>
<?php 
if($cms->is_post_back()){
	$_POST[url] = $adm->baseurl($name);
	foreach($_POST[ftitle] as $val){
		if($val!=""){
		$specifications .=$val.",";	
		}
	}
	$_POST[specifications] = substr($specifications,0,-1); 
	if($updateid){
		$cms->sqlquery("rs","category",$_POST,'pid',$updateid);
		$adm->sessset('Record has been updated', 's');
	}else{
		$_POST[submitdate] = time();
		$cms->sqlquery("rs","category",$_POST);
		$updateid = mysql_insert_id();
		$adm->sessset('Record has been added', 's');
	}
	$cms->redir(SITE_PATH_ADM.CPAGE."/manage-pro-sub-category.php?parentId=".$parentId, true);
}	
if(isset($id)){
	$rsAdmin=$cms->db_query("select * from #_category where pid='".$id."'");
	$arrAdmin=$cms->db_fetch_array($rsAdmin);
	@extract($arrAdmin);
}
?> 
<div class="content"> 
<div class="div-tbl">
<div class="cl"></div>
<?php $hedtitle = ucfirst(strtolower($cms->getSingleresult("select name from #_category where pid='$parentId'")))." Product Sub Category"; ?> 
       <?=$adm->alert()?>
      <div class="title"  id="innertit">
        <h2 class="bradcrumb"> 
			<a href="/tools" rel="v:url" property="v:title">Home</a> »<?php
			    $getuppar = $cms->getSingleresult("select parentId from #_category where pid='$parentId'");
				?><a href="/tools/catalog/manage-sub-category.php?parentId=<?=$getuppar?>" rel="v:url" property="v:title"> <?=ucfirst(strtolower($cms->getSingleresult("select name from #_category where pid='$getuppar'")))?></a>  »  

			<?php if($id){  
			    $getuppar2 = $cms->getSingleresult("select parentId from #_category where pid='$id'");
				?>
				<a href="/tools/catalog/manage-pro-sub-category.php?parentId=<?=$parentId?>" rel="v:url" property="v:title"> <?=ucfirst(strtolower($cms->getSingleresult("select name from #_category where pid='$getuppar2'")))?></a>  » 

			<a href="/tools/catalog/add-pro-sub-category.php?id=<?=$id?>&parentId=<?=$parentId?>" rel="v:url" property="v:title"> <?=ucfirst(strtolower($cms->getSingleresult("select name from #_category where pid='$id'")))?></a> 

			<?php }else{?> 
			<a href="/tools/catalog/manage-pro-sub-category.php?parentId=<?=$parentId?>" rel="v:url" property="v:title"> <?=ucfirst(strtolower($cms->getSingleresult("select name from #_category where pid='$parentId'")))?></a>  » 

			<a href="/tools/catalog/add-pro-sub-category.php?parentId=<?=$parentId?>" rel="v:url" property="v:title"> Add </a> 


			<?php
			} ?>
	     </h2> 
      </div>
        <div class="tbl-contant">
        <table width="100%" border="0" align="left" cellpadding="4" cellspacing="1" class="frm-tbl2" >
        
         <tr  class="grey_">
            <td width="25%" class="label">Under Product Category:</td>
            <td width="75%">  
            <select name="parentId" class="txt">
           <?php $rsAdmin_=$cms->db_query("select pid,name from #_category where `status`='Active' and `pid`='$parentId' order by name ");
	 		 while($arrAdmin_=$cms->db_fetch_array($rsAdmin_)){ ?>
            <option value="<?=$arrAdmin_[pid]?>" <?=(($parentId==$arrAdmin_[pid])?'selected="selected"':'')?>>
             <?=$arrAdmin_[name]?>
          </option>
          <?php  } ?>
        </select>
          </td>
          </tr>
            
          <tr  class="grey_">
            <td width="25%" class="label">Name:</td>
            <td width="75%"><input name="name" type="text" class="txt medium" id="name" value="<?=$name?>" /></td>
          </tr>
         <?php if($image and file_exists(UP_FILES_FS_PATH."/orginal/".$image)){?> 
         <tr>
          <td valign="top"  class="label"></td>
          <td><img src="<?=SITE_PATH."uploaded_files/orginal/".$image?>"?> </td>
         </tr>
         <?php } ?>
           <tr>
            <td valign="top" class="label">Image:</td>
            <td valign="top"><input type="text" name="image" value="<?=$image?>" class="txt medium" id="upimg" />
    <img  class="img-click" onClick="window.open('<?=SITE_PATH_ADM."crop/imageupload.php?imgid=upimg&image=category"?>','mywindow','width=800,height=400,left=200,scrollbars=yes, top=100,screenX=0,screenY=100')" src="<?=SITE_PATH_ADM?>images/clickhere.png" alt="" /></td>
          </tr>
          <tr>
            <td valign="top" class="label">Description:</td>
            <td valign="top"><textarea name="body" cols="40" rows="3" id="body"><?=$body?></textarea></td>
          </tr>

    <tr>
	  <td valign="top" class="label">Category Specification:</td>
	  <td valign="top">
	  <? if(!$id){?>
        <strong >Specification :</strong><input type="text" name="ftitle[]"  title="ftitle" class="txt medium"value="" /><br /><? }
		else{ 
				$feat = explode(',',$specifications);
				if(count($feat)){
					 foreach($feat as $val){?>
						<br />
						<strong >Specification :</strong><input type="text" name="ftitle[]"  title="ftitle" class="txt medium"value="<?=$val?>" /><br /><?php		 
					 }
			
			}
			else{?>
			 <strong >Specification :</strong><input type="text" name="ftitle[]"  title="ftitle" class="txt medium"value="" /><br /><?php
			}		 
		}?>
		<div class="addmore"></div>
		<p style="float:right; margin-right:410px; cursor:pointer" title="Add More" onclick="addField();"><strong>Add More</strong></p>
      </td>
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
<?php include("../inc/footer.inc.php")?></div>
</div>
<div class="cl"></div>
</div>
</div>

<script type="text/javascript"> 
 function addField(){
  var newContent = '<br /><strong >Specification :</strong><input type="text" name="ftitle[]"  title="ftitle" class="txt medium"value="" /><br />';
  $(".addmore").append(newContent); 
 }
</script> 
</body>
</html>
