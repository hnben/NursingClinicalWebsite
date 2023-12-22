<?php
session_start();
$user = $_GET['user'];
$pass = $_GET['pass'];

require '/home/badgergr/newdb.php';
$sql = "SELECT * FROM Login";
$result = @mysqli_query($cnxn, $sql);

if (!$cnxn) {
    die("Error Connecting to DB: " . mysqli_connect_error());
}

while ($row = mysqli_fetch_assoc($result)) {
    $dataUser = $row['Email'];
    $dataPass = $row['Password'];

    if ($user == $dataUser AND $pass == $dataPass){
        $_SESSION['loggedIn'] = true;
        header("Location: https://badger.greenriverdev.com/Sprint5/edit.php");
        break;
    }
    else{
        header("Location: https://badger.greenriverdev.com/Sprint5/login.php?msg= incorrect email or password");
    }

}
?>