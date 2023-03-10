<?php 

require_once "../../resources/mysql_connect.php";

// **Code copied from crud.php example on class GitHub and edited**

//=========================================================
// CREATE
//=========================================================
try {
    // Re-initialize result values
    $_SESSION['lastID']	= 0;

    // Create a prepared statement
    $sql = $conn->prepare("insert into contact (firstName, lastName, email, phone, contactMethod, smsAckn, topic, message) values (:firstName, :lastName, :email, :phone, :contactMethod, :smsAckn, :topic, :message);");

    // Bind column values as prepared statement parameters
    // NOTE: match the parameter name (first argument in the bindParam() method) with the value in the prepared SQL statement
    $sql->bindParam(':firstName', $firstName);
    $sql->bindParam(':lastName', $lastName);
    $sql->bindParam(':email', $email);
    $sql->bindParam(':phone', $phone);
    $sql->bindParam(':contactMethod', $contactMethod);
    $sql->bindParam(':smsAckn', $smsAckn);
    $sql->bindParam(':topic', $printTopic);
    $sql->bindParam(':message', $message);


    // Execute the query

    // If successful, get last inserted ID, 
    if ($sql->execute()) {
        $_SESSION['lastID']	= $conn->lastInsertId();
    } else {
        //DisplayError('Database Execute --- ' . $sql->errorInfo()[2]);
    }

} catch(PDOException $e) {
    //echo "Insert Error: " . $e->getMessage();
    $error = true;
}

$conn = NULL;

?>