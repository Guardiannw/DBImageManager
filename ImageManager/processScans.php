<?php
require_once('../shared/functions.php');
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//get the current id's and times
$ids = $_POST['id'];
$timestamps = $_POST['ts'];
$actionName = $_POST['action'];
$action = 1;
switch($actionName)
{
    case 'submit':
        $action = 0;
        break;
    case 'download':
    default:
        $action = 1;
}

//now, make them into a csv file and store them in the ./tmp directory
$csv = "\"ID\",\"Timestamp\"\n"; // make the headers
foreach($ids as $key=>$value)
{
    $csv .= "\"$value\",\"$timestamps[$key]\"\n"; //format = "23451","234125"\n
}

if($action == 1)// if it is for a download
{
    header('Content-type: text/csv');
    //get current Date and time to get filename
    $filename = 'timeStampData'.date('m-d-y').'.csv';

    //tell the browser what we are sending and what it will be called
    header("Content-Disposition: attachment; filename=$filename");

    //read out the values
    echo $csv;
}
else if($action == 0)
{
    $filename = 'timeStampData'.date('m-d-y-G-i-s').'.csv';
    
    //if there is no directory, then make the directory
    $dir = 'tmp';//need to change this to get the dir of the job
    if(!is_dir($dir))
    {
        mkdir($dir);
    }
    echo $filename;
    file_put_contents($filename, $csv);
    
    //lastly, set defaults for the file
    setFileDefaults($filename);
    
}
//return to the main menu