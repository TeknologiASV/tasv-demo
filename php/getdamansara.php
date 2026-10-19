<?php
// Old DB logic disabled while this endpoint returns random data.
// require_once "db_connect.php";

session_start();

if(isset($_POST['startDate'], $_POST['endDate'])){
    $startDate = filter_input(INPUT_POST, 'startDate', FILTER_SANITIZE_STRING);
    $endDate = filter_input(INPUT_POST, 'endDate', FILTER_SANITIZE_STRING);
    $location = filter_input(INPUT_POST, 'location', FILTER_SANITIZE_STRING);

    $message = array();
    $groundTotalCount = 0;
    $groundPassingCount = 0;
    $groundInCount = 0;
    $totalL1 = 0;
    $totalL2 = 0;
    $totalL3 = 0;
    $totalL4 = 0;
    $totalR1 = 0;
    $totalR2 = 0;
    $totalR3 = 0;
    $totalR4 = 0;
    $totalC = 0;
    $totalCA = 0;
    $totalCB = 0;
    $totalCC = 0;
    $totalCD = 0;

    $periodStart = DateTime::createFromFormat('Y-m-d', substr($startDate, 0, 10));
    $periodEnd = DateTime::createFromFormat('Y-m-d', substr($endDate, 0, 10));

    if ($periodStart && $periodEnd) {
        $periodEnd->modify('+1 day');
        $period = new DatePeriod($periodStart, new DateInterval('P1D'), $periodEnd);

        foreach ($period as $date) {
            $leftDoor = mt_rand(50, 250);
            $rightDoor = mt_rand(50, 250);
            $inStore = $leftDoor + $rightDoor;
            $dailyL1 = mt_rand(20, 150);
            $dailyL2 = mt_rand(20, 150);
            $dailyL3 = mt_rand(20, 150);
            $dailyL4 = mt_rand(20, 150);
            $dailyR1 = mt_rand(20, 150);
            $dailyR2 = mt_rand(20, 150);
            $dailyR3 = mt_rand(20, 150);
            $dailyR4 = mt_rand(20, 150);
            $dailyCA = mt_rand(20, 150);
            $dailyCB = mt_rand(20, 150);
            $dailyCC = mt_rand(20, 150);
            $dailyCD = mt_rand(20, 150);
            $dailyC = $dailyCA + $dailyCB + $dailyCC + $dailyCD;
            $passing = $dailyL1 + $dailyL2 + $dailyL3 + $dailyL4 + $dailyR1 + $dailyR2 + $dailyR3 + $dailyR4 + $dailyC;

            $message[] = array(
                'Date' => $date->format('Y-m-d'),
                'TotalGroundCount' => $inStore + $passing,
                'InStoreGroundCount' => $inStore,
                'LeftDoorCount' => $leftDoor,
                'RightDoorCount' => $rightDoor,
                'PassingGroundCount' => $passing,
                'TotalL1' => $dailyL1,
                'TotalL2' => $dailyL2,
                'TotalL3' => $dailyL3,
                'TotalL4' => $dailyL4,
                'TotalR1' => $dailyR1,
                'TotalR2' => $dailyR2,
                'TotalR3' => $dailyR3,
                'TotalR4' => $dailyR4,
                'TotalC' => $dailyC
            );

            $groundTotalCount += $inStore + $passing;
            $groundInCount += $inStore;
            $groundPassingCount += $passing;
            $totalL1 += $dailyL1;
            $totalL2 += $dailyL2;
            $totalL3 += $dailyL3;
            $totalL4 += $dailyL4;
            $totalR1 += $dailyR1;
            $totalR2 += $dailyR2;
            $totalR3 += $dailyR3;
            $totalR4 += $dailyR4;
            $totalC += $dailyC;
            $totalCA += $dailyCA;
            $totalCB += $dailyCB;
            $totalCC += $dailyCC;
            $totalCD += $dailyCD;
        }
    }

    echo json_encode(
        array(
            "status" => "success",
            "message" => $message,
            "groundTotalCount" => $groundTotalCount,
            "groundInCount" => $groundInCount,
            "groundPassingCount" => $groundPassingCount,
            "totalL1" => $totalL1,
            "totalL2" => $totalL2,
            "totalL3" => $totalL3,
            "totalL4" => $totalL4,
            "totalR1" => $totalR1,
            "totalR2" => $totalR2,
            "totalR3" => $totalR3,
            "totalR4" => $totalR4,
            "totalC" => $totalC,
            "totalCA" => $totalCA,
            "totalCB" => $totalCB,
            "totalCC" => $totalCC,
            "totalCD" => $totalCD
        ));

    /*
    if ($select_stmt = $dbU->prepare("SELECT * FROM uniqlo_DA WHERE Date>=? AND Date<=? ORDER BY Date")) {
        $select_stmt->bind_param('ss', $startDate, $endDate);
        
        // Execute the prepared query.
        if (! $select_stmt->execute()) {
            echo json_encode(
                array(
                    "status" => "failed",
                    "message" => "Something went wrong"
                )); 
        }
        else{
            $result = $select_stmt->get_result();
            $message = array();
            $dateBar = array();
            $groundTotalCount = 0;
            $groundPassingCount = 0;
            $groundInCount = 0;
            $totalL1 = 0;
            $totalL2 = 0;
            $totalL3 = 0;
            $totalL4 = 0;
            $totalR1 = 0;
            $totalR2 = 0;
            $totalR3 = 0;
            $totalR4 = 0;
            $totalC = 0;
            $totalCA = 0;
            $totalCB = 0;
            $totalCC = 0;
            $totalCD = 0;
            
            while ($row = $result->fetch_assoc()) {
                if(!in_array(substr($row['Date'], 0, 10), $dateBar)){
                    $message[] = array( 
                        'Date' => substr($row['Date'], 0, 10),
                        'TotalGroundCount' => 0,
                        'InStoreGroundCount' => 0,
                        'LeftDoorCount' => 0,
                        'RightDoorCount' => 0,
                        'PassingGroundCount' => 0,
                        'TotalL1' => 0,
                        'TotalL2' => 0,
                        'TotalL3' => 0,
                        'TotalL4' => 0,
                        'TotalR1' => 0,
                        'TotalR2' => 0,
                        'TotalR3' => 0,
                        'TotalR4' => 0,
                        'TotalC' => 0
                    );

                    array_push($dateBar, substr($row['Date'], 0, 10));
                }

                $key = array_search(substr($row['Date'], 0, 10), $dateBar);

                if($row['Mode'] == 'Ground'){
                    if($row['Door'] == 'in'){
                        $groundInCount += (int)$row['Count'];
                        //$groundTotalCount += (int)$row['Count'];
                        $message[$key]['TotalGroundCount'] += (int)$row['Count'];
                        $message[$key]['InStoreGroundCount'] += (int)$row['Count'];

                        if($row['Device'] == 'L1' || $row['Device'] == 'l1'){
                            //$totalL1 += (int)$row['Count'];
                            $message[$key]['LeftDoorCount'] += (int)$row['Count'];
                        }
                        if($row['Device'] == 'R1' || $row['Device'] == 'r1'){
                            //$totalL1 += (int)$row['Count'];
                            $message[$key]['RightDoorCount'] += (int)$row['Count'];
                        }
                    }
                    else if($row['Door'] == 'C1A'){
                        $groundPassingCount += (int)$row['Count'];
                        $groundTotalCount += (int)$row['Count'];
                        $message[$key]['TotalGroundCount'] += (int)$row['Count'];
                        $message[$key]['PassingGroundCount'] += (int)$row['Count'];

                        if($row['Device'] == 'C' || $row['Device'] == 'c'){
                            $totalC += (int)$row['Count'];
                            $totalCA += (int)$row['Count'];
                            $message[$key]['TotalC'] += (int)$row['Count'];
                        }
                    }
                    else if($row['Door'] == 'C1B'){
                        $groundPassingCount += (int)$row['Count'];
                        $groundTotalCount += (int)$row['Count'];
                        $message[$key]['TotalGroundCount'] += (int)$row['Count'];
                        $message[$key]['PassingGroundCount'] += (int)$row['Count'];

                        if($row['Device'] == 'C' || $row['Device'] == 'c'){
                            $totalC += (int)$row['Count'];
                            $totalCB += (int)$row['Count'];
                            $message[$key]['TotalC'] += (int)$row['Count'];
                        }
                    }
                    else if($row['Door'] == 'C1C'){
                        $groundPassingCount += (int)$row['Count'];
                        $groundTotalCount += (int)$row['Count'];
                        $message[$key]['TotalGroundCount'] += (int)$row['Count'];
                        $message[$key]['PassingGroundCount'] += (int)$row['Count'];

                        if($row['Device'] == 'C' || $row['Device'] == 'c'){
                            $totalC += (int)$row['Count'];
                            $totalCC += (int)$row['Count'];
                            $message[$key]['TotalC'] += (int)$row['Count'];
                        }
                    }
                    else if($row['Door'] == 'C1D'){
                        $groundPassingCount += (int)$row['Count'];
                        $groundTotalCount += (int)$row['Count'];
                        $message[$key]['TotalGroundCount'] += (int)$row['Count'];
                        $message[$key]['PassingGroundCount'] += (int)$row['Count'];

                        if($row['Device'] == 'C' || $row['Device'] == 'c'){
                            $totalC += (int)$row['Count'];
                            $totalCD += (int)$row['Count'];
                            $message[$key]['TotalC'] += (int)$row['Count'];
                        }
                    }
                    else if($row['Door'] == 'passing by' || $row['Door'] == 'C1A' || $row['Door'] == 'C1B' || $row['Door'] == 'C1C' || $row['Door'] == 'C1D'){
                        $groundPassingCount += (int)$row['Count'];
                        $groundTotalCount += (int)$row['Count'];
                        $message[$key]['TotalGroundCount'] += (int)$row['Count'];
                        $message[$key]['PassingGroundCount'] += (int)$row['Count'];

                        if($row['Device'] == 'L1' || $row['Device'] == 'l1'){
                            $totalL1 += (int)$row['Count'];
                            $message[$key]['TotalL1'] += (int)$row['Count'];
                        }
                        else if($row['Device'] == 'L2' || $row['Device'] == 'l2'){
                            $totalL2 += (int)$row['Count'];
                            $message[$key]['TotalL2'] += (int)$row['Count'];
                        }
                        else if($row['Device'] == 'L3' || $row['Device'] == 'l3'){
                            $totalL3 += (int)$row['Count'];
                            $message[$key]['TotalL3'] += (int)$row['Count'];
                        }
                        else if($row['Device'] == 'L4' || $row['Device'] == 'l4'){
                            $totalL4 += (int)$row['Count'];
                            $message[$key]['TotalL4'] += (int)$row['Count'];
                        }
                        else if($row['Device'] == 'R1' || $row['Device'] == 'r1'){
                            $totalR1 += (int)$row['Count'];
                            $message[$key]['TotalR1'] += (int)$row['Count'];
                        }
                        else if($row['Device'] == 'R2' || $row['Device'] == 'r2'){
                            $totalR2 += (int)$row['Count'];
                            $message[$key]['TotalR2'] += (int)$row['Count'];
                        }
                        else if($row['Device'] == 'R3' || $row['Device'] == 'r3'){
                            $totalR3 += (int)$row['Count'];
                            $message[$key]['TotalR3'] += (int)$row['Count'];
                        }
                        else if($row['Device'] == 'R4' || $row['Device'] == 'r4'){
                            $totalR4 += (int)$row['Count'];
                            $message[$key]['TotalR4'] += (int)$row['Count'];
                        }
                        else if($row['Device'] == 'C' || $row['Device'] == 'c'){
                            $totalC += (int)$row['Count'];
                            $message[$key]['TotalC'] += (int)$row['Count'];
                        }
                    }
                }
            }
            
            echo json_encode(
                array(
                    "status" => "success",
                    "message" => $message,
                    "groundTotalCount" => $groundTotalCount,
                    "groundInCount" => $groundInCount,
                    "groundPassingCount" => $groundPassingCount,
                    "totalL1" => $totalL1,
                    "totalL2" => $totalL2,
                    "totalL3" => $totalL3,
                    "totalL4" => $totalL4,
                    "totalR1" => $totalR1,
                    "totalR2" => $totalR2,
                    "totalR3" => $totalR3,
                    "totalR4" => $totalR4,
                    "totalC" => $totalC,
                    "totalCA" => $totalCA,
                    "totalCB" => $totalCB,
                    "totalCC" => $totalCC,
                    "totalCD" => $totalCD
                ));   
        }
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
