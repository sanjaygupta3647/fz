<?php
//$a = 34090.00;
///echo $cms->roundUptoNearestN($a);
  $sql=$cms->db_query("select pid,brand_id,size,price,offerprice from #_products");
 while($res1=$cms->db_fetch_array($sql)) 
  {
  
            $insertQry ="insert #_prod_price_admin set proid='".$res1[pid]."',store_id= '".$res1[brand_id]."',dsize = '".$res1[size]."',dprice= '".$res1[price]."',dofferprice= '".$res1[dofferprice]."'";  	
			 $cms->db_query($insertQry);
  
  } 

  /*
///Posted in Phpadda.in/// 
// the directory  './' - is the current directory  '../' - is the parent directory 
// case sensitive 
// e.x.: /home/user or c:\files 
$dir=UP_FILES_FS_PATH.'/orginal/'; 
// 1 - uppercase all files 
// 2 - lowercase all files 
// 3 - do not uppercase or lowercase 
$up=3; 
//rename files that have $w in their filename 
//case sensitive 
//set to '' if you want to rename all files 
$w='.jpg'; 
//do not rename files having $n in their filename 
$n=''; 
//add prefix to files 
$prefix=''; 
//add postfix 
$postfix=''; 
//replace 
// space with underscore
$replace=' '; 
$replace_with='_'; 
//true - traverse subdirectories 
//false - do not traverse subdirectories 
$tr=false; 
////// do NOT change anything below this ///////// 
set_time_limit(120); 
$files=array(); 
error_reporting(E_ERROR | E_PARSE); 
function prep($f,$dir) 
{ 
        global $up,$prefix,$postfix,$w,$replace_with,$replace,$n,$files; 
        if(strpos($f,$n)!==false) 
        return $f; 
        $f=str_replace($replace,$replace_with,$f); 
        if($up==1) 
        $f=strtoupper($f); 
        elseif($up==2) 
        $f=strtolower($f); 
        $f=$prefix.$f.$postfix; 
        $files[]=$dir.$f; 
        return $f; 
} 
$i=0; 
function dir_tr($dir) 
{ 
        global $i,$w,$tr,$files; 
        $dir=rtrim(trim($dir,'\\'),'/') . '/'; 
        $d=@opendir($dir); 
        if(!$d)die('The directory ' .$dir .' does not exists or PHP have no access to it<br><a target="_blank" href="http://phpadda.in">Need help?</a>'); 
        while(false!==($file=@readdir($d))) 
     { 
        if ($file!='.' && $file!='..' && $file!='renamer.php') 
        { 
            if(is_file($dir.$file)) 
            { 
                if($w=='' || (strpos($file,$w)!==false)) 
                { 
                    if(!in_array($dir.$file,$files)) 
                    { 
                        rename($dir.$file,$dir.(prep($file,$dir))); 
                        $i++; 
                    } 
                } 
            } 
            else 
            { 
                if(is_dir($dir.$file)) 
                { 
                    if($tr) 
                    dir_tr($dir.$file); 
                } 
            } 
        } 
    } 
    @closedir($d); 
} 
dir_tr($dir); 
echo '<br>Renamed ' . $i . ' files in directory ' . $dir; 
echo "<br>You can now delete renamer.php"; 

*/
?>
 

