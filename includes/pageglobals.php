
<?php

function new_log($user, $message, $address, $swctime){
    $log = new Logger();
    $log->create_log($swctime, $user->get_uid(), $address, $message);
}

if(array_key_exists("gamblinguid", $_SESSION) && array_key_exists("gamblingtoken", $_SESSION)){
    $user = new Users();
    $user->build_user_from_database((int)$_SESSION['gamblinguid']);
    $swc = new SWC();
    $token = new OAuthToken(null, null, null, $user->get_uid());
    $name = $user->get_character_name();
    $address = $_SERVER["REMOTE_ADDR"];
    if($token->get_expires_in() < 900 && $token->get_expires_at() != null){
        if($token->get_refresh_token() != null){
            $token = $swc->refresh_token($token->get_refresh_token());    
            $info = $swc->check_authentication(); 
            if($info != null){
                $token->record_token($user->get_uid());
                $swctime = $info->timestamp;
                $message = "Token refreshed for $name";
                new_log($user, $message, $address, $swctime);
            }
            else{
                $rawJson = $swc->get_time();
                $swctime = $rawJson->timestamp;
                $message = "Failed to refresh token after refresh for $name";
                new_log($user, $message, $address, $swctime);
                session_destroy();
                header("Location: login.php");
            }
        }
        else{
            $rawJson = $swc->get_time();
            $swctime = $rawJson->timestamp;
            $message = "No refresh token for $name";
            new_log($user, $message, $address, $swctime);
            session_destroy();
            header("Location: login.php");
        }
    }
    else{
        $swc->set_token($token);
        $info = $swc->check_authentication(); 
        if($info == null){
            $rawJson = $swc->get_time();
            $swctime = $rawJson->timestamp;
            $message = "No longer able to access resources with token for $name";
            new_log($user, $message, $address, $swctime);
            session_destroy();
            header("Location: login.php");
        }
    }
}
else{
    header("Location: login.php");
}


