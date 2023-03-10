<!DOCTYPE html>
<head>
    <title>Contact Us</title>
    <link rel="styleSheet" href="../css/contact_style.css"/>
</head>
<body>
<?php include_once "../req/header.php";?>
<?php
session_start();

//if(isset($_COOKIE["sampleCookie"])){echo "asdf";}
$cookie=json_decode($_COOKIE["sampleCookie"],true);

//die ($cookie2);
$firstName=$cookie["firstName"];

echo "We recieved your message, " .$firstName. ". Thank you for contacting us!";
//echo "We recieved your message. Thank you for contacting us!";

 include_once "../req/footer.php";
?>
</body>