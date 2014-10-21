<?php
$metaTitle = $cms->getSingleresult("select meta_title from #_meta_info where url='compare' and store_user_id = '$current_store_user_id'");
$metaIntro = $cms->getSingleresult("select meta_description from #_meta_info where url='compare' and store_user_id = '$current_store_user_id'");
$metaKeyword = $cms->getSingleresult("select meta_keyword from #_meta_info where url='compare' and store_user_id = '$current_store_user_id'");
?>
<div class="main_navi_class">
<div class="comp_box">
  <h2>Product Compare Details:</h2>
   <?php
	$qry = $cms->db_query("select product_id from #_product_compare where  ssid = '".session_id()."'");
	while($res=$cms->db_fetch_array($qry)){
		@extract($res);
		$p1[] = $product_id;
	}
	if($p1[0]){
	$qry1 = $cms->db_query("select * from #_products_user where  pid = '".$p1[0]."'");
	$res1=$cms->db_fetch_array($qry1);
	}
	if($p1[1]){
	$qry2 = $cms->db_query("select * from #_products_user where  pid = '".$p1[1]."'");
	$res2=$cms->db_fetch_array($qry2);
	}
	if($p1[2]){
	$qry3 = $cms->db_query("select * from #_products_user where  pid = '".$p1[2]."'");
	$res3=$cms->db_fetch_array($qry3);
	}
	if($p1[3]){
	$qry4 = $cms->db_query("select * from #_products_user where  pid = '".$p1[3]."'");
	$res4=$cms->db_fetch_array($qry4);
	}
  ?>
  <div class="comp_pro">
    <div class="comp_pro_box" style="width:100px; height:215px;"> You can add
      upto 4 Products
      to compare </div>
    <div class="comp_pro_box"> <strong><?php
	if($res1[title]){
		echo $res1[title]; ?> <?php
	}else{
		echo"NA";
	}
	
	?></strong><span alt="<?=$res1[pid]?>" <?=($res1[title])?'':'style="display:none"'?> class="removeComp">X</span>
      <div  class="comp_pro_img"><?php
	if($res1[image1]){?>
		<a href="<?=SITE_PATH?>detail/<?=$adm->baseurl($res1['title'])?>/<?=$p1[0]?>">
		<img src="<?=SITE_PATH_M?>uploaded_files/orginal/<?=$res1['image1']?>" style="max-height:250px; max-width:200px"></a><?php
	} 
	
	?></div>
    </div>
    <div class="comp_pro_box"> <strong> <?php
	if($res2[title]){
		echo $res2[title];  
	}else{
		echo"NA";
	}
	
	?></strong><span alt="<?=$res2[pid]?>" <?=($res2[title])?'':'style="display:none"'?> class="removeComp">X</span>
      <div class="comp_pro_img"><?php
	if($res2[image1]){?>
		<a href="<?=SITE_PATH?>detail/<?=$adm->baseurl($res2['title'])?>/<?=$p1[1]?>">
		<img src="<?=SITE_PATH_M?>uploaded_files/orginal/<?=$res2['image1']?>" style="max-height:250px; max-width:200px"></a><?php
	} 
	
	?></div>
    </div>
    <div class="comp_pro_box"> <strong><?php
	if($res3[title]){
		echo $res3[title]; ?> <?php
	}else{
		echo"NA";
	}
	
	?></strong> <span alt="<?=$res3[pid]?>" class="removeComp" <?=($res3[title])?'':'style="display:none"'?>>X</span>
      <div  class="comp_pro_img"><?php
	if($res3[image1]){?>
		<a href="<?=SITE_PATH?>detail/<?=$adm->baseurl($res3['title'])?>/<?=$p1[2]?>">
		<img src="<?=SITE_PATH_M?>uploaded_files/orginal/<?=$res3['image1']?>" style="max-height:250px; max-width:200px"></a><?php
	} 
	
	?></div>
    </div>
    <div class="comp_pro_box" style="border:none;"> <strong><?php
	if($res4[title]){
		echo $res4[title];  ?> <?php
	}else{
		echo"NA";
	}
	
	?></strong><span alt="<?=$res4[pid]?>" class="removeComp" <?=($res4[title])?'':'style="display:none"'?>>X</span>
      <div  class="comp_pro_img"><?php
	if($res4[image1]){?>
		<a href="<?=SITE_PATH?>detail/<?=$adm->baseurl($res4['title'])?>/<?=$p1[3]?>">
		<img src="<?=SITE_PATH_M?>uploaded_files/orginal/<?=$res4['image1']?>" style="max-height:250px; max-width:200px"></a><?php
	} 
	
	?></div>
    </div>
  </div>
  <div class="comp_price">
    <div class="comp_pro_box" style="width:100px;">
      <div class="span2">Price</div>
    </div>
    <div class="comp_pro_box">
      <div class="span2"><?php
	if($res1[offerprice]){
		echo "Rs ".$res1[offerprice];
	}else{
		echo"NA";
	}	
	?></div>
    </div>
    <div class="comp_pro_box">
      <div class="span2"><?php
	if($res2[offerprice]){
		echo "Rs ".$res2[offerprice];
	}else{
		echo"NA";
	}	
	?></div>
    </div>
    <div class="comp_pro_box">
      <div class="span2"><?php
	if($res3[offerprice]){
		echo "Rs ".$res3[offerprice];
	}else{
		echo"NA";
	}	
	?></div>
    </div>
    <div class="comp_pro_box" style="border:none;">
      <div class="span2"><?php
	if($res4[offerprice]){
		echo "Rs ".$res4[offerprice];
	}else{
		echo"NA";
	}	
	?></div>
    </div>
  </div>
  <div class="comp_price">
    <div class="comp_pro_box" style="width:100px;">
      <div class="span2">Key Features</div>
    </div>
    <div class="comp_pro_box"><?php
	if($res1[kf1] || $res1[kf3] || $res1[kf3]){
		if($res1[kf1]){echo "*".$res1[kf1];} if($res1[kf2]){echo "<br/>* ".$res1[kf2];} if($res1[kf3]){echo "<br/>* ".$res1[kf3];} 
	}else{
		echo"NA";
	}
	
	?></div>
    <div class="comp_pro_box"><?php
	if($res2[kf1] || $res2[kf3] || $res2[kf3]){
		if($res2[kf1]){echo "*".$res2[kf1];} if($res2[kf2]){echo "<br/>* ".$res2[kf2];} if($res2[kf3]){echo "<br/>* ".$res2[kf3];} 
	}else{
		echo"NA";
	}
	
	?></div>
    <div class="comp_pro_box"><?php
	if($res3[kf1] || $res3[kf3] || $res3[kf3]){
		if($res3[kf1]){echo "*".$res3[kf1];} if($res3[kf2]){echo "<br/>* ".$res3[kf2];} if($res3[kf3]){echo "<br/>* ".$res3[kf3];} 
	}else{
		echo"NA";
	} 
	?></div>
    <div class="comp_pro_box" style="border:none;"><?php
	if($res4[kf1] || $res4[kf3] || $res4[kf3]){
		if($res4[kf1]){echo"*". $res4[kf1];} if($res4[kf2]){echo "<br/>* ".$res4[kf2];} if($res4[kf3]){echo "<br/>* ".$res4[kf3];} 
	}else{
		echo"NA";
	} 
	?></div>
  </div>
  <div class="comp_price">
    <div class="comp_pro_box" style="width:100px;">
      <div class="span2">Other Features</div>
    </div>
    <div class="comp_pro_box"><?php 
	$feature=$cms->db_query("select * from #_product_feature where prod_id='".$p1[0]."' ");
	if(mysql_num_rows($feature)){
		 while($f=$cms->db_fetch_array($feature)){ extract($f);
				echo "* ".$ftitle." : ".$fdescription."<br/>";
		 }
	}else{
		echo"NA";
	}
	
	?></div>
    <div class="comp_pro_box"><?php
	$feature=$cms->db_query("select * from #_product_feature where prod_id='".$p1[1]."' ");
	if(mysql_num_rows($feature)){
		 while($f=$cms->db_fetch_array($feature)){ extract($f);
				echo "* ".$ftitle." : ".$fdescription."<br/>";
		 }
	}else{
		echo"NA";
	}
	
	?></div>
    <div class="comp_pro_box"><?php
	$feature=$cms->db_query("select * from #_product_feature where prod_id='".$p1[2]."' ");
	if(mysql_num_rows($feature)){
		 while($f=$cms->db_fetch_array($feature)){ extract($f);
				echo "* ".$ftitle." : ".$fdescription."<br/>";
		 }
	}else{
		echo"NA";
	}
	
	?></div>
    <div class="comp_pro_box" style="border:none;"><?php
	$feature=$cms->db_query("select * from #_product_feature where prod_id='".$p1[3]."' ");
	if(mysql_num_rows($feature)){
		 while($f=$cms->db_fetch_array($feature)){ extract($f);
				echo "* ".$ftitle." : ".$fdescription."<br/>";
		 }
	}else{
		echo"NA";
	}
	
	?></div>
  </div>
  <div class="comp_price">
    <div class="comp_pro_box" style="width:100px;">
      <div class="span2">Total View</div>
    </div>
    <div class="comp_pro_box"><?php
	if($res1[clicks]){
		echo $res1[clicks];
	}else{
		echo"NA";
	}
	
	?></div>
    <div class="comp_pro_box"><?php
	if($res2[clicks]){
		echo $res2[clicks];
	}else{
		echo"NA";
	}
	
	?></div>
    <div class="comp_pro_box"><?php
	if($res3[clicks]){
		echo $res3[clicks];
	}else{
		echo"NA";
	}
	
	?></div>
    <div class="comp_pro_box" style="border:none;"><?php
	if($res4[clicks]){
		echo $res4[clicks];
	}else{
		echo"NA";
	}
	
	?></div>
  </div>
  <!--<div class="comp_price">
    <div class="comp_pro_box" style="width:100px;">
      <div class="span2">Combo Offer</div>
    </div>
    <div class="comp_pro_box"><?php 
	if($res1[combo]){
			$com = explode(',',$res1['combo']);
			foreach($com as $val){
			$fretit = $cms->getSingleresult("select title from #_products_user where pid = '$val'");
			$freprice = $cms->getSingleresult("select offerprice from #_products_user where pid = '$val'")?>
			<p><span>FREE <?=$fretit?> worth RS. <?=$freprice?></span><br /></p><?php
			}
	}else{
		echo"NA";
	}
	
	?></div>
    <div class="comp_pro_box"><?php
	if($res2[combo]){
			$com = explode(',',$res2['combo']);
			foreach($com as $val){
			$fretit = $cms->getSingleresult("select title from #_products_user where pid = '$val'");
			$freprice = $cms->getSingleresult("select offerprice from #_products_user where pid = '$val'")?>
			<p><span>FREE <?=$fretit?> worth RS. <?=$freprice?></span><br /></p><?php
			}
	}else{
		echo"NA";
	}
	
	?></div>
    <div class="comp_pro_box"><?php
	if($res3[combo]){
			$com = explode(',',$res3['combo']);
			foreach($com as $val){
			$fretit = $cms->getSingleresult("select title from #_products_user where pid = '$val'");
			$freprice = $cms->getSingleresult("select offerprice from #_products_user where pid = '$val'")?>
			<p><span>FREE <?=$fretit?> worth RS. <?=$freprice?></span><br /></p><?php
			}
	}else{
		echo"NA";
	}
	
	?></div>
    <div class="comp_pro_box" style="border:none;"><?php
	if($res4[combo]){
			$com = explode(',',$res4['combo']);
			foreach($com as $val){
			$fretit = $cms->getSingleresult("select title from #_products_user where pid = '$val'");
			$freprice = $cms->getSingleresult("select offerprice from #_products_user where pid = '$val'")?>
			<p><span>FREE <?=$fretit?> worth RS. <?=$freprice?></span><br /></p><?php
			}
	}else{
		echo"NA";
	}
	
	?></div> -->
  </div>
  </div>
</div>
