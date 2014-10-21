<?php 
session_destroy();
 unset($_SESSION['access_token']);
 unset($_SESSION['gplusuer']);
echo"<script>self.location='".SITE_PATH."'</script>";
 
 ?>
