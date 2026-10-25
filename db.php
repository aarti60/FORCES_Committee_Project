<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$host = 'localhost';
$username = 'root';
$password = ''; // XAMPP MySQL password असल्यास इथे लिही
$database = 'forces_committee';

try {
    $conn = new mysqli(
        $host,
        $username,
        $password,
        $database
    );

    $conn->set_charset('utf8mb4');
} catch (mysqli_sql_exception $e) {
    error_log($e->getMessage());
    http_response_code(500);
    exit('Database connection failed. Check XAMPP and database settings.');
}