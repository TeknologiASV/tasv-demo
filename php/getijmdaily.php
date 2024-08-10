<?php
require_once "db_connect.php";

session_start();

if(isset($_POST['startDate'], $_POST['endDate'])){
    $startDate = filter_input(INPUT_POST, 'startDate', FILTER_SANITIZE_STRING);
    $endDate = filter_input(INPUT_POST, 'endDate', FILTER_SANITIZE_STRING);

    if ($select_stmt = $dbI->prepare("SELECT * FROM vehicle_count WHERE Date>=? AND Date<=? ORDER BY Date")) {
        $select_stmt->bind_param('ss', $startDate, $endDate);
        
        // Execute the prepared query.
        if (! $select_stmt->execute()) {
            echo json_encode(
                array(
                    "status" => "failed",
                    "message" => $select_stmt->error 
                )
            ); 
        }
        else{
            $result = $select_stmt->get_result();
            $message = array();
            $dateBar = array();
            $type1 = 0;
            $type2 = 0;
            $type3 = 0;
            $type4 = 0;

            while ($row = $result->fetch_assoc()) {
                if(!in_array(substr($row['Date'], 10, 3), $dateBar)){
                    $message[] = array( 
                        'Date' => substr($row['Date'], 10, 3),
                        'type1' => 0,
                        'type2' => 0,
                        'type3' => 0,
                        'type4' => 0,
                        'total' => 0
                    );

                    array_push($dateBar, substr($row['Date'], 10, 3));
                }

                $key = array_search(substr($row['Date'], 10, 3), $dateBar);
                $message[$key]['total'] += (int)$row['Count'];

                if($row['Vehicle_Type'] == '1'){
                    $message[$key]['type1'] += (int)$row['Count'];
                    $type1 += (int)$row['Count'];
                }
                else if($row['Vehicle_Type'] == '2'){
                    $message[$key]['type2'] += (int)$row['Count'];
                    $type2 += (int)$row['Count'];
                }
                else if($row['Vehicle_Type'] == '3'){
                    $message[$key]['type3'] += (int)$row['Count'];
                    $type3 += (int)$row['Count'];
                }
                else if($row['Vehicle_Type'] == '4'){
                    $message[$key]['type4'] += (int)$row['Count'];
                    $type4 += (int)$row['Count'];
                }
            }

            echo json_encode(
                array(
                    "status" => "success",
                    "message" => $message,
                    "type1" => $type1,
                    "type2" => $type2,
                    "type3" => $type3,
                    "type4" => $type4
                )
            );   
        }
    }
    else{
        echo json_encode(
            array(
                "status" => "failed",
                "message" => "Failed to prepare query for Felda"
            )
        ); 
    }
}
else{
    echo json_encode(
        array(
            "status" => "failed",
            "message" => "Missing Parameter"
        )
    ); 
}