<?php
function readCsv($csvFile) {
    $file_handle = fopen($csvFile, 'r');
    $lines = [];
    while (!feof($file_handle)) {
        $lines[] = fgetcsv($file_handle);
    }
    fclose($file_handle);
    return $lines;
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $date = $_POST['date'];
    $hour = $_POST['hour'];
    $presenter = $_POST['presenter'];
    $faculty_number = $_POST['faculty_number'];
    $email = $_POST['email'];
    
    $csvFile = '../data/valid_entries.csv';
    $csvData = readCsv($csvFile);
    $isValid = false;

    foreach ($csvData as $row) {
        if ($row[0] == $presenter && $row[1] == $faculty_number) {
            $isValid = true;
            break;
        }
    }

    if (!$isValid) {
        if (array_search([$presenter], array_column($csvData, 0)) === false) {
            $errors['presenter'] = 'Invalid presenter name.';
        }
        if (array_search([$faculty_number], array_column($csvData, 1)) === false) {
            $errors['faculty_number'] = 'Invalid faculty number.';
        }
        if (array_search([$invite_type], array_column($csvData, 2)) === false) {
            $errors['invite_type'] = 'Invalid invite type.';
        }
    }

    // If no errors, process the form (e.g., save to database, send email, etc.)
    if (empty($errors)) {
        // Form processing code here
        echo "Invitation created successfully!";
        exit;
    }
}
?>