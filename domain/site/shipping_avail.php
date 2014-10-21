<?php
	$metaTitle = $cms->getSingleresult("select meta_title from #_meta_info where url='shipping-area' and store_user_id = '$current_store_user_id'");
	$metaIntro = $cms->getSingleresult("select meta_description from #_meta_info where url='shipping-area' and store_user_id = '$current_store_user_id'");
	$metaKeyword = $cms->getSingleresult("select meta_keyword from #_meta_info where url='shipping-area' and store_user_id = '$current_store_user_id'"); 
 
	if($_POST[pincode]!=""){
		$cond .= " and pincode=".$_POST[pincode]; 
	}
	if($_POST[city]!=""){
		$cond .= " and city like '%".$_POST[city]."%'";  
	}
	if($_POST[areaname]!=""){
		$cond .= " and areaname like '%".$_POST[areaname]."%'"; 
	}
	if($_POST[shiping_charge]!=""){
		$cond .= " and shiping_charge like '%".$_POST[shiping_charge]."%'"; 
	}
	 
	$columns = "select * ";
	$sql = " from #_shipping_area_store where store_user_id ='$current_store_user_id' $cond  ";
	$sql_count = "select count(*) ".$sql;
	$order_by == '' ? $order_by = 'pid' : true;
	$order_by2 == '' ? $order_by2 = 'desc' : true;  
	$sql .= "order by $order_by $order_by2 "; 
	$sql = $columns.$sql;
	$result = $cms->db_query($sql);
	$reccnt = $cms->db_scalar($sql_count);
	 
?>
<div class="main_shipping_area">
	<div class="main_shipping_area1">
		<div class="main_shipping_area1_head">
			<h2>Search your Shipping Availabilty</h2>
		</div>
		<div class="main_shipping_area1_text">
			<p>
				fizzkart is India's best online shopping platform, a place where people can connect with each other to buy and services. Launched in soon with the vision for buyers and sellers to "meet online ", today we have over million people buy online shop product.
			</p>
			
		</div>
		<div class="main_shipping_area1_inputs">
			<p>
				Search Your Shipping Availability to enter City, Area and Pin code given below. 
			</p>
			<form action="" method="post">
				<input type="text" name="city" id="shipping_pincode" class="main_shipping_area1_inputs-cls" placeholder="City" title="city"/>
				<input type="text" name="areaname" id="shipping_pincode" class="main_shipping_area1_inputs-cls" placeholder="Area Name" title="Area name"/> 
				<input type="text" name="pincode" id="shipping_pincode" class="main_shipping_area1_inputs-cls pincode" placeholder="Pincode" title="pincode"/>
				<input type="submit" name="main_shipping" id="main_shipping_area1_input_button" class="main_shipping_area1_input_button" value="Search" />
			</form>
		</div>
	</div>
	<?php if($reccnt>=1){ ?>
	<div class="main_shipping_area2">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<thead>
				<th width="10%" align="center" valign="middle">Sr. no.</th>
				<th width="30%" align="center" valign="middle">City</th>
				<th width="20%" align="center" valign="middle">Area</th>
				<th width="20%" align="center" valign="middle">Pincode</th>
			</thead>
			<?php if($reccnt){ $nums=1; while ($line = $cms->db_fetch_array($result)){@extract($line);?>
			<tr class="orange">
				<td width="10%" align="center" valign="middle"><?=$nums?></td>
				<td width="30%" align="center" valign="middle"><?=$city?></td>
				<td width="20%" align="center" valign="middle"><?=$areaname?></td>
				<td width="20%" align="center" valign="middle"><?=$pincode?></td>
			</tr>
			<?php  $nums++;}}else{ echo $adm->rowerror(11);}?>   
			 
		</table>
		<?php }else{ ?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0"> 
			<tr class="orange">
				<td width="100%" align="center" valign="middle">No Record Found!</td>
			</tr>
		</table>
		<?php }?>
	</div>
</div>