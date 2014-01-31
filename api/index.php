<?php

//set up error reporting for debugging

//include the datamanager and connection to database.
require_once('connect.php');

//include necessary files
require_once('../shared/functions.php');
require_once('../shared/User.php');
require_once('ServiceRequestFunctions.php');

//determine window location
if(isset($_GET['action']))
{
    $action = $_GET['action'];
}
else
{
    $action = null;
}

//redirect the pages to the appropriate functions
switch($action)
{
    case 'searchAndSortAllServiceRequests':
        //get the variables for sorting
        $constraints = isset($_GET["constraints"]) ? $_GET["constraints"] : null;
        $column = $_GET["column"];
        $ascending = $_GET["ascending"];
        $ascending = strtolower($ascending) == 'false' ? false : true;//convert it to a boolean
        echo searchAndSortAllServiceRequests($constraints, $column, $ascending);
        break;
    case 'sortAllServiceRequests':
        //get the variables for sorting
        $column = $_GET["column"];
        $ascending = $_GET["ascending"];
        $ascending = strtolower($ascending) == 'false' ? false : true;//convert it to a boolean
        echo sortAllServiceRequests($column, $ascending);
        break;
    default:
        break;
}
?>

        