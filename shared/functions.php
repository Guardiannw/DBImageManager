<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/*
 * GLOBALS:
 * Contain the global variables for use in the program.
 */
$fileGroup = "webServer"; //the default group for all files on the server
$filePermissions = 0664;

/**
 * Sets the default permissions and information for the file
 * 
 * @param {File} $fileName
 * return {Boolean} True on success, False on failure
 */
function setFileDefaults($fileName)
{
    try
    {
        //lastly, change the owning group of the file to the default group
       global $fileGroup, $filePermissions;
       chgrp($fileName, $fileGroup); //set the group
       chmod($fileName, $filePermissions);//set the default file permissions
       return True;
    }
    catch(Exception $e)
    {
        return False;
    }
}
/**
 * getImageTimestamps
 * 
 * Returns an assoc array where the $key is the image name and the $value is the
 * timestamp.
 * 
 * @param $directory The directory which contains all of the files
 * @param $makecsv Optional: true if desire to output to a csv file
 * @param $fileName Optiona: if $makecsv is true, then default is imgTimestamps.csv
 */
function getImageTimestamps($directory, $makecsv = false, $fileName = 'imgTimestamps.csv')
{
    $contents = scandir($directory);
    $return = array();
    
    
    //use fnmatch to return only the jpg files in the directory
    foreach($contents as $file)
    {
        //only set the jpg images because only tiff and jpg images have exif timestamps
        if (fnmatch("*.jpg", $file, FNM_CASEFOLD)) {
            $return[$file] = NULL; // just so that the keys are set
        }
    }
    
    //now that we have all the pictures, get their timestamps
    foreach($return as $key=>&$value) //pass by reference so that the assignment works
    {
        $ts = exif_read_data($directory.$key, 'FILE');
        $value = $ts['FileDateTime'];
    }
    
    //make the csv if selected
    if($makecsv)
    {
        $handle = fopen($fileName, 'w+');
        //set csv headers
        $csvData = "\"FileName\",\"Timestamp\"\n";
        foreach($return as $key=>$value)
        {
            $csvData .= "\"$key\",\"$value\"\n";
        }
        fwrite($handle, $csvData);
        fclose($handle);
        
        //set the file defaults
        setFileDefaults($fileName);
    }
    
    return $return;
}

/**
 * Merges the client and image timestamp data csv's to create
 * 1 csv file if desired ($makecsv).
 * 
 * Returns an associative array containing the clientID as 'ID' and the imageFileName as 'FileName'.
 * 
 * @param {Path} $clientCSV The path and filename of the client csv data.
 * @param {Path} $imageCSV
 * @param {Boolean} $makecsv
 * @param {Boolean} $containHeaders
 * @param {String} $saveFileName
 */
