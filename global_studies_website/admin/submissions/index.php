<!DOCTYPE html>
<?php require_once "../req/login_session.php";?>
<html>
    <head>
        <title>Contact Submissions</title>
        <link rel="styleSheet" href="../../css/css_admin.css"/>
    </head>
    <body>
        
    <?php 
        require_once "../req/page_list.php";
        require_once "../req/section_functions.php";
    ?>

    <h1>Manage Contact Form Submissions</h1>

    <p>Email that recieves submissions can be changes on the manage user page.</p>

        <table id="contactsubmissions"> <!--https://www.w3schools.com/html/html_tables.asp-->
        <tr id="categories">
            <th id="id">ID</th>
            <th id="fName">First name</th>
            <th id="lName">Last name</th>
            <th id="email">Email address</th>
            <th id="message">Message</th>
            <th id="remove">Remove submission</th>
        </tr>
        <?php 
            //get data from table
            $result = readTable("contact_submissions");

            // Loop through results
            $numRows = sizeof($result);
            for($ii = 0; $ii<$numRows; $ii++){
                $currentRow = $result[$ii];

                $ID = $currentRow["id"];
                $firstName = $currentRow["firstName"];
                $lastName = $currentRow["lastName"];
                $email = $currentRow["email"];
                $message = $currentRow["message"];

                include "./createRow.php";
            }
        ?>
        </table>
    </body>
</html>