<!DOCTYPE html>
<html>
    <head>
        <title>Manage Uploads</title>
        <link rel="styleSheet" href="../../css/css_admin.css"/>
    </head>
    <body>
<?php   
    require_once "../req/login_session.php";
    require_once "../../req/database_functions.php";

    $fileList = readTable("file");

    $subheadingList = readTable($_SESSION['section']); //ex get table of faculty
    $name = getName($subheadingList, $_SESSION['id']); //ex get the name of the current faculty

    $selectedPath = getImg($subheadingList, $_SESSION['id']); //get the image source from the table
    
    //if one of the images is clicked:
    if(isset($_POST['imgButton'])){ 
        $newPath = $_POST['imgButton']; //take its value

        //update database 
        updateTable($_SESSION['section'], $_SESSION['id'], "imgsrc", $newPath);
        //refresh page
        header("Location: " . $_SERVER['PHP_SELF']); //I didn't know why it needed to refresh the page so I patched in this clunky fix to just refresh the page
        exit;
    }

    if(isset($_POST['back'])){
        header($_SESSION['header']);
        exit;
    }

    //Check if it's the current selected picture and put border around it
    function isSelected($value, $path){
        if($value == $path){
            echo "selected"; //for some reason it's showing the right one after an addtional page reload
        }
    }
?>
        
        <?php require_once("../req/page_list.php"); ?>

        <h1>Choose Image</h1>
        <h3>Selecting for: <?php echo $name?></h3>
        <form id="selectImg" name="selectImg" method="post">
            <table id="images"> <!--https://www.w3schools.com/html/html_tables.asp-->
            <?php
            //for each of the images found in the database
                $numRows = sizeof($fileList);
                for($ii = 0; $ii < $numRows; $ii++){
                    //get the image source from the table
                    $src = $fileList[$ii]['filePath'];
                    $id = $fileList[$ii]['id'];

                    //sorts out pdf files to not display them
                    if(!str_contains($src, ".pdf")){ //https://www.php.net/manual/en/function.str-contains.php
                        
                        //if it's the start of a row, open row
                        if($ii % 5 == 0){
                            echo "<tr class=\"imgtr\">" . PHP_EOL;
                        }

                        //print it out onto the screen
                        echo "<td class=\"imgtd\">
                            <button type=\"submit\" id=\"imgButton". $id ."\" name=\"imgButton\" class=\"imgButton ";
                            isSelected($src, $selectedPath);
                        echo "\" value=\"" . $src . "\">
                            </button> ". PHP_EOL . "
                            <script>changeImg(\"imgButton".$id."\", \"".$src."\");</script>
                            </td>" . PHP_EOL;
                        //https://stackoverflow.com/questions/7803814/how-can-i-prevent-refresh-of-page-when-button-inside-form-is-clicked

                        //if its the end of a row, close row
                        if($ii % 5 == 4){
                            echo "</tr>" . PHP_EOL;
                        }
                    }
                }
            ?>
            </table> <br />

            <input type="submit" id="back" name="back" value="Back"/>
        </form>
    </body>
</html>