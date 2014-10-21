<?php include("../../lib/opin.inc.php")?>
<?php define("CPAGE","catalog/")?>
<?php include("../inc/header.inc.php")?>
<div class="main">
<header>
     
      <div class="hrd-right-wrap">
        
        
        <div class="brdcm" id="hed-tit">Hot Deal</div>
        <div class="unvrl-btn">  
        <a href="javascript:void(0)" onclick="javascript:formback();" class="ub">
        <img src="<?=SITE_PATH_MEM?>images/back.png" alt=""></a> 
        
        </div> 
      </div>
      <div class="cl"></div>
    </header> 
    
 <div class="cl"></div>
<?php 
if($cms->is_post_back()){
	$_POST[store_user_id] = $_SESSION[uid];

	$_POST[url] = $adm->baseurl($name);
	if($updateid){
		$cms->sqlquery("rs","category",$_POST,'pid',$updateid);
		$adm->sessset('Record has been updated', 's');
	}else{
		$_POST[submitdate] = time();
		$cms->sqlquery("rs","category",$_POST);
		$adm->sessset('Record has been added', 's');
	}



	$pid  = $cms->getSingleresult("select pid from #_hotdeal where store_user_id = '".$_SESSION[uid]."'");
	if($pid){
		$cms->sqlquery("rs","hotdeal",$_POST,'pid',$pid);
		$adm->sessset('Record has been updated', 's');
	}else{
		$_POST[submitdate] = time();
		$cms->sqlquery("rs","hotdeal",$_POST);
		$adm->sessset('Record has been added', 's');
	}
	$cms->redir(SITE_PATH_MEM.CPAGE."/hotdeal.php", true);
}	
 	$rsAdmin=$cms->db_query("select * from #_hotdeal");
	if(mysql_num_rows($rsAdmin)){
		$arrAdmin=$cms->db_fetch_array($rsAdmin);
		@extract($arrAdmin);
	}
	
?> 
<div class="content"> 
<div class="div-tbl">
<div class="cl"></div>
    <?  //$adm->h1_tag('Dashboard &rsaquo; Category Manager',$others2)?>

<?php $hedtitle = "Hot Deal Management"; ?> 
      <?=$adm->alert()?>
      <div class="title"  id="innertit">
        <?=$adm->heading('Manage Hot Deal')?>
      </div>
        <div class="tbl-contant">
        <table width="100%" border="0" align="left" cellpadding="4" cellspacing="1" class="frm-tbl2" >  
		<?php
		if($pid){?> 
			<input type="hidden" name="pid" value="<?=$pid?>"><?php 
		 }?>
		 <tr  class="grey_">
            <td width="25%" class="label">Select Product Category:</td>
            <td width="75%">
			   <select name="cat_id"  class="txt" lang="R" title="Category"><?php
			    $rsAdmin=$cms->db_query("select cat_id,name from #_store_menu where store_user_id ='".$_SESSION[uid]."' and parent='0'  order by porder ");
				if(mysql_num_rows($rsAdmin)){
					while($arrAdmin=$cms->db_fetch_array($rsAdmin)){?>
					 <optgroup label="<?=$arrAdmin[name]?>"><?php
					 $pcat=$cms->db_query("select cat_id,name from #_store_menu where store_user_id ='".$_SESSION[uid]."' and parent='".$arrAdmin[cat_id]."'  order by porder ");
					if(mysql_num_rows($pcat)){
						while($prs=$cms->db_fetch_array($pcat)){?>
							<option value="<?=$prs[cat_id]?>"><?=$arrAdmin[name]?> => <?=$prs[name]?></option> <?php 
						}
					}?>
					 </optgroup><?php
					
					} 
				}
				?>
              </select>
			  </td>
          </tr>
          <tr  class="grey_">
            <td width="25%" class="label">Deal Discount Type:</td>
            <td width="75%">
			   <select name="type"  class="txt DealType" lang="R" title="Hote Deal Type">
                <option value="qty" <?=(($type=='qty')?'selected="selected"':'')?>>Quantity Wise</option>
                <option value="flat" <?=(($type=='flat')?'selected="selected"':'')?>>Flat % Discount</option>
              </select>
			  </td>
          </tr>
          <tr  class="grey_ qty" >
            <td width="25%" class="label">Quantity Discount Detail:</td>
            <td width="75%">Buy &nbsp;&nbsp;&nbsp;&nbsp;
			    <select name="qty1"  class="txt" ><?php
				for($i = 1; $i<10;$i++){?>
				<option value="<?=$i?>" <?=(($qty1==$i)?'selected="selected"':'')?>><?=$i?></option><?php
				}?>
                 
              </select>
			  &nbsp;&nbsp;&nbsp;&nbsp;Get &nbsp;&nbsp;&nbsp;&nbsp;
			    <select name="qty2"  class="txt" ><?php
				for($i = 1; $i<10;$i++){?>
				<option value="<?=$i?>" <?=(($qty2==$i)?'selected="selected"':'')?>><?=$i?></option><?php
				}?>
                 
              </select>&nbsp;&nbsp;&nbsp;&nbsp; Free
			  </td>
          </tr>
		  <tr  class="grey_ flat" >
            <td width="25%" class="label">Flat % Discount Detail:</td>
            <td width="75%">
				 Select Quantity &nbsp;&nbsp;&nbsp;&nbsp;
				<select name="numofprod"  class="txt" ><?php
				for($i = 1; $i<100;$i++){?>
				<option value="<?=$i?>" <?=(($numofprod==$i)?'selected="selected"':'')?>><?=$i?></option><?php
				}?>
                 
              </select>&nbsp;&nbsp;

			   Select Discount % &nbsp;&nbsp;&nbsp;&nbsp;
			    <select name="flatpercent"  class="txt" ><?php
				for($i = 1; $i<100;$i++){?>
				<option value="<?=$i?>" <?=(($flatpercent==$i)?'selected="selected"':'')?>><?=$i?></option><?php
				}?>
                 
              </select>&nbsp;&nbsp; 
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
$(document).ready(function(){
		$(".flat").hide(); 
		<?php
		if($type=='qty') {?> $(".qty").show(); $(".flat").hide();  <?php }  
		if($type=='flat') {?> $(".flat").show(); $(".qty").hide();  <?php } ?>
});
$(".DealType").change(function(){
	var type = $(this).val();
	if(type=='flat'){
		$(".flat").show();
		$(".qty").hide();
	}
	if(type=='qty'){
		$(".flat").hide();
		$(".qty").show();
	}
});
</script>
</body>
</html>
