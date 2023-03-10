<!DOCTYPE html>
<!--"log out" option on admin home page leads here-->
<?php
    session_start();
    
    if (isset($_SESSION['user'])) {
        unset($_SESSION['user']);
    }
?>

<head>
    <title>Admin Login</title>
    <link rel="styleSheet" href="../../css/login.css"/>
</head>
<body id="loginBody">
    <h1 id="loginH1">Logout Successful</h1>
    <a href="index.php">Return to Login</a> <br />
    <a href="../../home/index.php">Go to main site</a> <!--Empty href until we get a home page html doc-->
</body>