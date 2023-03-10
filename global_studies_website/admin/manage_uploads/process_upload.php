<?php //Main resource: https://www.php.net/manual/en/function.move-uploaded-file.php
require_once "../req/login_session.php";
require_once "../../req/database_functions.php";

$uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/img'; //https://stackoverflow.com/questions/8320785/destination-path-for-move-uploaded-file-in-php
$uploadFile = $uploadDir . "/" . basename($_FILES['fileUpload']['name']);
$readFilePath = "/img/" . basename($_FILES['fileUpload']['name']);

    try {
        if (!isset($_FILES["fileUpload"])) { //https://dev.to/einlinuus/how-to-upload-files-with-php-correctly-and-securely-1kng
            throw new RuntimeException('There is no file to upload.');
        }

        //This chunk taken from: https://www.php.net/manual/en/features.file-upload.php
        // Undefined | Multiple Files | $_FILES Corruption Attack
        // If this request falls under any of them, treat it invalid.
        if ( !isset($_FILES['fileUpload']['error']) || is_array($_FILES['fileUpload']['error'])) {
            throw new RuntimeException('Invalid parameters.');
        }

        // Check filesize
        if ($_FILES['fileUpload']['size'] > 8000000) { //has to be massive to upload high-res images, but turns out that php.ini or server settings control this anyway
            throw new RuntimeException('Exceeded filesize limit.');
        }

        //check file type. From: https://dev.to/einlinuus/how-to-upload-files-with-php-correctly-and-securely-1kng
        $allowedTypes = [
            'image/png' => 'png',
            'image/jpg' => 'jpg',
            'image/jpeg' => 'jpeg',
            'application/pdf' => 'pdf'
        ];

        try{
            $fileinfo = finfo_open(FILEINFO_MIME_TYPE);
            $filepath = $_FILES['fileUpload']['tmp_name'];
            $filetype = finfo_file($fileinfo, $filepath);
        }
        catch(PDOException $e){
            $_SESSION['errormsg'] = "Failed to process file.";
                header("Location: index.php");
                exit;
        }
        
        if(!in_array($filetype, array_keys($allowedTypes))) {
            throw new RuntimeException('Invalid file format.');
        }

        //if it made it this far, the file is safe
        //attempt to move file
        if (!move_uploaded_file($_FILES['fileUpload']['tmp_name'], $uploadFile)) {
            throw new RuntimeException('Failed to move uploaded file.');
        }

        //if file made it to the end, add its path to the database
            $conn = connectToDatabase();
            try {
                // Re-initialize result values
                $result		= NULL;
                $numRows	= 0;
        
                // Create prepared SQL statement
                $sql = $conn->prepare("insert into file (filePath, rootPath) values (:filePath, :rootPath);");
        
                $sql->bindParam(':filePath', $readFilePath);
                $sql->bindParam(':rootPath', $uploadFile);
        
                // Excecute query
                $sql->execute();
           
        
            } catch(PDOException $e) {
                $_SESSION['errormsg'] = "Failed to process file. File is likely too large.";
                header("Location: index.php");
                exit;
            } 
            $conn = NULL;
            
    } catch (RuntimeException $e) {
        echo $e->getMessage();
    }

    header("Location: index.php");
    exit;
?>