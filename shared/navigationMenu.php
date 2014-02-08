<?php
/*
 * PHP Pre-Process Information
 */
?>
<body>
    <div id="navigationMenu">
        <div id="navigationLocations">
            <div class="option button" onclick="document.location='/index.php'">
                Home
            </div>
            <div class="option button" onclick="document.location='/CustomerService/index.php'">
                Customer Service
            </div>
        </div>
        <div id="navigationTitle">
            <div class="option">
            Moore Studio School Division
            </div>
        </div>
        <div id="navigationSettings">
            <?php if(isset($user)): ?>
                <div class="option">
                    Welcome, <?php echo $user->fname; ?>
                </div>
                <div class="option button" onclick="document.location='/index.php?action=processLogout';">
                    Logout
                </div>
            <?php else: ?>
                <form id="login" method="POST" action="?action=processLogin">
                    <div class="option">
                        <div class='row'>
                            <label for="UserName">UserName: </label>
                            <input type="text" id="UserName" name="UserName">
                        </div>
                        <div class='row'>
                            <label for="Password">Password: </label>
                            <input type="password" id="Password" name="Password">
                        </div>
                    </div>
                    <button class="option button" type="submit" id="submit">
                        Login
                    </button>
                </form>
            <?php endif; ?>
        </div>
    </div>

