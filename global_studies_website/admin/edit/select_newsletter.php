<!DOCTYPE html>
<?php require_once "../req/login_session.php";?>
<html>
    <head>
        <title>Manage Uploads</title>
        <link rel="styleSheet" href="../../css/css_admin.css"/>
    </head>
    <body>
        
    <?php 
        require_once("../req/page_list.php"); 
        require_once "../req/section_functions.php";


        if(isset($_POST['backHome'])){
            header("Location: ./home.php");
            exit;
        }

        if(isset($_POST['newsletterFile'])){
             // Update database using database_functions.php
             updateTable("home_files", 1, "imgsrc", $_POST["filePath"]);

             //refresh page
             header("Location: " . $_SERVER['PHP_SELF']);
             exit;
        }
    ?>

        <h1>Choose Displayed Newsletter</h1>

        <table id="files"> <!--https://www.w3schools.com/html/html_tables.asp-->
        <tr id="categories">
            <th>ID</th>
            <th id="link">File</th>
            <th>Currently selected</th>
            <th>Choose file</th>
        </tr>

        <?php //get data and build table
            $allFiles = readTable("file");
            
            $homeTable = readTable("home_files");
            $newsletterPath = $homeTable[0]["imgsrc"];

            $numRows = sizeof($allFiles);
            for($ii = 0; $ii<$numRows; $ii++){
            
                $currentRow = $allFiles[$ii];
                $filePath = $currentRow["filePath"];

                //only show pdf, the valid format
                if(str_contains($filePath, ".pdf")){
                    //get remaining information    
                    $ID = $currentRow["id"];
            
                    if($filePath == $newsletterPath){
                            $selected = "Yes";
                        } else{
                            $selected = "No";
                        }
                    include "../req/newsletter_select_row.php";
                }
            }
        ?>

        </table> <br />

        <form method="post">
            <input type="submit" id="backHome" name="backHome" value="Back"/>
        </form>

    </body>
</html>
