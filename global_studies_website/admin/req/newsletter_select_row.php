    <tr <?php if($selected == "Yes"){echo "id=\"selectedTR\"";}?>>
        <td><?php echo $ID;?></td>
        <td><?php echo $filePath;?></td>
        <td><?php echo $selected;?></td>
        <td>
            <form method="post">
                <input type="hidden" id="filePath" name="filePath" value="<?php echo $filePath;?>"/>
                <input type="submit" id="newsletterFile" name="newsletterFile" value="Choose"/>
            </form>
        </td>
    </tr>