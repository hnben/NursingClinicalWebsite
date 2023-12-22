<?php 
session_start();
?>

<?php
require '/home/badgergr/newdb.php';

if (!$cnxn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "
    SELECT Name FROM Clinical 
    ORDER BY Name ASC
";

$result = mysqli_query($cnxn, $sql);

$data = array();

// Fetch associative array
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = array(
        'label' => $row["Name"],
        'value' => $row["Name"]
    );
}

mysqli_free_result($result);
mysqli_close($cnxn);

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html" lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="dark-light-mode.js"></script>
    <script src="autocomplete-library.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <title>Experience Form</title>
</head>

<body <?php echo isset($_COOKIE['darkMode']) && $_COOKIE['darkMode'] === 'on' ? 'data-bs-theme="dark"' : 'data-bs-theme="light"'; ?>>

<!--Navigation Bar-->
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
    <h1 style="text-align: center">Experience Form</h1><br>
    <h5> Please fill out the following form to rate your experience at the clinical you attended.
        Please be honest as we collect this data to ensure that we place our students in clinical settings that offer optimal learning environments and opportunities.</h5
        <br><br>
    <form method = "POST" action = "confirm.php">
        <div>
            <h6>1. What Clinical Site did you attend? <span class="P2_star">*</span> </h6>
            <label for="clinicName"></label><input type="text" class="form-control" name = "clinicName" id= "clinicName" required >

            <script>
                var auto_complete = new Autocomplete(document.getElementById('clinicName'), {
                    data:<?php echo json_encode($data); ?>,
                    maximumItems:10,
                    highlightTyped:true,
                    highlightClass : 'fw-bold text-primary'
                });
            </script>
        </div>

        <br><br>
        <div>
            <h6>2. I enjoyed my time at this clinical site <span class="P2_star">*</span></h6>
            <br>
            <div class="border">
                <div class=" d-flex ">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#69b444" class="bi bi-emoji-frown" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                        <path d="M4.285 12.433a.5.5 0 0 0 .683-.183A3.498 3.498 0 0 1 8 10.5c1.295 0 2.426.703 3.032 1.75a.5.5 0 0 0 .866-.5A4.498 4.498 0 0 0 8 9.5a4.5 4.5 0 0 0-3.898 2.25.5.5 0 0 0 .183.683zM7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5zm4 0c0 .828-.448 1.5-1 1.5s-1-.672-1-1.5S9.448 5 10 5s1 .672 1 1.5z"/>
                    </svg>
                    <label class="custom-container">
                        <input type="radio"  name="enjoyTime" value="1" required>
                        <span class="checkmark">1</span>
                    </label>

                    <label class="custom-container" >
                        <input type="radio"  name="enjoyTime"  value="2" required>
                        <span class="checkmark">2</span>
                    </label>

                    <label class="custom-container" >
                        <input type="radio" name="enjoyTime" value="3" required>
                        <span class="checkmark">3</span>
                    </label>

                    <label class="custom-container">
                        <input type="radio" name="enjoyTime"  value="4" required>
                        <span class="checkmark">4</span>
                    </label>

                    <label class="custom-container">
                        <input type="radio" name="enjoyTime"  value="5" required>
                        <span class="checkmark">5</span>
                    </label>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#69b444" class="bi bi-emoji-grin" viewBox="0 0 16 16">
                        <path d="M12.946 11.398A6.002 6.002 0 0 1 2.108 9.14c-.114-.595.426-1.068 1.028-.997C4.405 8.289 6.48 8.5 8 8.5s3.595-.21 4.864-.358c.602-.07 1.142.402 1.028.998a5.953 5.953 0 0 1-.946 2.258Zm-.078-2.25C11.588 9.295 9.539 9.5 8 9.5c-1.54 0-3.589-.205-4.868-.352.11.468.286.91.517 1.317A36.797 36.797 0 0 0 8 10.75a36.796 36.796 0 0 0 4.351-.285c.231-.407.407-.85.517-1.317Zm-1.36 2.416c-1.02.1-2.255.186-3.508.186-1.253 0-2.488-.086-3.507-.186A4.985 4.985 0 0 0 8 13a4.986 4.986 0 0 0 3.507-1.436ZM6.488 7c.114-.294.179-.636.179-1 0-1.105-.597-2-1.334-2C4.597 4 4 4.895 4 6c0 .364.065.706.178 1 .23-.598.662-1 1.155-1 .494 0 .925.402 1.155 1ZM12 6c0 .364-.065.706-.178 1-.23-.598-.662-1-1.155-1-.494 0-.925.402-1.155 1a2.793 2.793 0 0 1-.179-1c0-1.105.597-2 1.334-2C11.403 4 12 4.895 12 6Z"/>
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16Zm0-1A7 7 0 1 1 8 1a7 7 0 0 1 0 14Z"/>
                    </svg>
                </div>
            </div>
            <br><br>

            <h6>3. The clinical staff was supportive of my role <span class="P2_star">*</span></h6>
            <br>
            <div class="border">
                <div class=" d-flex ">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#69b444" class="bi bi-emoji-frown" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                        <path d="M4.285 12.433a.5.5 0 0 0 .683-.183A3.498 3.498 0 0 1 8 10.5c1.295 0 2.426.703 3.032 1.75a.5.5 0 0 0 .866-.5A4.498 4.498 0 0 0 8 9.5a4.5 4.5 0 0 0-3.898 2.25.5.5 0 0 0 .183.683zM7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5zm4 0c0 .828-.448 1.5-1 1.5s-1-.672-1-1.5S9.448 5 10 5s1 .672 1 1.5z"/>
                    </svg>
                    <label class="custom-container">
                        <input type="radio"  name="staffSupport"  value="1" required>
                        <span class="checkmark">1</span>
                    </label>

                    <label class="custom-container" >
                        <input type="radio"  name="staffSupport"  value="2" required>
                        <span class="checkmark">2</span>
                    </label>

                    <label class="custom-container" >
                        <input type="radio"  name="staffSupport"  value="3" required>
                        <span class="checkmark">3</span>
                    </label>

                    <label class="custom-container">
                        <input type="radio" name="staffSupport"  value="4" required>
                        <span class="checkmark">4</span>
                    </label>

                    <label class="custom-container">
                        <input type="radio" name="staffSupport"  value="5" required>
                        <span class="checkmark">5</span>
                    </label>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#69b444" class="bi bi-emoji-grin" viewBox="0 0 16 16">
                        <path d="M12.946 11.398A6.002 6.002 0 0 1 2.108 9.14c-.114-.595.426-1.068 1.028-.997C4.405 8.289 6.48 8.5 8 8.5s3.595-.21 4.864-.358c.602-.07 1.142.402 1.028.998a5.953 5.953 0 0 1-.946 2.258Zm-.078-2.25C11.588 9.295 9.539 9.5 8 9.5c-1.54 0-3.589-.205-4.868-.352.11.468.286.91.517 1.317A36.797 36.797 0 0 0 8 10.75a36.796 36.796 0 0 0 4.351-.285c.231-.407.407-.85.517-1.317Zm-1.36 2.416c-1.02.1-2.255.186-3.508.186-1.253 0-2.488-.086-3.507-.186A4.985 4.985 0 0 0 8 13a4.986 4.986 0 0 0 3.507-1.436ZM6.488 7c.114-.294.179-.636.179-1 0-1.105-.597-2-1.334-2C4.597 4 4 4.895 4 6c0 .364.065.706.178 1 .23-.598.662-1 1.155-1 .494 0 .925.402 1.155 1ZM12 6c0 .364-.065.706-.178 1-.23-.598-.662-1-1.155-1-.494 0-.925.402-1.155 1a2.793 2.793 0 0 1-.179-1c0-1.105.597-2 1.334-2C11.403 4 12 4.895 12 6Z"/>
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16Zm0-1A7 7 0 1 1 8 1a7 7 0 0 1 0 14Z"/>
                    </svg>
                </div>
            </div>
            <br><br>

            <h6>4. The site helped facilitate my learning objectives <span class="P2_star">*</span></h6>
            <br>
            <div class="border">
                <div class="d-flex">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#69b444" class="bi bi-emoji-frown" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                        <path d="M4.285 12.433a.5.5 0 0 0 .683-.183A3.498 3.498 0 0 1 8 10.5c1.295 0 2.426.703 3.032 1.75a.5.5 0 0 0 .866-.5A4.498 4.498 0 0 0 8 9.5a4.5 4.5 0 0 0-3.898 2.25.5.5 0 0 0 .183.683zM7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5zm4 0c0 .828-.448 1.5-1 1.5s-1-.672-1-1.5S9.448 5 10 5s1 .672 1 1.5z"/>
                    </svg>

                    <label class="custom-container">
                        <input type="radio"  name="siteFacilitation" value="1" required>
                        <span class="checkmark">1</span>
                    </label>

                    <label class="custom-container" >
                        <input type="radio"  name="siteFacilitation" value="2" required>
                        <span class="checkmark">2</span>
                    </label>

                    <label class="custom-container" >
                        <input type="radio"  name="siteFacilitation"  value="3" required>
                        <span class="checkmark">3</span>
                    </label>

                    <label class="custom-container">
                        <input type="radio" name="siteFacilitation"  value="4" required>
                        <span class="checkmark">4</span>
                    </label>

                    <label class="custom-container">
                        <input type="radio" name="siteFacilitation" value="5" required>
                        <span class="checkmark">5</span>
                    </label>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#69b444" class="bi bi-emoji-grin" viewBox="0 0 16 16">
                        <path d="M12.946 11.398A6.002 6.002 0 0 1 2.108 9.14c-.114-.595.426-1.068 1.028-.997C4.405 8.289 6.48 8.5 8 8.5s3.595-.21 4.864-.358c.602-.07 1.142.402 1.028.998a5.953 5.953 0 0 1-.946 2.258Zm-.078-2.25C11.588 9.295 9.539 9.5 8 9.5c-1.54 0-3.589-.205-4.868-.352.11.468.286.91.517 1.317A36.797 36.797 0 0 0 8 10.75a36.796 36.796 0 0 0 4.351-.285c.231-.407.407-.85.517-1.317Zm-1.36 2.416c-1.02.1-2.255.186-3.508.186-1.253 0-2.488-.086-3.507-.186A4.985 4.985 0 0 0 8 13a4.986 4.986 0 0 0 3.507-1.436ZM6.488 7c.114-.294.179-.636.179-1 0-1.105-.597-2-1.334-2C4.597 4 4 4.895 4 6c0 .364.065.706.178 1 .23-.598.662-1 1.155-1 .494 0 .925.402 1.155 1ZM12 6c0 .364-.065.706-.178 1-.23-.598-.662-1-1.155-1-.494 0-.925.402-1.155 1a2.793 2.793 0 0 1-.179-1c0-1.105.597-2 1.334-2C11.403 4 12 4.895 12 6Z"/>
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16Zm0-1A7 7 0 1 1 8 1a7 7 0 0 1 0 14Z"/>
                    </svg>
                </div>
            </div>
            <br><br>

            <h6>5. My preceptor helped facilitate my learning objectives <span class="P2_star">*</span> </h6>
            <br>
            <div class="border">
                <div class="d-flex">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#69b444" class="bi bi-emoji-frown" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                        <path d="M4.285 12.433a.5.5 0 0 0 .683-.183A3.498 3.498 0 0 1 8 10.5c1.295 0 2.426.703 3.032 1.75a.5.5 0 0 0 .866-.5A4.498 4.498 0 0 0 8 9.5a4.5 4.5 0 0 0-3.898 2.25.5.5 0 0 0 .183.683zM7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5zm4 0c0 .828-.448 1.5-1 1.5s-1-.672-1-1.5S9.448 5 10 5s1 .672 1 1.5z"/>
                    </svg>
                    <label class="custom-container" >
                        <input type="radio" name="preceptorFacilitation" value="1" required>
                        <span class="checkmark">1</span>
                    </label>

                    <label class="custom-container" >
                        <input type="radio" name="preceptorFacilitation" value="2" required>
                        <span class="checkmark">2</span>
                    </label>

                    <label class="custom-container" >
                        <input type="radio" name="preceptorFacilitation"  value="3" required>
                        <span class="checkmark">3</span>
                    </label>

                    <label class="custom-container">
                        <input type="radio" name="preceptorFacilitation" value="4" required>
                        <span class="checkmark">4</span>
                    </label>

                    <label class="custom-container" >
                        <input type="radio" name="preceptorFacilitation"  value="5" required>
                        <span class="checkmark">5</span>
                    </label>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#69b444" class="bi bi-emoji-grin" viewBox="0 0 16 16">
                        <path d="M12.946 11.398A6.002 6.002 0 0 1 2.108 9.14c-.114-.595.426-1.068 1.028-.997C4.405 8.289 6.48 8.5 8 8.5s3.595-.21 4.864-.358c.602-.07 1.142.402 1.028.998a5.953 5.953 0 0 1-.946 2.258Zm-.078-2.25C11.588 9.295 9.539 9.5 8 9.5c-1.54 0-3.589-.205-4.868-.352.11.468.286.91.517 1.317A36.797 36.797 0 0 0 8 10.75a36.796 36.796 0 0 0 4.351-.285c.231-.407.407-.85.517-1.317Zm-1.36 2.416c-1.02.1-2.255.186-3.508.186-1.253 0-2.488-.086-3.507-.186A4.985 4.985 0 0 0 8 13a4.986 4.986 0 0 0 3.507-1.436ZM6.488 7c.114-.294.179-.636.179-1 0-1.105-.597-2-1.334-2C4.597 4 4 4.895 4 6c0 .364.065.706.178 1 .23-.598.662-1 1.155-1 .494 0 .925.402 1.155 1ZM12 6c0 .364-.065.706-.178 1-.23-.598-.662-1-1.155-1-.494 0-.925.402-1.155 1a2.793 2.793 0 0 1-.179-1c0-1.105.597-2 1.334-2C11.403 4 12 4.895 12 6Z"/>
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16Zm0-1A7 7 0 1 1 8 1a7 7 0 0 1 0 14Z"/>
                    </svg>
                </div>
            </div>
            <br><br>

            <h6>6. I would recommend this site to another student <span class="P2_star">*</span></h6>
            <br>
            <div class="border">
                <div class="d-flex">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#69b444" class="bi bi-emoji-frown" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                        <path d="M4.285 12.433a.5.5 0 0 0 .683-.183A3.498 3.498 0 0 1 8 10.5c1.295 0 2.426.703 3.032 1.75a.5.5 0 0 0 .866-.5A4.498 4.498 0 0 0 8 9.5a4.5 4.5 0 0 0-3.898 2.25.5.5 0 0 0 .183.683zM7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5zm4 0c0 .828-.448 1.5-1 1.5s-1-.672-1-1.5S9.448 5 10 5s1 .672 1 1.5z"/>
                    </svg>

                    <label class="custom-container">
                        <input type="radio" name="recommendable" value="1" required>
                        <span class="checkmark">1</span>
                    </label>

                    <label class="custom-container" >
                        <input type="radio" name="recommendable" value="2" required>
                        <span class="checkmark">2</span>
                    </label>

                    <label class="custom-container" >
                        <input type="radio" name="recommendable" value="3" required>
                        <span class="checkmark">3</span>
                    </label>

                    <label class="custom-container">
                        <input type="radio" name="recommendable"  value="4" required>
                        <span class="checkmark">4</span>
                    </label>

                    <label class="custom-container">
                        <input type="radio" name="recommendable"  value="5" required>
                        <span class="checkmark">5</span>
                    </label>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#69b444" class="bi bi-emoji-grin" viewBox="0 0 16 16">
                        <path d="M12.946 11.398A6.002 6.002 0 0 1 2.108 9.14c-.114-.595.426-1.068 1.028-.997C4.405 8.289 6.48 8.5 8 8.5s3.595-.21 4.864-.358c.602-.07 1.142.402 1.028.998a5.953 5.953 0 0 1-.946 2.258Zm-.078-2.25C11.588 9.295 9.539 9.5 8 9.5c-1.54 0-3.589-.205-4.868-.352.11.468.286.91.517 1.317A36.797 36.797 0 0 0 8 10.75a36.796 36.796 0 0 0 4.351-.285c.231-.407.407-.85.517-1.317Zm-1.36 2.416c-1.02.1-2.255.186-3.508.186-1.253 0-2.488-.086-3.507-.186A4.985 4.985 0 0 0 8 13a4.986 4.986 0 0 0 3.507-1.436ZM6.488 7c.114-.294.179-.636.179-1 0-1.105-.597-2-1.334-2C4.597 4 4 4.895 4 6c0 .364.065.706.178 1 .23-.598.662-1 1.155-1 .494 0 .925.402 1.155 1ZM12 6c0 .364-.065.706-.178 1-.23-.598-.662-1-1.155-1-.494 0-.925.402-1.155 1a2.793 2.793 0 0 1-.179-1c0-1.105.597-2 1.334-2C11.403 4 12 4.895 12 6Z"/>
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16Zm0-1A7 7 0 1 1 8 1a7 7 0 0 1 0 14Z"/>
                    </svg>
                </div>
            </div>
        </div>
        <br><br>

        <label class="label">
            <h6>7. (Optional) Add any comments you would like to leave about the site or staff at this facility.</h6>

            <input type="text" class="form-control" name="commentStaffSite" value = "">
        </label>

        <br><br>
        <label>
            <h6>8. (Optional) Add any comments you would like to leave about your clinical instructor. <br>
                We will be using this information to better understand our instructors where they might need improvement,
                or when they are going above and beyond.<br>
                This information is kept private.</h6>

            <input type="text" class="form-control" name="commentInstructor" value= " ">
        </label>
        <br><br>

        <div class = "container" style="padding: 0">
            <button  type="submit" class="btn btn-dark ml-auto">Submit</button>
            <br><br><br>
        </div>
    </form>

</div>
<script src="autocomplete-library.js"></script>
<footer class="footer bg-dark text-light py-1">
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
