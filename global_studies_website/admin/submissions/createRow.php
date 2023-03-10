    <?php $remove = "remove" . $ID;?>
    <tr>
        <td><?php echo $ID;?></td>
        <td><?php echo $firstName;?></td>
        <td><?php echo $lastName;?></td>
        <td><?php echo $email;?></td>
        <td><?php echo $message;?></td>
        <td class="remove"> <!--Remove file button-->
            <form method="post">
                <input type="hidden" id="number" name="number" value="<?php echo $ID;?>"/>
                <input type="hidden" id="section" name="section" value="contact_submissions"/>
                <input type="submit" id="remove" name="remove" value="Remove"/>
            </form>
        </td>
    </tr>