<?php
 
$metaTitle = "Fizzkart Message";
$metaIntro = $_SESSION[mess_registration];
$metaKeyword = "Fizzkart Message,Fizzkart, Message";




$working_key='DB832F9427C63F7A77823DFBA8118E30';  
//Working Key should be provided here.
$encResponse=$_POST["encResp"];			//This is the response sent by the CCAvenue Server
$rcvdString=$cms->decrypt($encResponse,$working_key);		//Crypto Decryption used as per the specified working key.
$order_status="";
$decryptValues=@explode('&', $rcvdString);
$arr['logs'] = $rcvdString;
$arr['store_id'] = 0; 
$dataSize=@sizeof($decryptValues); 
for($i = 0; $i < $dataSize; $i++) 
	{
		$information=@explode('=',$decryptValues[$i]);
		if($i==3)	$order_status=$information[1];
		if($i==1)	$tracking_id=$information[1];
		if($i==0)	$order_id=$information[1];
	}
if(count($decryptValues)){ @extract($decryptValues);}  
$arr[tracking_id] = $tracking_id;
$arr[order_id] = $order_id; 
$count = $cms->getSingleresult("select count(*) from #_cc_log where order_id = '".$arr[tracking_id]."' ");
if(!$count and $arr[tracking_id]!='') $cms->sqlquery("rs","cc_log",$arr); 
 
?>
<div class="contentarea"> 
  <div class="registerarea">
    <div class="heading">Fizzkart Message:</div>
    <div class="subarea">
    <div style="min-height:300px;">
        <div class="alert-box error" style="display:none;"><span>error: </span>Write your error message here.</div>
		<?php if($_REQUEST['AuthDesc']){ ?>
				<?=$_REQUEST['AuthDesc']?>
		<?php }else{?>
        <div class="alert-box success"><span>Congratulation </span> <br/> <?=$_SESSION[mess_registration]?> 
		<?php
		if($order_status==="Success")
			{
				echo "<br/>Your card has been charged and your transaction $order_id is successful. Your tracking id is $tracking_id ";
				
			}
			else if($order_status==="Aborted")
			{
				echo "<br>Thank you for shopping with us.We will keep you posted regarding the status of your order through e-mail";
			
			}
			else if($order_status==="Failure")
			{
				echo "<br>Thank you for shopping with us.However,the transaction has been declined.";
			}
			else
			{
				echo "<br>Security Error. Illegal access detected";
			
			}
		?>
		<br/> Click <a href="<?=SITE_PATH?>Step-1">here</a> to register new account.<br/>
		</div>
		<?php }?>
        <div class="alert-box warning" style="display:none;"><span>warning: </span>Write your warning message here.</div>
        <div class="alert-box notice" style="display:none;"><span>notice: </span>Write your notice message here.</div>
        </div>

    </div>
  </div>
</div>
