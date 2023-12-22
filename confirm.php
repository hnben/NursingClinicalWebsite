
<?php
echo "
<head>
<link rel='stylesheet' href='style.css'>
<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN' crossorigin='anonymous'>
<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js' integrity='sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL' crossorigin='anonymous'></script>
<meta charset='UTF-8'>
<script src='dark-light-mode.js'></script>
<title>Confirm Page</title>
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
</head>
";

//checking to see if the fields are filled
if (isset($_POST["enjoyTime"]) AND
isset($_POST["staffSupport"]) AND
isset($_POST["siteFacilitation"]) AND
isset($_POST["preceptorFacilitation"]) AND
isset($_POST["recommendable"])) {

//assigned to variables
$clinicName = $_POST["clinicName"];
$enjoyTimeScore = $_POST["enjoyTime"];
$staffSupportScore = $_POST["staffSupport"];
$siteFacilitationScore = $_POST["siteFacilitation"];
$preceptorFacilitationScore = $_POST["preceptorFacilitation"];
$recommendableScore = $_POST["recommendable"];

$commentStaffSite = $_POST["commentStaffSite"];
$commentInstructor = $_POST ["commentInstructor"];
//check to see if the inputs are valid
if (validInput($enjoyTimeScore) AND
validInput($staffSupportScore) AND
validInput($siteFacilitationScore) AND
validInput($preceptorFacilitationScore) AND
validInput($recommendableScore)){

//passed all secondary validation and security
echo '<div class="container">
    <div class="card text-white bg-dark mb-3">
        <h1 class="card-header" style="background-color: #6c9574"> Please confirm your selection </h1>
        <div class="card-body">

            <div class="row">
                <div class = "col-4">
                    <p class = "text-start"><strong>Clinic Name: </strong></p>
                </div>
                <div class = "col-8">
                    <p class = "text-start">'. $clinicName .'</p>
                </div>
            </div>

            <div class="row">
                <div class = "col-4">
                    <p class = "text-start"><strong>Enjoy Time Score:</strong></p>
                </div>
                <div class = "col-8">
                    <p class = "text-start">'. $enjoyTimeScore .'</p>
                </div>
            </div>

            <div class="row">
                <div class = "col-4">
                    <p class = "text-start"><strong>Staff Support Score:</strong></p>
                </div>
                <div class = "col-8">
                    <p class = "text-start">'. $staffSupportScore .'</p>
                </div>
            </div>

            <div class="row">
                <div class = "col-4">
                    <p class = "text-start"><strong>Site Facilitation Score:</strong></p>
                </div>
                <div class = "col-8">
                    <p class = "text-start">'. $siteFacilitationScore.'</p>
                </div>

            </div>

            <div class="row">
                <div class = "col-4">
                    <p class = "text-start"><strong>Preceptor Facilitation Score:</strong></p>
                </div>
                <div class = "col-8">
                    <p class = "text-start">'. $preceptorFacilitationScore .'</p>
                </div>
            </div>

            <div class="row">
                <div class = "col-4">
                    <p class = "text-start"><strong>Recommendable Score:</strong></p>
                </div>
                <div class = "col-8">
                    <p class = "text-start">'. $recommendableScore .'</p>
                </div>
            </div>

            <div class="row">
                <div class = "col-4">
                    <p class = "text-start"><strong>Comments on Staff/Site:</strong></p>
                </div>
                <div class = "col-8">
                    <p class = "text-start">'. $commentStaffSite .'</p>
                </div>
            </div>

            <div class="row">
                <div class = "col-4">
                    <p class = "text-start"><strong>Comments on Instructor:</strong></p>
                </div>
                <div class = "col-8">
                    <p class = "text-start">'. $commentInstructor .'</p>
                </div>
            </div>

            <form method="POST" action="https://badger.greenriverdev.com/Sprint3/receipt.php">
                <input type="hidden" id="hiddenName" name="clinicName" value="' . $clinicName . '">

                <input type="hidden" id="hiddenEnjoyTimeScore" name="enjoyTime" value="' . $enjoyTimeScore . '">
                <input type="hidden" id="hiddenStaffSupportScore" name="staffSupport" value="' . $staffSupportScore . '">
                <input type="hidden" id="hiddenSiteFacilitationScore" name="siteFacilitation" value="' . $siteFacilitationScore . '">
                <input type="hidden" id="hiddenPreceptorFacilitationScore" name="preceptorFacilitation" value="' . $preceptorFacilitationScore . '">
                <input type="hidden" id="recommendableScore" name="recommendable" value="' . $recommendableScore . '">

                <input type="hidden" id="commentStaffSite" name="commentStaffSite" value="' . $commentStaffSite . '">
                <input type="hidden" id="commentStaffSite" name="commentInstructor" value="' . $commentInstructor . '">

                <div class="row">
                    <div class="col-6 text-start">
                        <button type="submit" id="confirmButton" name="submit" class="btn btn-success" style="background-color: #6c9574">Confirm</button>
                    </div>
                    <div class="col-6 text-end">
                        <a href="experience_form.html" class="btn btn-danger">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>';

$month = date('F');

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

}
}

//if all radio buttons aren't answered tell user to go back and answer them
else{

echo
'<div class="container">
    <div class="card text-white bg-dark mb-3 " >
        <h1 class="card-header " style="background-color: #6c9574" >Please fill out all the fields</h1>
        <div class="card-body">

            <h2 class = "text-start">Click the button below to return to the experience form.</h2>


            <div class="row" >
                <div class="col-6 text-start" >
                    <a href="experience_form.html" class="btn btn-success" style="background-color: #6c9574">
                        Return</a>

                </div>
            </div>
        </div>
    </div>
</div>';

}


function validInput ($input): bool {
if ($input === "1" ||
$input === "2" ||
$input === "3" ||
$input === "4" ||
$input === "5" ){
return true;
} else{
return false;
}

}






