<?php
//Code taken from Zamzam Mohamed
    //Recipients
    $headers = 'From: contactsubmissions@carolinecronk.com' . "\r\n";     //from
    $to = 'ccronk@cord.edu';                                               //to

    //Content                         
    $subject = 'New Form Submitted';
    
    if(isset($formOutput)){
        $txt = "Form output:" . "\r\n" . $formOutput;
    }
    else {$txt = 'Failed to set form output.';}

    mail($to, $subject, $txt, $headers);
?>