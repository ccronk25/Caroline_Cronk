    <tr>
        <td><?php echo $ID;?></td>
        <td><?php echo $filePath;?></td>
        <td class="remove"> <!--Remove file button-->
            <form method="post">
                <input type="hidden" id="filePath" name="filePath" value="<?php echo $filePath;?>"/>
                <input type="hidden" id="number" name="number" value="<?php echo $ID;?>"/>
                <input type="hidden" id="section" name="section" value="file"/>
                <input type="submit" id="removeFile" name="removeFile" value="Remove"/>
            </form>
        </td>
    </tr>