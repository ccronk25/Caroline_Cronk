<!DOCTYPE html>
<?php require_once "../req/login_session.php";?>
<html>
<head>
    <title>Edit Page</title>
    <link rel="styleSheet" href="../../css/css_admin.css"/>
</head>
<body>
    <h1>Edit "Campus Involvement"</h1>

    <p>Only edit one element at a time, as saving a change will refresh the page.</p>

<?php 
    require_once "../req/page_list.php";  
    require_once "../req/section_functions.php";   
?>

<?php
    $sectionTitle = "event";
    $sectionName = "Events";
    include "../req/generate_section.php";

    $sectionTitle = "club";
    $sectionName = "Clubs and Organizations";
    include "../req/generate_section.php";
?>

</body> 
</html>
