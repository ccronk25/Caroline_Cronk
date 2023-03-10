<?php 

require_once "../req/database_functions.php";

// **Code copied from crud.php example on class GitHub and edited**

//=========================================================
// CREATE
//=========================================================
$conn = connectToDatabase();

try {

    // Create a prepared statement
    $sql = $conn->prepare("insert into contact_submissions (firstName, lastName, email, message) values (:firstName, :lastName, :email, :message);");

    // Bind column values as prepared statement parameters
    // NOTE: match the parameter name (first argument in the bindParam() method) with the value in the prepared SQL statement
    $sql->bindParam(':firstName', $firstName);
    $sql->bindParam(':lastName', $lastName);
    $sql->bindParam(':email', $email);
    $sql->bindParam(':message', $message);


    // Execute the query
    $sql->execute();

} catch(PDOException $e) {
    //echo "Insert Error: " . $e->getMessage();
    $error = true;
}

$conn = NULL;

?>