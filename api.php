<?php

$con = mysqli_connect("localhost", "root", "", "API_DATA");
$response = array();
if ($con) {
    $sql = "SELECT * FROM subscription;";
    $result = mysqli_query($con, $sql);
    if ($result) {
        $i = 0;
        header("Content-Type: JSON");
        while ($row = mysqli_fetch_assoc($result)) {
            $query = "Select * from products where customer_id = {$row['customer_id']}";
            $query_run = mysqli_query($con, $query);
            if ($query_run) {
                if (mysqli_num_rows($query_run) > 0) {
                    header("Content-Type: JSON");
                    $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);
                }
            }
            $response[$i]['customer_id'] = $row['customer_id'];
            $response[$i]['customer_name'] = $row['customer_name'];
            $response[$i]['address'] = $row['address'];
            $response[$i]['phone_number'] = $row['phone_number'];
            $response[$i]['delivery_day'] = $row['delivery_day'];
            $response[$i]['delivery_period'] = $row['delivery_period'];
            $response[$i]['subscription_duration'] = $row['subscription_duration'];
            $response[$i]['basket'] = $res;
            $i++;
        }
        echo json_encode($response, JSON_PRETTY_PRINT);
    }
    else{
        $data = [
            'status' => 404,
            'message' => 'No subsciptions found'
        ];
        header("HTTP/1.0 404 No Subscription found");
        return json_encode($data);
    }
} else {
    echo "DB connection failed";
}
