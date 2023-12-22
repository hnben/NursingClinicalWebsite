<html lang="en">
<head>
    <title>Receipt</title>
    <style>
        body{
            text-align: center;
            padding: 10%;
        }
        .container{
            text-align: center;
            padding: 10%;
        }

    </style>

    <link rel='stylesheet' href='style.css'>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN' crossorigin='anonymous'>
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js' integrity='sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL' crossorigin='anonymous'></script>
    <meta charset='UTF-8'>
</head>
<body>
<div class = "receipt" id = "receiptPage">
    <?php

    if (isset($_POST["enjoyTime"]) AND
        isset($_POST["staffSupport"]) AND
        isset($_POST["siteFacilitation"]) AND
        isset($_POST["preceptorFacilitation"]) AND
        isset($_POST["recommendable"])) {

            $clinicName = $_POST["clinicName"];
            $enjoyTimeScore = $_POST["enjoyTime"];
            $staffSupportScore = $_POST["staffSupport"];
            $siteFacilitationScore = $_POST["siteFacilitation"];
            $preceptorFacilitationScore = $_POST["preceptorFacilitation"];
            $recommendableScore = $_POST["recommendable"];
            $commentStaffSite = $_POST["commentStaffSite"];
            $commentInstructor = $_POST ["commentInstructor"];

            if (validInput($enjoyTimeScore) AND
                validInput($staffSupportScore) AND
                validInput($siteFacilitationScore) AND
                validInput($preceptorFacilitationScore) AND
                validInput($recommendableScore)){

                sendToDB();
                    $currentYear = date('Y');
                    $shortYear = date('y');
                    $month = date('F');

                    //first letter of the month
                    $firstLetter = substr($month, 0, 1);
                    $randomNumber = rand(1000, 9999);

                    $background_color = 'fff';

                    $codeGenerator = $firstLetter . $randomNumber . $shortYear;

                    switch ($month) {
                        case "January":
                        case "February":
                        case "March":
                            echo "<body style='background-color:#345bb6'>";
                            break;
                        case "April":
                        case "May":
                        case "June":
                            echo "<body style='background-color:#1b6e1b'>";
                            break;
                        case "October":
                        case "November":
                        case "December":
                            echo "<body style='background-color:#f58811'>";
                            break;

                    }

                    echo '
                <div class="container">
                        <div class="card text-white bg-dark mb-3">
                            <div class="text-center">
                                <h1 class="card-header bg-success">Receipt</h1>
                                <img src="https://i.imgur.com/8v7u8co.png" alt="Checkmark" height="300">
                            </div>
                    <div class="card-body">
                            <h2>'. $month ." ". $currentYear .'</h2>
                            <h2>'. '#' . $codeGenerator .'</h2>
                            <p>(Screenshot This Page as a Receipt For Your Instructor)</p>
                    </div>
                ';

                }
            }

    function sendToDB(){
        global $clinicName;
        global $enjoyTimeScore;
        global $staffSupportScore;
        global $siteFacilitationScore;
        global $preceptorFacilitationScore;
        global $recommendableScore;
        global $commentStaffSite;
        global $commentInstructor;

        require '/home/badgergr/newdb.php';
        $sql = "INSERT INTO Clinical (Name) VALUES ('$clinicName')";
        @mysqli_query($cnxn, $sql);

        $IDsql= "SELECT ID FROM Clinical WHERE Name='$clinicName'";
        $result = @mysqli_query($cnxn, $IDsql);
        $row = mysqli_fetch_assoc($result);
        $id = $row['ID'];

        echo "<p> $id </p>";

        $Scoresql = "INSERT INTO Score (ClinicalID, EnjoyTimeScore, StaffSupportScore, SiteFacilitationScore, PreceptorFacilitationScore, RecommendableScore, CommentStaffSit, CommentInstructor) VALUES 
            ($id, $enjoyTimeScore, $staffSupportScore, $siteFacilitationScore, $preceptorFacilitationScore, $recommendableScore, '$commentStaffSite', '$commentInstructor')";

        @mysqli_query($cnxn, $Scoresql);
    }


        function validInput ($input): bool {
                if ($input === "1" ||
                    $input === "2" ||
                    $input === "3" ||
                    $input === "4" ||
                    $input === "5" ){
                    return true;
                }
                else{
                    return false;
                }

    }

    ?>
</div>

</body>
</html>