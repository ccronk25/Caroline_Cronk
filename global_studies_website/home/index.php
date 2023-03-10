<!DOCTYPE html>
<html>
<title>Global Studies</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../css/home.css">
<body>

<?php 
    session_start();

    require_once "../req/database_functions.php";
    $home_files= readTable("home_files"); 
    
    $newsletterFile = $home_files[0]['imgsrc'];
    $heroImageSrc = $home_files[1]['imgsrc'];
    $paragraph = $home_files[2]['description'];

    echo "<script>var heroImgSrc=\"".$heroImageSrc."\";</script>";
    
?>

    <!-- Navigation -->
    <?php require_once "../req/header.php";?>

<!-- Hero Image -->
<div id="hero-image" class="hero-image">
    <div class="hero-text">
        <h1>Welcome to the Global Studies Website</h1>
    </div>
</div> 

<script>
    changeImg("hero-image", heroImgSrc);
</script>

<!-- Description -->
<div class="blur">
    <h2>Our Program</h2>
    <p><i>A unique program at Concordia College</i></p>
    <p><?php echo $paragraph;?></p>
</div>

<script> //from sprites class example
    function hideByID(id){
        document.getElementById(id).style.display = "none";
        document.getElementById(id).style.visibility = "hidden";
    }
</script>

<?php 
$featured= readTable("featured");

    $currentRow=$featured[0];

    $name=$currentRow["name"];
    $description=$currentRow["description"];
    $imgsrc=$currentRow["imgsrc"];
    $isHidden=$currentRow["isHidden"];
    $id=$currentRow["id"];

    echo "<script>var imgsrc=\"".$imgsrc."\";</script>";

    if($isHidden == 1){
        echo "<script>hideById(\"student-quote\")</script>";
    }

?> 

<!-- Student Quotes -->
<div id="student-quote" class="student-quote">
    <div class="column">
        <div id="circle" class="circle" style="width: 300px; height: 300px;"></div>
    </div>
    <div class="column">
        <div class="quote">
            <h2><?php echo $name;?></h2>
            <p><?php echo $description;?></p>
        </div>
    </div>
</div>

<script> //set image for first featured student
    changeImg("circle", imgsrc);
</script> 

<?php    
    $currentRow=$featured[1];

    $name=$currentRow["name"];
    $description=$currentRow["description"];
    $imgsrc=$currentRow["imgsrc"];
    $isHidden=$currentRow["isHidden"];
    $id=$currentRow["id"];

    echo "<script>var imgsrc2=\"".$imgsrc."\";</script>";

    if($isHidden == 1){
        echo "<script>hideById(\"student-quote2\")</script>";
    }
?> 

<div id="student-quote2" class="student-quote2">
    <div class="column2">
        <div class="quote2">
            <h2><?php echo $name;?></h2>
            <p><?php echo $description;?></p>
        </div>
    </div>
    <div class="column2">
        <div id="circle2" class="circle2" style="width: 300px; height: 300px;"></div>
    </div>
</div>

<script> 
    changeImg("circle2", imgsrc2);
</script> 


<!-- Newsletter -->
<div class="newsletter-image">
    <div class="newsletter-text">
      <h1>Our Monthly Newsletter</h1>
      <p>Keep up with what's going on inside the global studies program!</p>
      
      <form method="post">
      <input type="submit" class="click" id="click" name="click" value="Click here to check it out!"/>
    </form>
    </div>
  </div>

  <?php
        if(isset($_POST['click'])){
            $_SESSION['newsletterFile'] = "../" . $newsletterFile;

            header("Location: newsletter.php");
            exit;
        }
    ?>

<!-- Footer -->
<?php include_once "../req/footer.php";?>
</body>
</html>
