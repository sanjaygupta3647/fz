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
	///  print_r($_POST[cat_id]);die;
		$cms->db_query("delete from #_store_menu where store_user_id='".$_SESSION[uid]."' and parent='0' ");  
		if(count($_POST[cat_id])){ 
			foreach($_POST[cat_id] as $key=>$val){
				if($val){
				$arr[cat_id] = $val; 
				$arr[porder] = $_POST[$val];  
				/*print_r($arr[porder]);
				//print_r($arr[porder]);die;
				 $result = array_unique($line);
				 print_r($result);die;*/
				 $arr[name] = $_POST['n'.$val];
				 $arr[image] = $_POST['img'.$val];
				 $arr[store_user_id] =$_SESSION[uid]; 
				 	//$porder = $cms->getSingleresult("select porder from #_store_menu where porder= '".$arr[porder]."' and store_user_id = '".$_SESSION[uid]."'");
					//echo"<pre>"; print_r($arr);die;  
 		          $cms->sqlquery("rs","store_menu",$arr);  
				}
			  
			}		
		}
		
		$adm->sessset('Record has been updated', 's');  
}
$catts = array();
$rsAdmin=$cms->db_query("select * from #_store_menu where store_user_id='".$_SESSION[uid]."'");
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
        <? //$adm->heading('List Product Category')?>
		 <h2 class="bradcrumb"><?php
		if($mode=='add' && $id!=''){?>
			<a href="/member" rel="v:url" property="v:title">Home</a> »
			<a href="/member/catalog" rel="v:url" property="v:title">Manage Menue</a> » 
			<a href="/catalog/?mode=add&amp;start=&amp;id=<?=$id?>" rel="v:url" property="v:title">Edit</a>  
		<?php		
		}else if($mode=='add' && $id=='') { 
		    ?>
			<a href="/member" rel="v:url" property="v:title">Home</a> »
			<a href="/member/catalog" rel="v:url" property="v:title">Manage Menue</a> » 
			<a href="/member/catalog/?mode=add" rel="v:url" property="v:title">Add</a>  
		<?php
		}else{?>
		    <a href="/member" rel="v:url" property="v:title">Home</a> »
			<a href="/member/catalog" rel="v:url" property="v:title">Manage Menue</a> »  
		<?php 
		}
		?>
	  </h2>
      </div>
      <div class="tbl-contant">
   <table width="100%" border="0" align="left" cellpadding="4" cellspacing="1" class="frm-tbl2">
	    <tr>
          <td  width="23%" class="label2"><b>Category Name</b></td>
          <td  width="50%">&nbsp;&nbsp;<strong><b>Order&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;Display Name</b></strong></td>
		   <td class="label2" width="27%" align="left"><b>Image</b></td>
       </tr><?php
	   $getplan = $cms->getSingleresult("select plan_id from #_store_detail where  pid = '".$_SESSION[store_id]."'");
	   $brand_cat=$cms->db_query("select pid,cat_id from #_plans_category where plan_id='".$getplan."' and parent!='0'");
	   while($brand_cats=$cms->db_fetch_array($brand_cat)){?>
        <tr  class="grey_">
			<td class="label"><input type="checkbox" name="cat_id[]" <?php if(in_array($brand_cats[cat_id],$catts)) echo 'checked="checked"'; ?> value="<?=$brand_cats[cat_id]?>" />&nbsp;&nbsp;&nbsp;
			<a href="<?=SITE_PATH_MEM.CPAGE?>/manage-sub-menue.php?parent=<?=$brand_cats[cat_id]?>"><?=$cms->getSingleresult("select name from #_category where pid = '".$brand_cats[cat_id]."'")?></a></td>
			<td ><?php
			if(count($catts)){
				$porder = $cms->getSingleresult("select porder from #_store_menu where cat_id = '".$brand_cats[cat_id]."' and store_user_id = '".$_SESSION[uid]."'");
	   
			}
			$catname = $cms->getSingleresult("select name from #_store_menu where cat_id = '".$brand_cats[cat_id]."' and store_user_id = '".$_SESSION[uid]."'");
			$image = $cms->getSingleresult("select image from #_store_menu where cat_id = '".$brand_cats[cat_id]."' and store_user_id = '".$_SESSION[uid]."'");
			?>
			<input  name="<?=$brand_cats[cat_id]?>" title="porder" size="3"  type="text"  value="<?=$porder?>" />&nbsp;&nbsp;&nbsp;
			
			<input  name="<?='n'.$brand_cats[cat_id]?>" title="name" size="3"  type="text" class="txt medium"  value="<?=($catname)?$catname:$cms->getSingleresult("select name from #_category where pid = '".$brand_cats[cat_id]."'")?>" />&nbsp;&nbsp;&nbsp;
			
			<input type="text" name="<?='img'.$brand_cats[cat_id]?>" value="<?=$image?>" class="txt" id="upimg<?=$brand_cats[pid]?>" />

       <img onClick="window.open('<?=SITE_PATH_MEM."crop/imageupload.php?imgid=upimg".$brand_cats[pid]."&image=product&view=big&name=".$image?>','mywindow','width=900,height=400,left=200,scrollbars=yes, top=100,screenX=0,screenY=100')" src="<?=SITE_PATH_MEM?>images/clickhere.png" alt=""  class="img-click"/>
	   </td>
	   <td>
		<?php
		if($image){?> <img src="<?=SITE_PATH?>uploaded_files/orginal/<?=$image?>" height="45"/>&nbsp;&nbsp;
		<?php
		}
		?>
			</td>

		</tr>
        <?php
	   }?>
       <tr>
          <td>&nbsp;</td>
            <td><input type="submit" name="Submit" class="uibutton  loading" value="&nbsp;&nbsp;&nbsp;Submit&nbsp;&nbsp;&nbsp;" /></td>
          </tr>
        </table> 
     
<?php include("../inc/footer.inc.php")?>
</div>
<div class="cl"></div>
</div>
</div>
</body>
</html>