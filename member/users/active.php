<?php 




foreach($str_adm_ids as $idm){ 
						$ch1=$cms->db_query("select email  from #_members where pid='$idm'");
						 $tempRes1 = $cms->db_fetch_array($ch1);
							//$store_id=$tempRes1['store_user_id'];
							$adminEmail = $cms->getSingleresult("select email_id from #_store_user where 1=1");
							$headers = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
							$headers .= 'From: Fizzkart@fizzkart.com' . "\r\n" .'CC: '.$adminEmail;
							$ch = $cms->db_query("select * from #_template where title ='Active Product' and store_id = '0' ");
							if(!mysql_num_rows($ch)){
								$ch = $cms->db_query("select * from #_template where title ='Active Product' and store_id = '0' ");
							} 
							$tempRes = $cms->db_fetch_array($ch);
							$subject2 = $tempRes[subject]; 
							///$url=$cms->curPageURL();
							$subject2 = str_replace("%%productname%%", $meta_title,$subject2);
							$mess2 = $tempRes[body]; 
							$mess2 = str_replace("%%subdomain%%", SITE_PATH,$mess2);
							$mess2 = str_replace("%%productname%%",$meta_title,$mess2);
							///echo $mess2;die;
							//@mail($tempRes1['email'], $subject2, $mess2,$headers); 						
						 
					}
					?>