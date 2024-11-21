<?php
//Author: Huzzein Adebiyi

$file = 'userdata.csv';
if (file_exists($file)) {
    header('Content-Type: application/csv');
    header('Content-Disposition: attachment; filename="' . basename($file) . '"');
    header('Pragma: no-cache');
    header('Expires: 0');
    readfile($file);
    exit();
} else {
    echo "No data available to download.";
}
?>
