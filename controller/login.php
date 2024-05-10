<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include_once($_SERVER['DOCUMENT_ROOT'] . '/jaa/borrowphp/config/connectdb.php');

    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    try {
        $sql = "SELECT * FROM user WHERE user = :user AND password = :password";
        $checkdata = $conn->prepare($sql);
        $checkdata->bindParam(":user", $username, PDO::PARAM_STR);
        $checkdata->bindParam(":password", $password, PDO::PARAM_STR);
        $checkdata->execute();
        $row = $checkdata->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $_SESSION['id'] = $row['user_id'];
            $_SESSION['user'] = $row['user'];
            $_SESSION['role'] = $row['role'];

            $sql = "INSERT INTO log(u_id, time_in) VALUES (:u_id, NOW())";
            $log = $conn->prepare($sql);
            $log->bindParam(":u_id", $_SESSION['id'], PDO::PARAM_INT);
            $log->execute();

            $sql = "SELECT log_id FROM log WHERE u_id = :u_id ORDER BY log_id DESC LIMIT 1";
            $logIdQuery = $conn->prepare($sql);
            $logIdQuery->bindParam(":u_id", $_SESSION['id'], PDO::PARAM_INT);
            $logIdQuery->execute();
            $log_row = $logIdQuery->fetch(PDO::FETCH_ASSOC);

            $_SESSION['log_id'] = $log_row['log_id'];
            $_SESSION['expire_time'] = time() + 10800;

            if ($_SESSION['role'] == 0) {
                $response['redirect'] = '/jaa/borrowphp/public/index.php';
            } elseif ($_SESSION["role"] == 1) {
                $response['redirect'] = '/jaa/borrowphp/public/admin/admin.php';
            }
            http_response_code(200);
            echo json_encode($response);
            exit();
        } else {
            http_response_code(401);
            echo json_encode(array("error" => "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง"));
            exit();
        }
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(array("error" => $e->getMessage()));
        exit();
    }
}
