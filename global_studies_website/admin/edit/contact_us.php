<!DOCTYPE html>
<?php require_once "../req/login_session.php";?>
<html>
    <head>
        <title>Edit Page</title>
        <link rel="styleSheet" href="../../css/css_admin.css"/>
    </head>
    <body>
    <?php 
        require_once "../req/page_list.php";  
        require_once "../req/section_functions.php";   

        $titleVariables = readByName("page", "contact");
        include_once "../req/generate_page.php";

    ?>

    </body> 
</html>
