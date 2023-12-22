<?php
session_start();

if (!$_SESSION['loggedIn'] || !isset($_SESSION['loggedIn']) || $_SESSION['loggedIn' == null]){
    header("Location: https://badger.greenriverdev.com/Sprint5/login.php?msg= no access to this page, please log in first");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <meta charset="UTF-8">
    <script src="dark-light-mode.js"></script>
    <title>Edit Requirements</title>
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
<?php
if (isset($_GET["msg"])) {
    $msg = $_GET["msg"];
    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
      ' . $msg . '
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
}
?>

<a href="https://badger.greenriverdev.com/Sprint5/add.php" class = "btn btn-dark"> Add New Requirements</a>
<div class = "container-fluid" style="90%">
    <div class = "row">
        <div class = "col-12">
            <div class="table-responsive">
                <table class="table table-hover table-striped table-bordered text-start">

            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Title</th>
                <th scope="col">Subheading 1</th>
                <th scope="col">Subheading 2</th>
                <th scope="col">Bullet Point 1</th>
                <th scope="col">Bullet Point 2</th>
                <th scope="col">Bullet Point 3</th>
                <th scope="col">Bullet Point 4</th>
                <th scope="col">Bullet Point 5</th>
                <th scope="col">Bullet Point 6</th>
                <th scope="col">Action</th>
            </tr>
            </thead>

            <tbody>
                <?php
                require '/home/badgergr/newdb.php';
                $sql = "SELECT * FROM Requirement";
                $result = @mysqli_query($cnxn, $sql);

                if (!$cnxn) {
                    die("Error Connecting to DB: " . mysqli_connect_error());
                }

                while ($row = mysqli_fetch_assoc($result)) {
                ?>
                    
                    <tr>
                            <td><?php echo $row["ID"] ?></td>
                            <td><?php echo $row["Title"] ?></td>
                            <td><?php echo $row["SubheadingOne"] ?></td>
                            <td><?php echo $row["SubheadingTwo"] ?></td>
                            <td><?php echo $row["BulletSubOne"] ?></td>
                            <td><?php echo $row["BulletSubTwo"] ?></td>
                            <td><?php echo $row["BulletSubThree"] ?></td>
                            <td><?php echo $row["BulletSubFour"] ?></td>
                            <td><?php echo $row["BulletSubFive"] ?></td>
                            <td><?php echo $row["BulletSubSix"] ?></td>

                            <td>
                                <a href="https://badger.greenriverdev.com/Sprint5/change.php?id=<?php echo $row["ID"] ?>" class="btn btn-success"> Edit </a>
                                <a href="https://badger.greenriverdev.com/Sprint5/delete.php?id=<?php echo $row["ID"] ?>" class="btn btn-danger"> Delete </a>
                            </td>
                    </tr>

                <?php
                }
                ?>
                

                    </tbody>
                </table>
            </div>
        </div>
    </div>
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