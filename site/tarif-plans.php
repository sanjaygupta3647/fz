 <?php
    if($items[2]){?>
            <div class="heading">Tarif &amp; Hosting Plan For <?=$cms->getSingleresult("select name from #_plans where pid = '".$items[2]."'")?></div>
			<div class="planbox"><?php
			$qry = $cms->db_query("SELECT pid,noOfDays,noOfMessage,amount FROM `#_plans_hosting` where plan_id ='".$items[2]."'  ");
 	 		if(mysql_num_rows($qry)){  
			while($res = $cms->db_fetch_array($qry)){
				@extract($res); ?>
				<div class="clear"></div><input type="radio" name="planID" value="<?=$pid?>" /><label><?=$noOfDays. ' Days /'.$cms->price_format($amount)?> / <?=$noOfMessage?> Message</label><?php	 
 			}?> 
			
			</div>
			<div class="plandetail">
			<strong>Categories: </strong>  <?=$cms->getCategoriesPlan($items[2])?><br />
			<strong>No. of Products</strong>: <?=$cms->getSingleresult(" select noOfProducts from #_plans where pid = '".$items[2]."'")?><br />
			<?php
			  $brands = $cms->getSingleresult(" select noOfBrands from #_plans where pid = '".$items[2]."'");
			  $stores = $cms->getSingleresult(" select noOfStores from #_plans where pid = '".$items[2]."'");
			  $type = $cms->getSingleresult(" select type from #_plans where pid = '".$items[2]."'");
			  if($type=='store'){?>
					 <strong>No. of Brands</strong>: <?=$brands?>   <br />
			  <?php
			  }else{?> 
					<strong>No. of Stores</strong>: <?=$stores?>   <br />
			  <?php
			  }?> 
			</div>
<?php 
		}
}?>
