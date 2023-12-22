<?php
require '/home/badgergr/newdb.php';

$sql = "SELECT Clinical.Name, Score.EnjoyTimeScore, Score.StaffSupportScore, Score.SiteFacilitationScore,
       Score.PreceptorFacilitationScore, Score.RecommendableScore
        FROM Clinical
        INNER JOIN Score ON Score.ClinicalID = Clinical.ID
        ORDER BY Clinical.Name;";

$result = @mysqli_query($cnxn, $sql);

// Set the response type to CSV
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="averages.csv"');

$output = fopen('php://output', 'w');

// Output header
fputcsv($output, array('Clinic Name', 'Overall Rating', 'Enjoy Time', 'Staff Support', 'Site Facilitation', 'Preceptor Facilitation', 'Recommendable'));

$currentClinic = null;
$entries = [];

// Output data
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
            $averageRow = calculateAverage($currentClinic, $entries);
            fputcsv($output, $averageRow);
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
    $averageRow = calculateAverage($currentClinic, $entries);
    fputcsv($output, $averageRow);
}

fclose($output);
mysqli_close($cnxn);

function calculateAverage($clinicName, $entries)
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

        return [
            $clinicName,
            number_format($averageTotalScore, 2),
            number_format($averageEnjoyTimeScore, 2),
            number_format($averageStaffSupportScore, 2),
            number_format($averageSiteFacilitationScore, 2),
            number_format($averagePreceptorFacilitationScore, 2),
            number_format($averageRecommendableScore, 2),
        ];
    }

    return [];
}
?>
