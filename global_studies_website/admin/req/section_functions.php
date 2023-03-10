<?php 
/*NOTE: "Subheading" and "element" refers to what is called a "card" in other parts of the website. All of them refer to the individual
        items within a section. (e.g. "faculty" is a section, "faculty 1" is a subheading or card.*/
	
    require_once "../../req/database_functions.php";

    //connects to the database and updates information based on the form
    function updateInfo($tableName, $id, $newName, $newDesc){
        $conn = connectToDatabase();

        try{   
            $sql = $conn->prepare("update " . $tableName . " set name=:name, description=:desc where id=:id");

            $sql->bindParam(':name', $newName);
            $sql->bindParam(':desc', $newDesc);
            $sql->bindParam(':id', $id);

            $sql->execute();

        } catch(PDOException $e) {
            //echo "Insert Error: " . $e->getMessage();
        }

        $conn = NULL;
    }

    //gets information from form and checks that no fields are empty
    function postForm($sectionTitle, $id){
        $name = $_POST["name"];
        $desc = $_POST["desc"];

        //gets current page for refreshing it
        $header = "Location: " . $_SERVER['PHP_SELF']; //https://stackoverflow.com/questions/4221116/php-refresh-current-page
    
        //checks if a field has been deleted/left empty
        if($name != "" && $desc != ""){
            updateInfo($sectionTitle, $id, $name, $desc);
        }
        else{ //make into an error message?
            echo "Make sure no fields are empty. An empty field will override the current value.";
        }

        //refresh the page to update values
        header($header);
        exit;
    }

    //Toggles whether the subheading is shown.
    //Param: name of table in database (should be same as section), the id of the subheading in the table, and the current value of isHidden (not the new one)
    function hideSubheading($tableName, $id, $isHidden){
        //if subheading is currently shown, hide it, and vice versa
        if($isHidden == 0){
            $isHidden = 1;
        } 
        else{
            $isHidden = 0;
        }

        //update the status based on id using function from database_functions.php
        updateTable($tableName, $id, "isHidden", $isHidden);
    }

    //sets information for the select_img page so that it knows which subheading to update the image for
    function setImgSessions($sectionTitle, $id, $location){
        $_SESSION['section'] = $sectionTitle;
        $_SESSION['id'] = $id;
        $_SESSION['header'] = "Location: " . $location;
    }

    //adds a new, blank subheading under the specified section
    function addSubheading($sectionTitle){
        $conn = connectToDatabase();

        try {
            // Create a prepared statement
            $sql = $conn->prepare("insert into " . $sectionTitle . " (name, description) values (:name, :description);");
    
            // Create and set variables for column values
            $name = "New " . $sectionTitle;
            $description = " ";
    
            // Bind column values as prepared statement parameters
            $sql->bindParam(':name', $name);
            $sql->bindParam(':description', $description);
        
            // Execute the query
            $sql->execute();
    
        } catch(PDOException $e) {
            //echo "Insert Error: " . $e->getMessage();
        }
    }

    function removeSubheading($sectionTitle, $id){
        $conn = connectToDatabase();
        try {
            $sql = $conn->prepare("delete from " . $sectionTitle . " where id=:ID");
    
            $sql->bindParam(':ID', $id);
    
            $sql->execute();
    
        } catch(PDOException $e) {
            //echo "Insert Error: " . $e->getMessage();
        }
    }

    function echoVariable($variable){
        if(isset($variable)){
            echo $variable;
        }
    }

    //FORM SUBMISSION - can't be a function because of using "isset" on post - nothing could call this function

    //if a save button is pressed
    if(isset($_POST["save"])){
        //update the database and refresh page
        $section = $_POST['section'];
        $idNumber = $_POST['number'];
        postForm($section, $idNumber);
    }

    //if a hide button is submitted
    if(isset($_POST['hide'])){
        //get section, id, and page to return to from hidden fields submitted
        $section = $_POST['section'];
        $idNumber = $_POST['number'];
        $isHidden = $_POST['isHidden'];
 
        hideSubheading($section, $idNumber, $isHidden);
    }
    
    //updating section title
    if(isset($_POST["saveTitle"])){
        //id of section and the new display name
        $tableName = $_POST['tableName'];
        $sectionID = $_POST['idNumber'];
        $newName = $_POST['newTitle'];

        //update the "section" table
        updateTable($tableName, $sectionID, "displayName", $newName); //database_functions.php
    }


    //if a change image button is clicked
    if(isset($_POST['changeImage'])){
        //get section, id, and page to return to from hidden fields submitted
        $section = $_POST['section'];
        $idNumber = $_POST['number'];
        $page = $_SERVER['PHP_SELF'];

        //set as session variables so "select_img.php" can read them
        $_SESSION['section'] = $section;
        $_SESSION['id'] = $idNumber;
        $_SESSION['header'] = "Location: " . $page;

        header("Location: select_img.php");
        exit;
    }

    //for adding a new subheading
    if(isset($_POST['new'])){
        $section = $_POST['section'];
        addSubheading($section);
    }

    //removing a subheading - should this function exist?
    if(isset($_POST['remove'])){
        $section = $_POST['section'];
        $idNumber = $_POST['number'];
        removeSubheading($section, $idNumber);
    }

    //removing a file
    if(isset($_POST['removeFile'])){
            $section = $_POST['section'];
            $idNumber = $_POST['number'];
            
            removeSubheading($section, $idNumber);

            unlink($_POST['filePath']);  
    }


$conn = NULL;
?>