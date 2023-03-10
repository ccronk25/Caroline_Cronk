<!DOCTYPE html>
<?php
    session_start();

    require_once "../../req/database_functions.php";

    $errorMsg = "";

    if(isset($_POST['submit'])){
        $username = htmlspecialchars($_POST["username"]);
        $inputPassword = htmlspecialchars($_POST["password"]);
        $password = "";
        $sectionTitle = "user";

        $conn = connectToDatabase();
        
        try {
            // Re-initialize result values
            $result		= NULL;
            $numRows	= 0;
   
           // Create prepared SQL statement
           $sql = $conn->prepare("select password from " . $sectionTitle . " where username=:username");

           $sql->bindParam(':username', $username);
   
            // Excecute query
           $sql->execute();
       
            // Get results (if any)
           $result = $sql->setFetchMode(PDO::FETCH_ASSOC);
           $result = $sql->fetchAll();

            for ($i = 0; $i < sizeof($result); $i++) {
                $row = $result[$i];
                $password = $row["password"];
                if($inputPassword == $password){
                    $_SESSION['user'] = $username; //https://artisansweb.net/create-php-login-system-your-website/
                    header("Location: ../home/index.php");
                    exit;
                }
                else{
                    $errorMsg = "Incorrect username or password.";
                }
            }
        } catch(PDOException $e) {
            $errorMsg = "Unable to log in.";
            //echo "Select Error: " . $e->getMessage();
        } 
        $conn = NULL;
    }
    
?>
<!--this is the page that the link on the footer leads to, where the administrators can log in-->
<head>
    <title>Admin Login</title>
    <link rel="styleSheet" href="../../css/login.css"/>
</head>
<body id="loginBody">

    <h1 id="loginH1">Admin Login</h1>
    <div class="section" id="loginSection">
        <form id="login" name="login" method="post">
            <label for="username">Username</label> <br />
            <input type="textbox" id="username" name="username"/> <br />

            <label for="password">Password</label> <br />
            <input type="password" id="password" name="password"/> <br />

            <input type="submit" id="submit" name="submit" value="Log In"/> <br />
            
            <!--This is a temporary link for the walkthrough, since I didn't want to use PHP to process the sumbit for this-->
        </form>
    </div>
    <p><?php echo $errorMsg;?>
</body>