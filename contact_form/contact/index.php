<!DOCTYPE html>
<?php 
    session_start();

    //Declaring all variables
    $firstName = "";
    $lastName = "";
    $email = ""; 
    $confirmEmail = "";
    $phone = "";
    $contactMethod = ""; 
    $smsAckn = ""; 
    $topic = "";
    $customTopic = "";
    $printTopic = "";
    $message = "";

    $postInputs = array(
        "firstName", 
        "lastName", 
        "email", 
        "confirmEmail",
        "phone", 
        "contactMethod", 
        "smsAckn", 
        "topic",
        "customTopic",
        "message"
    );

    $error = false;
    $errorMessage = "";

    //Key is the name of each input variable, value is whether that input has an error (true means error is present)
    $_SESSION['requiredInputs'] = array("firstName" => false, 
                                        "lastName" => false, 
                                        "email" => false, 
                                        "confirmEmail" => false,
                                        "contactMethod" => false, 
                                        "smsAckn" => false, 
                                        "topic" => false);

    //when submitted
    if (isset($_POST['submit'])){

        $error = false; //resets errors each submit to check them again

        //setting all variables based on POST values
        foreach($postInputs as $key){
            if(isset($_POST[$key])){
                //Trying to do htmlspecialchars on these didn't work well, and user can't type to them
                if($key == "contactMethod" || $key == "smsAckn"){
                    $$key = $_POST[$key]; //Double $$ because $key is a string with the same name as the input variable
                }                         //Intending to reference the variable name, not the variable value
                else{
                    $$key = htmlspecialchars($_POST[$key]);
                }
            }
            else{ //prevents null errors and makes it match with what I'm sorting for
                $$key = "";
            }
        }

        //Custom topic only used if "other" is selected
        if($topic == "Other") {
            $printTopic = $customTopic;
        }
        else { //printTopic is the topic that will be sent to me in the email
            $printTopic = $topic;
        }
    
        //checking all required inputs are filled out
        //if any required input is missing and the form sumbits, an error appears next to the instructions
        foreach($_SESSION['requiredInputs'] as $key => $hasError){
            if($$key == ""){
                $error = true;
                $errorMessage = "Please fill out all required fields. "; //only appears once
                $_SESSION['requiredInputs'][$key] = true;
            }
        }

        //check if emails match
        if($email != $confirmEmail) //https://www.geeksforgeeks.org/string-comparison-using-vs-strcmp-in-php/
        {
            $error = true; 
            $errorMessage .= "Email addresses do not match. "; //https://www.w3schools.com/php/php_operators.asp adds onto existing error message
            $_SESSION["requiredInputs"]['email'] = true;
            $_SESSION["requiredInputs"]['confirmEmail'] = true;
        }

        //check if email is valid (only checks first input because they have to match, meaning that if one is right, so is the other)
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { //from W3 schools PHP tutorial: https://www.w3schools.com/php/php_form_url_email.asp
            $error = true;
            $errorMessage .= "Invalid email format. "; //adds on to existing error message
            $_SESSION["requiredInputs"]['email'] = true;
        }
      
        if(!$error) { //if no errors, continue
            //format smsAckn
            if(isset($smsAckn)){
                $smsAckn = "Yes";
            }
            else{
                $smsAckn = "No"; //as a required input, this should never be the case. However, this prevents an error in the database just in case
            }

            //set cookie
            $inputData = array("firstName" => $firstName, 
                                "lastName" => $lastName, 
                                "email" => $email, 
                                "phone" => $phone, 
                                "contactMethod" => $contactMethod, 
                                "smsAckn" => $smsAckn, 
                                "topic" => $printTopic,
                                "message" => $message);
            
            $expireTime = 0; // https://www.w3schools.com/php/func_network_setcookie.asp#:~:text=Note%3A%20The%20setcookie()%20function,%2C%20use%20setrawcookie()%20instead).
            
            //setting cookies - from class example "cookie_create.php"
            setcookie("contactFormCookie", json_encode($inputData), $expireTime, "/");

            require_once "./inc/database.php";
            
            //once set, send user to confirmation page
            if(!$error){ //needs it again because the database.php can also update $error
                header("Location: ./confirmation.php");  //also from class php examples
                exit;
            }
        } 
    }

    //Error formatting function, checks key against session array of required inputs (with boolean values--true signifies an error)
    //Function goes within the label for each field. The rubric helped me know to use session variables.
    function format_error($inputKey) {
        if(isset($_POST['submit'])){
            if($_SESSION["requiredInputs"][$inputKey] == true)
                    echo "class = \"error\""; //https://stackoverflow.com/questions/25786205/change-an-elements-css-class-with-php
        }
    }
          
