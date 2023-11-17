<?php
//BS authorization
require_once("src/info.php");
//BS functions
require_once 'src/brightspaceFunctions.php';
//Experience BU functions
require_once 'src/experienceBUFunctions.php';
// Load up the LTI Support code
require_once 'src/ims-blti/blti.php';

//Initialize, all secrets as 'secret', do not set session, and do not redirect
$context = new BLTI($lti_auth['secret'], false, false);

//Check the key is correct
if($lti_auth['key'] == $context->info['oauth_consumer_key']){

    if (isset($_GET['organizations'])) {
        $orgs_respsponse = getOrganizations($config['eventUrl'] . '/v3.0/organizations/organization?statuses=Active', $auth_token);
        exit($orgs_respsponse);
    }

    if (isset($_POST['organizationId'])){
        $events_response = getEvents($config['eventUrl'] . '/v3.0/organizations/organization?statuses=Active', $auth_token);
    }
        
    readfile("../setup.html");
    
}
else{
    echo 'LTI credentials not valid. Please refresh the page and try again. If you continue to receive this message please contact <a href="mailto:'.$supportEmail.'?Subject= LTI connection issue" target="_top">'.$supportEmail.'</a>';
}


?>
