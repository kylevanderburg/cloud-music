<?php
$options['vanguard']=FALSE;
require "/var/www/api.ntfg.net/htdocs/hammer/vanilla.php";
$hammer->head("CloudMusic","");
$hammer->setHS(1);

// echo json_encode($hr->row);
// echo "<h1>".$hr->row['cue']."</h1>";

?>
<br /><br />
<span id="cuebox" class="text-center"></span>

<script>
setInterval(function(){ 
	$("#cuebox").html("");
	$.get( "proof2-read.php", {}, function(cue){
    $("#cuebox").html("<h1 class='display-1>Cue "+cue+"</h1>");
	})
 }, 3000);
</script>