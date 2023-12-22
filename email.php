<?php

//cookie remembers name and expires after 30 days
$name = $_POST["name"];
$email = $_POST["email"];
$phone = $_POST["phone"];
$programName = $_POST["programName"];
setcookie("nameCookie", $name, time() + 3600 * 24 * 30, "/");
setcookie("emailCookie", $email, time()+ 3600 * 24 * 30, "/");
setcookie("phoneCookie", $phone, time()+ 3600 * 24 * 30, "/");
setcookie("programName", $programName, time()+ 3600 * 24 * 30, "/");

echo
"
<head>
    <link rel='stylesheet' href='style.css'>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN' crossorigin='anonymous'>
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js' integrity='sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL' crossorigin='anonymous'></script>
    <meta charset='UTF-8'>
    <script src='dark-light-mode.js'></script>
    <title>Contact Confirmation</title>
    <style>
    body{
    text-align: center;
    padding: 10%
    }
    
    .container{
    text-align: center;
    padding: 10%;
    }
    
    body{
    background: lightgrey;
    }
    </style>
</head>
";


if(isset($_POST["name"]) AND isset($_POST["email"]) AND isset($_POST["phone"]) AND isset($_POST["message"])) {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $programName = $_POST["programName"];
    $messageContent = $_POST["message"];
    echo '
    <div class="card text-white bg-dark mb-3">
        <h1 class="card-header bg-success">Thank you for your message!</h1>
        <div class="card-body">
            <p class = "text-start">Name: ' .$name. '</p>
            <p class = "text-start">Email: ' .$email. '</p>
            <p class = "text-start">Phone: ' .$phone. '</p>
            <p class = "text-start">Program Name: ' .$programName. '</p>
            <p class = "text-start">Message: ' .$messageContent. '</p>
            <p class = "text-start">We have received your message. Click the button below to return to the contact form.</p>
            
            <div class="row">
                <div class="col-6 text-start">
                   <a href="contact_form.php" class="btn btn-success">
                   Return</a>
                </div>
            </div>
        </div>
    </div>
</div>';

}


$to = "hnbirthday0031@gmail.com";
$subject = "Contact Request";
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
    <title>Contact Request</title>
    </head>
    <body>
    <h1>Nursing Nucleus Contact Request</h1>
    <h2>Contact information</h2>
    <p>
    Name: $name <br>
    Email: $email <br>
    Phone: $phone <br>
    Program: $programName <br>
    <br>
    $messageContent
    </p>
    </body>
";


$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= "From: " . $email;

mail($to, $subject, $message, $headers);


