<!DOCTYPE html>
<html lang="en">
<!-- sources used: w3school, youtube (program with mosh and easy tutorials, Online Tutorials, garnatti one, Coding Market, dcode, full stack coding tutorialas) Team member: Zamzam, Caroline-->
<head>
<link rel="stylesheet" href="../css/inside_style.css">
 <title>Faculty and Concentration</title>
 <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Courgette&display=swap" rel="stylesheet">
</head>

<body>
<?php include_once "../req/header.php"; ?>

  <h1>Faculty</h1>
  <p class="p2color"><i>Meet some of our faculty memebers in the Global Studies Program</i></p>

<section class="container">

<?php 
require_once "../req/database_functions.php";

$sectionData = readTable("faculty");


$numRows = sizeof($sectionData);
for($ii = 0; $ii < $numRows; $ii++){
    $currentRow = $sectionData[$ii];

    $name = $currentRow["name"];
    $description = $currentRow["description"];
    $imgsrc = $currentRow["imgsrc"];
    $isHidden = $currentRow["isHidden"];
    $id =  $currentRow["id"];

    if(!$isHidden){
        include "createcard.php";
    }

    if($id %3 == 0){
      echo "<br />";
    }

}
?>

</section>

<!----------------------------------->
<!-------     List Items     -------->
<!----------------------------------->


<h1>Concentrations</h1>
<h2 class="h2color">Major in Global Studies</h2>
<p class="pcolor">A student majoring in global studies chooses one or two concentration areas in which to focus. All students will have an introduction to global studies and take part in the Senior Seminar course, which includes community research and career preparation.</p>

  <div class="box">
  <ul class="lcolor">

<?php 

$sectionData2 = readTable("concentration");

$numRows = sizeof($sectionData2);
for($ii = 0; $ii < $numRows; $ii++){
    $currentRow = $sectionData2[$ii];

    $description = $currentRow["description"];
    $isHidden = $currentRow["isHidden"];
    $id =  $currentRow["id"];

    if(!$isHidden){
        include "concentration.php";

    }

}


?>


  </ul>
</div>

}



<!----------------------------------->
<!-------      footer        -------->
<!----------------------------------->

<?php include_once "../req/footer.php";?>




    </body>
</html>