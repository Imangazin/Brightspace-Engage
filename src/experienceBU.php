<?php
require_once("info.php");

session_start();
$toolKey = $_SESSION['toolKey'];
$userName = $_SESSION['userName'];
session_write_close();

function experienceBUcall($url, $auth_token){

    $ch = curl_init($url);
    $headers = array (
        'Accept: application/json',
        'X-Engage-Api-Key: ' . $auth_token
    );
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $httpCode  = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    // Close the cURL session
    curl_close($ch);
    return json_decode($response);
}

function getEvents($url, $auth_token){
    $result = array();
    $isMore = true;
    $skip = 0;
    $take = 20;
    while($isMore){
        $response = experienceBUcall($url . '&take=' . $take . '&skip=' . $skip, $auth_token);
        foreach ($response->items as $each){  
            $result[] = array(
                "id"   => $each->id,
                "name" => $each->name
            );
        }
        $skip = $skip + $take;
        if ($skip > $response->totalItems) $isMore = false;
    }
    return json_encode($result);
}

function getOrganizationsByUsername($url, $userName, $auth_token){
    $result = array();
    $isMore = true;
    $skip = 0;
    $take = 20;
    while($isMore){
        $response = experienceBUcall($url . 'positionholder/?userId.username=' . $userName . '&take=' . $take . '&skip=' . $skip, $auth_token);
        foreach ($response->items as $each){
            $orgs = experienceBUcall($url . 'organization?ids=' . $each->organizationId, $auth_token);  
            $result[] = array(
                "id"   => $each->organizationId,
                "name" => $orgs->items[0]->name
            );
        }
        $skip = $skip + $take;
        if ($skip > $response->totalItems) $isMore = false;
    }
    return json_encode($result);
}

if($lti_auth['key'] == $toolKey){
    if (isset($_GET['organizationId'])){
        $events_response = getEvents($config['eventUrl'] . '/v3.0/events/event?organizationIds=' . $_GET['organizationId'], $config['eventAuthToken']);
        echo $events_response;
    } else {
        $orgs_response = getOrganizationsByUsername($config['eventUrl'] . '/v3.0/organizations/', $userName, $config['eventAuthToken']);
        echo $orgs_response;
    }
}
?>