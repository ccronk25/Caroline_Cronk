<!DOCTYPE html>
<?php require_once "../req/login_session.php";?>
<html>
<head>
    <title>Edit Page</title>
    <link rel="styleSheet" href="../../css/css_admin.css"/>
</head>
<body>

    <h1>Edit "Outside the Classroom"</h1>

    <p>Only edit one element at a time, as saving a change will refresh the page.</p>

<?php
  
    require_once("../req/page_list.php");  
    require_once "../req/section_functions.php"; 

    $sectionTitle = "career";
    $sectionName = "Career ";
    include "../req/generate_section.php";

    $sectionTitle = "internship";
    $sectionName = "Internships";
    include "../req/generate_section.php";
?>
<!--
<h2>Photo Display</h2>
<div class="section">
<?php/*
    //this one is different so i did it out here
    $sectionTitle = "photo_carousel";

    //get the desired section using database_functions.php
    $result = readTable($sectionTitle);

    $numRows = sizeof($result);
    
    //for as many rows as are in section, get data and use it to create subheadings
    
    for($ii = 0; $ii<$numRows; $ii++){
        $currentRow = $result[$ii];

        $imgsrc = $currentRow["imgsrc"];
        $idNumber = $currentRow["id"];
        $ID = $sectionTitle . $idNumber;

        include "../req/generate_photo_box.php"; 
        /*
        echo "
        <form method=\"post\">
            <input type=\"hidden\" id=\"section\" name=\"section\" value=\"" . $sectionTitle . "\"/>
            <input type=\"submit\" id=\"new\" name=\"new\" value=\"Add " . $sectionTitle . " +\"/>
        </form>";
    }*/

?>
</div>    -->

</body> 
</html>
