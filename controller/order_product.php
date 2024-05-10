<?php


if (isset($_POST['submit'])) {
    session_start();
    include_once($_SERVER['DOCUMENT_ROOT'] . '/jaa/borrowphp/config/connectdb.php');
    include_once('../plugin/script.php');

    $tel = htmlspecialchars($_POST['tel']);
    $address = htmlspecialchars($_POST['address']);
    $teacher = htmlspecialchars($_POST['teacher']);
    $department = htmlspecialchars($_POST['department']);
    $date_start = htmlspecialchars($_POST['date-start']);
    $date_end = htmlspecialchars($_POST['date-end']);

    do {
        $group_id = rand(1, 10000);
        $check_group_sql = "SELECT COUNT(*) AS count FROM oder_product WHERE group_id = :group_id";
        $check_group_query = $conn->prepare($check_group_sql);
        $check_group_query->bindParam(":group_id", $group_id, PDO::PARAM_INT);
        $check_group_query->execute();
        $group_exists = $check_group_query->fetch(PDO::FETCH_ASSOC)['count'];
    } while ($group_exists > 0);

    $order_sql = 'UPDATE oder_product 
    SET tel = :tel,
    address = :address, 
    teacher = :teacher, 
    department = :department, 
    date_start = :date_start, 
    date_end = :date_end,
    group_id = :group_id,
    status = "รออนุมัติ",
    dates_now = Now()
    WHERE user_id = :user_id AND status = "รอดำเนินการ"';
    $order_query = $conn->prepare($order_sql);
    $order_query->bindParam(":user_id", $_SESSION['id'], PDO::PARAM_INT);
    $order_query->bindParam(":tel", $tel, PDO::PARAM_INT);
    $order_query->bindParam(":address", $address, PDO::PARAM_STR);
    $order_query->bindParam(":teacher", $teacher, PDO::PARAM_STR);
    $order_query->bindParam(":department", $department, PDO::PARAM_STR);
    $order_query->bindParam(":date_start", $date_start, PDO::PARAM_STR);
    $order_query->bindParam(":date_end", $date_end, PDO::PARAM_STR);
    $order_query->bindParam(":group_id", $group_id, PDO::PARAM_INT);
    $order_query->execute();

    if ($order_query) {
        $sql = "SELECT o.*, u.user_id, u.user
        FROM oder_product AS o
        INNER JOIN user AS u ON o.user_id = u.user_id
        WHERE o.group_id = :group_id AND o.user_id = :user_id";
        $query = $conn->prepare($sql);
        $query->bindParam(":user_id", $_SESSION['id'], PDO::PARAM_INT);
        $query->bindParam(":group_id", $group_id, PDO::PARAM_INT);
        $query->execute();
        $rs = $query->fetch(PDO::FETCH_ASSOC);

        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        date_default_timezone_set("Asia/Bangkok");

        $sToken = "2fNscWyNE9kPYnR8xZmThiLLO4Xq91glzCrwRkwK874";
        $sMessage = "\nมีผู้ใช้ทำรายการยืมคืนครุภัณฑ์ \n";
        $sMessage .= "เวลา : " .  date("d-m-Y H:i", strtotime($rs['dates_now'])) . "\n";
        $sMessage .= "ผู้ใช้งาน : " . $rs['user'] . "\n";


        $chOne = curl_init();
        curl_setopt($chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
        curl_setopt($chOne, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($chOne, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($chOne, CURLOPT_POST, 1);
        curl_setopt($chOne, CURLOPT_POSTFIELDS, "message=" . $sMessage);
        $headers = array('Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer ' . $sToken . '',);
        curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($chOne, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($chOne);

        //Result error 
        if (curl_error($chOne)) {
            echo 'error:' . curl_error($chOne);
        } else {
            $result_ = json_decode($result, true);
            echo "status : " . $result_['status'];
            echo "message : " . $result_['message'];
        }
        curl_close($chOne);

        echo "<script>
            $(document).ready(function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'กรอกข้อมูลสำเร็จ',
                        text: 'กรุณารอเจ้าหน้าที่อนุมัติ',
                        timer: 2000,
                        showConfirmButton: false
                    });
                });
            </script>";
        header("refresh:1.5; url=/jaa/borrowphp/public/index.php");
        $conn = null;
    }
}
