<?php

    $options = get_option( 'tgm_settings' );

 	  $apiKey = $options['apikey'];
    $apiSec = $options['secapi'] ;
    $apiTok = $options['accestok'] ;
    $apiTokSec =  $options['accesstoksec'];

    $username = $options['usname'];
    $userID = $options['usid'];

    
  if(isset( $options["hashtaglookup"]) or $options["hashtaglookup"] == " " ){
      $hash = $options["hashtaglookup"];
  }
  else{
      $hash = "";
  }
  if(isset($options["mapmarker"])){
      $mapmarker = $options["mapmarker"];
  }
  else{
      $mapmarker = "http://www.google.com/intl/en_us/mapfiles/ms/micons/red-dot.png";
  }
  if(isset($options["amount"])){
      $looping = $options["amount"];
  }  
  else{
      $looping = 5;
  }


  if($options["styles"] != ""){
      $styles = $options["styles"];
    }
    else{
      $styles = '[{"featureType":"landscape.man_made","elementType":"geometry","stylers":[{"color":"#f7f1df"}]},{"featureType":"landscape.natural","elementType":"geometry","stylers":[{"color":"#d0e3b4"}]},{"featureType":"landscape.natural.terrain","elementType":"geometry","stylers":[{"visibility":"off"}]},{"featureType":"poi","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"poi.business","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"poi.medical","elementType":"geometry","stylers":[{"color":"#fbd3da"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#bde6ab"}]},{"featureType":"road","elementType":"geometry.stroke","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#ffe15f"}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#efd151"}]},{"featureType":"road.arterial","elementType":"geometry.fill","stylers":[{"color":"#ffffff"}]},{"featureType":"road.local","elementType":"geometry.fill","stylers":[{"color":"black"}]},{"featureType":"transit.station.airport","elementType":"geometry.fill","stylers":[{"color":"#cfb2db"}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#a2daf2"}]}]';
    }



    
   

    //seperate functions
    function checkTime($x){
      $time = strtotime($x);
      if($time >= strtotime('+12 hours')){
        return false;
      }
      else{
        return true;
      }
    }

    function checkStream($x){
      if(!$x){
        throw new Exception("Can't Connect to Twitter");
      }
      elseif(isset($x->errors)){
        if($x->errors[0]->code == 88){
          throw new Exception("LIMIT EXCEEDED");
        }
      }

    }
    set_exception_handler('checkStream');


    function getCords($x){
      $array = array();
      foreach ($x as $ce) {
          foreach ($ce as $dd) {
              array_push($array,$dd);
          }
      }
      return $array;
    }

    function linkHash($x){
      $reg = "/\#[a-zA-Z]+/";
      $new = array();
      $gg = explode(" ", $x);
      foreach ($gg as $word) {
        if(preg_match($reg, $word)){
          $stripslash = explode("#", $word);
          $word = '<a href="https://twitter.com/hashtag/'.$stripslash[1].'/?src=hash" target="_blank">'.$word.'</a>';
        }
        $word = urlFind($word);
        $word = hashTag($word);
        array_push($new, $word);
      }
      
      $tweetcontent = implode(" ", $new);
      return $tweetcontent;
    }

    function urlFind($x){
      $reg ="/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/";
      //$url = $x;
      $ar = array();
      if(is_array($x)){
        foreach ($x as $each) {
          if(preg_match($reg,$each)){
            $each = '<br><a href="'.$each.'" target="_blank">'.$each.'</a>';
          }
          array_push($ar, $each);
        }
        $y = implode(" ", $ar);
        return $y;
      }
      else{
        $url = $x;
        if(preg_match($reg,$url)){
          $url = '<br><a href="'.$url.'" target="_blank">'.$url.'</a>';
        }
        return $url;
      }
      
    }
    function hashtag($x){
      $reg = "/\@[a-zA-Z]+/";
      $ar = array();
      $another = explode(" ", $x);
        foreach ($another as $each) {
          if(preg_match($reg,$each)){
            $stripslash = explode("@", $each);
            $each = '<a href="https://twitter.com/'. $stripslash[1] .'" target="_blank">@'. $stripslash[1].'</a>';
          }
          array_push($ar, $each);
        }
        $y = implode(" ", $ar);
        return $y;
     
    }

  // function for connecting to twitters  api  

function twit(){
    global $apiTok, $apiTokSec, $apiKey, $apiSec, $username;

    $settings = array(
        'oauth_access_token' => $apiTok,
        'oauth_access_token_secret' => $apiTokSec,
        'consumer_key' => $apiKey,
        'consumer_secret' => $apiSec
    );

    $url = "https://api.twitter.com/1.1/statuses/user_timeline.json";
        //$url = "https://api.twitter.com/1.1/geo/search.json";
    $getfield = '?screen_name='.$username;
    $requestMethod = 'GET';
    $twitter = new TwitterAPIExchange($settings);
    $output = $twitter->setGetfield($getfield)
             ->buildOauth($url, $requestMethod)
             ->performRequest();

    return $output;
}








?>