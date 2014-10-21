<?php 
@extract($_GET); 
echo "select count(*)  from #_shipping_area_store where store_user_id = '".$current_store_user_id."'  and picode = '$picode' and status = 'Active' "; die;
$check = $cms->getSingleresult("select count(*)  from #_shipping_area_store where store_user_id = '".$current_store_user_id."'  and picode = '$picode' and status = 'Active' "); 
if($check){echo"yes";} 
?>

