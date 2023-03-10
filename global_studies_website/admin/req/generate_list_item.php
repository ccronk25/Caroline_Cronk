<?php
//if an item is hidden, have the button say "show," if it isn't, have the button say "hide."
    $hiddentxt = "";
    if($isHidden == 0){
        $hiddentxt = "Hide ";
    } else {
        $hiddentxt = "Show ";
    }

    if($sectionTitle == "concetnration"){
        $sectionName = "Concentration ";
    }
?>

<!--generates one item from section table. Variables declared in "generate_page.php" or the associated edit page-->
<div id="<?php echo $ID;?>" name="<?php echo $ID;?>">

    <!--echoes the name from the database-->
    <h3><?php echo $sectionName . $idNumber;?></h3>

    <!--form to edit name and description-->
    <form id="<?php echo $ID . "Edit";?>" name="<?php echo $ID . "Edit";?>" method="post" class="subheading">
        <input type="hidden" id="name" name="name" value="0"/>
                    
        <label for="desc" class="subheading">Edit description</label> <br />
        <textarea id="desc" name="desc" rows="4" class="subheading"><?php echo $desc;?></textarea> <br />
        
        <input type="hidden" id="section" name="section" value="<?php echo $sectionTitle?>"/>
        <input type="hidden" id="number" name="number" value="<?php echo $idNumber?>"/>
        
        <input type="submit" id="save" name="save" value="Save" class="subheading"/>
    </form> <br />

    <!--hides subheading identified by hidden values section and id-->
    <form method="post">
        <input type="hidden" id="section" name="section" value="<?php echo $sectionTitle?>"/>
        <input type="hidden" id="number" name="number" value="<?php echo $idNumber?>"/>
        <input type="hidden" id="isHidden" name="isHidden" value="<?php echo $isHidden?>"/>
        <input type="submit" id="hide" name="hide" value="<?php echo $hiddentxt . $sectionTitle;?>"/>
    </form>

    <!--removes subheading identified by hidden values section and id-->
    <form method="post">
        <input type="hidden" id="section" name="section" value="<?php echo $sectionTitle?>"/>
        <input type="hidden" id="number" name="number" value="<?php echo $idNumber?>"/>
        <input type="submit" id="remove" name="remove" value="<?php echo "Remove " . $sectionTitle;?>"/>
    </form>
            
</div>