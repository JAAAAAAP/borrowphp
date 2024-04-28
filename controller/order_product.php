<?php


if (isset($_POST['submit'])) {
    session_start();
    include_once($_SERVER['DOCUMENT_ROOT'] . '/jaa/bookingphp/config/connectdb.php');
    include_once('../plugin/script.php');

    $tel = htmlspecialchars($_POST['tel']);
    $address = htmlspecialchars($_POST['address']);
    $teacher = htmlspecialchars($_POST['teacher']);
    $department = htmlspecialchars($_POST['department']);
    $date_start = htmlspecialchars($_POST['date-start']);
    $date_end = htmlspecialchars($_POST['date-end']);
    
    do {
        $group_id = rand(1, 1000);
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
    status = "รออนุมัติ"
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
        echo "<script>
            $(document).ready(function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'กรอกข้อมูลสำเร็จ',
                        text: 'กรุณากรอเจ้าหน้าที่อนุมัติ',
                        timer: 2000,
                        showConfirmButton: false
                    });
                });
            </script>";
        header("refresh:1.5; url=/jaa/bookingphp/public/index.php");
        $conn = null;
    }
}
