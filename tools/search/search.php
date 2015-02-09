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
$columns = "select *,  count(keywords) as kcount from #_searchkey  ";
$sql = "  where store_id ='0'  ".$cond;
$sql .= "group by keywords,searchtype order by pid desc ";
$sql_count = $cms->db_query("select count(*) from #_searchkey where store_id ='0' group by keywords,searchtype  "); 
$sql .= "limit $start, $pagesize ";
$sql = $columns.$sql;
$result = $cms->db_query($sql);
$reccnt = mysql_num_rows($sql_count);
?> 
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="data-tbl">
          <tr class="t-hdr">
            <td width="3%" align="center"><?=$adm->orders('#',false)?></td>
             <td width="10%" align="center"><?=$adm->orders('keyword',true)?></td>
			 <td width="5%" align="center"><?=$adm->orders('Count',true)?></td>
            <td width="5%" align="center"><?=$adm->orders('Search For',true)?></td>
           
			
			 
          </tr>
          <?php if($reccnt){ $nums=1; while ($line = $cms->db_fetch_array($result)){@extract($line);?>
          <tr <?=$adm->even_odd($nums)?>>
            <td align="center"><?=$nums?></td>
             <td align="center"><?=$keywords?></td>
			  <td align="center" valign="top"><?=$kcount?></td>
			    <td align="center"><?=ucfirst($searchtype)?></td>
		 
          </tr>
          <?php $nums++;}}else{ echo $adm->rowerror(5);}?>
        </table>
 <form>
 