<?php
session_start();

if (!$_SESSION['loggedIn'] || !isset($_SESSION['loggedIn']) || $_SESSION['loggedIn' == null]){
    header("Location: https://badger.greenriverdev.com/Sprint5/login.php?msg= no access to this page, please log in first");
}

?>


<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html" lang="en">

<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="dark-light-mode.js"></script>
    <script src="autocomplete-library.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
          crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
            crossorigin="anonymous"></script>
    <title>Experience Form</title>
</head>
<body <?php echo isset($_COOKIE['darkMode']) && $_COOKIE['darkMode'] === 'on' ? 'data-bs-theme="dark"' : 'data-bs-theme="light"'; ?>>




<div id="navigation">
    <nav class="navbar navbar-expand navbar-light" id="navbarColor">
        <a class="navbar-brand" href="https://badger.greenriverdev.com/">
            <img src = "https://i.imgur.com/n4l8Bam.png" alt="Green River Nursing Logo" width = "80" class="d-inline-block align-text-top">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="requirements.php"><b class="nav_hover">Clinical Requirements</b><span class="sr-only"></span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="experience_form.php"><b class="nav_hover">Experience Form</b></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact_form.php"><b class="nav_hover">Contact Form</b></a>
                </li>

                <?php
                if ($_SESSION['loggedIn']) {
                    echo '
                <li class="nav-item active">
                    <a class="nav-link" href="edit.php"><b class="nav_hover">Edit Requirements</b><span class="sr-only"></span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="edit_site.php"><b class="nav_hover">Edit Clinical</b></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="viewentries.php"><b class="nav_hover">View Entries</b></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="viewAdmins.php"><b class="nav_hover">View Admins</b></a>
                </li>
                    ';
                }
                ?>
            </ul>
        </div>
        <div class="dark_mode">
            <button onclick = "darkDarkMode()" id="dark-mode-toggle" class="btn btn-dark ml-auto"> <i class="bi bi-cloud-moon-fill"></i> Dark Mode </button>
        </div>
    </nav>
</div>

<br>


<?php
require '/home/badgergr/newdb.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //  clinic name from the form
    $newName = $_POST['newName'];
    $currentName = $_POST['currentName'];


    $updateSql = "UPDATE Clinical SET Name = ? WHERE Name = ?";
    $stmt = mysqli_prepare($cnxn, $updateSql);
    mysqli_stmt_bind_param($stmt, "ss", $newName, $currentName);

    if (mysqli_stmt_execute($stmt)) {
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
      Updated Successfully
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    } else {
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
      Please try again, duplicate entry name
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    }

    mysqli_stmt_close($stmt);
}

// dropdown
$sql = "SELECT Name FROM Clinical ORDER BY Name ASC";
$result = mysqli_query($cnxn, $sql);

$data = array();

while ($row = mysqli_fetch_assoc($result)) {
    $data[] = array(
        'label' => $row["Name"],
        'value' => $row["ID"]
    );
}

mysqli_free_result($result);
mysqli_close($cnxn);

?>





<div class="container">


    <h1 style="text-align: center">Edit Clinic Names</h1><br>


    <form method="POST" action="">
        <div class="mb-3">
            <label for="currentName" class="form-label">Select Clinic to Edit:</label>
            <select class="form-select" id="currentName" name="currentName">

                <?php
                foreach ($data as $clinic) {
                    echo "<option value='{$clinic['label']}'>{$clinic['label']}</option>";
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="newName" class="form-label">Enter New Clinic Name:</label>
            <input type="text" class="form-control" id="newName" name="newName" required>
        </div>
        <button type="submit" class="btn btn-primary" style="background-color: #6c9574">Update Clinic Name</button>
    </form>

</div>
<footer class="footer bg-dark text-light py-1">
    <div class="container">
        <p class="text-center"> Green River Dev 2023 </p>
        <p class = "text-center">
            <?php
            if ($_SESSION['loggedIn']){
                echo '<a href="logout.php"> Logout </a>';
            }
            else {
                echo '<a href="login.php"> Login </a>';
            }
            ?>
        </p>
    </div>
</footer>

</body>

</html>
