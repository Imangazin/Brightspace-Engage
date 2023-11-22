<?php
//BS authorization
require_once("src/info.php");
//BS functions
//require_once 'src/brightspaceFunctions.php';
//Experience BU functions
//require_once 'src/experienceBU.php';
// Load up the LTI Support code
require_once 'src/ims-blti/blti.php';

//Initialize, all secrets as 'secret', do not set session, and do not redirect
$context = new BLTI($lti_auth['secret'], false, false);

$currentCookieParams = session_get_cookie_params();
$cookie_domain= $_SERVER['HTTP_HOST'];
session_set_cookie_params(
    $currentCookieParams["lifetime"],
    '/BLETEST/Brightspace-Engage/; samesite=None; Secure; Partitioned',
    $cookie_domain,
    "1",
    "1"
);
//}

session_start();
$_SESSION['toolKey'] = $context->info['oauth_consumer_key'];
session_write_close();

//Check the key is correct
if($lti_auth['key'] == $context->info['oauth_consumer_key']){
    readfile("setup.html");
}
else{
    echo 'LTI credentials not valid. Please refresh the page and try again. If you continue to receive this message please contact <a href="mailto:'.$supportEmail.'?Subject= LTI connection issue" target="_top">'.$supportEmail.'</a>';
}
?>
