<?php
//Cloud Music - Kyle Vanderburg
//Code that references NoteForge Liszt functions are prefixed LZ.

//LZ: We'll load the Liszt Core (called Hammer), and to do that we'll set some variables for this iteration:
//LZ: this page doesn't require logging in, so set the Vanguard flag to False
$options['vanguard']=TRUE;
$options['vanguardAccess']="X";

//LZ: Vanilla is a wrapper for Hammer that loads a bunch of stuff, you can see the result at cloudmusic.me
require "/var/www/api.ntfg.net/htdocs/hammer/vanilla.php";

//LZ: the Head function loads...the head of the page. 
$hammer->head("CloudMusic","<link rel=\"stylesheet\" href=\"/assets/cloudmusic-bootstrap.css?v=".$hammer->getHT('timestamp')."\" type=\"text/css\" />");

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
	<?php include "cloudmusic.page";?>
	</div>

<?php }else{
	//Dynamic page load, if required ?>
	<div class="container">
	<?php if(file_exists($page)){include $page;}?>
	</div><!--container-->
<?php }	?>

<?php //LZ: Load the footer. ?>
<?php $fullwidth=0; include('/var/www/cdn.ntfg.net/htdocs/footer/footer.snip');?>

<?php //LZ: Analytics tracking?>
<!-- Piwik -->
<script type="text/javascript">
  var _paq = _paq || [];
  _paq.push(["trackPageView"]);
  _paq.push(["enableLinkTracking"]);

  (function() {
    var u=(("https:" == document.location.protocol) ? "https" : "http") + "://trk.ntfg.net/";
    _paq.push(["setTrackerUrl", u+"piwik.php"]);
    _paq.push(["setSiteId", "17"]);
    var d=document, g=d.createElement("script"), s=d.getElementsByTagName("script")[0]; g.type="text/javascript";
    g.defer=true; g.async=true; g.src=u+"piwik.js"; s.parentNode.insertBefore(g,s);
  })();
</script>
<!-- End Piwik Code -->

</body>
</html>