<!DOCTYPE html>
<?php 
    require_once "../req/login_session.php";
    require_once "../req/section_functions.php";
?>
<html>
    <head>
        <title>Manage Uploads</title>
        <link rel="styleSheet" href="../../css/css_admin.css"/>
    </head>
    <body>
        
    <?php require_once("../req/page_list.php"); ?>

        <h1>Manage Uploads</h1>

        <p class="error"><?php if(isset($_SESSION["errorMsg"])){echo $_SESSION["errorMsg"];}?></p>

        <table id="uploads"> <!--https://www.w3schools.com/html/html_tables.asp-->
        <tr id="categories">
            <th>ID</th>
            <th id="link">File</th>
            <th>Remove file</th>
        </tr>

        <?php //get data and build table
            $tableData = readTable("file");

            $numRows = sizeof($tableData);
            for($ii = 0; $ii<$numRows; $ii++){
                $currentRow = $tableData[$ii];

                $ID = $currentRow["id"];
                $filePath = $currentRow["filePath"];
                $rootPath = $currentRow["rootPath"];

                include "./createRow.php";
            }
        ?>

        </table> <br />

        <form id="fileAdd" name="fileAdd" class="section" enctype="multipart/form-data" method="post" action="process_upload.php"> <!--https://www.php.net/manual/en/features.file-upload.post-method.php-->
            <label for="fileUpload">Add file:</label> <br />
            <input type="file" id="fileUpload" name="fileUpload" accept="image/png, image/jpeg, image/jpg, application/pdf"/> <br /> <!--https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/file-->
        
            <input type="submit" id="fileSubmit" name="fileSubmit" value="Confirm"/>
        </form>

        <p class="error"><?php if(isset($_SESSION['errormsg'])){echo $_SESSION['errormsg'];}?></p>
    </body>
</html>
