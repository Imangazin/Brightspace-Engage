<?php

require_once('info.php');
require_once 'lib/D2LAppContextFactory.php';

/*
    Brightspace secure (OAUTH 1.0) API call (POST, GET, PUT) 
*/
function doValenceRequest($verb, $route, $headers_list, $postFields = array()){

    global $config;
    // Create authContext
    $authContextFactory = new D2LAppContextFactory();
    $authContext = $authContextFactory->createSecurityContext($config['appId'], $config['appKey']);

    // Create userContext
    $hostSpec = new D2LHostSpec($config['host'], $config['port'], $config['scheme']);
    $userContext = $authContext->createUserContextFromHostSpec($hostSpec, $config['userId'], $config['userKey']);

    // Create url for API call
    $uri = $userContext->createAuthenticatedUri($route, $verb);
    
    // Setup cURL
    $ch = curl_init();
    $options = array(
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST  => $verb,
        CURLOPT_URL            => $uri,
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_POSTFIELDS     => $postFields,
        CURLOPT_HTTPHEADER     => $headers_list,
        CURLOPT_FOLLOWLOCATION => false
        //array('Accept: application/json', 'Content-Type: application/json'),	
    );
    
    curl_setopt_array($ch, $options);

    // Do call
    $response = curl_exec($ch);

    $httpCode  = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    return(array('Code'=>$httpCode, 'response'=>json_decode($response)));
}

?>
