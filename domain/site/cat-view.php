<div  class="main_matter_area">
  <div class="main_text_brdr_none">
    <div class="left_refine_search">
      <div class="left_refine_search1">Refine Your Search</div>
      <div class="left_refine_search2">
        <p>Men</p>
        <b>Subcategory</b><br/>
        <a href="#">Mens Tshirt (394)</a> </div>
      <div class="left_refine_search3">
        <h3>Brand</h3>
        <ul>
          <li><a href="#">Puma (79)</a></li>
          <li><a href="#">Bad Mushroom (44)</a></li>
          <li><a href="#">TeeMaker (34)</a></li>
          <li><a href="#">Adidas (24)</a></li>
          <li><a href="#">Proline (22)</a></li>
          <li><a href="#">CrossCreek (21)</a></li>
          <li><a href="#">Go Untucked (18)</a></li>
          <li><a href="#">Aeropostale (17)</a></li>
          <li><a href="#">Lotto (15)</a></li>
          <li><a href="#">R.L.Polo (9)</a></li>
          <li><a href="#">Xpress Polo (8)</a></li>
          <li><a href="#">American Derby (6)</a></li>
          <li><a href="#">Attitude (6)</a></li>
          <li><a href="#">Lacost (6)</a></li>
          <li><a href="#">American Hollister (5)</a></li>
          <li><a href="#">Fila (3)</a></li>
          <li><a href="#">Reebok (3)</a></li>
          <li><a href="#">Being Human (2)</a></li>
          <li><a href="#">Duke (2)</a></li>
          <li><a href="#">Tom Tailor (2)</a></li>
          <li><a href="#">Abercrombie (1)</a></li>
          <li><a href="#">Lee (1)</a></li>
          <li><a href="#">Lee cooper (1)</a></li>
          <li><a href="#">Peter England (1)</a></li>
        </ul>
        <div class="price_range">
          <ul>
            <h3>Price Range</h3>
            <li><a href="#">Less Then 500 (96)</a></li>
            <li><a href="#">500-999 (234)</a></li>
            <li><a href="#">1000-1499 (61)</a></li>
            <li><a href="#">1500-1999 (3)</a></li>
          </ul>
        </div>
        <div class="product_text">
          <ul>
            <li><a href="#">Apparels </a></li>
            <li><a href="#">Accessories </a></li>
            <li><a href="#">Foot Wear </a></li>
            <li><a href="#">Electronics </a></li>
            <li><a href="#">Mobiles </a></li>
            <li><a href="#">Toys</a></li>
            <li><a href="#">Books</a></li>
            <li><a href="#">Food/Dry Fruit</a></li>
            <li><a href="#">Health/Beauty </a></li>
            <li><a href="#">Cashback</a></li>
            <li><a href="#">Combo</a></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="apparel_paging">
      <div class="main_text_areain_apparel2"> >><a href="#">Mens-Tshirt</a> </div>
      <div class="right2"> <a href="#">Price low-to-high</a> | <a href="#">Price high-to-low</a> </div>
    </div>
    <div class="apparel_paging2">
      <div class="main_text_areain_apparel">
        <h3>Mens-Tshirt</h3>
      </div>
      <div class="right"> <a href="#">>></a> <a href="#">>></a> <a href="#">5</a> <a href="#">4</a> <a href="#">3</a> <a href="#">2</a> <a href="#">1</a> </div>
    </div>
    <div class="apparel_paging3"><?php 
	 $i =1; 
	  $store=$cms->db_query("select pid,title,clicks,image1,price,offerprice from #_products_user where store_user_id='$current_store_user_id' 
	and status = 'Active' and cat_id = '".$items[2]."' order by pid desc");
 	if(mysql_num_rows($store)){ 
	  while($storeres=$cms->db_fetch_array($store))
				{   
					$img = SITE_PATH."uploaded_files/orginal/no-img.gif";
					if(file_exists('../uploaded_files/orginal/'.$storeres['image1']) && $storeres['image1']!="")
					{
						  $img = SITE_PATH."uploaded_files/orginal/".$storeres['image1'];
					}?>
      <div class="apparel_main_div"><a href="<?=SITE_PATH?>domain/<?=$items[0]?>/detail/<?=$adm->baseurl($storeres['title'])?>/<?=$storeres['pid']?>">
	  <img src="<?=$img?>" width="150"  height="160" title="<?=$storeres['title']?>" alt="<?=$storeres['title']?>"/>
        <div class="apparel_text">
          <p><?=$storeres['title']?></p>
         <span><?php if($storeres['offerprice']){?><span>Rs.<?=$storeres['price']?></span> Rs. <?=$storeres['offerprice']?> <?php }
						else {?> Rs.<?=$storeres['price']?> <?php }?> </span></br> 
         <a  href="<?=SITE_PATH?>domain/<?=$items[0]?>/detail/<?=$adm->baseurl($storeres['title'])?>/<?=$storeres['pid']?>">BUY NOW</a> </div>
      </div>
	  <?php $i++;
			  }
		}else{
		
		echo " No Product In This Category ";
		}?>
    </div>
  </div>
  <?php include "brand-list.php";  ?>
</div>
