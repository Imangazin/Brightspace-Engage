<?php
require_once('info.php');
ini_set('display_errors', 1);

// $authtoken = config['eventAuthToken'];
// $baseUrl = config['eventUrl'];

// $branch_id='16';
// $organizationId = '2717';

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

function getOrganizations($url, $auth_token){
    $organizations = array();
    $isMore = true;
    $skip = 0;
    $take = 20;
    while($isMore){
        $response = experienceBUcall($url . '&take=' . $take . '&skip=' . $skip, $auth_token);
        foreach ($response->items as $each){  
            $organizations[] = array(
                "organization_id" => $each->id,
                "name"            => $each->namezz
            );
        }
        $skip = $skip + $take;
        if ($skip > $response->totalItems) $isMore = false;
    }
    echo sizeof($organizations);
    return $organizations;
}

function getEvents($url, $auth_token){
    $events = array();
    $isMore = true;
    $skip = 0;
    $take = 20;
    while($isMore){
        $response = experienceBUcall($url . '&take=' . $take . '&skip=' . $skip, $auth_token);
        foreach ($response->items as $each){  
            $events[] = array(
                "event_id" => $each->id,
                "name"     => $each->name
            );
        }
        $skip = $skip + $take;
        if ($skip > $response->totalItems) $isMore = false;
    }
    return $events;
}
?>