<?php
session_start();

$userEmail = $_GET['email'];
$userToken = $_GET['token'];
$userPass = $_GET['pass'];
$userPassMatch = $_GET['passMatch'];
$newName = $_POST['newName'];
$currentName = $_POST['currentName'];

$dataUser = null;
$dataToken = null;

function randomToken (): String
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';

    for ($i = 0; $i < 5; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $randomString;
}

if (isset($userEmail)){
    require '/home/badgergr/newdb.php';
    $sql = "SELECT * FROM Login";
    $result = @mysqli_query($cnxn, $sql);

    if (!$cnxn) {
        die("Error Connecting to DB: " . mysqli_connect_error());
    }

    while ($row = mysqli_fetch_assoc($result)) {
        $dataUser = $row['Email'];

        if ($userEmail == $dataUser) {
            $_SESSION['email'] = $dataUser;

            $to = $userEmail;

            $subject = "Password Recovery Token";
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= "From: badgerTeam@greenriver.edu ";
            $token = randomToken();

            $sql = "INSERT INTO `Token`(`Token`) VALUES ('$token')";
            @mysqli_query($cnxn, $sql);

            $message = "
    <html lang='en'>
    <head>
    <style>
    
    h1 {
    text-align: center;
    font-family: Arial, sans-serif;
    background: #45A049;
    border-radius: 2px;
    padding: 4px;
    }
    
    p {
    font-family: Arial, sans-serif;
    font-size: 16px;
    margin: 1rem 2rem;
    
    }
    
    </style>
    <title>Recovery </title>
    </head>
    <body>
    <h1>Token for password recovery</h1>
    <p>
    Your password recovery token is: $token
    </p>
    </body>
";

            mail($to, $subject, $message, $headers);
            break;
        }
    }
    if ($userEmail != $dataUser){
        header("Location: https://badger.greenriverdev.com/Sprint5/recover.php?msg= no email found in database");
    }
    else{
        header("Location: https://badger.greenriverdev.com/Sprint5/token.php");
    }


}
else if (isset($userToken) AND isset($_SESSION['email'])){

    require '/home/badgergr/newdb.php';
    $sql = "SELECT * FROM Token";
    $result = @mysqli_query($cnxn, $sql);

    if (!$cnxn) {
        die("Error Connecting to DB: " . mysqli_connect_error());
    }

    while ($row = mysqli_fetch_assoc($result)) {
        $dataToken = $row['Token'];

        if ($dataToken == $userToken){
            break;
        }
    }

    if ($userToken != $dataToken){
        header("Location: https://badger.greenriverdev.com/Sprint5/token.php?msg= try again, token are case sensitive");
    }
    else{
        require '/home/badgergr/newdb.php';
        $sql = "DELETE FROM Token;";
        @mysqli_query($cnxn, $sql);
        
        header("Location: https://badger.greenriverdev.com/Sprint5/updatedPassword.php");
    }


}
else if (isset($userPass) AND isset($userPassMatch) AND isset($_SESSION['email'])){
    if ($userPass != $userPassMatch){
        header("Location: https://badger.greenriverdev.com/Sprint5/updatedPassword.php?msg= passwords do not match");
    }
    else{
        $email = $_SESSION['email'];
        require '/home/badgergr/newdb.php';
        $sql = "UPDATE `Login` SET `Password`='$userPass' WHERE Email = '$email'";
        $result = @mysqli_query($cnxn, $sql);

        header("Location: https://badger.greenriverdev.com/Sprint5/login.php?msg= passwords updated");
    }

}