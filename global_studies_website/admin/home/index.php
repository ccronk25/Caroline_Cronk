<!DOCTYPE html>
<?php require_once "../req/login_session.php";?>
<!--This is the admin home page, which contains the editing and management options, including links to detail pages-->
<!--Two options: this is a sidebar on the left and clicking the links makes the detail pages show up in a larger content area on the right,
                 or this is the whole page, and clicking links brings you to new pages-->
<head>
    <title>Admin Home</title>
    <link rel="styleSheet" href="../../css/css_admin.css"/>
</head>
<body>
    <h1>Admin Home</h1>
    <p> Welcome to the admin home page! Select an option from the side bar. </p>
<?php require_once("../req/page_list.php"); ?>
</body>