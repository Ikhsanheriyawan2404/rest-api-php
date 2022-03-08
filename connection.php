<?php
$hostname = "localhost";
$database = "rest_example";
$username = "admin";
$password = "admin";
$connect = mysqli_connect($hostname, $username, $password, $database);

if (!$connect) {
    die("Connection Failed: " . mysqli_connect_error());
}