<?php
$options['vanguard']=FALSE;
require "/var/www/api.ntfg.net/htdocs/hammer/vanilla.php";
$hammer->head("CloudMusic","");
$hammer->setHS(1);

$hr = new vanderburg_cloudmusic_work($hammer);

$hr->getByID(1);
// echo json_encode($hr->row);
echo "<h1>".$hr->row['cue']."</h1>";
?>