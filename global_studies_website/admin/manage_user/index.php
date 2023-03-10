<!DOCTYPE html>
<html>
    <head>
        <title>Manage User</title>
        <link rel="styleSheet" href="../../css/css_admin.css"/>
    </head>
    <body>
        <?php 
            require_once "../req/page_list.php"; 
            require_once "../req/login_session.php";
            require_once "../req/section_functions.php";

            $userInfo = readTable("user");

            $row = $userInfo[0];

            $username = $row["username"];
            $retrievedPassword = $row["password"];
            $email = $row["contactEmail"];

            $usernameError = "";
            $passwordError = "";
            $emailError = "";

            //username form submission
            if(isset($_POST["usernameSubmit"])){
                
                if(isset($_POST['username']) && isset($_POST['password'])){
                    //if field isn't empty
                    if($_POST['username'] != "" && $_POST['password'] != ""){
                        $username = htmlspecialchars($_POST['username']);
                        $inputPassword = htmlspecialchars($_POST['password']);

                        //if the inputted password matches the retrieved password, continue
                        if($retrievedPassword === $inputPassword){
                            updateTable("user", 1, "username", $username);
                            $usernameError = "Username updated successfully.";
                        }
                        else{ //otherwise, set an error
                            $usernameError = "Password is incorrect. ";
                        }
                    }
                    else{ //if it is empty
                        $usernameError = "Please fill out all fields.";
                    }
                } //if it isn't set
                else{
                    $usernameError = "Please fill out all fields.";
                }
            }

            //password form submission
            if(isset($_POST["passwordSubmit"])){
                $requiredInputs = array("oldPassword", "newPassword", "confirmPassword");
                
                foreach($requiredInputs as $key){
                    if(isset($_POST[$key])){
                        //if field isn't empty
                        if($_POST[$key] != ""){
                            $$key = htmlspecialchars($_POST[$key]);
                        }
                        else{ //if it is empty
                            $passwordError = "Please fill out all fields.";
                        }
                    } //if it isn't set
                    else{
                        $passwordError = "Please fill out all fields.";
                    }
                }

                //if everything got set correctly, verify the contents
                if($passwordError == ""){
                    if($retrievedPassword !== $oldPassword){
                        $passwordError = "Password is incorrect. ";
                    }
                    if($newPassword !== $confirmPassword){
                        $passwordError .= "New passwords do not match. ";
                    }
                }

                //if there are still no errors, update the database
                if($passwordError == ""){
                    updateTable("user", 1, "password", $newPassword);
                    $passwordError = "Password updated successfully.";
                }
            }

            //email form emailSubmit
            if(isset($_POST["emailSubmit"])){
                
                //if field is set
                if(isset($_POST['email']) && isset($_POST['password'])){
                    //if field isn't empty
                    if($_POST['email'] != "" && $_POST['password'] != ""){
                        $email = htmlspecialchars($_POST['email']);
                        $inputPassword = htmlspecialchars($_POST['password']);

                        //if the inputted password matches the retrieved password, continue
                        if($retrievedPassword === $inputPassword){
                            //if the new email is a valid address
                            if (filter_var($email, FILTER_VALIDATE_EMAIL)) { //from W3 schools PHP tutorial: https://www.w3schools.com/php/php_form_url_email.asp
                                updateTable("user", 1, "contactEmail", $email);
                                $emailError = "Email updated successfully.";
                            }
                            else{ //if email isn't valid
                                $emailError .= "Invalid email format. ";
                            } 
                        }
                        else{ //if passwords don't match, set an error
                            $emailError .= "Password is incorrect. ";
                        }
                    }
                    else{ //if field is empty
                        $emailError = "Please fill out all fields.";
                    }
                } //if field isn't set
                else{
                    $emailError = "Please fill out all fields.";
                }
            }
            
        ?>

        <h1>Manage User</h1>

        <div class="section">
            <h3 class="userForms">Change username:</h3>
            
            <p class="error"><?php echo $usernameError;?></p>

            <form id="changeUsername" name="changeUsername" method="post">
                <!--Input new username-->
                <label for="username">New username:</label>
                <input type="textbox" id="username" name="username" value="<?php echoVariable($username);?>"/> <br />

                <!--Input old password for security-->
                <label for="password">Password:</label>
                <input type="password" id="password" name="password"/>

                <input type="submit" id="usernameSubmit" name="usernameSubmit" value="Save"/>
            </form>
        </div>

        <div class="section">
            <h3 class="userForms">Change password:</h3>

            <p class="error"><?php echo $passwordError;?></p>

            <form id="changePassword" name="changePassword" method="post">
                <!--Input old password for security-->
                <label for="oldPassword">Old password:</label>
                <input type="password" id="oldPassword" name="oldPassword"/> <br />

                <!--Input new password-->
                <label for="newPassword">New password:</label>
                <input type="password" id="newPassword" name="newPassword"/> <br />
                
                <!--Confirm new password-->
                <label for="confirmPassword">Confirm new password:</label>
                <input type="password" id="confirmPassword" name="confirmPassword"/>

                <input type="submit" id="passwordSubmit" name="passwordSubmit" value="Save"/>
            </form>
        </div>

        <div class="section">
            <h3 class="userForms">Set email that recieves contact form information:</h3>

            <p class="error"><?php echo $emailError;?></p>

            <form id="changeEmail" name="changeEmail" method="post">
                <!--Change contact submission email-->
                <label for="email">Email:</label>
                <input type="textbox" id="email" name="email" value="<?php echoVariable($email);?>"/> <br />    
            
                <!--Input old password for security-->
                <label for="password">Password:</label>
                <input type="password" id="password" name="password"/>

                <input type="submit" id="emailSubmit" name="emailSubmit" value="Save"/>
            </form>
        </div>

    </body>
</html>