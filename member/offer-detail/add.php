<?php defined('_JEXEC') or die('Restricted access'); ?>
<style>
.text{width: 100px;}
</style>
<?php 
if($cms->is_post_back()){ 
	/*if(count($_POST[prod])){
		foreach($_POST[prod] as $val){ 
			   if($val=='All'){
				   $allprods = $cms->getAllProdsOfOffer($_SESSION[uid],$cat_id,$brand_id);
					if(count($allprods)){
						$_POST[prods] = implode(',',$allprods);
					}
					break;
			   }else{
			    $something .= $val.","; 
			   } 
		}
		if($something){
			$_POST[prods] = substr($something,0,-1);
		}
	}*/
	$getType=$cms->getSingleresult("select type from #_offer_detail where cat_id='".$cat_id."' and store_user_id = '".$_SESSION[uid]."' ");
	if($getType==$_POST[type] || $getType==""){
	$prods = $cms->getTotalProdsByCat($_SESSION[uid],$_POST[cat_id]);   
	if(count($prods)){
		$_POST[store_user_id] = $_SESSION[uid];
		if($updateid){
			$cms->sqlquery("rs","offer_detail",$_POST,'pid',$updateid);
			$adm->sessset('Record has been updated', 's'); 
		}else{  
			$_POST[submitdate] = time();
			$cms->sqlquery("rs","offer_detail",$_POST);
			$updateid = mysql_insert_id();
			$adm->sessset('Record has been added', 's'); 
		} 
	}else{
	    @extract($_POST);
		$catname=$cms->getSingleresult("select name from #_store_menu where store_user_id ='".$_SESSION[uid]."' and cat_id='".$_POST[cat_id]."'");
		$adm->sessset("No Produtcs in $catname category, please choose another category.", 'e'); 
	}
	}else{
		switch ($getType){
				case "freeProd": 
				    $adm->sessset("Only Free Product type is allowed for this category.", 'e'); 
					break;
				case "flatPercent":
					 $adm->sessset("Only Flat Discount type is allowed for this category.", 'e');  
					break;
				case "rangeQty":
					 $adm->sessset("Only Range Wise(Quantity) type is allowed for this category.", 'e');   
					break;
				case "rangeAmt":
					 $adm->sessset("Only Range Wise(Amount) type is allowed for this category.", 'e'); 
					break;
				default:
			}
		
	}

	$path = SITE_PATH_MEM.CPAGE."?cat_id=".$cat_id; 
	$cms->redir($path, true);
}	
if(isset($id)){
	$rsAdmin=$cms->db_query("select * from #_offer_detail where pid='".$id."' and store_user_id = '".$_SESSION[uid]."' ");
	$arrAdmin=$cms->db_fetch_array($rsAdmin);
	@extract($arrAdmin);
}
?>

<table width="100%" border="0" align="left" cellpadding="4" cellspacing="1" class="frm-tbl2" >
  <input type="hidden" name="offertype" value="periodoffer">
  <input type="hidden" name="cat_id" value="<?=$cat_id?>">

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
    <td width="12%" class="label">Priority:</td>
    <td width="37%">
	  <input type="text" value="<?=($porder)?$porder:'1'?>" name="porder"  class="txt" size="1" lang="R" title="Priority" /> 
    </td>
  </tr> 
  <tr  class="grey_">
    <td width="12%" class="label">Deal Discount Type:</td>
    <td width="37%"><select name="type"  class="txt DealType" lang="R" title="Type">
	    <option value="">------Select Type------</option>
        <option value="flatPercent" <?=(($type=='flatPercent')?'selected="selected"':'')?>>Flat Discount</option>
        <option value="freeProd" <?=(($type=='freeProd')?'selected="selected"':'')?>>Free Product</option>
		<option value="rangeQty" <?=(($type=='rangeQty')?'selected="selected"':'')?>>Range Wise(Quantity)</option>
		<option value="rangeAmt" <?=(($type=='rangeAmt')?'selected="selected"':'')?>>Range Wise(Amount)</option>
      </select>
    </td>
  </tr> 
 <?php 
