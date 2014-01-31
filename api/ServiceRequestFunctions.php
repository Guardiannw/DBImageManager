<?php

global $databaseManager;

function searchAndSortAllServiceRequests($constraints,$column, $ascending)
{
    global $databaseManager;
    
    //get the service requests
    $array = $databaseManager->searchAllServiceRequestsWithConstraints($constraints,$column, $ascending);
        
    //convert the associative array to a non associative array
    $return = array_values($array);

    return json_encode($return);
}