<?php

require '/home/badgergr/newdb.php';
$sql = "SELECT Clinical.Name, EnjoyTimeScore, StaffSupportScore, SiteFacilitationScore, PreceptorFacilitationScore, RecommendableScore, CommentStaffSit, CommentInstructor
FROM Score JOIN Clinical ON Clinical.ID = Score.ClinicalID ORDER BY Clinical.Name ASC;";


$result = @mysqli_query($cnxn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    $name = $row['Name'];
    $enjoyTimeScore = $row['EnjoyTimeScore'];
    $StaffSupportScore = $row['StaffSupportScore'];
    $SiteFacilitationScore = $row['SiteFacilitationScore'];
    $PreceptorFacilitationScore = $row['PreceptorFacilitationScore'];
    $RecommendableScore = $row['RecommendableScore'];
    $CommentStaffSit = $row['CommentStaffSit'];
    $CommentInstructor = $row['CommentInstructor'];


    echo "<p>$name - $enjoyTimeScore, $StaffSupportScore, $SiteFacilitationScore, $PreceptorFacilitationScore, $RecommendableScore, $CommentStaffSit, $CommentInstructor </p>";
}
?>
