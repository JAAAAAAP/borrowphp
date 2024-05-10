<?php

// ตรวจสอบว่า session มีค่าหรือไม่
if (isset($_SESSION['expire_time']) && $_SESSION['expire_time'] < time()) {
    try {
        include_once($_SERVER['DOCUMENT_ROOT'] . '/jaa/borrowphp/config/connectdb.php');

        $sql = "UPDATE log SET time_out = NOW() WHERE log_id = :log_id";
        $log = $conn->prepare($sql);
        $log->bindParam(":log_id", $_SESSION['log_id'], PDO::PARAM_INT);
        $log->execute();
        if ($log) {
            session_destroy();
            header("location:\jaa\borrowphp\public\index.php");
        } else {
            echo "error";
        }
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(array("error" => $e->getMessage()));
        exit();
    }
    exit;
} else {
    // ยังไม่หมดอายุ อัปเดตเวลาใหม่
    $_SESSION['expire_time'] = time() + 10800; // ตั้งเวลาหมดอายุใหม่หลังจาก 1 ชั่วโมง
}
