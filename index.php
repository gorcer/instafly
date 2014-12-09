<?php
//session_start();

$client_id = 'e0f6616ab38d4e9a99e20c47c97cbef2';
$redirectUri = 'http://instafly.gorcer.com/';

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
	<div class="large-2 columns">
		<h2>InstaFly</h2>
	</div>
     <div class="large-8 columns">
         <center>
             <h3>Просматривайте фотографии интересных мест</h3>
             <script type="text/javascript" src="//yastatic.net/share/share.js" charset="utf-8"></script><div class="yashare-auto-init" data-yashareL10n="ru" data-yashareType="small" data-yashareQuickServices="vkontakte,facebook,twitter,odnoklassniki,moimir" data-yashareTheme="counter" data-yashareLink="<?=$redirectUri ?>" data-yashareImage="img/screenshot.png"></div>
         </center>
     </div>
	<div class="large-2 columns">
        <label>Период</label>
        <select id="periodSelect">
            <option value="15m">15 минут</option>
            <option value="30m">30 минут</option>
            <option value="1h">1 час</option>
            <option value="6h">6 часов</option>
            <option value="24h">24 часа</option>
            <option value="6d">6 дней</option>
        </select>
	</div>
</div>

 <div class="row">
  <div class="large-12 columns">	
   <div class="panel"  id="map" style="height: 640px;"></div>
  </div>
 </div>

 <hr/>


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
		<ul class="small-block-grid-12" id="lastlist">
		  
		</ul>
 </div>
</div>

 <div class="row">
	 <div class="large-12 columns">
		 InstaFly - это сайт, на котором вы можете посмотреть какие фотографии выкладываются в сервис инстаграм в интересующих вас районах города. Вы можете выбрать период за который будут загружаться фотографии из Instagram на карту. Под картой выводится список найденных фотографий. При каждом перемещении происходит обновление списка загруженных на карту фотографий из instagram. Для работы с проектом вам предварительно необходимо авторизоваться в инстаграме.
	 </div>
 </div>

 <hr/>


<footer class="row">
	<div class="large-12 columns">
		<hr />
			<div class="row">
				<div class="large-6 columns">
					<p>&copy; All rights reserved.</p>
				</div>
                <div class="large-6 columns">
                    <!-- Yandex.Metrika informer -->
                    <a href="https://metrika.yandex.ru/stat/?id=22485028&amp;from=informer"
                       target="_blank" rel="nofollow"><img src="//bs.yandex.ru/informer/22485028/3_1_FFFFFFFF_EFEFEFFF_0_pageviews"
                                                           style="width:88px; height:31px; border:0;" alt="Яндекс.Метрика" title="Яндекс.Метрика: данные за сегодня (просмотры, визиты и уникальные посетители)" onclick="try{Ya.Metrika.informer({i:this,id:22485028,lang:'ru'});return false}catch(e){}"/></a>
                    <!-- /Yandex.Metrika informer -->

                    <!-- Yandex.Metrika counter -->
                    <script type="text/javascript">
                        (function (d, w, c) {
                            (w[c] = w[c] || []).push(function() {
                                try {
                                    w.yaCounter22485028 = new Ya.Metrika({id:22485028,
                                        webvisor:true,
                                        clickmap:true,
                                        trackLinks:true,
                                        accurateTrackBounce:true});
                                } catch(e) { }
                            });

                            var n = d.getElementsByTagName("script")[0],
                                s = d.createElement("script"),
                                f = function () { n.parentNode.insertBefore(s, n); };
                            s.type = "text/javascript";
                            s.async = true;
                            s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

                            if (w.opera == "[object Opera]") {
                                d.addEventListener("DOMContentLoaded", f, false);
                            } else { f(); }
                        })(document, window, "yandex_metrika_callbacks");
                    </script>
                    <noscript><div><img src="//mc.yandex.ru/watch/22485028" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
                    <!-- /Yandex.Metrika counter -->
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

    var
        lat = 33.126642,
        long = 131.919037;

    if (ymaps.geolocation !== undefined) {
        long = ymaps.geolocation.longitude;
        lat = ymaps.geolocation.latitude;

    }

        myMap = new ymaps.Map ("map", {
	    center: [lat, long],
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
	
	instamap.run();
	
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