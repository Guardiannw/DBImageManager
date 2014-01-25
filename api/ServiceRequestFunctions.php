<?php

global $databaseManager;

/**
 * Returns a sorted list of all service requests in json format.
 * @param String $column
 * @param Boolean $ascending
 * @return JSON array of service requests in JSON format
 */
function sortAllServiceRequests($column, $ascending)
{
    global $databaseManager;
    
    //get the service requests
    $array = $databaseManager->getAllServiceRequestsWithColumns(ServiceRequest::getViewColumns(),$column, $ascending);
        
    //convert the associative array to a non associative array
    $return = array_values($array);
    
    return json_encode($return);
}

function searchAndSortAllServiceRequests($constraints,$column, $ascending)
{
    global $databaseManager;
    
    //get the service requests
    $array = $databaseManager->searchAllServiceRequestsWithColumns($constraints,$column, $ascending);
        
    //convert the associative array to a non associative array
    $return = array_values($array);

    return json_encode($return);
}