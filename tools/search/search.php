  </form>
<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php 
$order_ = true;
$hedtitle = "Searched Keywords";
$innertit = "Search List";
 
 $cond = "";
 if($status){$cond .= " and status = '$status' " ;}
  if($from){$cond .= " and submitdate>='$from' " ;}
   if($to){$cond .= "  and submitdate <='$to' " ;}
    
 

$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
$columns = "select *,  count(keyword) as kcount from #_search  ";
 $sql = "  where 1 ".$cond;
//$order_by == '' ? $order_by = 'pid' : true;
//$order_by2 == '' ? $order_by2 = 'desc' : true;

//$sql .= "order by $order_by $order_by2 ";
$sql .= "group by keyword order by id desc ";
$sql_count = $cms->db_query("select count(*) from #_search group by keyword  "); 
$sql .= "limit $start, $pagesize ";
$sql = $columns.$sql;
$result = $cms->db_query($sql);
$reccnt = mysql_num_rows($sql_count);
?>
<form method="get" style="display:none">
 <table width="100%" border="0" align="left" cellpadding="4" cellspacing="1" class="frm-tbl2">
    <tr  class="grey_">
      <td width="25%" class="label">From:*</td>
      <td width="75%"><input name="from" type="text" class="txt medium" id="invdate1" lang="R" title="Title" value="<?=$from?>" /></td>
    </tr> 
    <tr  class="grey_">
      <td width="25%" class="label">To:*</td>
      <td width="75%"><input name="to" type="text" class="txt medium" id="invdate2" lang="R" title="to" value="<?=$to?>" /></td>
    </tr>    
	<input type="hidden" name="mode" value="<?=($mode)?$mode:'cart'?>" />
    <?php /*?><tr>
      <td width="25%"  class="label">Status:<span>*</span></td>
      <td width="75%"><select name="status"  class="txt" title="Status" lang="R" xml:lang="R">
       <option value="">--Select--</option>
        <option value="pending" <?=(($status=='pending')?'selected="selected"':'')?>>Pending</option>
        <option value="delivered" <?=(($status=='delivered')?'selected="selected"':'')?>>Delivered</option>
        <option value="process" <?=(($status=='process')?'selected="selected"':'')?>>Process</option>
        <option value="canceled" <?=(($status=='canceled')?'selected="selected"':'')?>>Canceled</option>
      </select></td>
    </tr><?php */?> 
	<tr>
	  <td>&nbsp;</td>
	  <td>
      <input type="hidden" name="mode" value="order" /> 
	  <input type="submit" name="Submit" class="uibutton  loading"  value="&nbsp;&nbsp;&nbsp;Submit&nbsp;&nbsp;&nbsp;" /></td>
    </tr>	
  </table>
 </form>
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="data-tbl">
          <tr class="t-hdr">
            <td width="3%" align="center"><?=$adm->orders('#',false)?></td>
             <td width="10%" align="center"><?=$adm->orders('keyword',true)?></td>
			 <td width="5%" align="center"><?=$adm->orders('Count',true)?></td>
            <td width="5%" align="center"><?=$adm->orders('Title',true)?></td>
            <td width="15%" align="center"><?=$adm->orders('url',true)?></td>
			
			 
          </tr>
          <?php if($reccnt){ $nums=1; while ($line = $cms->db_fetch_array($result)){@extract($line);?>
          <tr <?=$adm->even_odd($nums)?>>
            <td align="center"><?=$nums?></td>
             <td align="center"><?=$keyword?></td>
			  <td align="center" valign="top"><?=$kcount?></td>
			    <td align="center"><?=$title?></td>
			<td align="center" valign="top"><a target="_blank" href="<?=$url?>"><?=$url?></a></td>
          </tr>
          <?php $nums++;}}else{ echo $adm->rowerror(5);}?>
        </table>
 <form>
 