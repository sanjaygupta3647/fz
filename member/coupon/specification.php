<?php include("../../lib/opin.inc.php");
if($_GET[cat_id])
{?>
       <? 
	  $specification=$cms->getSingleresult("select specifications from #_category where pid='".$_GET[cat_id]."'");
	  $catname=$cms->getSingleresult("select name from #_category where pid='".$_GET[cat_id]."'");
	  if($specification){
		  $spec = explode(',',$specification);
 		  if(count($spec)){
			foreach($spec as $val){?>
				<input type="checkbox" name="ftitle[]" value="<?=$val?>"> <?=$val?>
				<input type="text" name="fdescription[]" style="margin:10px;" title="description" class="txt medium" value="" /><br /> 
			<?php			
			}
		  }else{
		  ?>
			<input type="checkbox" name="ftitle[]" value="<?=$specification?>"> <?=$specification?> 
			<input type="text" name="fdescription[]" style="margin:10px;" title="description" class="txt medium" value="" /><br /> 
		  <?php
		  }
	  
	  }else{
	   echo"No Specification Maintained $catname";
	  }
	  
	   	
}


?>

