<?php
//Check to see if the user is not logged in, if they are not, then redirect them to the login
//screen.
if(!isset($_SESSION['User']))
{
    //redirect to login page
    header("Location: /index.php");
}
