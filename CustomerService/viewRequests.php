<?php

/*
 * PHP Pre-Process Information
 */
global $requests, $headers, $schoolNames;

//format the time for the requests
formatTimeArray($requests, array(ServiceRequest::$creationdate), "F d, Y");

//format the SchoolID's with the school names
foreach($requests as &$request)
{
    //create a simple link to the schoolid
    $sid = &$request[ServiceRequest::$schoolid];
    
    //assign it to the appropriate field
    $sid = $schoolNames[(int)$sid];
    
    //get the name variable
}
?>

<table id="viewRequests">
    <thead id="head">
        <tr>
            <!-- Service Request Headers -->
            <?php foreach($headers as $col): ?>
            <th>
                <?php echo $col; ?>
            </th>
            <?php endforeach;?>
            
            <!-- Edit Header -->
            <th>
                Edit
            </th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($requests as $row): ?>
        <tr>
            <!-- Input normal row information -->
            <?php foreach($row as $cols): ?>
            <td>
                <?php echo $cols; ?>
            </td>
            <?php endforeach; ?>
            
            <!-- Input the edit button -->
            <td>
                <form method="GET">
                    <input type='hidden' name='id' value='<?php echo $row[ServiceRequest::$id]; ?>'>
                    <input type='hidden' name='action' value='editRequest'>
                    <input type="submit" value="Edit">
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>