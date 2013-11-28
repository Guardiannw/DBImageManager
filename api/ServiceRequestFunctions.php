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
    $array = $databaseManager->getAllServiceRequests($column, $ascending);
    
    //convert the associative array to a non associative array
    $return = array_values($array);
    return json_encode($return);
}