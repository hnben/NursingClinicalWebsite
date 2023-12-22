<?php
//empty string if cookie name has no value
session_start();

$rememberedName = $_COOKIE['nameCookie'] ?? '';
$rememberedEmail = $_COOKIE['emailCookie'] ?? '';
$rememberedPhone = $_COOKIE['phoneCookie'] ?? '';
$rememberedProgram = $_COOKIE['programCookie'] ?? '';
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Form</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="dark-light-mode.js"></script>
    <!--    <script src="form-validation.js"></script>-->
</head>

<body <?php echo isset($_COOKIE['darkMode']) && $_COOKIE['darkMode'] === 'on' ? 'data-bs-theme="dark"' : 'data-bs-theme="light"'; ?>>


<!--Navigation Bar -->
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
<h1 style = "text-align: center">Contact Form</h1> <br>

<div id="contactForm" class="container">
    <form method = "POST" action = "email.php">
        <div class="mb-3">
            <label for="inputName" class="form-label"><h6>Your Name <span class="P2_star">*</span></h6></label>
            <input type="text" class="form-control" id="inputName" name="name" value="<?php echo $_COOKIE['nameCookie']; ?>"
                   minlength="4" maxlength="100"
                   placeholder="Jane Doe" required>
        </div>

        <div class="mb-3">
            <label for="inputEmail" class="form-label"><h6>Your E-mail <span class="P2_star">*</span></h6></label>
            <input type="email" class="form-control" id="inputEmail" name = "email" value = "<?php echo $_COOKIE['emailCookie']; ?>"
                   minlength="3" maxlength="320"
                   placeholder="someone@email.com" required>
        </div>

        <div class="mb-3">
            <label for="inputPhone" class="form-label"><h6>Your Phone Number</h6></label>
            <input type="tel" class="form-control" id="inputPhone" name= "phone" value = "<?php echo $_COOKIE['phoneCookie']; ?>"
                   pattern="[0-9]{10}">
        </div>

        <div class="mb-3">
            <label for="programName" class="form-label"><h6>Program Name</h6></label>
            <input type="text" class="form-control" id="programName" name="program" value="">
        </div><br>

        <div class="mb-3">
            <label for="inputMessage" class="form-label"><h6>Write Us A Message <span class="P2_star">*</span></h6></label>
            <textarea class="form-control" id="inputMessage" rows="3" name = "message"
                      placeholder="2000 character limit" minlength="10" maxlength="2000" required></textarea>
        </div>

        <br>
        <!--        Button-->
        <div class = "container" style="padding-bottom: 10%; padding-left: 0">
            <button  type="submit" class="btn btn-dark ml-auto">Submit</button>
        </div>

    </form>
</div>


<!--        Footer-->
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

