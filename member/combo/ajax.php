<?php include("../../lib/opin.inc.php");?><br/><br/>
<select name="prods[]" class="txt medium prods"    title="Product">
  <option value="" >---None--</option> 
  <?php
	  $pr = $cms->getTotalProds($_SESSION[uid]);
	  if(count($pr)){
		$prQ=$cms->db_query("select pid,title,cat_id from #_products_user where status='Active' and pid in (".implode(',',$pr).") order by title ");
		while($prs=$cms->db_fetch_array($prQ)){
		  $prQry=$cms->db_query("select  dsize,dprice,dofferprice from #_product_price where proid ='".$prs[pid]."' ");
		  if(mysql_num_rows($prQry)){
			  while($r=$cms->db_fetch_array($prQry)){ if(!$r[dsize]) $r[dsize] = 'NA';
			     $price  = (int)$cms->getPriceSize($prs[pid],$_SESSION[uid],$r[dsize]);
				 if($price>0){?>  
				 <option value="<?=$prs[pid]?>$$<?=$r[dsize]?>" <?=($prs[pid]==$val)?'selected="selected"':''?>>
				<?=$prs[title]?>(<?=$r[dsize]?>) ==> <?=$cms->getSingleresult("select name from #_store_menu where cat_id='".$prs[cat_id]."' and store_user_id ='".$_SESSION[uid]."' ")?> Category of <strong>Rs. <?=$price?></strong>
				</option><?php 
				 }
			  }
		  }  
		}
	  }?> 
</select>

