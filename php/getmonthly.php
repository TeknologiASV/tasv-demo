<?php
// Old DB logic disabled while this endpoint returns random data.
// require_once "db_connect.php";

session_start();

if(isset($_POST['startDate'], $_POST['endDate'])){
    $startDate = filter_input(INPUT_POST, 'startDate', FILTER_SANITIZE_STRING);
    $endDate = filter_input(INPUT_POST, 'endDate', FILTER_SANITIZE_STRING);
    $location = filter_input(INPUT_POST, 'location', FILTER_SANITIZE_STRING);
    $door = 'in';

    $oneUtamaCount = 0;
    $damansaraCount = 0;
    $oneUtamaTranc = 0;
    $damansaraTranc = 0;
    $message = array();

    $periodStart = DateTime::createFromFormat('Y-m-d', substr($startDate, 0, 10));
    $periodEnd = DateTime::createFromFormat('Y-m-d', substr($endDate, 0, 10));

    if ($periodStart && $periodEnd) {
        $periodEnd->modify('+1 day');
        $period = new DatePeriod($periodStart, new DateInterval('P1D'), $periodEnd);

        foreach ($period as $date) {
            $uniqloOU = mt_rand(100, 500);
            $uniqloDAS = mt_rand(80, 450);
            $transOU = mt_rand(20, 120);
            $transDAS = mt_rand(15, 100);

            $message[] = array(
                'Date' => $date->format('Y-m-d'),
                'uniqloOU' => $uniqloOU,
                'uniqloDAS' => $uniqloDAS,
                'transOU' => $transOU,
                'transDAS' => $transDAS
            );

            $oneUtamaCount += $uniqloOU;
            $damansaraCount += $uniqloDAS;
            $oneUtamaTranc += $transOU;
            $damansaraTranc += $transDAS;
        }
    }

    echo json_encode(
        array(
            "status" => "success",
            "message" => $message,
            "oneUtamaCount" => $oneUtamaCount,
            "damansaraCount" => $damansaraCount,
            "oneUtamaTranc" => $oneUtamaTranc,
            "damansaraTranc" => $damansaraTranc,
        ));

    /*
    if ($select_stmt = $dbU->prepare("SELECT * FROM uniqlo_1u WHERE Door=? AND Date>=? AND Date<=? ORDER BY Date")) {
        $select_stmt->bind_param('sss', $door, $startDate, $endDate);
        
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
            $oneUtamaCount = 0;
            $damansaraCount = 0;
            $oneUtamaTranc = 0;
            $damansaraTranc = 0;
            $result = $select_stmt->get_result();
            $device = 'L1';
            $message = array();
            $dateBar = array();
            
            while($row = $result->fetch_assoc()) {
                if(!in_array(substr($row['Date'], 0, 10), $dateBar)){
                    $message[] = array( 
                        'Date' => substr($row['Date'], 0, 10),
                        'uniqloOU' => 0,
                        'uniqloDAS' => 0,
                        'transOU' => 0,
                        'transDAS' => 0
                    );

                    array_push($dateBar, substr($row['Date'], 0, 10));
                }

                $key = array_search(substr($row['Date'], 0, 10), $dateBar);
                
                if($row['Door'] == 'in'){
                    $oneUtamaCount += (int)$row['Count'];
                    $message[$key]['uniqloOU'] += (int)$row['Count'];
                }
            }
            
            if ($select_stmt2 = $dbU->prepare("SELECT * FROM uniqlo_DA WHERE Door=? AND Device=? AND Date>=? AND Date<=? ORDER BY Date")) {
                $select_stmt2->bind_param('ssss', $door, $device, $startDate, $endDate);
                
                // Execute the prepared query.
                if (! $select_stmt2->execute()) {
                    echo json_encode(
                        array(
                            "status" => "failed",
                            "message" => $select_stmt2->error 
                        )); 
                }
                else{
                    $result2 = $select_stmt2->get_result();

                    while($row2 = $result2->fetch_assoc()) {
                        $damansaraCount += $row2['Count'];
                        $key = array_search(substr($row2['Date'], 0, 10), $dateBar);
                        $message[$key]['uniqloDAS'] += (int)$row2['Count'];
                        //$oneUtamaCount += $row2['Count'];
                    }

                    if ($select_stmt3 = $dbU->prepare("SELECT * FROM transaction WHERE Date>=? AND Date<=? ORDER BY Date")) {
                        $select_stmt3->bind_param('ss', $startDate, $endDate);
                        
                        // Execute the prepared query.
                        if (! $select_stmt3->execute()) {
                            echo json_encode(
                                array(
                                    "status" => "failed",
                                    "message" => $select_stmt3->error 
                                )); 
                        }
                        else{
                            $result3 = $select_stmt3->get_result();
        
                            while($row3 = $result3->fetch_assoc()) {
                                if($row3['Outlet'] == 'OU'){
                                    $oneUtamaTranc += (int)$row3['Transaction'];
                                    $message[$key]['transOU'] += (int)$row['Transaction'];
                                }
                                else if($row3['Outlet'] == 'DAS'){
                                    $damansaraTranc += (int)$row3['Transaction'];
                                    $message[$key]['transDAS'] += (int)$row['Transaction'];
                                }
                            }
                            
                            echo json_encode(
                                array(
                                    "status" => "success",
                                    "message" => $message,
                                    "oneUtamaCount" => $oneUtamaCount,
                                    "damansaraCount" => $damansaraCount,
                                    "oneUtamaTranc" => $oneUtamaTranc,
                                    "damansaraTranc" => $damansaraTranc,
                                ));   
                        }
                    }
                    else{
                        echo json_encode(
                            array(
                                "status" => "failed",
                                "message" => "Failed to get transactions"
                            )
                        ); 
                    }
                }
            }
            else{
                echo json_encode(
                    array(
                        "status" => "failed",
                        "message" => "Failed to prepare query for DA"
                    )
                ); 
            }
        }
    }
    else{
        echo json_encode(
            array(
                "status" => "failed",
                "message" => "Failed to prepare query for 1U"
            )
        ); 
    }
    */
}
else{
    echo json_encode(
        array(
            "status" => "failed",
            "message" => "Missing Parameter"
        )
    ); 
}
