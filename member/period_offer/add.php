 <!-- caleder start  -->
<link rel="stylesheet" type="text/css" media="all" href="./calender/calendar-blue2.css" title="summer" />
<script type="text/javascript" src="./calender/calendar.js"></script>
<script type="text/javascript" src="./calender/calendar-en.js"></script>
<script type="text/javascript" src="./calender/calendar-setup.js"></script>
<!-- caleder end  -->
<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php 
if($cms->is_post_back()){
	$prods = $cms->getTotalProdsByCat($_SESSION[uid],$_POST[cat_id]); 
	$cat_id1=$cms->getSingleresult("select cat_id from #_offer where store_user_id ='".$_SESSION[uid]."' and cat_id='".$_POST[cat_id]."'");
	
	if(count($prods)){
		$_POST[store_user_id] = $_SESSION[uid];
		if($updateid){
			$cms->sqlquery("rs","offer",$_POST,'pid',$updateid);
			$adm->sessset('Record has been updated', 's'); 
		}else{ 
			if(!$cat_id1){
			$_POST[submitdate] = time();
			$cms->sqlquery("rs","offer",$_POST);
			$updateid = mysql_insert_id();
			$adm->sessset('Record has been added', 's');
			}else{ 
			$catname=$cms->getSingleresult("select name from #_store_menu where store_user_id ='".$_SESSION[uid]."' and cat_id='".$_POST[cat_id]."'");
			$dayfrom=$cms->getSingleresult("select dayfrom from #_offer where store_user_id ='".$_SESSION[uid]."' and cat_id='".$_POST[cat_id]."'");
			if($dayfrom!='0000-00-00'){
			$offer="Period Offer";
			}else{  $offer="Hot Deal Offer";   }

			$adm->sessset(" This Produtcs  $catname category Allrady in $offer, please choose another category.", 'e'); 
			}
		} 
	}else{
	    @extract($_POST);
		$catname=$cms->getSingleresult("select name from #_store_menu where store_user_id ='".$_SESSION[uid]."' and cat_id='".$_POST[cat_id]."'");
		$adm->sessset("No Produtcs in $catname category, please choose another category.", 'e'); 
	}

	$path = SITE_PATH_MEM.CPAGE.'?mode=add&id='.$updateid; 
	$cms->redir($path, true);
}	
if(isset($id)){
	$rsAdmin=$cms->db_query("select * from #_offer where pid='".$id."' and store_user_id = '".$_SESSION[uid]."' ");
	$arrAdmin=$cms->db_fetch_array($rsAdmin);
	@extract($arrAdmin);
}
?>
 
 <table width="100%" border="0" align="left" cellpadding="4" cellspacing="1" class="frm-tbl2" >   
		<input type="hidden" name="offertype" value="periodoffer">
		<tr>
            <td class="label">&nbsp;</td>
            <td><a href="<?=SITE_PATH_MEM?>offer-detail/?cat_id=<?=$cat_id?>">Manage offer</a> </td>
          </tr>
		 <tr  class="grey_">
		   <td width="12%" class="label">Select Date :From :  &nbsp;&nbsp;
		   <td width="39%">
            <input name="dayfrom" type="text"  id="dayfrom" size="8" lang="R" readonly="readonly" class="border04" value="<?=$dayfrom?>" />
            <img src="../calender/calendar.gif" name="dateon_button" width="16" height="16" id="dateon_button" title="Date selector" onmouseover="this.style.background='red';" 	onmouseout="this.style.background=''" />
            <script type="text/javascript">
					Calendar.setup(
					{ inputField:"dayfrom",ifFormat:"%y-%m-%d",button:"dateon_button",step:1});
					</script>
            &nbsp;&nbsp; To :
            <input name="dayto" type="text"  id="dayto" size="8" lang="R" readonly="readonly" class="border04" value="<?=$dayto?>" />
            <img src="../calender/calendar.gif" name="dateon_button1" width="16" height="16" id="dateon_button1" title="Date selector" onmouseover="this.style.background='red';" 	onmouseout="this.style.background=''" /> </font></span>
            <script type="text/javascript">
					Calendar.setup(
					{ inputField:"dayto",ifFormat:"%y-%m-%d",button:"dateon_button1",step:1});
					</script> </td>  </td>  </tr>
					 <tr  class="grey_">
            <td width="12%" class="label">Select Product Category:</td>
            <td width="39%">
			   <select name="cat_id"  class="txt" lang="R" title="Category"><?php
			    $rsAdmin=$cms->db_query("select cat_id,name from #_store_menu where store_user_id ='".$_SESSION[uid]."' and parent='0'  order by porder ");
				if(mysql_num_rows($rsAdmin)){
					while($arrAdmin=$cms->db_fetch_array($rsAdmin)){?>
					 <optgroup label="<?=$arrAdmin[name]?>"><?php
					 $pcat=$cms->db_query("select cat_id,name from #_store_menu where store_user_id ='".$_SESSION[uid]."' and parent='".$arrAdmin[cat_id]."'  order by porder ");
					if(mysql_num_rows($pcat)){
						while($prs=$cms->db_fetch_array($pcat)){?>
							<option value="<?=$prs[cat_id]?>" <?=(($prs[cat_id]==$cat_id)?'selected="selected"':'')?>><?=$arrAdmin[name]?> => <?=$prs[name]?></option> <?php 
						}
					}?>
					 </optgroup><?php
					
					} 
				}
				?>
              </select>
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
 
 