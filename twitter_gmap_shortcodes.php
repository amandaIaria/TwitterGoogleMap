<?php



//shortcode

function gm($att, $content = null){
	global $apiKey, $apiSec, $apiTok, $apiTokSec,  $username , $userID, $hash, $json, $cords, $styles, $mapmarker, $c1, $c2, $options;
	require_once "twitter/index.php";

	try{
    checkStream($json);

    if($hash == ""){
			
			if(isset($json[0]->entities->media[0]->media_url)){
				$image = '<img src="'.$json[0]->entities->media[0]->media_url.'">';
			}
		  $tweetcontent = linkHash($json[0]->text);
    }
		else{
			$e = $json[0]->entities->hashtags;
			if(isset($e[0]->text ) and $e[0]->text == $hash){
				
				if(isset($json[0]->entities->media[0]->media_url)){;
					$image = '<img src="'.$json[0]->entities->media[0]->media_url.'">';
				}
				$cords = getCords($json[0]->place->bounding_box->coordinates[0]);
				$tweetcontent = linkHash($json[0]->text);
        $t = $json[0]->created_at;
    		}
			else{
				foreach ($json as $fdtruck) {
					$foundhash = strpos($fdtruck->text, $hash);
					if( ($foundhash) ) {
						$cords = getCords($fdtruck->place->bounding_box->coordinates[0]);

						$tweetcontent = linkHash($fdtruck->text);
							
						if(isset($fdtruck->entities->media[0]->media_url)){
							$url = "http://twitter.com/".$username."/status/".$fdtruck->id_str;
							$image = '<img src="'.$fdtruck->entities->media[0]->media_url.'">';
						}
             $t = $fdtruck->created_at;	
						break;		
					}
				}
			}
		}
		
   
    
   if((isset($cords) ) or (is_array($cords) ) or ($cords[0] != "") ){

      if(checkTime($t)){
        $c1 = $options['rLAT'];
        $c2 = $options['rLONG'];
        $mapmarker = $options['rMark'];
     $tcontent = "";
      }
      else{
        $c1 = $cords[1];
        $c2 = $cords[0];
        $mapmarker = $options["mapmarker"];
        $tcontent = '<div id="tweetBubble"><div class="content">'.$tweetcontent.'</div><div class="image"><div class="container"><a href="'.$url.'" target="_blank">'.$image.'</a></div></div></div>';
       
      }
    }
    else{
      $c1 = $options['rLAT'];
      $c2 = $options['rLONG'];
      $mapmarker = $options['rMark'];
        $tcontent = "";
    }
    
?>

		<script type="text/javascript">
    	var hashtag = "<?php echo $hash; ?>";

  		var styles = <?php echo $styles; ?>;
  		var styledMap = new google.maps.StyledMapType(styles, 
        {name: "Styled Map"});

	  	var zoom = 15;
    	var infoContent = '<?php echo $tcontent; ?>';
    	var map;
    	var tLocation = new google.maps.LatLng(<?php echo $c1; ?>, <?php echo $c2; ?>)
  

			function CoordMapType(tileSize) {
  			this.tileSize = tileSize;
			}

			CoordMapType.prototype.getTile = function(coord, zoom, ownerDocument) {
  			var div = ownerDocument.createElement('div');
  
  			div.style.width = this.tileSize.width + 'px';
  			div.style.height = this.tileSize.height + 'px';
  			div.style.fontSize = '1';
  			
  			return div;
			};
			function initialize() {
  			var mapOptions = {
    			zoom : zoom,
          draggable : <?php if(is_mobile() or is_tablet()) echo 'false';
                            else echo 'true'; ?>,
    			center : tLocation
  			};
  		
      	map = new google.maps.Map(document.getElementById('myMap'), mapOptions);
      	var iconBase = 'https://maps.google.com/mapfiles/kml/shapes/';
      	var marker = new google.maps.Marker({
        	position: tLocation,
        	map: map,
        	title: 'Twitter',
        	icon:  '<?php echo $mapmarker; ?>'
      	});

      		var infowindow = new google.maps.InfoWindow({
        		content: infoContent
      		});

      		marker.setMap(map);

      	// Insert this overlay map type as the first overlay map type at
      	// position 0. Note that all overlay map types appear on top of
      	// their parent base map.
  			map.overlayMapTypes.insertAt(
      			0, new CoordMapType(new google.maps.Size(256, 256))
      		);

      		google.maps.event.addListener(marker, 'click', function() {
        		infowindow.open(map,marker);
      		});

      		map.mapTypes.set('map_style', styledMap);
        		map.setMapTypeId('map_style');
			}

			google.maps.event.addDomListener(window, 'load', initialize);

		</script>

<?
		$output = "";

		$output .= '<div class="spinner"><div id="myMap" class="gmap custom-row row-style-yes row-parallax-bg parallax-bg-done" style="height:500px; width:100%"></div></div>';

		return $output;
	}
	catch(Exception $e){
		return "Opps Looks like Twitter is having issues.<br> " .$e->getMessage();
	}
}

add_shortcode("googleMapTweets", "gm");

function full_twitter_stream($att, $content = null){
  global $apiKey, $apiSec, $apiTok, $apiTokSec,  $username , $userID, $hash , $json, $looping;
  require_once "twitter/index.php";
  try{
  	checkStream($json);
		$tweetcontent = "";
		$hlink = "";
		$striphash = array();
		$findLink = array();
		$content = '<div id="twitterStream">';
  	$content .= '<a href="http://twitter.com/'.$username.'" target="_blank"><h1>@'.$username.'</h1></a>';
		
		//foreach($json as $data){
  	for($i = 0 ; $i < $looping; $i++){

    	$datesplit = explode(" ", $json[$i]->created_at);
			$date = $datesplit[1]."<br>".$datesplit[2];
    	$url = "http://twitter.com/".$username."/status/".$json[$i]->id_str;
    	
    	if($json[$i]->entities->hashtags){
    			$tweetcontent= linkHash($json[$i]->text);
    	}
    	else{
    		$arr = array();
    		$arr = explode(" ", $json[$i]->text);
    		$jh = urlFind($arr);
        $tweetcontent = hashTag($jh);
    	}

    	$content .= 
    		'<div class="tweet">
    			<div class="col one">
    				<div class="date">'
    				.	$date.
    				'</div>
    			</div>
    			<div class="col two">
    				<div class="content">'
        				.$tweetcontent.
      				'</div>
      				<div class="url">
      					<div class="line"></div>
      					<a href="'.$url.'" target="_blank">
      						See Tweet
      					</a>
      				</div>
    			</div>
    		</div>'
    	;
  	}  
  
  	$content .= '</div>';
    
  	$output = "";
  	$output .= $content;
  	return $output;
  }
  catch(Exception $e){
		return "Opps Looks like Twitter is having issues.<br> " .$e->getMessage();
	}

}

add_shortcode("twitter_stream", "full_twitter_stream");

function wpse_load_plugin_css() {
    $plugin_url = plugin_dir_url( __FILE__ );

    wp_enqueue_style( 'style1', $plugin_url . 'assets/style/css/tstyles.css' );

   
}
add_action( 'wp_enqueue_scripts', 'wpse_load_plugin_css' );


function debug($att, $content = null){
  global $apiKey, $apiSec, $apiTok, $apiTokSec,  $username , $userID, $hash, $json, $cords, $styles, $mapmarker, $c1, $c2, $options;
  require_once "twitter/index.php";
  echo "<pre>";
  var_dump($json);
echo "</pre>";
}

add_shortcode("debug", "debug");

?>