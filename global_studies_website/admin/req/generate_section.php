<div id="section" name="section" class="section">
    <h2><?php echo $sectionName?></h2>

<?php

    $result		= NULL;	// Query results returned after executing an SQL statement
	$numRows	= 0;	// Number of rows (records) returned by an SQL query

    //get the desired section using database_functions.php
    $result = readTable($sectionTitle);

    $numRows = sizeof($result);
    
    //for as many rows as are in section, get data and use it to create subheadings
    
    for($ii = 0; $ii<$numRows; $ii++){
        $currentRow = $result[$ii];

        $desc = $currentRow["description"];
        $idNumber = $currentRow["id"];
        $isHidden = $currentRow["isHidden"];
        $ID = $sectionTitle . $idNumber;

        if($sectionTitle != "concentration" && $sectionTitle != "career"){ //concentration and career have no name or img
            $name = $currentRow["name"];
            $imgsrc = $currentRow["imgsrc"];

            include "../req/generate_subheading.php";  
        }
        else{
            include "../req/generate_list_item.php";  
        }    
                  
    }

?>

<br />

<?php if($sectionTitle != "featured"){ //couldn't think of a better way to exclude this for featured
    echo "
    <form method=\"post\">
        <input type=\"hidden\" id=\"section\" name=\"section\" value=\"" . $sectionTitle . "\"/>
        <input type=\"submit\" id=\"new\" name=\"new\" value=\"Add " . $sectionTitle . " +\"/>
    </form>";
}
?>
</div>
