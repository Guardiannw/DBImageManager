<?php
/*
 * PHP Pre-Process Information
 */
if(isset($_SESSION['User']))
{
    $user = $_SESSION['User'];
}
else
{
    $user = null;
}
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Moore Studio Image Framework</title>
        <link rel="stylesheet" href="/shared/main.css" type="text/css">
        <link rel="stylesheet" href="/shared/jqueryui/css/base/jquery-ui.css">
        <script src="/shared/functions.js" type="text/javascript"></script>
        <script src="/shared/jquery/jquery.js" type="text/javascript"></script>
        <script src="/shared/jqueryui/jquery-ui.js" type="text/javascript"></script>
        <script src="/shared/json3/json3.js" type="text/javascript"></script>
    </head>
<body>
    <div id="loginStatus">
        <?php if(isset($user)): ?>
        <h5>Welcome <?php echo $user->fname; ?>! <a href="/index.php?action=processLogout">Logout</a></h5>
        <?php endif; ?>
    </div>