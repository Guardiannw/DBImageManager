<?php

//set up error reporting for debugging
error_reporting(E_ALL);

//connect to the database and create the $databaseManager object
require_once('connect.php');

//include the functions file for all of the functions of the program
require_once('../shared/functions.php');


//include the necessary classes
require_once('../shared/ServiceRequest.php');
require_once('../shared/Client.php');
require_once('../shared/School.php');

//outside variables
global $databaseManager;

//Contact the model to get the appropriate information
if(isset($_GET['action']))
{
    $action = $_GET['action'];
}
else
{
    $action = null;
}

//configure all variables and calculations before locating to the page
switch($action)
{
    case 'viewRequests':
        //get all of the service requests in the database
        $requests = $databaseManager->getAllServiceRequests();
        $headers = $databaseManager->getTableHeaders(ServiceRequest::$table);
        //get the names and id's for the Schools
        $schoolNames = $databaseManager->getAllSchoolNames();
        break;
    case 'createRequest':
        //get the names and id's for the Schools
        $schoolNames = $databaseManager->getAllSchoolNames();
        break;
    case 'submitRequest':
        //initialize the service request
        $sr = $_POST;
        $serviceRequest = 
                new ServiceRequest
                        (0, 
                        $sr['ContactName'], 
                        $sr['ContactEmail'], 
                        $sr['ContactPhone'], 
                        $sr['ClientName'], 
                        $sr['SchoolID'], 
                        $sr['OrderType'], 
                        $sr['ContactType'], 
                        $sr['Issue'], 
                        $sr['Assignee'], 
                        $sr['Notes']);
        
        //submit the requst
        $databaseManager->addServiceRequest($serviceRequest);
        //redirect to the view screen
        header('Location:.?action=viewRequests');
        break;
    case 'editRequest':
        //get the id from the url
        $id = $_GET['id'];
        $request = $databaseManager->getServiceRequestWithID($id);
        //get the names and id's for the Schools
        $schoolNames = $databaseManager->getAllSchoolNames();
        break;
    case 'updateRequest':
        //initialize the service request
        $sr = $_POST;
        $serviceRequest = 
                new ServiceRequest
                        (0, 
                        $sr['ContactName'], 
                        $sr['ContactEmail'], 
                        $sr['ContactPhone'], 
                        $sr['ClientName'], 
                        $sr['SchoolID'], 
                        $sr['OrderType'], 
                        $sr['ContactType'], 
                        $sr['Issue'], 
                        $sr['Assignee'], 
                        $sr['Notes'],
                        $sr['Status'],
                        $sr['PercentComplete']);
        //set the id
        $serviceRequest->id = $sr['ID'];
        
        //update the request
        $databaseManager->updateServiceRequest($serviceRequest);
        //redirect to the view screen
        header('Location:.?action=viewRequests');
        break;
    default:
        //nothing
    }
//This is the View part of ModelViewController
//figure out where to redirect the page
//include the header
include_once('../shared/header.php'); //draw the header for all pages

switch($action)
{
    case 'viewRequests':
        include_once('viewRequests.php');
        break;
    case 'createRequest':
        include_once('CreateRequest.php'); //draw the main menu
        break;
    case 'editRequest':
        include_once('editRequest.php'); //draw the edit menu
        break;
    default://if the action has not been selected, then simply draw the main menu
        include_once('menu.php'); //draw the main menu
        
}

//draw the footer
include_once('../shared/footer.php');//draw the footer



?>