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
    <script src="dark-light-mode.js"></script>
    <style>
        .table-striped>tbody>tr:nth-child(odd)>td,
        .table-striped>tbody>tr:nth-child(odd)>th {
            background-color: #d5e5cd;
        }

        [data-bs-theme=dark] .table-striped>tbody>tr:nth-child(odd)>td,
        .table-striped>tbody>tr:nth-child(odd)>th {
            color: white;
            background: darkgreen;
        }

        .sort-asc::after {
            content: " ▲";
        }

        .sort-desc::after {
            content: " ▼";
        }
    </style>

    <script>
        function sortTable(n) {
            var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
            table = document.getElementById("table");
            switching = true;
            // Set the sorting direction to ascending:
            dir = "asc";
            /* Make a loop that will continue until
            no switching has been done: */
            while (switching) {
                // Start by saying: no switching is done:
                switching = false;
                rows = table.rows;
                /* Loop through all table rows (except the
                first, which contains table headers): */
                for (i = 1; i < (rows.length - 1); i++) {
                    // Start by saying there should be no switching:
                    shouldSwitch = false;
                    /* Get the two elements you want to compare,
                    one from the current row and one from the next: */
                    x = rows[i].getElementsByTagName("TD")[n];
                    y = rows[i + 1].getElementsByTagName("TD")[n];
                    /* Check if the two rows should switch place,
                    based on the direction, asc or desc: */
                    if (dir == "asc") {
                        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                            // If so, mark as a switch and break the loop:
                            shouldSwitch = true;
                            break;
                        }
                    } else if (dir == "desc") {
                        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                            // If so, mark as a switch and break the loop:
                            shouldSwitch = true;
                            break;
                        }
                    }
                }
                if (shouldSwitch) {
                    /* If a switch has been marked, make the switch
                    and mark that a switch has been done: */
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                    // Each time a switch is done, increase this count by 1:
                    switchcount++;
                } else {
                    /* If no switching has been done AND the direction is "asc",
                    set the direction to "desc" and run the while loop again. */
                    if (switchcount == 0 && dir == "asc") {
                        dir = "desc";
                        switching = true;
                    }
                }
            }

            // Reset arrow indicators
            resetArrows();
            // Set arrow indicator for the currently sorted column
            var currentHeader = document.getElementsByTagName("TH")[n];
            currentHeader.classList.toggle("sort-asc", dir === "asc");
            currentHeader.classList.toggle("sort-desc", dir === "desc");
        }

        function resetArrows() {
            var headers = document.getElementsByTagName("TH");
            for (var i = 0; i < headers.length; i++) {
                headers[i].classList.remove("sort-asc");
                headers[i].classList.remove("sort-desc");
            }
        }
    </script>
    <title>Average Scores</title>
    <style>
        .table-striped>tbody>tr:nth-child(odd)>td,
        .table-striped>tbody>tr:nth-child(odd)>th {
            background-color: #d5e5cd;
        }

        [data-bs-theme=dark] .table-striped>tbody>tr:nth-child(odd)>td,
        .table-striped>tbody>tr:nth-child(odd)>th {
            color: white;
            background: darkgreen;
        }
    </style>
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
<div class='container-fluid mt-3'>
    <form method='post'>
        <div class='row'>
            <div class='col-md-2'>
                <!-- Modify the link/button below your table -->
                <a href="averages.php" class="btn btn-success" download="averages.csv">Export to CSV</a>
            </div>
            <div class='col-md-2'>
                <a href='viewentries.php' class='btn btn-primary'>View Entries</a>
            </div>
    </form>
    <?php
    require '/home/badgergr/newdb.php';

    $sql = "SELECT Clinical.Name, Score.EnjoyTimeScore, Score.StaffSupportScore, Score.SiteFacilitationScore,
       Score.PreceptorFacilitationScore, Score.RecommendableScore
        FROM Clinical
        INNER JOIN Score ON Score.ClinicalID = Clinical.ID
        ORDER BY Clinical.Name;";

    $result = @mysqli_query($cnxn, $sql);

    $currentClinic = null;
    $clinicsData = [];

    echo "
        <table class='table table-sticky-top table-striped' id='table'>
            <thead class='sticky-top bg-white'>
                <tr>
                    <th onclick='sortTable(0)'>Clinic Name</th>
                    <th onclick='sortTable(1)'>Overall Rating</th>
                    <th onclick='sortTable(2)'>Enjoy Time</th>
                    <th onclick='sortTable(3)'>Staff Support</th>
                    <th onclick='sortTable(4)'>Site Facilitation</th>
                    <th onclick='sortTable(5)'>Preceptor Facilitation</th>
                    <th onclick='sortTable(6)'>Recommendable</th>
                </tr>
            </thead>
            <tbody>";

    while ($row = mysqli_fetch_assoc($result)) {
        $Name = $row['Name'];
        $EnjoyTimeScore = $row['EnjoyTimeScore'];
        $StaffSupportScore = $row['StaffSupportScore'];
        $SiteFacilitationScore = $row['SiteFacilitationScore'];
        $PreceptorFacilitationScore = $row['PreceptorFacilitationScore'];
        $RecommendableScore = $row['RecommendableScore'];

        // Check if we've moved to a new clinic
        if ($currentClinic !== $Name) {
            // Calculate and store average scores for the previous clinic
            if ($currentClinic !== null) {
                displayAverage($currentClinic, $entries);
            }

            // Update the current clinic and reset entries array
            $currentClinic = $Name;
            $entries = [];
        }

        // Add the entry to the current clinic's entries
        $entries[] = [
            'Name' => $Name,
            'EnjoyTimeScore' => $EnjoyTimeScore,
            'StaffSupportScore' => $StaffSupportScore,
            'SiteFacilitationScore' => $SiteFacilitationScore,
            'PreceptorFacilitationScore' => $PreceptorFacilitationScore,
            'RecommendableScore' => $RecommendableScore,
        ];
    }

    // Calculate and store average scores for the last clinic
    if ($currentClinic !== null) {
        displayAverage($currentClinic, $entries);
    }

    echo "</tbody>
        </table>
