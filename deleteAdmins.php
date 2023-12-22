<?php
require '/home/badgergr/newdb.php';
$id = $_GET["id"];
$sql = "DELETE FROM `Login` WHERE ID = $id";
$result = @mysqli_query($cnxn, $sql);

if ($result) {
    header("Location: https://badger.greenriverdev.com/Sprint5/viewAdmins.php?msg=Admin deleted successfully");
} else {
    echo "Failed: " . mysqli_error($cnxn);
}