<?php
//Author: Huzzein Adebiyi
session_start();

// Check if the user is registered
if (!isset($_SESSION['message'])) {
    $_SESSION['message'] = 'Please sign up to access the dataset.';
    header('Location: index.php'); // Redirect to the sign-up page if not registered
    exit();
}

$_SESSION['message'] = ''; // Clear the message after redirect

// Read the dataset
$dataset = array_map('str_getcsv', file('largedataset.csv'));

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dataset</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="dataset-container">
        <h2>Access Your Dataset</h2>
        <a href="download.php" class="download-btn">Download Dataset as CSV</a>
        <table>
            <thead>
                <tr>
                    <?php
                    // Print the headers
                    foreach ($dataset[0] as $header) {
                        echo "<th>{$header}</th>";
                    }
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php
                // Print the rows of the dataset
                foreach ($dataset as $index => $row) {
                    if ($index > 0) { // Skip the header row
                        echo '<tr>';
                        foreach ($row as $cell) {
                            echo "<td>{$cell}</td>";
                        }
                        echo '</tr>';
                    }
                }
                ?>
            </tbody>
        </table>
        
    </div>
</body>
</html>
