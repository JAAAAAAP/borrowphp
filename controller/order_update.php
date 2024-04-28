<?php

if (isset($_POST["amount"]) && $_POST["id"]) {
    include_once($_SERVER['DOCUMENT_ROOT'] . '/jaa/bookingphp/config/connectdb.php');
    include_once('../plugin/script.php');

    $id = $_POST['id'];
    $amount = $_POST['amount'];

    if ($amount != null) {
        $order_update_sql = "UPDATE oder_product SET amount = :amount WHERE o_id = :id";
        $update_query = $conn->prepare($order_update_sql);
        $update_query->bindParam(":id", $id, PDO::PARAM_INT);
        $update_query->bindParam(":amount", $amount, PDO::PARAM_INT);
        $update_query->execute();

        if ($update_query) {

            echo "<script>
            $(document).ready(function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'แก้ไขจำนวนสำเร็จ',
                        timer: 1000,
                        showConfirmButton: false
                    });
                });
            </script>";
            header("refresh:1.5; url=/jaa/bookingphp/public/order.php");
            $conn = null;
        }
    } else {

        echo "<script>
            $(document).ready(function() {
                Swal.fire({
                    icon: 'warning',
                    title: 'กรุณากรอกจำนวน',
                    timer: 1500,
                    showConfirmButton: false
                });
            });
        </script>";
        header("refresh:1.5; url=/jaa/bookingphp/public/order.php");
        $conn = null;
    }
}
