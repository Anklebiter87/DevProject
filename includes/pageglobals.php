
<?php

$user = new Users();
$user->build_user_from_database((int)$_SESSION['gamblinguid']);
$swc = new SWC();
$token = new OAuthToken(null, null, null, $user->get_uid());

if($token->get_expires_in() < 900){
    $token = $swc->refresh_token($token->get_refresh_token());    
    $info = $swc->check_authentication(); 
    if($info != null){
        $token->record_token($user->get_uid());
    }
    else{
        session_destroy();
        header("Location: login.php");
    }
}
else{
    $swc->set_token($token);
    $info = $swc->check_authentication(); 
    if($info == null){
        session_destroy();
        header("Location: login.php");
    }
}
