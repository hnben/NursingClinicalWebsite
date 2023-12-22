<?php
require '/home/badgergr/newdb.php';

$sql = "SELECT Clinical.Name, Score.EnjoyTimeScore, Score.StaffSupportScore, Score.SiteFacilitationScore,
       Score.PreceptorFacilitationScore, Score.RecommendableScore, Score.CommentStaffSit,
       Score.CommentInstructor,
       ROUND((Score.EnjoyTimeScore + Score.StaffSupportScore + Score.SiteFacilitationScore +
        Score.PreceptorFacilitationScore + Score.RecommendableScore) / 5, 2) as AverageTotalScore
        FROM Clinical
        INNER JOIN Score ON Score.ClinicalID = Clinical.ID
        ORDER BY Name ASC;";

$result = @mysqli_query($cnxn, $sql);

$filename = "entries.csv";
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="' . $filename . '"');

$output = fopen("php://output", "w");

// Add CSV headers
fputcsv($output, array('Clinic Name', 'Enjoy Time', 'Staff Support', 'Site Facilitation', 'Preceptor Facilitation', 'Recommendable', 'Visit Score', 'Staff Situation Comments', 'Instructor Comments'));

while ($row = mysqli_fetch_assoc($result)) {
    $csvRow = array(
        $row['Name'],
        $row['EnjoyTimeScore'],
        $row['StaffSupportScore'],
        $row['SiteFacilitationScore'],
        $row['PreceptorFacilitationScore'],
        $row['RecommendableScore'],
        number_format($row['AverageTotalScore'], 2),
        $row['CommentStaffSit'],
        $row['CommentInstructor']
    );
    fputcsv($output, $csvRow);
}

fclose($output);
exit();
?>

