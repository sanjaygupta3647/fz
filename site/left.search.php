<?php
if($_POST[search]!=""){
	$terms .= "&key=".$_POST[search];
}
if($_POST[city]!=""){
	$terms .= "&city=".$_POST[city];
}
if($_POST[market]!=""){
	$terms .= "&market=".$_POST[market];
} 
if($_POST[searchfor]!=""){
	$terms .= "&searchfor=".$_POST[searchfor];
} 
if($_POST[searchbtn]){
	header("Location:".SITE_PATH."search/?search=1".$terms); die; 
}
?>
<div class="heading">Refine Your Search</div>
<form method="post" action="">
<div class="catlink">
	<input type="text" name="search" value="<?=$_GET[key]?>" class="inputbox-inner2"  />
</div>
<div class="catlink">

<select name="searchfor" class="selectbox-inner"  id="searchfor" lang="R" title="Search Criteria">
		  
		 <option value="store" <?=($_GET[searchfor]=='store')?'selected="selected"':''?>>Store</option> 
		 <option value="brand" <?=($_GET[searchfor]=='brand')?'selected="selected"':''?>>Brand</option> 
		 <option value="product" <?=($_GET[searchfor]=='product')?'selected="selected"':''?>>Product</option>
	</select>
</div>
<div class="catlink" id="citydiv">

 <select name="city" id="search-city" class="selectbox-inner">
	<?php   
	$sql_city1="select pid,city from #_city where country_id='80'";
	$sql_city1_query=$cms->db_query($sql_city1);
	?><option value="">--Select City--</option>
	<?php while($city_array=$cms->db_fetch_array($sql_city1_query)){?>
	<option value="<?=$city_array['city']; ?>" <?php if($_GET[city]==$city_array[city]){echo 'selected="selected"';} ?> ><?php echo $city_array['city']; ?></option>
	<?php }?> 
</select>
</div>
<div class="catlink" id="marketdiv">
<select name="market" class="selectbox-inner" id="city-market">
	<?php
	if($_GET[market]){?><option value="<?=$_GET[market]?>"><?=$_GET[market]?></option> <?php }
	?>
	<option value="">Select Market</option> 
</select>
</div>
<div class="catlink">
	<input type="submit" name="searchbtn" value="GO" class="searchbtn2"  />
</div>
</form>