<!DOCTYPE html>
<html>
    <head>
        <title>Global Studiess Newsletter</title>
        <link rel="stylesheet" href="../css/home.css">
    </head>
    <body>
        <?php session_start();?>
    <!-- //https://stackoverflow.com/questions/18040386/how-to-display-pdf-in-php -->
        <iframe id="newsletterFrame" src="<?php echo $_SESSION['newsletterFile'];?>" width="100%" height=100%></iframe>
    </body>
</html>