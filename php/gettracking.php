<?php
// Old DB logic disabled while this endpoint returns random data.
// require_once "db_connect.php";

session_start();

if(isset($_POST['startDate'], $_POST['endDate'], $_POST['harvesterId'])){
    $startDate = filter_input(INPUT_POST, 'startDate', FILTER_SANITIZE_STRING);
    $endDate = filter_input(INPUT_POST, 'endDate', FILTER_SANITIZE_STRING);
    $harvesterId = filter_input(INPUT_POST, 'harvesterId', FILTER_SANITIZE_STRING);

    $message = array();
    $nodes = array('c1', 'c2', 'c3', 'e1', 'e2', 'e3', 'e4', 'e5');
    $periodStart = DateTime::createFromFormat('Y-m-d', substr($startDate, 0, 10));
    $periodEnd = DateTime::createFromFormat('Y-m-d', substr($endDate, 0, 10));

    if ($periodStart && $periodEnd) {
        $periodEnd->modify('+1 day');
        $period = new DatePeriod($periodStart, new DateInterval('P1D'), $periodEnd);

        foreach ($period as $date) {
            $path = array();
            $distance = mt_rand(800, 1500);
            $lastNode = '';

            for ($hour = 6; $hour <= 18; $hour += mt_rand(1, 2)) {
                do {
                    $node = $nodes[array_rand($nodes)];
                } while ($node == $lastNode);

                $distance -= mt_rand(20, 120);
                $path[] = array(
                    'Date' => sprintf('%02d:%02d:%02d', $hour, mt_rand(0, 59), mt_rand(0, 59)),
                    'Location' => $node,
                    'Distance' => max($distance, 0)
                );
                $lastNode = $node;
            }

            $message[] = array(
                'Date' => $date->format('Y-m-d'),
                'Path' => $path
            );
        }
    }

    echo json_encode(
        array(
            "status" => "success",
            "message" => $message
        ));

    /*
    if ($select_stmt = $dbF->prepare("SELECT * FROM felda_table1 WHERE Rec_time>=? AND Rec_time<=? AND ID=? ORDER BY Rec_time")) {
        $select_stmt->bind_param('sss', $startDate, $endDate, $harvesterId);
        
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
            $current = "";
            $distance = 0;
            
            while ($row = $result->fetch_assoc()) {
                if(!in_array(substr($row['Rec_time'], 0, 10), $dateBar)){
                    $message[] = array( 
                        'Date' => substr($row['Rec_time'], 0, 10),
                        'Path' => array()
                    );

                    array_push($dateBar, substr($row['Rec_time'], 0, 10));
                    $current = "";
                }

                $key = array_search(substr($row['Rec_time'], 0, 10), $dateBar);

                if(count($message[$key]['Path']) <= 0){
                    if(substr($row['Rec_time'], 11, 2) >= "06"){
                        array_push($message[$key]['Path'], array( 
                            'Date' => substr($row['Rec_time'], 11, 8),
                            'Location' => $row['Node_name'],
                            'Distance' => $row['R_m']
                        ));
    
                        $current = $row['Node_name'];
                        $distance = (int)$row['R_m'];
                    }
                }
                else{
                    if($row['Node_name'] != $current){
                        if(substr($row['Rec_time'], 11, 2) >= "06"){
                            if($distance >= (int)$row['R_m']){
                                array_push($message[$key]['Path'], array( 
                                    'Date' => substr($row['Rec_time'], 11, 8),
                                    'Location' => $row['Node_name'],
                                    'Distance' => $row['R_m']
                                ));

                                $current = $row['Node_name'];
                                $distance = (int)$row['R_m'];
                            }
                        }
                    }
                    else{
                        if($distance >= (int)$row['R_m']){
                            $distance = (int)$row['R_m'];
                        }
                    }
                }
            }
            
            echo json_encode(
                array(
                    "status" => "success",
                    "message" => $message
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
