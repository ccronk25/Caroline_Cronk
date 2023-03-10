<?php
    session_start();

    $firstName;
    $lastName;
    $email;
    $message;

    //creating cookie (3)
    function ifError($field){
       
       $error=false;     
                if($field==""){
                    $error = true;
                }
                return $error;
    }

    $ifError=false;
    if (isset($_POST['submit'])) {
        $ifError=false;

            $firstName= htmlspecialchars($_POST['firstName']);
            $lastName= htmlspecialchars($_POST['lastName']);
            $email= htmlspecialchars($_POST['email']);
            $message= htmlspecialchars($_POST['message']);

            $reqfields = array($firstName,$lastName,$email,$message);

            for ($i=0; $i<sizeof($reqfields); $i++)
            {
                if ($reqfields[$i] =="")
                {
                    $ermessage ="Please fill out all required fields.";
                 $ifError=true;
                }
        
            }

            if($ifError==false){
                //sending email confirmation (2)
                require_once "../req/database_functions.php";

                $userData = readTable("user");
                $to = $userData[0]['contactEmail'];
                //$to = "zamzam8253@gmail.com";
                $subject = "My message";
                $txt = "New Submission \r\n First name: " .$firstName. "\r\n Last name: " .$lastName. "\r\n Email address: " .$email. "\r\n Message: " .$message;//add all the form fields
                $headers = "From: contactsubmissions@carolinecronk.com'" . "\r\n";

                mail($to,$subject,$txt,$headers);

                require_once "contact_form_database.php";

                $cookieData = array("firstName" => $firstName
                                    , "lastName" => $lastName);

                $expireTime = time() + 86400 * 30; 
                setcookie("sampleCookie", json_encode($cookieData), $expireTime, "/");

                header("Location: SendEmail.php");
                exit;
            
            $ermessage="";
            }
}

        
    
?>
<!DOCTYPE html>
<head>
    <title>Contact Us</title>
    <link rel="styleSheet" href="../css/contact_style.css"/>
</head>
<body>
<?php include_once "../req/header.php";?>
    <h1>Contact Us</h1>
    <?php

if($ifError)
 {
     echo ( "<div class=\"alert\">". $ermessage ."</div>");

 }

 ?>
           <script type="text/javascript" >

           function Isvalid() {
                var array1= ["firstName","lastName", "email", "message"];
                //return false;
               let Valid= true;
               for(i=0; i<array1.length; i++){
                    
                    if (document.getElementById(array1[i]).value == "") {
                        if(Valid != false){ //this is how I got my contact form to only alert once regardless of how many fields are empty - Caroline
                            alert("ERROR: Please fill out all the required fields.");
                        }
                        Valid = false;
                        document.getElementById(array1[i]).className= "alert";
                    }
                    else{ 
                       // document.getElementById("contact").action="SendEmail.php"; /this was bypassing the php
                    } 
                }
           return Valid;
           }
           </script>

    <div class="section">
        <p>Note: All fields are required</p>

        <form id="contact" name="contact" method="post" action="" onsubmit="return Isvalid();">
            <label for="firstName">First Name </label> 
            <label for="lastName">Last Name </label> <br/> 

            <input type="textbox" id="firstName" name="firstName" <?php if($ifError){ if(ifError($firstName)) { echo "class=\"error\"";}}?> <?php if(isset($firstName)) { echo "value=\"" . $firstName . "\""; } ?> placeholder="First Name" />
            <input type="textbox" id="lastName" name="lastName" <?php if(isset($lastName)){ if(ifError($lastName)) { echo "class=\"error\"";;}}?> <?php if(isset($lastName)) { echo "value=\"" . $lastName . "\""; } ?>  placeholder="Last Name" />
            <br/>

            <label for="email">Email Address </label> <br />
            <input type="textbox" id="email" name="email" <?php if(isset($email)){ if(ifError($email)) { echo "class=\"error\"";}}?> <?php if(isset($email)) { echo "value=\"" . $email . "\""; } ?> placeholder="Email" > <br/>

            <label for="message">Message </label> <br />
            <textarea id="message" name="message" <?php if(isset($message)){ if(ifError($message)) { echo "class=\"error\"";}}?>placeholder="Message"><?php if(isset($message)) { echo $message; } ?></textarea> <br/>
            
   
          

            <input type="submit" id="submit" name="submit" value="Submit">
        </form>
    </div>

    <?php include_once "../req/footer.php";?>
</body>