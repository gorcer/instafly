<?php
//session_start();

$client_id = 'e0f6616ab38d4e9a99e20c47c97cbef2';
$redirectUri = 'http://insta.gorcer.com/';

//$uid = $_SESSION['token'];
/*
if ($uid == false)
{
	header("Location: https://api.instagram.com/oauth/authorize/?client_id=".$client_id."&redirect_uri=".$redirectUri."&response_type=token");
	die();
}*/

?>
<head>
 <meta charset="utf-8" />
 <meta name="viewport" content="width=device-width" />
 <title>InstaFly</title>
 
 <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.js"></script>
 
  <!-- If you are using CSS version, only link these 2 files, you may add app.css to use for your overrides if you like. -->
  <link rel="stylesheet" href="css/normalize.css" />
  <link rel="stylesheet" href="css/foundation.css" />
  
  <link rel="stylesheet" href="css/main.css" />


  <link rel="stylesheet" href="css/carousel.css" />
  <script type="text/javascript" src="js/jquery.tinycarousel.min.js"></script>


  <script src="js/vendor/custom.modernizr.js"></script>
  
  
	
<script type="text/javascript" src="js/instamap.js"></script>
 
<script src="http://api-maps.yandex.ru/2.0-stable/?load=package.full&lang=ru-RU" type="text/javascript"></script>
</head>
<body>

 <div class="row">
	<div class="large-3 columns">
		<h2>InstaFly</h2>
	</div>
	<div class="large-9 columns">
	<!--<ul class="right button-group">
		<li><a href="#" class="button">Link 1</a></li>
		<li><a href="#" class="button">Link 2</a></li>
		<li><a href="#" class="button">Link 3</a></li>
		<li><a href="#" class="button">Link 4</a></li>
		</ul>
	-->
	</div>
</div>

 <div class="row">
  <div class="large-12 columns">	
   <div class="panel"  id="map" style="height: 500px;"></div>
  </div>
  <hr/>
 </div> 

<!-- 
 <div class="row">
  <div class="large-12 columns">	
   
   <div id="lastlist">		
		<div class="viewport large-12 columns">
			<ul class="overview">
			

			</ul>
		</div>		
	</div>  
   
  </div>
  <hr/>
 </div> 
-->

<div class="row">
  <div class="large-12 columns">	
		<ul class="small-block-grid-6" id="lastlist">
		  
		</ul>
 </div>
</div>




<footer class="row">
	<div class="large-12 columns">
		<hr />
			<div class="row">
				<div class="large-6 columns">
					<p>&copy; All rights reserved.</p>
				</div>			
		</div>
	</div>
</footer>
	

<div id='insta'></div>
 
 
<script type="text/javascript">


var instamap = Object.create(Instamap);
ymaps.ready(init);
var myMap;



function init(){
	myMap = new ymaps.Map ("map", {
	    center: [43.126642,131.919037],
	    zoom: 12,
	    behaviors: ['default', 'scrollZoom']
	});				
	
	myMap.controls
	// Кнопка изменения масштаба.
	.add('zoomControl', { left: 5, top: 5 })
	// Список типов карты
	.add('typeSelector')
	// Стандартный набор кнопок
	.add('mapTools', { left: 35, top: 5 });



	if(window.location.hash) {
		var accessToken = window.location.hash.substring(1);
		accessToken = accessToken.substring(13, accessToken.length);
		console.log(accessToken);
	}
	else {
		var url = 'https://api.instagram.com/oauth/authorize/?client_id=<?php echo $client_id ?>&redirect_uri=<?php echo $redirectUri ?>&response_type=token';
		window.location.href = url;
	}

	instamap.init(myMap, "insta",{
		 accessToken: accessToken,
		 clientID: '<?php echo $client_id ?>',
		 PhotoList: 'lastlist'
			});

	
	//instamap.getByCoords(42.993704, 131.929754, 5000);
	
	instamap.run(60*60);
	
	}
</script>
 
 
 
  <script>
  document.write('<script src=' +
  ('__proto__' in {} ? 'js/vendor/zepto' : 'js/vendor/jquery') +
  '.js><\/script>')
  </script>
  <script src="js/foundation/foundation.js"></script>
  <script src="js/foundation/foundation.alerts.js"></script>
  <script src="js/foundation/foundation.clearing.js"></script>
  <script src="js/foundation/foundation.cookie.js"></script>
  <script src="js/foundation/foundation.dropdown.js"></script>
  <script src="js/foundation/foundation.forms.js"></script>
  <script src="js/foundation/foundation.joyride.js"></script>
  <script src="js/foundation/foundation.magellan.js"></script>
  <script src="js/foundation/foundation.orbit.js"></script>
  <script src="js/foundation/foundation.placeholder.js"></script>
  <script src="js/foundation/foundation.reveal.js"></script>
  <script src="js/foundation/foundation.section.js"></script>
  <script src="js/foundation/foundation.tooltips.js"></script>
  <script src="js/foundation/foundation.topbar.js"></script>
  <script src="js/foundation/foundation.interchange.js"></script>
  <script>
    $(document).foundation();
   
  </script>
</body>