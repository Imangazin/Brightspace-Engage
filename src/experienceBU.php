<?php
require_once("info.php");

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

function getResponse($url, $auth_token){
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
    return json_decode($result);
}

if (isset($_POST['organizationId'])){
    $events_response = getResponse($config['eventUrl'] . '/v3.0/events/event?organizationIds=' . $_POST['organizationId'], $config['eventAuthToken']);
    echo $events_respsponse;
} else {
    $orgs_respsponse = getResponse($config['eventUrl'] . '/v3.0/organizations/organization?statuses=Active', $config['eventAuthToken']);
    echo $orgs_respsponse;
}
?>