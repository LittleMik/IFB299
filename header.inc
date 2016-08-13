<div class="header-external">
        <div class="header-internal">
            <a href="index.php" class="seperate logo">
                <img src="images/wifi-logo.jpg" alt="Company Logo" height="150">
            </a>

            <div class="container-left menu">
                <a href="index.php">Home</a><a href="">Contact</a><a href="">About</a>
                <div class="website-title">
                    WiFi Locator
                </div>
            </div>

            <div class="seperate register">
                <?php     
                    if (isset($_SESSION['isUser']))   {    
                        echo '<a href="logout.php?location=',urlencode($_SERVER['REQUEST_URI']),'">Logout</a> 
                        
                        | Hello ', $_SESSION['firstname'],'!';
                    } else {
                        echo '<a href="login.php?location=',urlencode($_SERVER['REQUEST_URI']),'">Login</a> | <a href="user-registration.php">Register</a>';
                    }
                ?> 
            </div>
        </div>
    </div>