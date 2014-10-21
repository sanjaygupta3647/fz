<?php
 $result['pid'] = $items[2];
$ms = $cms->getTarifPlan($result['pid']).$cms->getCategoriesPlan($result['pid']);

?>

<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" >
  <tr>
    <td>
	<h2><?=$cms->getSingleresult("select name from #_plans where pid = '".$items[2]."'")?></h2>
	<?=$ms?> <br />
	 No of Products: <?=$cms->getSingleresult(" select noOfProducts from #_plans where pid = '".$items[2]."'")?>   <br />
	 <?php
	  $brands = $cms->getSingleresult(" select noOfBrands from #_plans where pid = '".$items[2]."'");
	  $stores = $cms->getSingleresult(" select noOfStores from #_plans where pid = '".$items[2]."'");
	  $type = $cms->getSingleresult(" select type from #_plans where pid = '".$items[2]."'");
	  if($type=='store'){?>
	  		 No of Brands: <?=$brands?>   <br />
	  <?php
	  }else{?> 
	  		No of Stores: <?=$stores?>   <br />
	  <?php
	  }
	 ?>
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
