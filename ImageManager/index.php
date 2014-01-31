<?php

//set up error reporting for debugging

//connect to the database and create the $databaseManager object
require_once('connect.php');

//include the functions file for all of the functions of the program
require_once('../shared/functions.php');


session_start(); //must be called before any html is sent on every page that needs it

//check to make sure the user is logged in
require_once('../loginRedirect.php');

//figure out where to redirect the page
if(isset($_GET['window']))
{
    $window = $_GET['window'];
}
else
{
    $window = null;
}

//include the header
include_once('../shared/header.php'); //draw the header for all pages

//draw the content
switch($window)
{
    case 'dataView':
        include_once('dataView.php');
        break;
    case 'scanCards':
        include_once('scanCards.php'); //draw the main menu
        break;
    default://if the window has not been selected, then simply draw the main menu
        include_once('menu.php'); //draw the main menu
}

//draw the footer
include_once('../shared/footer.php');//draw the footer



?>