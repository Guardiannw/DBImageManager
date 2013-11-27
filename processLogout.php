<?php

//try to log out
try{
    //simple logout function
    session_unset();
}
catch(Exception $e)
{
    echo $e->getMessage();
}