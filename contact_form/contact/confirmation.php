<!DOCTYPE html>
<?php
session_start();

$dbOutput= ""; //for formatting database data

    //if the cookie is set
    if(isset($_COOKIE["contactFormCookie"])){
    //decode it
        $cookiesDecoded = json_decode($_COOKIE["contactFormCookie"], true); //from class example "cookie.php"

    //Double check cookies: if any required input is missing from the cookies, it gives an error message and returns to contact page
        $requiredCookies = array("firstName",
                                "lastName",
                                "email", 
                                "contactMethod", 
                                "smsAckn", 
                                "topic");

        foreach($requiredCookies as $cookieInput){ //learned syntax of "foreach" from class examples on GitHub
            if($cookiesDecoded[$cookieInput] == ""){
                $_SESSION["cookieError"] = "Failed to set required cookies. Please try again.";
                header("Location: ./index.php"); 
                exit;
            }
            else { //reset value if cookies go through
                $_SESSION["cookieError"] = "";
            }
        }

        //create output string for email
        $formOutput = "";
        foreach($cookiesDecoded as $key => $value){
            $formOutput .= $key . ": " . $value . "\r\n";
        }
    }
    include_once "./inc/sendmail.php";

    require_once "../../resources/mysql_connect.php";

//=========================================================
// READ **Code copied from crud.php example on class GitHub and edited**
//=========================================================

try {
    // Re-initialize result values

    // Create prepared SQL statement
    $sql = $conn->prepare("select * from contact where id=:contactID");

    // Create variables for parameter values
        $contactID = $_SESSION['lastID'];


    // Bind parameters
    $sql->bindParam(':contactID', $contactID);

    // Excecute query
    $sql->execute();

    // Get results (if any)
    $result = $sql->setFetchMode(PDO::FETCH_ASSOC);
    $result = $sql->fetchAll();

    // Loop through results
    for ($i = 0; $i < sizeof($result); $i++) {
        $row = $result[$i];
        $dbOutput = "First name: " . $row["firstName"] . "<br />" . 
        "Last name: " . $row["lastName"] . "<br />" .
        "Email address: " . $row["email"] . "<br />" .
        "Phone number: " . $row["phone"]. "<br />" .
        "Preferred method of contact: " . $row["contactMethod"] . "<br />" .
        "Acknowledged SMS Rates: " . $row["smsAckn"] . "<br />" .
        "Topic: " . $row["topic"] . "<br />" .
        "Message: " .  $row["message"];
    }

} catch(PDOException $e) {
    //echo "Select Error: " . $e->getMessage();
}

$conn = NULL;

?>

<html>
    <head>
        <title>Contact Form Confirmation</title>
        <!--Same style sheet, edited to add an "error" and "thanks" style for the new situations-->
        <link rel="styleSheet" href="../css/contact_style_sheet.css"/>
    </head> 
    <body>
        <h1>Form Submitted Successfully!</h1>
        <p id="thanks">Thank you for submitting<?php 
            if(isset($_COOKIE["contactFormCookie"])){ //just in case. Prevents errors when opening the confirmation page directly
            if($cookiesDecoded["firstName"] != ""){ //if first name available, use it. 
                echo ", " . $cookiesDecoded["firstName"]; //otherwise it just reads "Thank you for submitting."
            }}
            ?>.</p> <br />
        <p id="instructions">Please review your answers below:</p>
    <?php
        if(isset($dbOutput)){
            echo $dbOutput;
        }
    ?>
    </body>
</html>
