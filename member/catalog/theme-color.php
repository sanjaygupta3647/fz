<?php include("../../lib/opin.inc.php")?>
<?php define("CPAGE","catalog/")?>
<?php include("../inc/header.inc.php")?>
<div class="main">
<style>
span{ 
	width:5px; 
	padding:10px;
	margin-left:2px;
}
</style>
<header>
     
      <div class="hrd-right-wrap">  
        <div class="brdcm" id="hed-tit">Choose Theme Color</div>
        <div class="unvrl-btn">
		
        <a href="javascript:void(0)" onclick="javascript:submitions('change');" class="ub">
        <img src="<?=SITE_PATH_MEM?>images/change_icon.png" alt=""></a> 

        <a href="javascript:void(0)" onclick="javascript:formback();" class="ub">
        <img src="<?=SITE_PATH_MEM?>images/back.png" alt=""></a> 
        
        </div> 
      </div>
      <div class="cl"></div>
    </header>  
 <div class="cl"></div> 
<?php  
	if($cms->is_post_back()){
		if($themeId) {
			$str_adm_ids = implode(",",$themeId);
			switch ($_POST['action']){
				case "change":
					 
					$check  = $cms->getSingleresult("select themeId from #_theme_store where store_id = '".$_SESSION[store_id]."'");
					if($check){
						$cms->db_query("update #_theme_store set themeId = '".$_POST[themeId][0]."' where store_id = '".$_SESSION[store_id]."' ");
					}else{
						$cms->db_query("insert into #_theme_store set themeId = '".$_POST[themeId][0]."', store_id = '".$_SESSION[store_id]."' ");
					} 
					$adm->sessset('Theme Color Updated', 's');
					break; 
				default:
			}
		}
		$cms->redir(SITE_PATH_MEM.CPAGE."/theme-color.php", true);
		exit;
	}
	$cond = "";
	if($parentId)
	{
		$cond= " and parentId = '$parentId' ";
	}
	$start = intval($start);
	$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
	$columns = "select * ";
	$sql = " from #_themes where status = 'Active' ".$cond;
	$order_by == '' ? $order_by = 'pid' : true;
	$order_by2 == '' ? $order_by2 = 'desc' : true;
	$sql_count = "select count(*) ".$sql; 
	$sql .= "order by $order_by $order_by2 ";
	$sql .= "limit $start, $pagesize ";
	$sql = $columns.$sql;
	$result = $cms->db_query($sql);
	$reccnt = $cms->db_scalar($sql_count);
?>
<div class="content">
<div class="div-tbl">
<div class="cl"></div>

<?php $hedtitle = "Store Theme  Management"; ?> 
    <? //$adm->h1_tag('Dashboard &rsaquo; Category Manager',$others)?>
    <h1><? if($parentId) {echo $cms->getSingleresult("select name from #_category where pid='$parentId'");}?></h1>
     
      <?=$adm->alert()?>
      <div class="title"  id="innertit">
        <? //$adm->heading('Category Manager')?>
         <h2 class="bradcrumb"><?php
		if($mode=='add' && $id!=''){?>
			<a href="/member" rel="v:url" property="v:title">Home</a> »
			<a href="/member/catalog" rel="v:url" property="v:title">Theme Color</a> » 
			<a href="/catalog/?mode=add&amp;start=&amp;id=<?=$id?>" rel="v:url" property="v:title">View</a>  
		<?php		
		}else if($mode=='add' && $id=='') { 
		    ?>
			<a href="/member" rel="v:url" property="v:title">Home</a> »
			<a href="/member/catalog" rel="v:url" property="v:title">Theme Color </a> » 
			<a href="/member/catalog/?mode=add" rel="v:url" property="v:title">Add</a>  
		<?php
		}else{?>
		    <a href="/member" rel="v:url" property="v:title">Home</a> »
			<a href="/member/catalog" rel="v:url" property="v:title">Theme Color </a> »  
		<?php 
		}
		?>
	  </h2>
      </div>
      <div class="tbl-contant">
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0"  class="data-tbl">
          <tr class="t-hdr">
            <td width="5%" align="center"><?=$adm->orders('#',false)?></td>
            <td width="5%" align="center" valign="middle"><?=$adm->orders('#',false)?></td>
            <td width="37%" align="center"><?=$adm->orders('Name',true)?></td>
            <td width="27%" align="center"><?=$adm->orders('Color',true)?></td> 
          </tr>
          <?php 
		  $themeIds = $cms->getSingleresult("select themeId from #_theme_store where store_id = '".$_SESSION[store_id]."'");
		  if($reccnt){ $nums=1; while ($line = $cms->db_fetch_array($result)){@extract($line);?>
           <tr <?=$adm->even_odd($nums)?>>
            <td align="center"><?=$nums?></td>
			<td align="center"><input type="radio" name='themeId[]' <?=($pid==$themeIds)?'checked':''?> value="<?=$pid?>"></td>
			<td align="center"><?=$title?></td>
			<td align="center">
				<span style="background-color:#<?=$header_strip?>"></span>
				<span style="background-color:#<?=$sstrip?>"></span>
				<span style="background-color:#<?=$border?>"></span>
				<span style="background-color:#<?=$background?>"></span>
				<span style="background-color:#<?=$footer_strip?>"></span>
			</td>
          </tr>
          <?php $nums++;}}else{ echo $adm->rowerror(5);}?>
        </table>
      </div> 
       <div class="cl"></div>
   <?php include("../inc/paging.inc.php")?>
    <div class="cl"></div>
</div>
<?php include("../inc/footer.inc.php")?>
</div>
<div class="cl"></div>
</div>
</div> 
</body>
</html>