</div>
</div>";


    function displayAverage($clinicName, $entries)
    {
        $totalEnjoyTimeScore = array_sum(array_column($entries, 'EnjoyTimeScore'));
        $totalStaffSupportScore = array_sum(array_column($entries, 'StaffSupportScore'));
        $totalSiteFacilitationScore = array_sum(array_column($entries, 'SiteFacilitationScore'));
        $totalPreceptorFacilitationScore = array_sum(array_column($entries, 'PreceptorFacilitationScore'));
        $totalRecommendableScore = array_sum(array_column($entries, 'RecommendableScore'));

        $totalScores = $totalEnjoyTimeScore + $totalStaffSupportScore + $totalSiteFacilitationScore
            + $totalPreceptorFacilitationScore + $totalRecommendableScore;

        $totalEntries = count($entries);

        if ($totalEntries > 0) {
            $averageEnjoyTimeScore = $totalEnjoyTimeScore / $totalEntries;
            $averageStaffSupportScore = $totalStaffSupportScore / $totalEntries;
            $averageSiteFacilitationScore = $totalSiteFacilitationScore / $totalEntries;
            $averagePreceptorFacilitationScore = $totalPreceptorFacilitationScore / $totalEntries;
            $averageRecommendableScore = $totalRecommendableScore / $totalEntries;
            $averageTotalScore = $totalScores / ($totalEntries * 5); // Divide by 5 for the total of 5 columns

            echo "
            <tr>
                <td>" . $clinicName . "</td>
                <td>" . number_format($averageTotalScore, 2) . "</td>
                <td>" . number_format($averageEnjoyTimeScore, 2) . "</td>
                <td>" . number_format($averageStaffSupportScore, 2) . "</td>
                <td>" . number_format($averageSiteFacilitationScore, 2) . "</td>
                <td>" . number_format($averagePreceptorFacilitationScore, 2) . "</td>
                <td>" . number_format($averageRecommendableScore, 2) . "</td>
            </tr>";
        }
    }
    ?>
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
