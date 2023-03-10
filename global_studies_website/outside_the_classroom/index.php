<!DOCTYPE html>
<html lang="en">
<!-- sources used: w3school, youtube (program with mosh and easy tutorials, Tief Software Lab, EJ Media, Creative Coding, Full Stack Coding Tutorials, dcode, Online Tutorials)Team members: Zamzam, Caroline-->
<head>
<link rel="stylesheet" href="../css/outside_style.css">
 <title>Outside the Classroom</title>
 <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Courgette&display=swap" rel="stylesheet">
</head>

<body>

<?php include_once "../req/header.php";?>

  <h1>Career</h1>
  <p class="p2color">Global studies will prepare you for a wide variety of career paths from working in government, NGOs, nonprofits, and businesses. Many students go abroad after graduation, gaining work experience and learning language.</p>
  <p class= "p3color">Recent grads have gone to:</p>
  <ul class="careerlist">
  
  <?php 
require_once "../req/database_functions.php";

$sectionData = readTable("career");

$numRows = sizeof($sectionData);
for($ii = 0; $ii < $numRows; $ii++){
    $currentRow = $sectionData[$ii];

    $description = $currentRow["description"];
    $isHidden = $currentRow["isHidden"];
    $id =  $currentRow["id"];

    if(!$isHidden){
        include "./career.php";

    }

}

?>
</ul> 


<!----------------------------------->
<!-------    Photo Carousel   ------->
<!----------------------------------->


<h3 class="h3color">Here are a couple of pictures of students travelling to India, Costa Rica, Washington DC, and More!</h3>
<div class="box">
    <a href="./abroad_photos/CostaRica1.jpg"><img id="img-gal" src="./abroad_photos/CostaRica1.jpg" width="400" width="200"></a>
    <a href="./abroad_photos/CostaRica2.jpg"><img id="img-gal" src="./abroad_photos/CostaRica2.jpg" width="400" width="200"></a>
    <a href="./abroad_photos/CostaRica3.jpg"><img id="img-gal" src="./abroad_photos/CostaRica3.jpg" width="400" width="200"></a>
    <a href="./abroad_photos/CostaRica4.jpg"><img id="img-gal" src="./abroad_photos/CostaRica4.jpg" width="400" width="200"></a>
    <a href="./abroad_photos/India1.jpg"><img id="img-gal" src="./abroad_photos/India1.jpg" width="400" width="200"></a>
    <a href="./abroad_photos/India2.jpg"><img id="img-gal" src="./abroad_photos/India2.jpg" width="400" width="200"></a>
    <a href="./abroad_photos/India3.jpg"><img id="img-gal" src="./abroad_photos/India3.jpg" width="400" width="200"></a>
    <a href="./abroad_photos/India4.jpg"><img id="img-gal" src="./abroad_photos/India4.jpg" width="400" width="200"></a>
    <a href="./abroad_photos/India5.jpg"><img id="img-gal" src="./abroad_photos/India5.jpg" width="400" width="200"></a>
    <a href="./abroad_photos/India6.jpg"><img id="img-gal" src="./abroad_photos/India6.jpg" width="400" width="200"></a>
    <a href="./abroad_photos/India7.jpg"><img id="img-gal" src="./abroad_photos/India7.jpg" width="400" width="200"></a>
    <a href="./abroad_photos/Washington1.jpg"><img id="img-gal" src="./abroad_photos/Washington1.jpg" width="400" width="200"></a>
    <a href="./abroad_photos/Washington2.jpg"><img id="img-gal" src="./abroad_photos/Washington2.jpg" width="400" width="200"></a>
    <a href="./abroad_photos/Washington3.jpg"><img id="img-gal" src="./abroad_photos/Washington3.jpg" width="400" width="200"></a>
    <a href="./abroad_photos/Washington4.jpg"><img id="img-gal" src="./abroad_photos/Washington4.jpg" width="400" width="200"></a>
    <a href="./abroad_photos/Washington5.jpg"><img id="img-gal" src="./abroad_photos/Washington5.jpg" width="400" width="200"></a>
    <a href="./abroad_photos/Washington6.jpg"><img id="img-gal" src="./abroad_photos/Washington6.jpg" width="400" width="200"></a>
    <a href="./abroad_photos/Africa1.jpg"><img id="img-gal" src="./abroad_photos/Africa1.jpg" width="400" width="200"></a>
    <a href="./abroad_photos/Place1.jpg"><img id="img-gal" src="./abroad_photos/Place1.jpg" width="400" width="200"></a>
    <a href="./abroad_photos/Place2.jpg"><img id="img-gal" src="./abroad_photos/Place2.jpg" width="400" width="200"></a>
    <a href="./abroad_photos/Place3.jpg"><img id="img-gal" src="./abroad_photos/Place3.jpg" width="400" width="200"></a>

</div>


<!----------------------------------->
<!-------     List Items     -------->
<!----------------------------------->


<h1>Internships</h1>


<?php $sectionData = readTable("internship");

$numRows = sizeof($sectionData);
for($ii = 0; $ii < $numRows; $ii++){
    $currentRow = $sectionData[$ii];

    $name = $currentRow["name"];
    $description = $currentRow["description"];
    $isHidden = $currentRow["isHidden"];
    $id =  $currentRow["id"];

    if(!$isHidden){
        include "internship.php";

    }

}

?>





<!----------------------------------->
<!-------      footer        -------->
<!----------------------------------->

<?php include_once "../req/footer.php";?>

</body>
</html>
