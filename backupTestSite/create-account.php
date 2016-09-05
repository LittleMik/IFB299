<?php
    require 'pdo.inc';
    /*Add User Entry into the members table*/
    try{
        $newUserQuery = $pdo->prepare('
        INSERT INTO members (Email, Firstname, Lastname, Password, Salt, Birthdate)
        VALUES (:email, :firstname, :lastname, SHA2(CONCAT(:password, :salt1), 0), :salt2, :birthdate)');
        //Convert form birthdate into sql format (yyyy-mm-dd).
        if (isset($_POST['birth-year']) && isset($_POST['birth-month']) && isset($_POST['birth-day'])){
            $SQLBirthDate = $_POST['birth-year'].'-'.sprintf("%02s", $_POST['birth-month']).'-'.sprintf("%02s", $_POST['birth-day']);
        }else{
            $SQLBirthDate = null;
        }
        
        //Generate a random salt.
        $salt = uniqid(mt_rand(), true);
        //Bind and execute all the values    
        $newUserQuery->execute(array(
            ':email' => $_POST['yourEmail'], 
            ':firstname' => $_POST['firstName'], 
            ':lastname' => $_POST['lastName'], 
            ':password' => $_POST['yourPassword'], 
            ':salt1' => $salt, 
            ':salt2' => $salt, 
            ':birthdate'=> $SQLBirthDate));
        /*login and send back to home page*/
        session_start();
        $_SESSION['isUser'] = true;
        $_SESSION['firstname'] = $_POST['firstName'];
        header("Location: index.php");
    }catch(PDOException $e){
        echo $e->getMessage(); 
    }
    

?>