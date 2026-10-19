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
    $lvl1TotalCount = 0;
    $lvl1PassingCount = 0;
    $lvl1InCount = 0;

    $periodStart = DateTime::createFromFormat('Y-m-d', substr($startDate, 0, 10));
    $periodEnd = DateTime::createFromFormat('Y-m-d', substr($endDate, 0, 10));

    if ($periodStart && $periodEnd) {
        $periodEnd->modify('+1 day');
        $period = new DatePeriod($periodStart, new DateInterval('P1D'), $periodEnd);

        foreach ($period as $date) {
            $currentDate = $date->format('Y-m-d');

            $groundIn = mt_rand(100, 500);
            $groundPassing = mt_rand(200, 900);
            $lvl1In = mt_rand(80, 400);
            $lvl1Passing = mt_rand(150, 700);

            $message[] = array(
                'Date' => $currentDate,
                'TotalGroundCount' => $groundIn,
                'InStoreGroundCount' => $groundIn,
                'PassingGroundCount' => $groundPassing,
                'TotalLvl1Count' => $lvl1In,
                'InStoreLvl1Count' => $lvl1In,
                'PassingLvl1Count' => $lvl1Passing
            );

            $groundTotalCount += $groundIn;
            $groundInCount += $groundIn;
            $groundPassingCount += $groundPassing;
            $lvl1TotalCount += $lvl1In;
            $lvl1InCount += $lvl1In;
            $lvl1PassingCount += $lvl1Passing;
        }
    }

    echo json_encode(
        array(
            "status" => "success",
            "message" => $message,
            "groundTotalCount" => $groundTotalCount,
            "groundInCount" => $groundInCount,
            "groundPassingCount" => $groundPassingCount,
            "lvl1TotalCount" => $lvl1TotalCount,
            "lvl1InCount" => $lvl1InCount,
            "lvl1PassingCount" => $lvl1PassingCount
        ));

    /*
    if ($select_stmt = $dbU->prepare("SELECT * FROM uniqlo_1u WHERE Date>=? AND Date<=? ORDER BY Date")) {
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
            $lvl1TotalCount = 0;
            $lvl1PassingCount = 0;
            $lvl1InCount = 0;
            
            while ($row = $result->fetch_assoc()) {
                if(substr($row['Date'], 0, 10) != "2022-11-26" && substr($row['Date'], 0, 10) != "2022-11-27" && substr($row['Date'], 0, 10) != "2022-11-28" && substr($row['Date'], 0, 10) != "2022-11-29"){
                    if(!in_array(substr($row['Date'], 0, 10), $dateBar)){
                        $message[] = array( 
                            'Date' => substr($row['Date'], 0, 10),
                            'TotalGroundCount' => 0,
                            'InStoreGroundCount' => 0,
                            'PassingGroundCount' => 0,
                            'TotalLvl1Count' => 0,
                            'InStoreLvl1Count' => 0,
                            'PassingLvl1Count' => 0
                        );
    
                        array_push($dateBar, substr($row['Date'], 0, 10));
                    }
    
                    $key = array_search(substr($row['Date'], 0, 10), $dateBar);
    
                    if($row['Mode'] == 'Ground'){
                        if($row['Door'] == 'in'){
                            $groundInCount += (int)$row['Count'];
                            $groundTotalCount += (int)$row['Count'];
                            $message[$key]['TotalGroundCount'] += (int)$row['Count'];
                            $message[$key]['InStoreGroundCount'] += (int)$row['Count'];
                        }
                        else if($row['Door'] == 'passing by'){
                            $groundPassingCount += (int)$row['Count'];
                            //$groundTotalCount += (int)$row['Count'];
                            //$message[$key]['TotalGroundCount'] += (int)$row['Count'];
                            $message[$key]['PassingGroundCount'] += (int)$row['Count'];
                        }
                    }
                    else if($row['Mode'] == 'Level 1'){
                        if($row['Door'] == 'in'){
                            $lvl1InCount += (int)$row['Count'];
                            $lvl1TotalCount += (int)$row['Count'];
                            $message[$key]['TotalLvl1Count'] += (int)$row['Count'];
                            $message[$key]['InStoreLvl1Count'] += (int)$row['Count'];
                        }
                        else if($row['Door'] == 'passing by'){
                            $lvl1PassingCount += (int)$row['Count'];
                            //$lvl1TotalCount += (int)$row['Count'];
                            //$message[$key]['TotalLvl1Count'] += (int)$row['Count'];
                            $message[$key]['PassingLvl1Count'] += (int)$row['Count'];
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
                    "lvl1TotalCount" => $lvl1TotalCount,
                    "lvl1InCount" => $lvl1InCount,
                    "lvl1PassingCount" => $lvl1PassingCount
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
