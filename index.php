<?php

//set up error reporting for debugging
mysqli_report(MYSQLI_REPORT_ERROR);

//include necessary files
require_once('shared/functions.php');
require_once('shared/User.php');

//include the datamanager and connection to database.
require_once('connect.php');


session_start(); //must be called before any html is sent on every page that needs it


//determine window location
if(isset($_GET['action']))
{
    $action = $_GET['action'];
}
else
{
    $action = null;
}

//if the user is not logged in, then make the user log in, otherwise continue as normal
if(!isset($_SESSION['User']) && !in_array($action,array("Login","processLogin","processLogout","Logout")))
{
    header("Location: ?action=Login"); // redirect to login page
    $action = "Login";//change the action to login
}

//for data and redirection
switch($action)
{
    case 'ImageManager':
        header('Location: ImageManager/index.php');
        break;
    case 'CustomerService':
        header('Location: CustomerService/index.php');
        break;
    case 'MainMenu':
        break;
    case 'processLogin':
        
        $loginInfo = $_POST; //pass in the login information
        $session = &$_SESSION; // pass the session variable along
        require_once('processLogin.php');
        
        //redirect back here after login completion
        header("Location: .");
        break;
    case 'processLogout':
        require_once('processLogout.php');//logout
        
        //redirect back here after login completion, redirect to logout page
        header("Location: ?action=Logout");
        break;
    default:
        break;
}

//for drawing windows
include_once('shared/header.php'); //draw the header for all pages

switch($action)
{
    case 'MainMenu':
        include_once('mainMenu.php'); //draw the main menu
        break;
    case 'Login':
        include_once('login.php'); //for the user to log in at the beginning of the session.
        break;
    case 'Logout':
        include_once('logout.php'); //to inform the user that they have successfully logged out
        break;
    default://if the window has not been selected and user is logged in, draw mainMenu
        include_once('mainMenu.php'); //draw the main menu
        
}

include_once('shared/footer.php');//draw the footer


?>

        