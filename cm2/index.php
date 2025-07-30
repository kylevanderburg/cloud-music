<?php
//Cloud Music - Kyle Vanderburg
//Code that references NoteForge Liszt functions are prefixed LZ.

//LZ: We'll load the Liszt Core (called Hammer), and to do that we'll set some variables for this iteration:
//LZ: this page doesn't require logging in, so set the Vanguard flag to False
$options['vanguard']=FALSE;

//LZ: Vanilla is a wrapper for Hammer that loads a bunch of stuff, you can see the result at cloudmusic.me
require "/var/www/liszt.cloud/hammer/vanilla.php";

//LZ: the Head function loads...the head of the page. 
$hammer->head("CloudMusic","<link rel=\"stylesheet\" href=\"https://liszt.dev/assets/lz-master3.css?v=".$hammer->getHT('timestamp')."\" type=\"text/css\" /><link rel=\"stylesheet\" href=\"/assets/cloudmusic-bootstrap.css?v=".$hammer->getHT('timestamp')."\" type=\"text/css\" />");

	//This is dumb code that allows me to use this page as a template, which pulls in ".page" files. The interface for Cloud Music is at cloudmusic.page. 
	//KV Page Handler
	if (!isset($_GET['page'])){
		//Naked URL? Do this
		$page = "index"; //Honestly, later we'll swap index for "cloudmusic.page", so this is an exercise in futility
	}else{
		//Page specified? Do this
		$page = $_GET['page'];
		$user = $page; //Vestigal code, ignore
		$page = $page . ".page";
		if (!file_exists($page)){
			// $page = "user.page";
		}
	}

	//Vestigal code, ignore
	if (isset($_GET['page'])){$herepage = $_GET['page'] . "/";}
	if (isset($_GET['slug'])){$hereslug = $_GET['slug'] . "/";}
	if (isset($_GET['item'])){$hereitem = $_GET['item'] . "/";}
?>
 
<body>
	<?php //LZ: Liszt uses Bootstrap for its UX elements, which are loaded earlier. Here's the top navbar ?>
	<nav class="navbar navbar-light navbar-expand-md navbar-fixed-top" role="navigation">
		<div class="container">
				<a class="navbar-brand" href="/"><img src="/assets/cloudmusic.png"></a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#lisztnav" aria-controls="lisztnav" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
			<div class="collapse navbar-collapse" id="lisztnav">
				<ul class="navbar-nav mr-auto">
					<a class="nav-item<?php if($page=="index"){echo "active";}?>" href="/">Home</a>
				</ul>
			</div>
		</div><!--Container-->
	</nav>

<?php 
	//If naked url as before, load cloudmusic.page. Container is a Bootstrap class to prevent it from being full-width.
	if($page=="index"){?>
	<div class="container">
	
	<?php
	echo "<h1>Austerity</h1>";
echo "<script src=\"//cdn.liszt.app/vendor/howler.js/2.2.3/dist/howler.js\"></script>";
?>
<button type="button" class="cuebtn btn btn-lg btn-success mb-3" id="cue1"><i class="fas fa-rocket"></i> Play audio</button><br />
<button type="button" class="btn btn-lg btn-danger mb-3" id="stop"><i class="fas fa-square"></i> STOP</button><br />
<span id="alpha">asdf</span>
<span id="beta">asdf</span>
<span id="gamma">asdf</span>\

<button id="accelPermsButton"  style="height:50px;" onclick="getAccel()"><h1>Get Accelerometer Permissions</h1></button>
        
<script>
var id1;

// var cue1 = new Howl({
  // src: ['//kylevanderburg.com/assets/epm/Austerity Backing Track.wav'],
  // html5: true
// });

// $('#stop').click(function(){
	// cue1.stop();
	// $('.cuebtn').removeClass('btn-warning').removeClass('btn-kv').addClass('btn-kv');
// });

// $('#cue1').click(function(){
	// cue1.stop();
	// id1=cue1.play();
	// $('.cuebtn').removeClass('btn-warning').removeClass('btn-kv').addClass('btn-kv');
	// $('#cue1').removeClass('btn-kv').addClass('btn-warning');
// });


//Accel

function handleOrientation(event) {
	// alert(event);
  var absolute = event.absolute;
  var alpha    = event.alpha;
  var beta     = event.beta;
  var gamma    = event.gamma;
  Do stuff with the new orientation data
  $('#alpha').html(alpha);
  $('#beta').html(beta);
  $('#gamma').html(gamma);
}
window.addEventListener("deviceorientation", handleOrientation, true);

function getAccel(){
    DeviceMotionEvent.requestPermission().then(response => {
        if (response == 'granted') {
            console.log("accelerometer permission granted");
            // Do stuff here
        }
    });
}

if(window.DeviceMotionEvent){
  window.addEventListener("devicemotion", motion, false);
}else{
  console.log("DeviceMotionEvent is not supported");
}

// function motion(event){
  // alert("Accelerometer: "
    // + event.accelerationIncludingGravity.x + ", "
    // + event.accelerationIncludingGravity.y + ", "
    // + event.accelerationIncludingGravity.z
  // );
// }
</script>
	</div>

<?php }else{
	//Dynamic page load, if required ?>
	<div class="container">
	<?php if(file_exists($page)){include $page;}?>
	</div><!--container-->
<?php }	?>

<?php //LZ: Load the footer. ?>
<?php $fullwidth=0; include('/var/www/liszt.cloud/liszt-templates/footer/footer.snip');?>

<?php //LZ: Analytics tracking?>
<!-- Matomo -->
<script>
  var _paq = window._paq = window._paq || [];
  /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
  _paq.push(['trackPageView']);
  _paq.push(['enableLinkTracking']);
  (function() {
    var u="//track.liszt.app/";
    _paq.push(['setTrackerUrl', u+'matomo.php']);
    _paq.push(['setSiteId', '105']);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
    g.async=true; g.src=u+'matomo.js'; s.parentNode.insertBefore(g,s);
  })();
</script>
<!-- End Matomo Code -->


</body>
</html>