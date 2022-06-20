<?php
require_once 'includes/autoloader.php';
session_start();
if (isset($_SESSION['gamblingtoken'])) {
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
  <div class="wrapper">
    <div class="main-panel">
      <div class="d-flex justify-content-center" style="margin:8">
        <div class="col-10 col-sm-10">
          <div class="card">
            <div class="card-header">
              <div class="d-flex justify-content-center">
                <h2 id="form-title">The SWC Pazaak Gambling Platform</h2>
              </div>
            </div>
            <div class="card-body">
              <div class="col-12 col-sm-12">
                <p>Welcome to the Pazaak Gambling site for Star Wars Combine. This site was designed to be dev submition to the Star Wars Combine. 
                </br>
                <p>You must first login and this site uses SWC authentication to enable all
                  of its features. By logging in, you are only allowing character_read access. Character_read is a minimal
                  amount of access, which allows public profile information only.</p>
                </br>
                <div class="d-flex justify-content-center form_container">
                  <a href="loginprocesser.php">
                    <button type="button" class="btn btn-secondary btn-sm" title="Login">
                      SWC Login
                    </button>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
</body>
</html>