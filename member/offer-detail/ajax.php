<?php include("../../lib/opin.inc.php");
if($_GET[cat_id]){
	 $getProds = $cms->getAllProdsOfOffer($_SESSION[uid],$_GET[cat_id],$_GET[brand_id]);
	  ?> 
      <select name="prod[]" style="height:100px; min-width:415px"  class="txt" lang="R" title="Type" multiple >
	    <?php
		if(count($getProds)){?>
	    <option value="All">------All Product------</option>
		<?php
			foreach($getProds as $val){?>
			 <option value="<?=$val?>"><?=$cms->getSingleresult("select title from #_products_user where pid = '$val'")?></option>
			<?php			
			}
		?>
       
       <?php }else{
	   ?><option value="">------No Product Found------</option><?php
	   }?>  
      </select><?php	
}?>

