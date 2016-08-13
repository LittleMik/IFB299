<?php
    session_start();
    if(isset($_POST['login'])){
        $email = $_POST['yourEmail'];
        require 'verifyPassword.php';
        if (checkPassword($_POST['yourEmail'], $_POST['yourPassword'])){
            $_SESSION['isUser'] = true;

            //Get Firstname
            try{
                require 'pdo.inc';
                $getInfoQuery = $pdo->prepare('SELECT Firstname, UserID FROM members   
                                    WHERE Email = :email limit 1');
                $getInfoQuery->bindValue(':email',$_POST['yourEmail']);
                $getInfoQuery->execute();

                $userInfo = $getInfoQuery->fetch();
                $_SESSION['firstname'] = $userInfo['Firstname'];
                $_SESSION['userID'] = $userInfo['UserID'];
                header("Location: ".$_GET['location']);
                exit();
            } catch (PDOException $e){
                echo $e->getMessage(); 
            }
        }else{ 
            echo'
            <script>
                window.onload = function var1() {
                    document.getElementById(\'error\').innerHTML = \'Your username or password is incorrect!\';
                };
            </script>';
        }
    }
?>
<!DOCTYPE html>
<html>

<head>
    <title>Wifi Hotspots</title>
    
    <meta name="author" content="Greg Mills">
    <meta name="description" content="A collation of reviews about Wifi Hotspots">
    <meta name="keywords" content="Wifi Review, CAB230, Web Design">
    
    <link href="main.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
    <script type="text/javascript" src="code.js"></script>
</head>
    
<body>
<div class="wrapper">
    <?php include 'header.inc' ?>
    </div>
    <div class="content">
        <!--Signing Up Form-->
        <form class = "register-form center" action="login.php?location=<?php echo urlencode($_GET['location'])?>" method="post">
            <h1 class="align-text-center">Login</h1>
            <div id="error"></div>
            <input id ="email" class="text" placeholder="Email" value = "<?php echo (isset($email))?$email:'';?>" type="email" name="yourEmail" required>

            <input id ="password" class="text" placeholder="Password" type="password" name="yourPassword" required>
            <div class="register-button center">
                <button id="register-button-inner" name="login" href="#" class="button turquoise" type="submit"><span>&#10004</span>Submit</a>
            </div>
        </form>
    </div>
    <?php include 'footer.inc'?>
    
</div>
    
</body>

</html>