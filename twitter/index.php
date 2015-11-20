<?php

require_once('TwitterAPIExchange.php');

//$cachedir =  $_SERVER['DOCUMENT_ROOT'].'/cache/';

$cachedir =  plugin_dir_path(__FILE__).'/'.'cache/';
//echo $_SERVER['DOCUMENT_ROOT']."/wp/wp-content/plugins/TwitterGoogleMap_production/twitter/cache/";
//$cachedir = "/cache/";
$cachetime = 1800;
$cacheext = 'json';

//$files = glob( $cachedir.'*.*' );

// Sort files by modified time, latest to earliest
// Use SORT_ASC in place of SORT_DESC for earliest to latest
/*array_multisort(
    array_map( 'filemtime', $files ),
    SORT_NUMERIC,
    SORT_ASC,
    $files
);*/

/** Perform a GET request and echo the response **/
/** Note: Set the GET field BEFORE calling buildOauth(); **/

    $page = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    //file name         
   
    $cachefile = $cachedir. "cache.json"; 
    
    if(file_exists($cachefile)){
          $cachefile_created = filemtime($cachefile);
    }
    else{
        $cachefile_created = 0;
    }
    


    if (time() - $cachetime < $cachefile_created) {
        $output = file_get_contents($cachefile); 
        //echo "reading cache -- for debugging will be gone in launch";
    }
    else{
       //echo "not reading cache -- for debugging will be gone in launch";
        
        clearstatcache();
    
        $output = twit() ;

        $fp = fopen($cachefile, 'w'); 

        // save the contents of output buffer to the file
        fwrite($fp, $output);
        fclose($fp);

      
 
    }


$json = json_decode($output, true);



?>



