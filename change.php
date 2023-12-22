<?php
require '/home/badgergr/newdb.php';
$id = $_GET["id"];

if (isset($_POST["submit"])){

    $title = $_POST['title'];
    $subHeadingOne = $_POST['subHeadingOne'];
    $subHeadingTwo = $_POST['subHeadingTwo'];
    $bulletSubOne = $_POST['bulletPointOne'];
    $bulletSubTwo = $_POST['bulletPointTwo'];
    $bulletSubThree = $_POST['bulletPointThree'];
    $bulletSubFour = $_POST['bulletPointFour'];
    $bulletSubFive = $_POST['bulletPointFive'];
    $bulletSubSix = $_POST['bulletPointSix'];


    $sql = "UPDATE Requirement SET `Title`='$title',`SubheadingOne`='$subHeadingOne',`SubheadingTwo`='$subHeadingTwo',`BulletSubOne`='$bulletSubOne' ,`BulletSubTwo`='$bulletSubTwo' ,`BulletSubThree`='$bulletSubThree' ,`BulletSubFour`='$bulletSubFour' ,`BulletSubFive`='$bulletSubFive' ,`BulletSubSix`='$bulletSubSix' WHERE id = $id";
    $result = @mysqli_query($cnxn, $sql);

    if ($result) {
        header("Location: https://badger.greenriverdev.com/Sprint5/edit.php?msg=Data updated successfully");
    } else {
        echo "Failed: " . mysqli_error($cnxn);
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"></script>
    <meta charset="UTF-8">
    <script src="dark-light-mode.js"></script>
    <title>Add Requirements</title>
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

<div class = "container">
    <div class = "text-center mb-4">
        <h2> Editing Requirements</h2>
        <p class = "text-muted"> Click update after changing any information</p>
    </div>
    <?php
    $sql = "SELECT * FROM Requirement WHERE id = $id LIMIT 1";
    $result = mysqli_query($cnxn, $sql);
    $row = mysqli_fetch_assoc($result);
    ?>

    <div class = "container d-flex justify-content-center">
        <form action="" method="POST" >
            <div class = "row">
                <div class = "col-12">
                    <label class = "form-label" for="title"> Title* </label>
                    <input type="text" class = "form-control" name="title" placeholder="Vaccine" id = "title" value="<?php echo $row['Title'] ?>" required>
                </div>
            </div>

            <div class = "row">
                <div class = "col-6">
                    <label class = "form-label" for="subheadingOne"> Section 1 </label>
                    <input type="text" class = "form-control" name="subHeadingOne" placeholder="Titler" id="subheadingOne" value="<?php echo $row['SubheadingOne'] ?>">
                </div>
                <div class = "col-6">
                    <label class = "form-label" for="subheadingTwo"> Section 2 </label>
                    <input type="text" class = "form-control" name="subHeadingTwo" placeholder="Declination Form" id="subheadingTwo" value="<?php echo $row['SubheadingTwo'] ?>">
                </div>

                <br>

                <div class="col-12">
                    <p class = "text-center"> Bullet Points</p>
                </div>
            </div>

            <div class = "row">
                <div class = "col-6">
                    <label class = "form-label" for="bulletPointOne">  </label> <br>
                    <textarea name="bulletPointOne" placeholder="bullet point text" cols="50" rows="2" id ="bulletPointOne" class = "form-control" required ><?php echo $row['BulletSubOne'] ?></textarea>
                </div>
                <div class = "col-6">
                    <label class = "form-label" for="bulletPointFour">  </label> <br>
                    <textarea name="bulletPointFour" placeholder="bullet point text" cols="50" rows="2" id ="bulletPointFour" class = "form-control"><?php echo $row['BulletSubFour'] ?></textarea>
                </div>
            </div>

            <div class = "row">
                <br>
                <div class = "col-6">
                    <label class = "form-label" for="bulletPointTwo">  </label> <br>
                    <textarea name="bulletPointTwo" placeholder="bullet point text" cols="50" rows="2" id ="bulletPointTwo" class = "form-control"><?php echo $row['BulletSubTwo'] ?></textarea>
                </div>
                <div class = "col-6">
                    <label class = "form-label" for="bulletPointFive">  </label> <br>
                    <textarea name="bulletPointFive" placeholder="bullet point text" cols="50" rows="2" id ="bulletPointFive" class = "form-control"><?php echo $row['BulletSubFive'] ?></textarea>
                </div>
            </div>

            <div class = "row">
                <br>
                <div class = "col-6">
                    <label class = "form-label" for="bulletPointThree"> </label> <br>
                    <textarea name="bulletPointThree" placeholder="bullet point text" cols="50" rows="2" id ="bulletPointThree" class = "form-control"><?php echo $row['BulletSubThree'] ?></textarea>
                </div>
                <div class = "col-6">
                    <label class = "form-label" for="bulletPointSix"> </label> <br>
                    <textarea name="bulletPointSix" placeholder="bullet point text" cols="50" rows="2" id ="bulletPointSix" class = "form-control"><?php echo $row['BulletSubSix'] ?></textarea>
                </div>
            </div>

            <br>

            <div class="row">
                <div class = "col-6 text-start">
                    <button type="submit" class="btn btn-success" name="submit" data-toggle="modal" data-target="#exampleModal"> Update </button>
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel"> Save New Requirements </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Changes were saved!
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal"> Close </button>
                                    <a href="https://badger.greenriverdev.com/Sprint5/requirements.php" class="btn btn-primary"> Requirements Page </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class = "col-6 text-end">
                    <a href="https://badger.greenriverdev.com/Sprint5/edit.php" class="btn btn-danger"> Cancel </a>
                </div>
            </div>
        </form>
    </div>
</div>

<footer class="footer bg-dark text-light">
    <div class="container">
        <p class = "text-center"> Green River Dev 2023 </p>
        <p class = "text-center">
            <?php
            if ($_SESSION['loggedIn']){
                echo '<a href="logout.php"> Logout </a>';
            }
            else{
                echo '<a href="login.php"> Login </a>';
            }
            ?>
        </p>
    </div>
</footer>
</body>
</html>