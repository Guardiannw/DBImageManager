<?php

//set up error reporting for debugging
error_reporting(E_ALL);

//include the functions file for all of the functions of the program
require_once('shared/functions.php');

//start the session for window tracking
session_start(); //must be called before any html is sent

//figure out where to redirect the page
if(isset($_GET['window']))
{
    $window = $_GET['window'];
}
else
{
    $window = null;
}

switch($window)
{
    case 'ImageManager':
        header('Location: ImageManager/index.php');
        break;
    case 'CustomerService':
        header('Location: CustomerService/index.php');
        break;
    default://if the window has not been selected, then simply draw the main menu
        include_once('shared/header.php'); //draw the header for all pages
        include_once('mainMenu.php'); //draw the main menu
        include_once('shared/footer.php');//draw the footer
}




?>

        