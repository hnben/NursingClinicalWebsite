<?php
require '/home/badgergr/newdb.php';
$id = $_GET["id"];
$sql = "DELETE FROM `Requirement` WHERE ID = $id";
$result = @mysqli_query($cnxn, $sql);

if ($result) {
    header("Location: https://badger.greenriverdev.com/Sprint4/edit.php?msg=Data deleted successfully");
} else {
    echo "Failed: " . mysqli_error($cnxn);
}