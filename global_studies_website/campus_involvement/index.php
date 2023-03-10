<!DOCTYPE html>
<html lang="en">
<!-- sources used: w3school, youtube (program with mosh and easy tutorials) -->
<head>
<link rel="stylesheet" href="../css/campus_involvement_style.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Courgette&display=swap" rel="stylesheet">
 
</head>

<body>

<?php include_once "../req/header.php"; ?>

  <h1>Campus Involvement</h1>

  <h4>Related Clubs</h4>

  <section class="container">
  
  <?php require_once "../req/database_functions.php";

$club= readTable("club");

$numRows= sizeof($club);

for ( $i=0; $i<$numRows; $i++)
{
    $currentRow=$club[$i];

    $name=$currentRow["name"];
    $description=$currentRow["description"];
    $imgsrc=$currentRow["imgsrc"];
    $isHidden=$currentRow["isHidden"];
    $id=$currentRow["id"];

    $section= "club";

    if (!$isHidden)
    {
        include "createcard.php";
    }
}
 ?>

</section>

<h3>Events</h3>

<section class="container">

<?php

$section= "event";
$event= readTable("event");

$numRows= sizeof($event);

for ( $i=0; $i<$numRows; $i++)
{
    $currentRow=$event[$i];
    $name=$currentRow["name"];
    $description=$currentRow["description"];
    $imgsrc=$currentRow["imgsrc"];
    $isHidden=$currentRow["isHidden"];
    $id=$currentRow["id"];

    $section= "event";

    if (!$isHidden)
    {
        include "createcard.php";
    }
}
 ?>

</section>

<script>
      //source: online tutorials video (youtube)
      let more = document.querySelectorAll('.more');
      for (let i=0; i<more.length; i++)
      {
        more[i].addEventListener('click',function()
        {
          more[i].parentNode.classList.toggle('active')
        }
        
        )
      }
</script>

<?php include_once "../req/footer.php";?>
</body>
</html>