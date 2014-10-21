<?php
define("APPID","539322812832955");
define("SECRET","423ea5ddfe41c115c1d63c2dd10b2293");

require 'facebook/facebook.php';

$facebook = new Facebook(array(
  'appId'  => APPID,
  'secret' => SECRET,
));


?>