<?php /*
$arr[] = 200;
$arr[] = 100;
$arr[] = 30;
$arr[] = 210;
$arr[] = 20;
sort($arr);
 print_r($arr);
 

 $offer1 = array(); 
   $prod_id1[] = array(); 
   $arr[]=array();  
   $i=1; $j=1;   
   //$offer1[hotdealco]=1;$offer1[periodco]=1; 
   $check1=$this->db_query("select * from #_cart where  ssid = '$ssid' ");
  if(mysql_num_rows($check1)){  
	  while($res1 = $this->db_fetch_array($check1)){ extract($res1);  
      $cat_id = $this->getSingleresult("select cat_id  from #_products_user where pid='$proid' and store_user_id ='$store_user_id'"); 
	  $price = $this->getSingleresult("select price  from #_products_user where pid='$proid' and store_user_id ='$store_user_id'"); 
	  $check = $this->getSingleresult("select offertype  from #_offer where status='Active' and cat_id = '$cat_id' and store_user_id ='$store_user_id'"); 
	   if($check=='hotdeal'){  
	      $offer1[hotdealco]= $offer1[hotdealco]+$i;
	       $qty_data=$this->db_query("select * from #_offer where offertype='hotdeal' and status='Active' and cat_id = '$cat_id' and store_user_id ='$store_user_id'");
		    $rs=$this->db_fetch_array($qty_data); extract($rs); 
			$offer1[numofprod]=$numofprod;
			$offer1[amount]=$amount;
			$offer1[qty1]=$qty1;
			$offer1[flatpercent]=$flatpercent;
			if($type=='flat' && $discounttype =='percent'){
				$offer1[hflatpercent]=$flatpercent;
				$offer1[hflatpercentdis]=$res1[price]*$flatpercent/100;
				$offer1[hppayprice]=$res1[price] - $offer1[hflatpercentdis];
			}else if($type=='flat' && $discounttype =='amount'){  
				$offer1[hfdiscountp]=$amount;
				$offer1[hfpayprice]=$res1[price]-$amount; 
			}else if($type=='qty' && $discounttype =='percent'){
			    $offer1[hqflatpercent] = $flatpercent;  
				if($offer1[hotdealco]>=$offer1[numofprod]){    
				$offfer1[hqplatdis]=($res1[price]*$flatpercent)/100; 
				$offfer1[hqppayprice]=$res1[price]-$offfer1[hqplatdis];   
				 }else{
				   $offfer1[hqppayprice]=$res1[price];
				   }
			}else if($type=='qty' && $discounttype=='qty1'){  
			     $offer1[hqqty1] =$qty1;  
			if($offer1[hotdealco]>=$numofprod){ 
			     $offer1[hqtotalp]=$numofprod*$res1[price];
			     $offer1[hqpricedis] = $qty1*$res1[price];  
				 $offer1[hqpayprice]= $offer1[hqtotalp] - $offer1[hqpricedis];  
				}else{
				 $offer1[hqpayprice]=$res1[price];
				} 	 
			}else if($type=='qty' && $discounttype =='amount'){
				$offer1[hamount]=$amount;
				if($offer1[hotdealco]>=$numofprod){	 
				  $offer1[qadiscountp]=$amount;
				  $offer1[fpayprice]=$res1[price]-$amount; 
					
				}else{
				$offer1[fpayprice]=$res1[price];
				}
			}   
		       	
				
		   
	   }else if($check=='periodoffer'){ 
	          $offer1[periodco]=$offer1[periodco]+$j;
	         $qty_data=$this->db_query("select * from #_offer where offertype='periodoffer' and status='Active' and cat_id ='$cat_id' and store_user_id ='$store_user_id'");
		     $offer_rs=$this->db_fetch_array($qty_data); @extract($offer_rs);   
			 $offer1[offertype] = $offertype;
			if($type=='flat' && $discounttype =='percent'){
				$offer1[pflatpercent]=$flatpercent;
				$offer1[pflatpercentdis]=$res1[price]*$flatpercent/100;
				$offer1[pppayprice]=$res1[price] - $offer1[pflatpercentdis];   
			}else if($type=='flat' && $discounttype =='amount'){ 
				$offer1[pdiscountp]=$amount;
				$offer1[ppayprice]=$res1[price]-$offer1[pdiscountp]; 
			}else if($type=='qty' && $discounttype =='percent'){ 
				 //echo $offer1[periodco];die;
				 if($offer1[periodco]>=$numofprod){  
				 $totalpro_price=$numofprod*$res1[price];
				 $offfer1[pqplatdis]=($totalpro_price*$flatpercent)/100;
				 $offfer1[pqpayprice]=$res1[price]-$offfer1[pqplatdis];  
				 }else{
				   $offfer1[pqpayprice]=$res1[price];
				 }
			}else if($type=='qty' && $discounttype =='qty1'){   
				if($offer1[periodco]>=$numofprod){ 
			     $offer1[pqtotalp]=$res1[price]*$numofprod;
			     $offer1[pqpricedis]=$qty1*$res1[price]; 
				 $offer1[pqpayprice1]= $offer1[pqtotalp]-$offer1[pqpricedis];
				}else{
				 $offer1[pqpayprice1]=$res1[price];
				}	 	 
			}else if($type=='qty' && $discounttype =='amount'){ 
				  if($offer1[periodco]>=$numofprod){ 
					 $offer1[pdiscountp]=$amount; 
					 $offer1[ppayprice2]=$res1[price]-$offer1[pdiscountp]; 
					 $offer1[pqamount] = $amount;
				  }else{
				  $offer1[ppayprice2]=$res1[price];
				  }
		   }   
		  	       
		
		 } 
		   $combo_data=$this->db_query("select * from #_combo_prod where prod_id='$proid' and store_user_id='$store_user_id'");   
			if(mysql_num_rows($combo_data)){ 
				$prod_id1[]= $proid; 
				  $data=$this->db_fetch_array($combo_data);extract($data); 
				  $arr = explode(',',$data[comboprod]); 
				   if(array_diff($prod_id1,$arr)){   
				    $offer1[totalcomboamount] =$data[totalprice];
					$offer1[comboprice]= $data[comboprice];
					$offer1[totaldisprice]=$offer1[totalcomboamount]-$offer1[comboprice];
				}
				  }  
	        $offer1[totalamount]=$offer1[totalamount]+ $res1[price];    
	        $offer1[totaldiscountamount]=$offer1[totaldiscountamount]+$offer1[hflatpercentdis]+$offer1[hfdiscountp]+$offfer1[hqplatdis]+$offfer1[hqplatdis]+$offer1[pflatpercentdis]+$offer1[pqpricedis]+$offer1[pdiscountp]+$offer1[qadiscountp]+$offfer1[pqplatdis];
            $offer1[totalpayamount]= $offer1[totalpayamount]+$offer1[hppayprice]+$offer1[hfpayprice]+ $offer1[hqpayprice]+$offer1[fpayprice]+$offer1[pppayprice]+$offfer1[pqpayprice]+$offer1[pqpayprice1]+$offer1[ppayprice2];
	       $offfer1[pqplatdis]=0;$offer1[hflatpercentdis]=0;$offer1[hfdiscountp]=0;$offfer1[hqplatdis]=0;$offer1[pflatpercentdis]=0;$offer1[pqpricedis]=0;$offer1[pdiscountp]=0;$offer1[qadiscountp]=0;
	  }        
			  
   }
  
    
    $offer1[totalamount]= $offer1[totalamount] ; 
	$offer1[totaldiscountamount]=$offer1[totaldiscountamount]+$offer1[totaldisprice]; 
	$offer1[totalpayamount]=$offer1[totalamount]- $offer1[totaldiscountamount]; 
	return $offer1; */
?>