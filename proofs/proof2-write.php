<?php
$options['vanguard']=FALSE;
require "/var/www/api.ntfg.net/htdocs/hammer/vanilla.php";
$hammer->head("CloudMusic","");
$hammer->setHS(1);

$hr = new vanderburg_cloudmusic_work($hammer);

$hr->getByID(1);

$cue = $_GET['cue'];

$push['cue'] = $cue;
$hr->update($push);

$hr->getByID(1);
var_dump($hr->row);
?>