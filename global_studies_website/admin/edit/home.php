<!DOCTYPE html>
<?php require_once "../req/login_session.php";?>
<head>
    <title>Edit Page</title>
    <link rel="styleSheet" href="../../css/css_admin.css"/>
</head>
<body>
    <h1>Edit "Home"</h1>

    <p>Only edit one element at a time, as saving a change will refresh the page.</p>
<?php  

    if(isset($_POST["newsFile"])){
        header("Location: ./select_newsletter.php");
        exit;
    }

    require_once "../req/page_list.php";  
    require_once "../req/section_functions.php"; 

    $homeTable = readTable("home_files");
    //path to newsletter file
    $newsletterPath = $homeTable[0]["imgsrc"];
    //path to splash image
    $splashPath = $homeTable[1]["imgsrc"];
    //summary description
    $desc = $homeTable[2]["description"];
?>

    <!--choose large photo on home page-->
    <div class="section">
        <h2>Choose Home Image</h2>
        <form method="post">
            <input type="hidden" id="section" name="section" value="home_files"/>
            <input type="hidden" id="number" name="number" value="2"/>
            <input type="submit" id="changeImage" name="changeImage" value="Change Image"/>
            <p class="imgtag"><?php echo $splashPath?></p>
        </form> 
    </div>

    <div class="section">
        <h2>Summary paragraph</h2>
        <!--form to edit name and description-->
        <form id="summaryEdit" name="summaryEdit" method="post" class="subheading">           
            <label for="desc" class="subheading">Edit description</label> <br />
            <textarea id="desc" name="desc" rows="4" class="subheading"><?php echo $desc;?></textarea> <br />
            
            <input type="hidden" id="name" name="name" value="paragraph"/>
            <input type="hidden" id="section" name="section" value="home_files"/>
            <input type="hidden" id="number" name="number" value="3"/>
            
            <input type="submit" id="save" name="save" value="Save" class="subheading"/>
        </form>
    </div>

    <?php  
    //construct first section
        $sectionTitle = "featured";
        $sectionName = "Featured Students";
        include "../req/generate_section.php";

    //construct newsletter section -- doesn't have same as everything else, so it doesn't use the include file
        $sectionName = "Newsletter";
    ?>

    <!-- Options for second section-->
    <div id="section" name="section" class="section">
        <h2><?php echo $sectionName?></h2>

    <!--Change newsletter pdf-->
        <p>Newsletter file: <?php echo $newsletterPath;?></p>

        <form method="post">    
            <input type="submit" id="newsFile" name="newsFile" value="Change newsletter file"/>
        </form>

</body>