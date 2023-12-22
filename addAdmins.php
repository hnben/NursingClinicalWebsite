<?php
session_start();

function randomToken (): String
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';

    for ($i = 0; $i < 5; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $randomString;
}

if (isset($_POST['submit'])){
    require '/home/badgergr/newdb.php';

    $email = $_POST['email'];
    $randPassword = randomToken();

    $sql = "INSERT INTO `Login`(`Email`, `Password`) VALUES ('$email','$randPassword')";
    $result = @mysqli_query($cnxn, $sql);

    if ($result) {
        $to = $email;
        $subject = "New Admin Login Information";
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: badgerTeam@greenriver.edu ";

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
    <title> New Admin </title>
    </head>
    <body>
    <h1>Admin Account Creation</h1>
    <p>
    This email address will be used for your login information. </p>
    <p>Temporary Password: $randPassword </p>
    <p>You can reset your pass using forget password in the login page.</p>
    </body>
";

        mail($to, $subject, $message, $headers);
        header("Location: https://badger.greenriverdev.com/Sprint5/viewAdmins.php?msg=Email sent to new admin");
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

<div class = "container">
    <div class = "text-center mb-4">
        <h2> Add new admins</h2>
        <p class = "text-muted"> Please enter the email address of the new admin</p>
    </div>

    <div class = "container d-flex justify-content-center">
        <form action="addAdmins.php" method="POST" >
            <div class = "row">
                <div class = "col-12">
                    <label class = "form-label" for="title"> E-mail Address </label>
                    <input type="text" class = "form-control" name="email" placeholder="someone@mail.com" id = "title" required>
                </div>
            </div>

            <div class="row">
                <div class = "col-6 text-start">
                    <button type="submit" class="btn btn-success" name="submit" data-toggle="modal" data-target="#exampleModal"> Send </button>

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
                                    <a href="viewAdmins.php" class="btn btn-primary"> View Admins </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class = "col-6 text-end">
                    <a href="viewAdmins.php" class="btn btn-danger"> Cancel </a>
                </div>
            </div>
        </form>
    </div>
</div>
</body>
</html>

