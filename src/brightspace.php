<?php

require_once('info.php');
require_once 'lib/D2LAppContextFactory.php';

session_start();
$toolKey = $_SESSION['toolKey'];
$orgUnitId = $_SESSION['orgUnitId'];
session_write_close();

/*
    Brightspace secure (OAUTH 1.0) API call (POST, GET, PUT) 
*/
function doValenceRequest($verb, $route, $postFields = array()){

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
        CURLOPT_HTTPHEADER     => array('Accept: application/json', 'Content-Type: application/json'),	
    );
    
    curl_setopt_array($ch, $options);

    // Do call
    $response = curl_exec($ch);

    $httpCode  = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    return json_decode($response);
}

function getGrades($url){
    $result = array();
    $response = doValenceRequest('GET',$url);
        foreach ($response as $each){  
            $result[] = array(
                "id"   => $each->Id,
                "name" => $each->Name
            );
        }
    return json_encode($result);
}

if($lti_auth['key'] == $toolKey){
    $grade_items = getGrades('/d2l/api/le/'. $config['LP_Version'] . '/' . $orgUnitId . '/' . 'grades/');
    echo $grade_items;
}

?>
