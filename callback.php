
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
        $auth = $swc->get_token($code);
    }
}

echo var_dump($_POST);
echo var_dump($_GET);
echo var_dump($_SESSION);