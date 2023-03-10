<?php
//if an item is hidden, have the button say "show," if it isn't, have the button say "hide."
    $hiddentxt = "";
    if($isHidden == 0){
        $hiddentxt = "Hide ";
    } else {
        $hiddentxt = "Show ";
    }

?>

<!--generates one item from section table. Variables declared in "generate_page.php" or the associated edit page-->
<div id="<?php echo $ID;?>" name="<?php echo $ID;?>">
    <!--Image first so that it lines up with the top of the subheading-->
    <div id="<?php echo $ID;?>Img" name="<?php echo $ID;?>Img" class="subheading imgButton photoBox"></div>

    <script>
        changeImg("<?php echo $ID;?>Img", "<?php echo $imgsrc;?>");
    </script>

    <!--echoes the name from the database-->
    <h3><?php echo $name;?></h3>

    <!--form to edit name and description-->
    <form id="<?php echo $ID . "Edit";?>" name="<?php echo $ID . "Edit";?>" method="post" class="subheading">
        <label for="name" class="subheading">Change name</label>
        <input type="textbox" id="name" name="name" value="<?php echo $name;?>" class="subheading"/>
                    
        <label for="desc" class="subheading">Edit description</label> <br />
        <textarea id="desc" name="desc" rows="4" class="subheading"><?php echo $desc;?></textarea> <br />
        
        <input type="hidden" id="section" name="section" value="<?php echo $sectionTitle?>"/>
        <input type="hidden" id="number" name="number" value="<?php echo $idNumber?>"/>
        
        <input type="submit" id="save" name="save" value="Save" class="subheading"/>
    </form>

    <!--changes IMAGE identified by hidden values section and id-->
    <form method="post">
        <input type="hidden" id="section" name="section" value="<?php echo $sectionTitle?>"/>
        <input type="hidden" id="number" name="number" value="<?php echo $idNumber?>"/>
        <input type="submit" id="changeImage" name="changeImage" value="Change Image"/>
        <p class="imgtag"><?php echo $imgsrc?></p>
    </form> <br />

    <!--HIDES subheading identified by hidden values section and id-->
    <form method="post">
        <input type="hidden" id="section" name="section" value="<?php echo $sectionTitle?>"/>
        <input type="hidden" id="number" name="number" value="<?php echo $idNumber?>"/>
        <input type="hidden" id="isHidden" name="isHidden" value="<?php echo $isHidden?>"/>
        <input type="submit" id="hide" name="hide" value="<?php echo $hiddentxt . $sectionTitle;?>"/>
    </form>

    <!--REMOVES subheading identified by hidden values section and id-->
    <?php if($sectionTitle != "featured"){ //couldn't think of a better way to do this
        echo "
        <form method=\"post\">
            <input type=\"hidden\" id=\"section\" name=\"section\" value=\"". $sectionTitle . "\"/>
            <input type=\"hidden\" id=\"number\" name=\"number\" value=\"" . $idNumber . "\"/>
            <input type=\"submit\" id=\"remove\" name=\"remove\" value=\"Remove " . $sectionTitle . "\"/>
        </form>";
    }
    
    ?>  
</div>