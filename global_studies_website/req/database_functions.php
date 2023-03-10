<?php
//all MySQL code comes from classroom example on GitHub

    function connectToDatabase(){
        $conn						= NULL;			
        $connection_hostName		= '';	        // Database server - Removed for security
        $connection_databaseName	= '';	        // Database name - Removed for security
        $connection_username		= '';		    // User with access to the database - Removed for security
        $connection_password		= '';	        // Password for the user - Removed for security
        $connection_type			= 'mysql';		


        //--------------------------------------------------
        // CONNECT
        //--------------------------------------------------

        try {
            $conn = new PDO($connection_type
                                    . ':host=' . $connection_hostName . ';'
                                    . 'dbname=' . $connection_databaseName
                                    , $connection_username
                                    , $connection_password);
            
        } catch (PDOException $e) {
            //echo "Select Error: " . $e->getMessage();
        }
        return $conn;
    }

    //grabs the entire table 
    //Param: sectionTitle is the target table name
    function readTable($sectionTitle){
        $result		= NULL;	// Query results returned after executing an SQL statement
    
        $conn = connectToDatabase();
        try {
             // Re-initialize result values
             $result		= NULL;

            // Create prepared SQL statement
            $sql = $conn->prepare("select * from " . $sectionTitle . " order by id");
    
             // Excecute query
            $sql->execute();
        
             // Get results (if any)
            $result = $sql->setFetchMode(PDO::FETCH_ASSOC);
            $result = $sql->fetchAll();
    
        } catch(PDOException $e) {
            //echo "Select Error: " . $e->getMessage();
        } 
        
        $conn = NULL;
        return $result; //result is a double array/matrix 
    }

    function readByName($tableName, $name){
        $result		= NULL;	// Query results returned after executing an SQL statement
        $numRows	= 0;	// Number of rows (records) returned by an SQL query

        $conn = connectToDatabase();

        try {

            // Create prepared SQL statement
            $sql = $conn->prepare("select * from " . $tableName . " where name=:name");

            //Bind parameteres
            $sql->bindParam(':name', $name);

            // Excecute query
            $sql->execute();

            // Get results (if any)
            $result = $sql->setFetchMode(PDO::FETCH_ASSOC);
            $result = $sql->fetchAll();

            return $result;
        

        } catch(PDOException $e) {

        } 

    $conn = NULL;

    }

    //parameters: $result array from database, $ID which subheading of the section you are on, starting from 0 (ex. second faculty member, $ID = 1)
    //If it's easier we could edit this to take the ID given and subtract 1 from it
    //returns a string containing the name from the database
    function getName($result, $ID){
        $realID = $ID - 1;
        $currentRow = $result[$realID];

        $name = $currentRow["name"];      
        return $name;
    }

    function getDesc($result, $ID){
        $realID = $ID - 1;
        $currentRow = $result[$realID];

        $desc = $currentRow["description"];   
        return $desc;
    }

    function getImg($result, $ID){
        $realID = $ID - 1;
        $currentRow = $result[$realID];
        $img = $currentRow["imgsrc"];   
        return $img;
    }

    function updateTable($tableName, $id, $field, $newInput){
        $conn = connectToDatabase();
        try{   
            $sql = $conn->prepare("update " . $tableName . " set " . $field ."=:newInput where id=:id");

            $sql->bindParam(':newInput', $newInput);
            $sql->bindParam(':id', $id);

            $sql->execute();

        } catch(PDOException $e) {
            //echo "Insert Error: " . $e->getMessage();
        }

        $conn = NULL;
    }
    
    

?>

<script> //function taken from https://stackoverflow.com/questions/12470046/javascript-function-to-change-background-image and modified
    function changeImg(id, imgsrc) {
        document.getElementById(id).style.backgroundImage = "url("+imgsrc+")";
    }
</script>
