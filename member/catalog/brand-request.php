<?php 
include("../../lib/opin.inc.php");  
if($_SESSION[usertype]!='brand'){
		$cms->redir(SITE_PATH_MEM);
	}
  
if($cms->is_post_back()){   
 			
			if($_POST[status]=='Active'){
				
				$cms->db_query("update #_barnds_product set status = 'Active'  where   store_user_id = '$store' and brand_id = '".$_SESSION[uid]."' ");
			
			}
			$cms->sqlquery("rs","request_brand",$_POST,'pid',$id);
			if($_POST[status]=='Inactive'){
			$cms->req_forbrands_brans_mail($_POST['store'] ,'Inactive',$_SESSION[uid]);
			}
			if($_POST[status]=='Cancle'){
			$cms->req_forbrands_brans_mail($_POST['store'] ,'Cancle',$_SESSION[uid]);
			} 
			if($_POST[status]=='Active'){
		      $cms->req_forbrands_brans_mail($_POST['store'],'Active',$_SESSION[uid]);
		         }
		
			
			$adm->sessset('Record has been updated', 's');
			$red = SITE_PATH_MEM.CPAGE."/store-list-brand.php";
			$cms->redir($red, true);
		}
		
       
$plan_id = $cms->getSingleresult("select plan_id from #_store_detail where  pid = '".$_SESSION[store_id]."'");
$noOfStores = $cms->getSingleresult("select noOfStores from #_plans where  pid = '".$plan_id."'");
$requestedStores = $cms->getSingleresult("select count(*) from #_request_brand where brand_id ='".$_SESSION[uid]."' and status = 'Active' ");
$remainStores = (int)($noOfStores - $requestedStores);  
  
?>
<?php include("../inc/header.inc.php")?>

<div class="main">
  <header>
    <div class="hrd-right-wrap">
 
      <div class="brdcm" id="hed-tit">Store Request</div>
      <div class="unvrl-btn">   <a href="javascript:void(0)" onclick="javascript:formback();" class="ub"> <img src="<?=SITE_PATH_MEM?>images/back.png" alt=""></a> </div>
    </div>
    <div class="cl"></div>
  </header>
  <div class="cl"></div>
  <div class="content">
    <div class="div-tbl">
      <div class="cl"></div>
      <? //$adm->h1_tag('Dashboard &rsaquo; Store Request Manager',$others2)?>
      <?php $hedtitle = "Store Request Management"; ?>
      <?=$adm->alert()?>
      <div class="title"  id="innertit">
        <?=$adm->heading('Add/Update Store Detail')?>
      </div>
      <div class="tbl-contant">
        <table width="100%" border="0" align="left" cellpadding="2" cellspacing="1"  class="frm-tbl2">
		<?php   
		$request = $cms->db_query("select * from  #_request_brand where   pid = '$id' and brand_id = '".$_SESSION[uid]."' ");
		if(mysql_num_rows($request)){
			$line = $cms->db_fetch_array($request);extract($line);
			 
		?>
		<input type="hidden" name="store" value="<?=$store_user_id?>">
		<tr  class="grey_">
			<td width="23%" class="label">Store Title:</td>
			<td width="77%"><?=$cms->getSingleresult("select title from #_store_detail where store_user_id = '".$store_user_id."'")?></td>
		</tr> 
		<tr>
			<td width="25%"  class="label">Remark:</td>
			<td width="75%"><input type="text" name="remark"   title="remark" class="txt medium" value="<?=$remark?>" /></td>
		</tr>
		<tr>
			  <td class="label">Status:<span>*</span></td>
			  <td><select name="status"  class="txt medium" lang="R" title="Status">
			  <option <?php if(!$remainStores){?> disabled="disabled"<?php } ?> value="Active" <?=(($status=='Active')?'selected="selected"':'')?>>Active</option>
			  <option value="Inactive" <?=(($status=='Inactive')?'selected="selected"':'')?> >Inactive</option>
			  <option value="Cancle" <?=(($status=='Cancle')?'selected="selected"':'')?>>Cancle</option>
			  </select>	  
			  </td>
		 </tr>
		 <tr>
		<td>&nbsp;</td>
            <td><input type="submit" name="Submit" class="uibutton  loading" value="&nbsp;&nbsp;&nbsp;Submit&nbsp;&nbsp;&nbsp;" /></td>
          </tr>
		 <?php
			}else{?> 
			<tr  class="grey_">
			<td width="23%" colspan="2" class="label">No Record Found!</td> 
			</tr> 
		<?php
			}
			?> 
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