function mergeClientImageData($clientCSV, $imageCSV, $makecsv = false, $containHeaders = true, $saveFileName = "ImageData.csv")
{
    //Initialization
    $clientHandle = fopen($clientCSV, 'r');
    $imageHandle = fopen($imageCSV, 'r');
    
    //initialize the imported arrays 
    $clientFileArray = null;
    $imageFileArray = null;
    
    if($containHeaders)
    {
        $clientHeaders = fgetcsv($clientHandle);
        $imageHeaders = fgetcsv($imageHandle);
        $timestampHeader = "Timestamp";
        $imageNameHeader = "FileName";
        $clientIDHeader = "ID";
        
        //initialize the clientIndexes for referencing
        foreach($clientHeaders as $key=>$value)
        {
            switch($value)
            {
                case $timestampHeader:
                    $clientIndexes[$timestampHeader] = $key;
                    break;
                case $clientIDHeader:
                    $clientIndexes[$clientIDHeader] = $key;
                    break;
                default:
                    break;
            }
        }
        
        //initialize the imageIndexes for referencing
        foreach($imageHeaders as $key=>$value)
        {
            switch($value)
            {
                case $timestampHeader:
                    $imageIndexes[$timestampHeader] = $key;
                    break;
                case $imageNameHeader:
                    $imageIndexes[$imageNameHeader] = $key;
                    break;
                default:
                    break;
            }
        }
    }
    else
    {
        /*
         * If no headers are provided, the the layout must be 
         * |ClientID,Timestamp|
         * 
         * and
         * 
         * |ImageName,Timestamp|
         */
        $clientIndexes[$timestampHeader] = 1;
        $clientIndexes[$clientIDHeader] = 0;
        $imageIndexes[$timestampHeader] = 1;
        $imageIndexes[$imageNameHeader] = 0;
    }
    
    //read in the entire clientCSV
    for($i = 0; !feof($clientHandle);$i++)
    {
        $lineArray = fgetcsv($clientHandle);
        if($lineArray)
        {
            $clientFileArray[$i][$timestampHeader] = $lineArray[$clientIndexes[$timestampHeader]];
            $clientFileArray[$i][$clientIDHeader] = $lineArray[$clientIndexes[$clientIDHeader]];
        }
    }
    //read in the entire imageCSV
    for($i = 0; !feof($imageHandle);$i++)
    {
        $lineArray = fgetcsv($imageHandle);
        if($lineArray)
        {
            $imageFileArray[$i][$timestampHeader] = $lineArray[$imageIndexes[$timestampHeader]];
            $imageFileArray[$i][$imageNameHeader] = $lineArray[$imageIndexes[$imageNameHeader]];
        }
    }
    
    //sort the arrays by the timestamps
    $timestamps = array(); // for sort order
    
    //sort the client array
    foreach($clientFileArray as $key=>$value)
    {
        $timestamps[] = $value[$timestampHeader];
    }
    array_multisort($timestamps, SORT_DESC, $clientFileArray);
    
    //reset the timestamps array
    unset($timestamps);
    $timestamps = array(); 
    //sort the image array
    foreach($imageFileArray as $key=>$value)
    {
        $timestamps[] = $value[$timestampHeader];
    }
    array_multisort($timestamps,SORT_DESC, $imageFileArray);
    
    //pair the clients up with the images
    $returnArray = array();
    foreach($clientFileArray as $client)
    {
        foreach($imageFileArray as $key=>$image)
        {
            if($image[$timestampHeader] > $client[$timestampHeader])
            {
                $temp[$clientIDHeader] = $client[$clientIDHeader];
                $temp[$imageNameHeader] = $image[$imageNameHeader];
                $returnArray[] = $temp;
                unset($imageFileArray[$key]);
                unset($temp);
            }
            else
            {
                break;
            }
        }
    }
    
    //if $makecsv is true then make the csv file
    $csv; //declare the $csv content variable
    if($makecsv)
    {
        //add the headers first
        $csv = "\"$clientIDHeader\",\"$imageNameHeader\"\n";
        foreach($returnArray as $line)
        {
            $csv .= "$line[$clientIDHeader],\"$line[$imageNameHeader]\"\n";
        }
        
        //print the csv to the file
        file_put_contents($saveFileName, $csv);
        //set the file defaults
        setFileDefaults($saveFileName);
    }
    return $returnArray;
    
}

/**
 * Takes in a time and format string and converts it to specified format
 * @param date or time $time
 * @param DateTimeFormat $formatString
 * @return formattedTime
 */
function formatTime($time, $formatString)
{
    //if the time is not null
    if($time !== "NULL" && isset($time))
    {
        $timestamp = strtotime($time);
        return date($formatString, $timestamp);
    }
    else
    {
        return "N/A";
    }
}

/**
 * Changes the format of the date and times within input array to the 
 * specified format string.
 * 
 * Returns false on failure, returns true otherwise;
 * 
 * @param timearray &$array
 * @param columnsToFormat $colKeys
 * @param DateTimeFormat $formatString
 */
function formatTimeArray(&$array,$colKeys, $formatString)
{
    try{
        foreach($colKeys as $key)
        {
            foreach($array as &$row)
            {
                $row[$key] = formatTime($row[$key], $formatString);
            }
        }
    }
    catch(Exception $e)
    {
        return False;
    }
    return True;
}
?>