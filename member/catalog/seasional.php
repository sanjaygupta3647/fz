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
	$pid  = $cms->getSingleresult("select pid from #_hotdeal where store_user_id = '".$_SESSION[uid]."'");
	if($pid){
		$cms->sqlquery("rs","hotdeal",$_POST,'pid',$pid);
		$adm->sessset('Record has been updated', 's');
	}else{
		$_POST[submitdate] = time();
		$cms->sqlquery("rs","hotdeal",$_POST);
		$adm->sessset('Record has been added', 's');
	}
	$cms->redir(SITE_PATH_MEM.CPAGE."/seasional.php", true);
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

<?php $hedtitle = "Seasional Management"; ?> 
      <?=$adm->alert()?>
      <div class="title"  id="innertit">
        <?=$adm->heading('Manage Seasional')?>
      </div>
        <div class="tbl-contant">
        <table width="100%" border="0" align="left" cellpadding="4" cellspacing="1" class="frm-tbl2" >  
		<?php
		if($pid){?> 
			<input type="hidden" name="pid" value="<?=$pid?>"><?php 
		 }?>
		 <tr>
            <td class="label">Start Date:<span>*</span><input name="dayfrom" type="text"  id="dayfrom" size="8" readonly="readonly" class="border04" value="<?=$dt?>" />
<img src="../calender/calendar.gif" width="16" height="16" id="dateon_button" title="Date selector" onmouseover="this.style.background='red';" 	onmouseout="this.style.background=''" />
<script type="text/javascript">
					Calendar.setup(
					{ inputField:"dayfrom",ifFormat:"%d-%m-%y",button:"dateon_button",step:1});
					</script></td>
            <td> End date:<input name="dayto" type="text"  id="dayto" size="8" readonly="readonly" class="border04" value="<?=$dt?>" />
<img src="../calender/calendar.gif" width="16" height="16" id="dateon_button1" title="Date selector" onmouseover="this.style.background='red';" onmouseout="this.style.background=''" />
     <script type="text/javascript"> 
	     Calendar.setup(
					{ inputField:"dayto",ifFormat:"%d-%m-%y",button:"dateon_button1",step:1});
					</script></td>
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
			   Flat Discount &nbsp;&nbsp;&nbsp;&nbsp;
			    <select name="flatpercent"  class="txt" ><?php
				for($i = 1; $i<100;$i++){?>
				<option value="<?=$i?>" <?=(($flatpercent==$i)?'selected="selected"':'')?>><?=$i?></option><?php
				}?>
                 
              </select>&nbsp;&nbsp;<b>%</b> on each hot deal product
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
