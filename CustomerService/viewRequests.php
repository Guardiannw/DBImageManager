<?php

/*
 * PHP Pre-Process Information
 */
global $requests, $headers;

?>

<table id="viewRequests">
    <thead id="head">
        <tr>
            <?php foreach($headers as $col): ?>
            <th>
                <?php echo $col; ?>
            </th>
            <?php endforeach;?>
        </tr>
    </thead>
    <tbody>
        <?php foreach($requests as $row): ?>
        <tr>
            <?php foreach($row as $cols): ?>
            <td>
                <?php echo $cols; ?>
            </td>
            <?php endforeach; ?>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>