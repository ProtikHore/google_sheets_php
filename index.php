<?php
require __DIR__ . '/vendor/autoload.php';

$client = new \Google_Client();
$client->setApplicationName('Google Sheets With PHP');
$client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
$client->setAccessType('offline');

$client->setAuthConfig('credentials.json');

$sheets = new \Google_Service_Sheets($client);


$spreadsheetId = '1g66RitDyMFAMdKmtob3wyooNXCxNh3oWTin2YIhN1JA';
$range = 'A:B';
$response = $sheets->spreadsheets_values->get($spreadsheetId, $range);

$valus = $response->getValues();
if(empty($valus)) {
    echo "No Data...";
} else {
    foreach ($valus as $row) {
        print_r($row);
    }
}