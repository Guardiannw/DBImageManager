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
    
    //get the names and id's for the Schools
    $schoolNames = $databaseManager->getAllSchoolNames();
    
    //get the names and id's for all Users
    $userNames = $databaseManager->getAllUserNames(User::kGETFULLNAME);
        
    //convert the associative array to a non associative array
    $return = array_values($array);
    
    //format the time for the requests
    formatTimeArray($return, array(ServiceRequest::$creationdate, ServiceRequest::$completeddate), ServiceRequest::DEFAULTTIMEFORMAT);

    //format the SchoolID's with the school names
    foreach($return as $key=>$request)
    {
        //re-assign the schoolid field
        //create a simple link to the schoolid
        $sid = $request[ServiceRequest::$schoolid];

        //assign the school name to the schoolid field
        $return[$key][ServiceRequest::$schoolid] = $schoolNames[(int)$sid];
        unset($sid);

        //re-assign the receiverID field
        //create a simple link to the schoolid
        //$sid = $request[ServiceRequest::$rid];

        //assign the user name to the receiverid field
        //$return[$key][ServiceRequest::$rid] = implode(" ",$userNames[(int)$sid]);
        //unset($sid);

        //re-assign the assigneeID field
        ////create a simple link to the schoolid
        $sid = $request[ServiceRequest::$aid];

        //assign the user name to the asigneeid field
        $return[$key][ServiceRequest::$aid] = implode(" ",$userNames[(int)$sid]);
        unset($sid);
    }
    
    return json_encode($return);
}

function searchAndSortAllServiceRequests($constraints,$column, $ascending)
{
    global $databaseManager;
    
    //get the service requests
    $array = $databaseManager->searchAllServiceRequestsWithColumns($constraints,ServiceRequest::getViewColumns(),$column, $ascending);
    
    //get the names and id's for the Schools
    $schoolNames = $databaseManager->getAllSchoolNames();
    
    //get the names and id's for all Users
    $userNames = $databaseManager->getAllUserNames(User::kGETFULLNAME);
        
    //convert the associative array to a non associative array
    $return = array_values($array);
    
    //format the time for the requests
    formatTimeArray($return, array(ServiceRequest::$creationdate, ServiceRequest::$completeddate), ServiceRequest::DEFAULTTIMEFORMAT);

    //format the SchoolID's with the school names
    foreach($return as $key=>$request)
    {
        //re-assign the schoolid field
        //create a simple link to the schoolid
        $sid = $request[ServiceRequest::$schoolid];

        //assign the school name to the schoolid field
        $return[$key][ServiceRequest::$schoolid] = $schoolNames[(int)$sid];
        unset($sid);

        //re-assign the receiverID field
        //create a simple link to the schoolid
        //$sid = $request[ServiceRequest::$rid];

        //assign the user name to the receiverid field
        //$return[$key][ServiceRequest::$rid] = implode(" ",$userNames[(int)$sid]);
        //unset($sid);

        //re-assign the assigneeID field
        ////create a simple link to the schoolid
        $sid = $request[ServiceRequest::$aid];

        //assign the user name to the asigneeid field
        $return[$key][ServiceRequest::$aid] = implode(" ",$userNames[(int)$sid]);
        unset($sid);
    }
    return json_encode($return);
}