$brand_ids = $cms->db_query("select brand_id from #_barnds_product where store_user_id='".$_SESSION[uid]."' and  cat_id ='$cat_id' group by brand_id  ");			
			if(mysql_num_rows($brand_ids)){
				?>
				<tr>
				<td class="label">Brand:<span>*</span></td>
				<td><select name="brand_id" id="brand_id"  class="txt"  title="Brand">
					<option value="" >---Select Brand---</option><?php
					while($res=$cms->db_fetch_array($brand_ids)){
					$check = $cms->getSingleresult("select status from #_request_brand where store_user_id='".$_SESSION[uid]."' and brand_id = '".$res[brand_id]."' ");
					if($check=='Active'){
					?><option value="<?=$res[brand_id]?>" <?=(($brand_id==$res[brand_id])?'selected="selected"':'')?>   ><?=$cms->getSingleresult("select title from fz_store_detail where store_user_id = '".$res[brand_id]."'")?></option><?php
					}
					}?>
				  </select></td>
			  </tr><?php
			} 
// $getProds = $cms->getAllProdsOfOffer($_SESSION[uid],$cat_id,$brand_id);
 
 ?>
 <!-- 
<tr  class="grey_">
    <td width="12%" class="label">Select Product:</td>
    <td width="37%">
	  <div id="proddiv">
	  <select name="prod[]" style="height:100px; min-width:415px"  class="txt" lang="R" title="Type" multiple >
	    <?php
		if(count($getProds)){?>
	    <option value="All">------All Product------</option>
		<?php
		    if($prods){ $selected = explode(',',$prods);}
			foreach($getProds as $val){ 
				$ms = "";
			  if(count($selected) && in_array($val,$selected)){ $ms = 'selected="selected"';}
				?>
			 <option value="<?=$val?>" <?=$ms?>><?=$cms->getSingleresult("select title from #_products_user where pid = '$val'")?></option>
			<?php			
			}
		?>
       
       <?php }else{
	   ?><option value="">------No Product Found------</option><?php
	   }?>  
      </select>
	  </div>
    </td>
  </tr> 
-->
  <tr  class="grey_ " >
    <td width="12%" class="label">Offer:</td>
    <td width="37%">

	  <p class="offer flatPercent"> Select Discount % &nbsp;&nbsp;&nbsp;&nbsp;
        <select name="flatpercent"  class="txt" >
          <?php
				for($i = 0; $i<100;$i++){?>
          <option value="<?=$i?>" <?=(($flatpercent==$i)?'selected="selected"':'')?>>
          <?=$i?>
          </option>
          <?php
				}?>
        </select>
      </p>
	<p class="offer freeProd">
	   On Purchase of 
		<select name="onshop"  class="txt" >
          <?php
				for($i = 1; $i<1000;$i++){?>
          <option value="<?=$i?>" <?=(($onshop==$i)?'selected="selected"':'')?>>
          <?=$i?>
          </option>
          <?php
				}?>
        </select> 
        
        &nbsp;&nbsp;Get &nbsp;<select name="getfree"  class="txt" >
          <?php
				for($i = 1; $i<1000;$i++){?>
          <option value="<?=$i?>" <?=(($getfree==$i)?'selected="selected"':'')?>>
          <?=$i?>
          </option>
          <?php
				}?>
        </select> &nbsp; Free &nbsp;Items</p>

	  <p class="offer rangeQty">Start Qty &nbsp;&nbsp; 
       <input name="qty1" class="text" type="text" value="<?=$qty1?>">
        &nbsp;&nbsp;&nbsp;  
        End Qty &nbsp;&nbsp; 
        <input name="qty2" class="text" type="text" value="<?=$qty2?>">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
        Discount % &nbsp; 
        <select name="qtyDisPercent"  class="txt" >
          <?php
				for($i = 1; $i<100;$i++){?>
          <option value="<?=$i?>" <?=(($qtyDisPercent==$i)?'selected="selected"':'')?>>
          <?=$i?>
          </option>
          <?php
			}?>
        </select>
      </p>

      <p class="offer rangeAmt">Start Amount &nbsp;&nbsp; 
        Rs.<input name="amount1" class="text" type="text" value="<?=$amount1?>">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
        End Amount &nbsp;&nbsp;&nbsp;&nbsp;
        Rs.<input name="amount2" class="text" type="text" value="<?=$amount2?>">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
        Discount Amount &nbsp; 
        Rs.<input name="discAmt" class="text" type="text" value="<?=$discAmt?>">
      </p>


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
