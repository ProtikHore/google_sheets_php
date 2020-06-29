<?php
include "database.php";


require __DIR__ . '/vendor/autoload.php';

$client = new \Google_Client();
$client->setApplicationName('Google Sheets With PHP');
$client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
$client->setAccessType('offline');

$client->setAuthConfig('credentials.json');

$sheets = new \Google_Service_Sheets($client);


// $spreadsheetId = '1g66RitDyMFAMdKmtob3wyooNXCxNh3oWTin2YIhN1JA'; // for test sheet
$spreadsheetId = '1O7QeWi8JUDewl8nrxzUnFstkUqHaa5R5qwHTP4vRLOk'; // for dppm shet
//$range = 'A2:Z'; // for test range
$range = 'A3:Z'; // for dppm range
$response = $sheets->spreadsheets_values->get($spreadsheetId, $range);

$values = $response->getValues();

if(empty($values)) {
    echo "No Data...";
} else {
    foreach ($values as $key=> $row) {
    	 //echo json_encode($row, JSON_FORCE_OBJECT);
//        print_r($row[0] . '-' . $row[1]);
//        echo $row[0] . '-' . $row[11];
//        echo "<br>";


        //$sql = "INSERT INTO user (first_name, last_name) VALUES ('$row[0]', '$row[1]')"; // for user table


        $date = date_format(date_create($row[11]), 'Y-m-d');
        $sql = "INSERT INTO dppm (ORDER_ID, CUSTOMER_NAME, CUSTOMER_PO_REF, SHIP_TO, PART_ID, WORK_CENTER, SHIPPED_QTY, REJECT_QTY, DPPM, RMA, UNIT_PRICE, SHIPPED_DATE, WEEK, MONTH)
                VALUES ('$row[0]', '$row[1]', '$row[2]', '$row[3]', '$row[4]', '$row[5]', '$row[6]', '$row[7]', '$row[8]', '$row[9]', '$row[10]', '$date', '$row[12]', '$row[13]')";

        if ($conn->query($sql) === TRUE) {
            echo "Record" . ++$key . "Inserted successfully";
            echo "<br>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }



    }
    $conn->close();
}