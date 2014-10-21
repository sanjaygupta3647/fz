<?php
$date = date_create('2014-02-01');
$days = 5;
date_add($date, date_interval_create_from_date_string($days.' days'));
echo date_format($date, 'Y-m-d');
?>