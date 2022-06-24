
<?php
require_once 'includes/autoloader.php';
session_start();
if (isset($_SESSION['gamblingtoken'])) {
  header("Location: index.php");
}

if (isset($_GET)) {
    if(array_key_exists('error', $_GET)){
        error_log($_GET['error']);
        header("Location: index.php");
    }

    if(array_key_exists('code', $_GET)) {
        $code = $_GET['code'];
        $swc = new SWC();
        $auth = $swc->request_token($code);
        if(isset($auth)){
            if(!isset($_SESSION)){
                session_start();
            }
            if($swc->check_authentication()){
                $_SESSION['gamblingtoken'] = $auth->get_uuid();
                header("Location: index.php");
            }
            else{
                header("Location: login.php");
            }
        }
    }
}