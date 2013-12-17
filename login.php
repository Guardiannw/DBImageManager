<?php
/*
 * PHP Pre-Process Information
 */
?>
<!DOCTYPE html>
<html>
    <head>
        <title>
            Login: Moore Studio School Division
        </title>
    </head>
    <body>
        <div id='loginBox'>
            <form id="login" method="POST" action="?action=processLogin">
                <div class='row'>
                    <label for="Email">Email: </label>
                    <input type="text" id="Email" name="Email">
                </div>
                <div class='row'>
                    <label for="Password">Password: </label>
                    <input type="password" id="Password" name="Password">
                </div>
                    <input type="submit" id="submit" value="Log In">
            </form>
        </div>
    </body>
</html>