<?php
// 2fNscWyNE9kPYnR8xZmThiLLO4Xq91glzCrwRkwK874
$port = 13306;
$dsn = "mysql:host=localhost;dbname=borrowphp;charset=utf8";
$username = "root";
$password = "";


$path = "http://localhost/jaa/bookingphp/public/";


try {
    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
