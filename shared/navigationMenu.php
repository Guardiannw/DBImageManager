<?php
/*
 * PHP Pre-Process Information
 */
?>
<body>
    <div id="navigationMenu">
        <div id="navigationLocations">
            <div class="option button" onclick="document.location='/index.php'">
                <h1>Home</h1>
            </div>
            <div class="dropdown">
                <div class="option">
                    <h1>Customer Service</h1>
                </div>
                <div class="menuitem button" onclick="document.location='/CustomerService/index.php?action=createRequest';">
                    <h1>Add New</h1>
                </div>
                <div class="menuitem button" onclick="document.location='/CustomerService/index.php?action=viewRequests';">
                    <h1>View Requests</h1>
                </div>
            </div>
        </div>
        <div id="navigationTitle">
            <div class="option">
                <h1>Moore Studio School Division</h1>
            </div>
        </div>
        <div id="navigationSettings">
            <?php if(isset($user)): ?>
                <div class="option">
                    <h1>Welcome, <?php echo $user->fname; ?></h1>
                </div>
                <div class="option button" onclick="document.location='/index.php?action=processLogout';">
                    <h1>Logout</h1>
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
                        <h1>Login</h1>
                    </button>
                </form>
            <?php endif; ?>
        </div>
    </div>

