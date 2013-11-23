<?php

/*
 * PHP Pre-Process Information
 */
global $requests, $headers;

?>

<table id="viewRequests">
    
    <!-- This is the header row -->
    <tr>
        <?php foreach($headers as $col): ?>
        <td>
            <?php echo $col; ?>
        </td>
        <?php endforeach;?>
    </tr>
    
    <!-- All other rows are actual entries -->
    <?php foreach($requests as $rows): ?>
    <tr>
        
    </tr>
    <?php endforeach; ?>
</table>