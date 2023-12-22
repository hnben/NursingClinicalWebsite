<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <meta charset="UTF-8">
    <script>
        function collapseAll() {
            var accordionItems = document.querySelectorAll('.accordion-collapse');
            accordionItems.forEach(function (item) {
                var accordion = new bootstrap.Collapse(item, { toggle: false });
                accordion.hide();
            });
        }
    </script>
    <style>
        button.btn-primary {
            background-color: #d5e5cd !important;
            color: black;
        }
        [data-bs-theme=dark] button.btn.btn-primary{
            color: #dee2e6; /* Text color for the button during dark mode*/
            background: darkgreen !important;
        }
    </style>

    <script src="dark-light-mode.js"></script>
    <title>Requirements Page</title>
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
<div class="container">
    <h1 style='text-align: center'> Clinical Requirements</h1>
    <h5 style="text-align: center">All vaccination proof must include full name, date of birth, and date of vaccine, titer (blood draw), or test </h5>

        <div class='text-end'>
            <button class="btn btn-primary" onclick="collapseAll()">Collapse All</button>
        </div>
</div>
<div class="tabs">
    <div class="container">
        <div class="accordion">
            <div class="accordion-collapse" id="accordionRequirement">

                <?php
                require '/home/badgergr/newdb.php';
                $sql = "SELECT * FROM Requirement";
                $result = @mysqli_query($cnxn, $sql);

                if (!$cnxn) {
                    die("Error Connecting to DB: " . mysqli_connect_error());
                }

                while ($row = mysqli_fetch_assoc($result)) {
                    $title = $row['Title'];
                    $subHeadingOne = $row['SubheadingOne'];
                    $subHeadingTwo = $row['SubheadingTwo'];
                    $bulletSubOne = $row['BulletSubOne'];
                    $bulletSubTwo = $row['BulletSubTwo'];
                    $bulletSubThree = $row['BulletSubThree'];
                    $bulletSubFour = $row['BulletSubFour'];
                    $bulletSubFive = $row['BulletSubFive'];
                    $bulletSubSix = $row['BulletSubSix'];


                    if (isset($subHeadingOne) && isset($subHeadingTwo) && isNotEmpty($subHeadingOne) && isNotEmpty($subHeadingTwo)) {
                        createDoubleSubHeading($title, $subHeadingOne, $subHeadingTwo, $bulletSubOne, $bulletSubTwo, $bulletSubThree, $bulletSubFour, $bulletSubFive, $bulletSubSix);
                    } else {
                        createNoSubheading($title, $bulletSubOne, $bulletSubTwo, $bulletSubThree, $bulletSubFour, $bulletSubFive, $bulletSubSix);
                    }
                }

                function createDoubleSubHeading($title, $subHeadingOne, $subHeadingTwo, $bulletSubOne, $bulletSubTwo, $bulletSubThree, $bulletSubFour, $bulletSubFive, $bulletSubSix)
                {
                    $titleNoSpaces = str_replace(' ', '', $title);
                    echo '
    <div class="accordion-item" style="border-width: 0">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#' . $titleNoSpaces . '" aria-expanded="true" aria-controls="' . $titleNoSpaces . '" style="  border-radius: 10px; ">
                    <h5>' . $title . '</h5> 
                </button>
            </h2>
            <div id="' . $titleNoSpaces . '" class="accordion-collapse collapse">
                <div class="accordion-body">
                    <div class="container">
                        <div class="row">
                            <div class="card-group">
                                <div class="card" style="box-shadow: 0 0 5px #333333">
                                    <div class="card-body">
                                        <h5 class="card-title">' . $subHeadingOne . '</h5>
                                        <ul>
                                            ' . (isNotEmpty($bulletSubOne) ? createAccordionListItem($bulletSubOne) : '') . '
                                            ' . (isNotEmpty($bulletSubTwo) ? createAccordionListItem($bulletSubTwo) : '') . '
                                            ' . (isNotEmpty($bulletSubThree) ? createAccordionListItem($bulletSubThree) : '') . '
                                        </ul>
                                    </div>
                                </div>
                                <div class="or"><p>OR</p></div>
                                <div class="card" style="box-shadow: 0 0 5px #333333">
                                    <div class="card-body">
                                        <h5 class="card-title">' . $subHeadingTwo . '</h5>
                                        <ul>
                                            ' . (isNotEmpty($bulletSubFour) ? createAccordionListItem($bulletSubFour) : '') . '
                                            ' . (isNotEmpty($bulletSubFive) ? createAccordionListItem($bulletSubFive) : '') . '
                                            ' . (isNotEmpty($bulletSubSix) ? createAccordionListItem($bulletSubSix) : '') . '
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>';
                }

                function createNoSubheading($title, $bulletSubOne, $bulletSubTwo, $bulletSubThree, $bulletSubFour, $bulletSubFive, $bulletSubSix)
                {
                    $titleNoSpaces = str_replace(' ', '', $title);
                    echo '
        <div class="accordion-item" style="border-width: 0">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#' . $titleNoSpaces . '" aria-expanded="true" aria-controls="' . $titleNoSpaces . '" style="  border-radius: 10px; ">
                   <h5> ' . $title . '</5>
                </button>
            </h2>
            <div id="' . $titleNoSpaces . '" class="accordion-collapse collapse">
                <div class="accordion-body">
                    <div class="container">
                        <div class="row">
                            <div class="card-group">
                                <div class="card" style="box-shadow: 0 0 5px #333333">
                                    <div class="card-body">
                                        <ul>
                                            ' . (isNotEmpty($bulletSubOne) ? createAccordionListItem($bulletSubOne) : '') . '
                                            ' . (isNotEmpty($bulletSubTwo) ? createAccordionListItem($bulletSubTwo) : '') . '
                                            ' . (isNotEmpty($bulletSubThree) ? createAccordionListItem($bulletSubThree) : '') . '
                                            ' . (isNotEmpty($bulletSubFour) ? createAccordionListItem($bulletSubFour) : '') . '
                                            ' . (isNotEmpty($bulletSubFive) ? createAccordionListItem($bulletSubFive) : '') . '
                                            ' . (isNotEmpty($bulletSubSix) ? createAccordionListItem($bulletSubSix) : '') . '
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        ';
                }

                function createAccordionListItem($bullet): string{
                    return '
        <li>
            <p class="card-text">
                ' . $bullet . '
            </p>
        </li>';
                }

                function isNotEmpty($value): bool{
                    return isset($value) && $value !== '';
                }
                ?>
            </div>
        </div>
    </div>
</div>

<!--Footer-->
<footer class="footer bg-dark text-light py-1">
    <div class="container">
        <p class="text-center"> If you have any questions about the requirements, you can email me at csavage@greenriver.edu </p>
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
