<?php
require_once "connection.php";

if (function_exists($_GET['function'])) {
    $_GET['function']();
}

function get_employees()
{
    global $connect;      
    $query = $connect->query("SELECT * FROM employees");  

    while ($row = mysqli_fetch_object($query))
    {
        $data[] = $row;
    }

    $response = [
        'status' => 1,
        'message' =>'Success',
        'data' => $data
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
}

function get_employee_id()
{
    global $connect;
    if (!empty($_GET["id"])) {
        $id = $_GET["id"];      
    }

    $query = "SELECT * FROM employees WHERE id = $id";      
    $result = $connect->query($query);
    while($row = mysqli_fetch_object($result))
    {
        $data[] = $row;
    }

    if($data) {
        $response = [
            'status' => 1,
            'message' =>'Success',
            'data' => $data
        ];               
    } else {
        $response = [
            'status' => 0,
            'message' =>'No Data Found'
        ];
    }
    
    header('Content-Type: application/json');
    echo json_encode($response);
    
}

function store_employee()
{
    global $connect;   
    $check = [
        'id' => '',
        'name' => '',
        'gender' => '',
        'address' => '',
    ];

    $check_match = count(array_intersect_key($_POST, $check));
    if ($check_match == count($check)) {
        $result = mysqli_query($connect, "INSERT INTO employees SET
        id = '$_POST[id]',
        name = '$_POST[name]',
        gender = '$_POST[gender]',
        address = '$_POST[address]'");

        if ($result) {
            $response = [
                'status' => 1,
                'message' =>'Insert Success'
            ];
        } else {
            $response = [
                'status' => 0,
                'message' =>'Insert Failed.'
            ];
        }
    } else {
        $response = [
            'status' => 0,
            'message' =>'Wrong Parameter'
        ];
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}

function update_employee()
{
    global $connect;
    if (!empty($_GET["id"])) {
        $id = $_GET["id"];      
    }   

    $check = ['name' => '', 'gender' => '', 'address' => ''];
    $check_match = count(array_intersect_key($_POST, $check));    

    if ($check_match == count($check)) {

        $result = mysqli_query($connect, "UPDATE employees SET               
        name = '$_POST[name]',
        gender = '$_POST[gender]',
        address = '$_POST[address]' WHERE id = $id");    
    
        if ($result) {
            $response = [
                'status' => 1,
                'message' =>'Update Success'                  
            ];
        } else {
            $response = [
                'status' => 0,
                'message' =>'Update Failed'                  
            ];
        }
    } else {
        $response = [
            'status' => 0,
            'message' =>'Wrong Parameter',
            'data'=> $id
        ];
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}

function delete_employee()
{
    global $connect;
    $id = $_GET['id'];
    $query = "DELETE FROM employees WHERE id=".$id;
    if (mysqli_query($connect, $query)) {
        $response = [
            'status' => 1,
            'message' =>'Delete Success'
        ];
    } else {
        $response = [
            'status' => 0,
            'message' => 'Delete Fail.'
        ];
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}