?>

<html>
    <head>
        <title>Contact</title>
        <link rel="styleSheet" href="../css/contact_style_sheet.css"/> <!--linking css learned from W3 schools-->
        <script type="text/javascript">
        
        //The script basically does the same thing as the php, just with pop-up alerts instead of changing the error message.
        var required_inputs = ["firstName", "lastName", "email", "confirmEmail", "contactMethod", "topic"];// "contactMethod", //https://www.w3schools.com/js/js_arrays.asp
           
        function checkRequiredInputs(){ //most of this taken from js_form_validation example in class GitHub repository
            var isValid = true;

            for (var ii = 0; ii<required_inputs.length; ii++){ //https://www.w3schools.com/js/js_loop_for.asp 
                var currentInputID = required_inputs[ii];
                var currentLabel = document.getElementById(currentInputID + "Label");
                if(document.forms['contactForm'][currentInputID].value == "") {
                    isValid = false;  
                    currentLabel.className = "error"; //https://stackoverflow.com/questions/195951/how-can-i-change-an-elements-class-with-javascript
                }
                else{
                    currentLabel.className = "";
                }
            } 

            //Tried doing same fix as radio buttons to no avail, so here's the special case. 
            //If I had multiple, the required checkboxes would have their own array
            var currentID = "smsAckn";
            var currentLabel = document.getElementById(currentID + "Label");
            if(!document.getElementById(currentID).checked){
                currentLabel.className = "error";
                isValid = false;
            }
            else{
                currentLabel.className = "";
            }

            if(isValid == false){
                alert("Please fill out all required fields.");
            }

            //email validation
            var emailAddress = document.getElementById("email").value;
            var emailConfirm = document.getElementById("confirmEmail").value;

            //valid pattern and characters?
            if (!emailAddress.match(/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/)) { //https://stackoverflow.com/questions/46155/how-can-i-validate-an-email-address-in-javascript  https://www.simplilearn.com/tutorials/javascript-tutorial/email-validation-in-javascript
                if(isValid == true){ //if another error already called the alert, don't do it yet
                    alert("Invalid email address.");
                }
                document.getElementById("emailLabel").className = "error";
                isValid = false;
            }
            else if(isValid == true){ //doesn't override formatting from if they're both empty
                document.getElementById("emailLabel").className = "";
            }

            //check that emails match
            if(emailAddress !== emailConfirm){ //https://www.javascripttutorial.net/string/javascript-string-equals/
                if(isValid == true){ //if another error already called the alert, don't do it yet
                    alert("Email addresses do not match.");
                }
                document.getElementById("emailLabel").className = "error";
                document.getElementById("confirmEmailLabel").className = "error";
                isValid = false;
            } 
            else if(isValid == true){ //doesn't override formatting from if they're both empty (and therefore match)
                document.getElementById("emailLabel").className = "";
                document.getElementById("confirmEmailLabel").className = "";
            }

            return isValid;
         }
        </script>

    </head>
    <body>
        <h1>Contact Form</h1>

        <p <?php if($error==true){echo "class = \"error\"";} else{echo "id = \"instructions\"";}?>> <?php if($error==true){echo $errorMessage;}?>* Denotes a required field.  </p>

        <form id="contactForm" name="contactForm" method="post" action ="" enctype="multipart/form-data" onsubmit="return checkRequiredInputs();"> <!--from javascript form validation example in class GitHub-->
            
        <!--First and last name--> <!--All labels and text inputs based on in-class examples-->
            <label id="firstNameLabel" for="firstName" <?php format_error("firstName");?> >*First name:</label> <!--//https://stackoverflow.com/questions/25786205/change-an-elements-css-class-with-php-->
            <input type="text" id="firstName" name="firstName" class="formInput shortText" value="<?php if($firstName != "") {echo $firstName;}?>"/> <!--class usage learned from W3 Schools-->
            <label id="lastNameLabel" for="lastName" <?php format_error("lastName");?> >*Last name:</label>
            <input type="text" id="lastName" name="lastName" class="formInput shortText" value="<?php if($lastName != ""){echo $lastName;}?>"/> <br />

            <!--email-->
            <label id="emailLabel" for="email" <?php format_error("email"); ?> >*Email address:</label>
            <input type="text" id="email" name="email" class="formInput" value="<?php if($email != ""){echo $email;}?>" placeholder="example@ex.com"/> <br /> <!--placeholder learned from Zamzam Mohamed-->

            <!--confirm email-->
            <label id="confirmEmailLabel" for="confirmEmail" <?php format_error("confirmEmail"); ?> >*Confirm email:</label>
            <input type="text" id="confirmEmail" name="confirmEmail" class="formInput" value="<?php if($confirmEmail != ""){echo $confirmEmail;}?>" placeholder="example@ex.com"/> <br />

            <!--phone--> <!--non required inputs don't need an error format-->
            <label for="phone">Phone number:</label>
            <input type="text" id="phone" name="phone" class="formInput"  value="<?php if($phone != ""){echo $phone;}?>" placeholder="xxx-xxx-xxxx"/> <br /> 

            <!--Preferred method of contact radio buttons-->    <!--id vs name vs value with radio buttons learned from W3 schools-->
            <p id="contactMethodLabel" <?php format_error("contactMethod");?> >*Preferred method of contact:</p>    <!--"checked" found here: https://bulma.io/documentation/form/radio/-->
            
            <input name="contactMethod" type="hidden" value=""/> <!-- a surprisingly simple fix for these not having a default value, which previously messed with my array functions https://www.sitepoint.com/html-checkbox-radio-button-defaults/ -->

            <input type="radio" id="preferEmail" name="contactMethod" value="Email" class="formInput" <?php if($contactMethod == "Email"){echo "checked";}?>/>
            <label for ="preferEmail">Email</label> 
            <input type="radio" id="preferCall" name="contactMethod" value="Call" class="formInput" <?php if($contactMethod == "Call"){echo "checked";}?>/>
            <label for ="preferCall">Phone (Call)</label>  
            <input type="radio" id="preferText" name="contactMethod" value="Text" class="formInput" <?php if($contactMethod == "Text"){echo "checked";}?>/>
            <label for ="preferText">Phone (Text)</label>  <br />

            <!--SMS rates checkbox-->
            <input type="checkbox" id="smsAckn" name="smsAckn" class="formInput" <?php if($smsAckn == "on"){echo "checked";}?> />
            <label for="smsAckn" id="smsAcknLabel" <?php format_error("smsAckn");?> >*I understand that SMS rates apply on text communication as normal.</label> <br />
           
            <!--Topic dropdown-->
            <label id="topicLabel" for="topic" <?php format_error("topic");?> >*Topic:</label>   <!--Dropdown instructions found on W3 schools-->
            <select id="topic" name="topic" class="formInput">
                <option value="" <?php if($topic == ""){echo "selected";}?>>(Choose a topic)</option> <!--Checks for the value in the $topic variable and puts the correct one as selected-->
                <option value="Resume" <?php if($topic == "Resume"){echo "selected";}?>>Resume Question</option>
                <option value="Hiring" <?php if($topic == "Hiring"){echo "selected";}?>>Interest in hiring</option>
                <option value="Commissions" <?php if($topic == "Commissions"){echo "selected";}?>>Commissions</option>
                <option value="Other" <?php if($topic == "Other"){echo "selected";}?>>Other</option>
            </select> <br />

            <!--Other topic textbox-->
            <label for="customTopic">If other, specify: </label>
            <input type="text" id="customTopic" name="customTopic" class="formInput shortText" value="<?php if($customTopic != ""){echo $customTopic;}?>" /> <br />

            <!--Message textarea-->
            <label for="message">Message:</label>
            <textarea id="message" name="message" rows="6" class="formInput"><?php if($message != ""){echo $message;}?></textarea> <br /> 
            <!--learned rows from w3 Schools. I wanted it to read as a textarea instead of a textbox even without CSS-->

            <!--submit button-->
            <input type="submit" id="submit" name="submit" class="formInput" value="Submit"/>

            <!--Error messages, if any-->
            <p class="error"><?php if(isset($_SESSION["cookieError"])){echo $_SESSION["cookieError"];} ?></p>
        </form>
    </body>
</html>
