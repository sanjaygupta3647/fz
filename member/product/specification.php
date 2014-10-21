<?php include("../../lib/opin.inc.php");
if($_GET[cat_id])
{ 
	  if($_GET[subcat]){
		 $specification=$cms->getSingleresult("select specifications from #_category where pid='".$_GET[subcat]."'"); 
	  }
	  if(!$specification) $specification=$cms->getSingleresult("select specifications from #_category where pid='".$_GET[cat_id]."'");
	  $catname=$cms->getSingleresult("select name from #_category where pid='".$_GET[cat_id]."'");
	  if($specification){
		  $spec = explode(',',$specification);
 		  if(count($spec)){
			  $i = 1;
			foreach($spec as $val){
				if($val!=""){
				$fdis=$cms->getSingleresult("select fdescription from #_product_feature where prod_id	='".$_GET[prod_id]."' and ftitle='$val'"); 
				?>
				<input type="checkbox" name="ftitle<?=$i?>" <?=($fdis)?'checked':''?> value="<?=$val?>"> <?=$val?>
				<input list="browsers" type="text" name="fdescription<?=$i?>" style="margin:10px;" title="description" class="txt medium" value="<?=$fdis?>" /><br /> 
				<datalist id="browsers">
				<option value="Uttar Pradesh">
				<?php
				$i++;
				$qry21 = $cms->db_query("select fdescription from #_product_feature group by fdescription order by fdescription");
				if(mysql_num_rows($qry21)){
				while($res2 = $cms->db_fetch_array($qry21)){?>
					<option value="<?=$res2[fdescription]?>"> <?php				
					}
				}
				 ?>
				</datalist>
			<?php	
				}
			}
		  }else{
		  ?>
			<input type="checkbox" name="ftitle1" value="<?=$specification?>"> <?=$specification?> 
			<input list="browsers" type="text" name="fdescription1" style="margin:10px;" title="description" class="txt medium" value="" /><br /> 
			<datalist id="browsers">
			<option value="Uttar Pradesh">
			<?php
			$qry21 = $cms->db_query("select fdescription from #_product_feature group by fdescription order by fdescription");
			if(mysql_num_rows($qry21)){
			while($res2 = $cms->db_fetch_array($qry21)){?>
				<option value="<?=$res2[fdescription]?>"> <?php
			
				}
			}
			 ?>
			</datalist>
		  <?php
		  }
	  
	  }else{
	   echo"No Specification Maintained $catname";
	  }
	  
	   	
}


?>

