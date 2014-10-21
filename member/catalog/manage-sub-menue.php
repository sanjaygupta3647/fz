<?php include("../../lib/opin.inc.php")?>
<?php define("CPAGE","catalog/");$mode=true?>
<?php include("../inc/header.inc.php")?>
<div class="main">
<header>
     
      <div class="hrd-right-wrap">
        
        
        <div class="brdcm" id="hed-tit">Banner</div>
        <div class="unvrl-btn"> 
        
        
        </div> 
      </div>
      <div class="cl"></div>
    </header> 
<?php
if($cms->is_post_back()){  
		if(count($_POST[cat_id])){
			$cms->db_query("delete from #_store_menu where store_user_id='".$_SESSION[uid]."' and parent ='".$_GET[parent]."' ");  
			foreach($_POST[cat_id] as $key=>$val){
				if($val){
				$arr[cat_id] = $val;
				$arr[porder] = $_POST[$val];
				$arr[parent] = $_GET[parent]; 
				$arr[name] = $_POST['n'.$val];
				$arr[store_user_id] =$_SESSION[uid];
				//echo"<pre>"; print_r($arr);die;
				$cms->sqlquery("rs","store_menu",$arr);
				}
			  
			}
		}
		$adm->sessset('Record has been updated', 's');  
}
$catts = array();
$rsAdmin=$cms->db_query("select * from #_store_menu where store_user_id='".$_SESSION[uid]."' and parent ='".$_GET[parent]."' ");
while($arrAdmin=$cms->db_fetch_array($rsAdmin)){
@extract($arrAdmin);
$catts[] = $cat_id;
}
?>
<div class="content">
<div class="div-tbl">
<div class="cl"></div>
    <? //$adm->h1_tag('Dashboard &rsaquo; Order Details',$others2)?>
  <?php $hedtitle = "Menue Management"; ?>    
      <?=$adm->alert()?>
      <div class="title">
       <a href="<?=SITE_PATH_MEM.CPAGE?>/manage-menue.php"> <?=$adm->heading('List Product sub Category of '.$cms->getSingleresult("select name from #_category where pid = '".$_GET[parent]."'"))?></a>
      </div>
	  
      <div class="tbl-contant">
   <table width="100%" border="0" align="left" cellpadding="4" cellspacing="1" class="frm-tbl2">
	    <tr>
          <td class="label2"><b>Category Name</b></td>
          <td>&nbsp;&nbsp;<strong><b>Order&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;Display Name</b></strong></td>
       </tr><?php
	   $getplan = $cms->getSingleresult("select plan_id from #_store_detail where  pid = '".$_SESSION[store_id]."'");
	   $brand_cat=$cms->db_query("select pid,name from #_category   where parentId='".$_GET[parent]."'");
	   if(mysql_num_rows($brand_cat)){
	   while($brand_cats=$cms->db_fetch_array($brand_cat)){?>
        <tr  class="grey_">
			<td width="23%" class="label"><input type="checkbox" name="cat_id[]" <?php if(in_array($brand_cats[pid],$catts)) echo 'checked="checked"'; ?> value="<?=$brand_cats[pid]?>" />&nbsp;&nbsp;&nbsp;
			 <?=$brand_cats[name]?> </td>
			<td width="77%"><?php
			if(count($catts)){
				$porder = $cms->getSingleresult("select porder from #_store_menu where cat_id = '".$brand_cats[pid]."' and store_user_id = '".$_SESSION[uid]."'");
	   
			}
			$catname = $cms->getSingleresult("select name from #_store_menu where cat_id = '".$brand_cats[pid]."' and store_user_id = '".$_SESSION[uid]."'");

			?>
			<input  name="<?=$brand_cats[pid]?>" title="porder" size="3"  type="text"  value="<?=$porder?>" />&nbsp;&nbsp;&nbsp;
			<input  name="<?='n'.$brand_cats[pid]?>" title="name" size="3"  type="text" class="txt medium"  value="<?=($catname)?$catname:$cms->getSingleresult("select name from #_category where pid = '".$brand_cats[pid]."'")?>" />
			</td>

		</tr>
        <?php
	  
	   }?>
       <tr>
          <td>&nbsp;</td>
			<input type = "hidden" name = "parent" value="<?=$_GET[parent]?>"?>
            <td><input type="submit" name="Submit" class="uibutton  loading" value="&nbsp;&nbsp;&nbsp;Submit&nbsp;&nbsp;&nbsp;" /></td>
          </tr>
	<?php
	   }else{
	   
	   echo '<tr><td colspan="2">No Sub category found</td></tr>';
	   
	   }
	   ?>
        </table> 
     
<?php include("../inc/footer.inc.php")?>
</div>
<div class="cl"></div>
</div>
</div>

<script type="text/javascript">
var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
var Accordion1 = new Spry.Widget.Accordion("Accordion1");
</script>
</body>
</html>