<?php
    require_once 'includes/autoloader.php';
    session_start();
    if(isset($_SESSION['gamblingtoken'])){
        header("Location: index.php");
    }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <title>Login</title>
    <?php
        require_once 'includes/head.php';
    ?>
</head>
<body>
    <?php

    ?>
</body>
</html>