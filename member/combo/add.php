<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php 
if($cms->is_post_back()){
	$tot = 0;
	$_POST[store_user_id] = $_SESSION[uid]; 
	$_POST[prod_id] = $_POST[prods][0];
	$_POST[totalcomboproduct] = 0;
	if($_POST[prods]){
		$lop  = 0;
		foreach($_POST[prods] as $val){
			if($val){
				$_POST[totalcomboproduct]++; 
				$v = explode('$$',$val); 
				$price = $cms->getPriceSize($v[0],$_SESSION[uid],$v[1]); 
				if($lop!=0)	$content .= $val.",";
				$lop++;
				$tot  =$tot + $price;
			}  
		}
		$_POST[totalcomboproduct] = $_POST[totalcomboproduct]-1;
		$_POST[comboprod] = substr($content,0,-1);
		$_POST[totalprice] = $tot;
		if($updateid){
		$cms->sqlquery("rs","combo_prod",$_POST,'pid',$updateid);
		$adm->sessset('Combo been updated', 's');
		}else{
			$_POST[submitdate] = time();
			$cms->sqlquery("rs","combo_prod",$_POST);
			$adm->sessset('Combo has been added', 's');
		}
		//$cms->redir(SITE_PATH_MEM.CPAGE, true);
 if(isset($_GET['start']) && $_GET['start'] > 0) {
		$path = SITE_PATH_MEM.CPAGE."/index.php?start=".$_GET['start'];
	} else {
		$path = SITE_PATH_MEM.CPAGE;
	}
	$cms->redir($path, true);
		
		
		}else{ 
			$adm->sessset('No product has been selected ', 'e');
		}  
	
}	
if(isset($id)){
	$rsAdmin=$cms->db_query("select * from #_combo_prod where pid='".$id."' and store_user_id ='".$_SESSION[uid]."'");
	$arrAdmin=$cms->db_fetch_array($rsAdmin);
	@extract($arrAdmin);
}
?>
 
  <table width="100%" border="0" align="left" cellpadding="4" cellspacing="1" class="frm-tbl2">
   <tr  class="grey_">
    <td width="12%" class="label">Title:</td>
    <td width="37%">
	  <input type="text" value="<?=$title?>" name="title"  class="txt medium" lang="R" title="Title" /> 
    </td>
  </tr> 

   <tr  class="grey_">
    <td width="12%" class="label">Offer Detail:</td>
    <td width="37%">
	  <textarea  name="info"  class="txt medium" lang="R" title="Title" ><?=$info?></textarea> 
    </td>
  </tr> 
    <tr  class="grey_">
      <td width="25%" class="label">Select Product:</td>
      <td width="75%">
      <select name="prods[]" class="txt medium prods"  lang="R" title="Product">
      <option value="" >---Select--</option> 
	  <?php
	  $pr = $cms->getTotalProds($_SESSION[uid]);
	  if(count($pr)){
		$prQ=$cms->db_query("select pid,title,cat_id from #_products_user where status='Active' and pid in (".implode(',',$pr).") order by title ");
		while($prs=$cms->db_fetch_array($prQ)){
		  $prQry=$cms->db_query("select  dsize,dprice,dofferprice from #_product_price where proid ='".$prs[pid]."' ");
		  if(mysql_num_rows($prQry)){
			  while($r=$cms->db_fetch_array($prQry)){ if(!$r[dsize]) $r[dsize] = 'NA';
			     $price  = (int)$cms->getPriceSize($prs[pid],$_SESSION[uid],$r[dsize]);
				 if($price>0){?>  
				 <option value="<?=$prs[pid]?>$$<?=$r[dsize]?>" <?=($prs[pid].'$$'.$r[dsize]==$prod_id)?'selected="selected"':''?>>
				<?=$prs[title]?>(<?=$r[dsize]?>) ==> <?=$cms->getSingleresult("select name from #_store_menu where cat_id='".$prs[cat_id]."' and store_user_id ='".$_SESSION[uid]."' ")?> Category of <strong>Rs. <?=$price?></strong>
				</option><?php 
				 }
			  }
		  }  
		}
	  }?> 
	  </select>	
	   <span class="addmore">
	   <?php
	    $pr3 = $cms->getTotalProds($_SESSION[uid]);
		if($totalcomboproduct){
			$pr = explode(",",$comboprod); 
			if(count($pr)){
				foreach($pr as $val){?><br/><br/> 
					<select name="prods[]" class="txt medium prods"  title="Product">
					  <option value="" >---None--</option><?php		 
					  if(count($pr3)){
					  $prQ=$cms->db_query("select pid,title,cat_id from #_products_user where status='Active' and pid in (".implode(',',$pr3).") order by title ");
						while($prs=$cms->db_fetch_array($prQ)){
						  $prQry=$cms->db_query("select  dsize,dprice,dofferprice from #_product_price where proid ='".$prs[pid]."' ");
						  if(mysql_num_rows($prQry)){
							  while($r=$cms->db_fetch_array($prQry)){ if(!$r[dsize]) $r[dsize] = 'NA';
								 $price  = (int)$cms->getPriceSize($prs[pid],$_SESSION[uid],$r[dsize]);
								 if($price>0){?>  
								 <option value="<?=$prs[pid]?>$$<?=$r[dsize]?>" <?=($prs[pid].'$$'.$r[dsize]==$val)?'selected="selected"':''?>>
								<?=$prs[title]?>(<?=$r[dsize]?>) ==> <?=$cms->getSingleresult("select name from #_store_menu where cat_id='".$prs[cat_id]."' and store_user_id ='".$_SESSION[uid]."' ")?> Category of <strong>Rs. <?=$price?></strong>
								</option><?php 
								 }
							  }
						  }  
						}
					  }?> 
					</select><?php				
				}
			}
		}
	   ?>
	   </span>
		<p style="float:right; margin-right:100px; cursor:pointer" title="Add More" id="addclick"><strong>Add More</strong></p> 
      </td>
    </tr>
	<tr>
      <td width="25%"  class="label">Current Price:</td>
      <td width="75%"><p id="addprice"><?php
	  $explodes  = explode('$$',$prod_id);
	  $pric =	$cms->getPriceSize($explodes[0],$_SESSION[uid],$explodes[1]);
	  $str = " Rs. $pric + ";
	  $pr = explode(",",$comboprod); 
			if(count($pr)){
				foreach($pr as $val){
					$v  = explode('$$',$val); 
					$prc = $cms->getPriceSize($v[0],$_SESSION[uid],$v[1]);
					$pric = $pric + $prc;
					$str .= " Rs. $prc + ";
					}
					$str = substr($str,0,-2);
			}
			echo "$str = Rs. $pric";?> 
				</p></td>
    </tr>
   <tr>
      <td width="25%"  class="label">Combo Price:</td>
      <td width="75%"><input type="text" name="comboprice"  lang="R" title="comboprice" class="txt medium" value="<?=$comboprice?>" /></td>
    </tr>
    
	<tr>
	  <td class="label">Status:<span>*</span></td>
	  <td><select name="status" class="select" lang="R" title="Status">
	  <option value="Active" <?=(($status=='Active')?'selected="selected"':'')?>>Active</option>
	  <option value="Inactive" <?=(($status=='Inactive')?'selected="selected"':'')?>>Inactive</option>
	  </select>	  </td>
    </tr>
	 
    
	<tr>
	  <td>&nbsp;</td>
	  <td>
	  <input type="submit" name="Submit" class="uibutton  loading" value="&nbsp;&nbsp;&nbsp;Submit&nbsp;&nbsp;&nbsp;" /></td>
    </tr>	
  </table>
 <script type="text/javascript"> 
 $("#addclick").click(function(){
	$.ajax({ 
	url: '<?=SITE_PATH_MEM.CPAGE?>/ajax.php', 
	success: function (data) {
		$(".addmore").append(data); 
	},
	error: function (request, status, error) {
		alert(request.responseText);
	}
	});
 
 }); 
 /*
 $(".prods").change(function(){ 	  
		v = $(this).val(); 
		$("#addprice").html(v);
 });*/  
  
 $("body").delegate( ".prods", "change", function() {
	var v = "";
	 $(".prods").each(function() {
		v += $(this).val()+","; 
	 }); 
	 $.ajax({ 
	url: '<?=SITE_PATH_MEM.CPAGE?>/calculate.php?prods='+v, 
	success: function (data) {
		$("#addprice").html(data); 
	},
	error: function (request, status, error) {
		alert(request.responseText);
	}
	}); 
 });
</script>