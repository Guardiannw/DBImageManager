<?php

//global variables
global $loginInfo, $session, $databaseManager;

try
{
    //verify with database;
    $user = $databaseManager->getUserFromLogin($loginInfo['Email'], $loginInfo['Password']);
    
    //if it was not successful then throw an error
    if(empty($user))
    {
        throw new Exception("Invalid Username and Password");
    }
    //if successful, then create user and add the user to the session
    $userObject = User::fromArray($user);
    $session['User'] = $userObject;
}
catch(Exception $e)
{
    echo $e->getMessage();
}

