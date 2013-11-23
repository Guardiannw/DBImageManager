<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
global $databaseManager; //should be initialized in the connect.php


$jobs = $databaseManager->getJobs(); //retrieves an associative array of all the jobs in the database

//if the jobs are empty, then add 1 where the value is Empty
if(empty($jobs))
{
    $assocArray['Name'] = "Empty";
    array_push($jobs, $assocArray);
    unset($assocArray);
}
?>

<form method="post" action="processScans.php">
    <table id="scanTable">
        <tr>
            <td>
                Count
            </td>
            <td>
                ID
            </td>
            <td>
                Time
            </td>
        </tr>
    </table>
    
    <!-- Determines whether or not to download the file or to add it to the database -->
    <label for="radioDownload" >Download</label> 
    <input type="radio" name="action" id="radioDownload" value="download" onclick="changeVisibilityOnCheck(this, 'selectJob', false)" >
    <label for="radioSubmit" value="Submit">Submit</label>
    <input type="radio" name="action" value="submit" id="radioSubmit" onclick="changeVisibilityOnCheck(this, 'selectJob', true)" checked>
    <!-- If submit is checked, a job must be selected which it can be applied to -->
    <select id="selectJob" name="selectJob" style="visibility: visible;">
        <?php foreach($jobs as $job): ?>
        <option value="<?php echo $job['Name']; ?>">
            <?php echo $job['Name']; ?>
        </option>
        <?php endforeach; ?>
    </select>
    
    <input type="submit" name="submit" value="Submit">
    
    
    
    <script type="text/javascript">
        addNewTableRowWithTextInputs("scanTable");
    </script>
</form>