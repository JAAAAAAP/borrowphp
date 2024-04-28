<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["group_id"])) {
        include_once($_SERVER['DOCUMENT_ROOT'] . '/jaa/bookingphp/config/connectdb.php');
        include_once('../plugin/script.php');

        $group_id = $_POST["group_id"];
        $p_ids = $_POST["p_id"]; // รับอาร์เรย์ของ p_id
        // คำนวณผลรวมของจำนวนสินค้าทั้งหมดในกลุ่ม
        foreach ($p_ids as $p_id) {
            $amount_sql = 'SELECT amount FROM oder_product WHERE group_id = :group_id AND p_id = :p_id';
            $amount_query = $conn->prepare($amount_sql);
            $amount_query->bindParam(':group_id', $group_id, PDO::PARAM_INT);
            $amount_query->bindParam(':p_id', $p_id, PDO::PARAM_INT);
            $amount_query->execute();
            $amount_rs = $amount_query->fetch(PDO::FETCH_ASSOC);

            $select_sql = 'SELECT p_id,amount FROM products WHERE p_id = :id';
            $select_query = $conn->prepare($select_sql);
            $select_query->bindParam(':id', $p_id, PDO::PARAM_INT);
            $select_query->execute();
            $rs = $select_query->fetch(PDO::FETCH_ASSOC);
            $rs['amount'];
            if ($amount_rs['amount'] > $rs['amount']) {
                echo "<script>
                $(document).ready(function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'จำนวนไม่เพียงพอต่อการยืม',
                        timer: 1500,
                        showConfirmButton: false
                    });
                });
            </script>";
            header("refresh:1.5; url=/jaa/bookingphp/public/approve.php");

                exit;
            }

            foreach ($amount_rs as $amount) {
                $minus_sql = 'UPDATE products SET amount = amount - :total_amount WHERE p_id = :p_id';
                $minus = $conn->prepare($minus_sql);
                $minus->bindParam(':p_id', $p_id, PDO::PARAM_INT);
                $minus->bindParam(':total_amount', $amount, PDO::PARAM_INT);
                $minus->execute();
            }
        }

        if ($rs['amount'] >= $rs['amount']) {
            // อัปเดตจำนวนสินค้าในตาราง products

            // อัปเดตสถานะในตาราง oder_product
            $sql = "UPDATE oder_product SET status = :status WHERE group_id = :group_id AND status = :status1";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':group_id', $group_id, PDO::PARAM_INT);
            $stmt->bindValue(':status', "กำลังยืม", PDO::PARAM_STR);
            $stmt->bindValue(':status1', "อนุมัติแล้ว", PDO::PARAM_STR);
            $stmt->execute();

            // Redirect back to the previous page
            header("refresh:1.5; url=/jaa/bookingphp/public/approve.php");
            exit;
        } else {
            echo "<script>
                $(document).ready(function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'ไม่พบข้อมูลสำหรับการอนุมัติ',
                        timer: 1500,
                        showConfirmButton: false
                    });
                });
            </script>";
            header("refresh:1.5; url=/jaa/bookingphp/public/approve.php");
            exit;
        }
    } else {
        echo "ไม่พบข้อมูล group_id ที่ถูกส่งมา";
        echo "<script>window.history.back();</script>";
        exit;
    }
} else {
    echo "ไม่พบข้อมูล group_id ในการส่งแบบฟอร์ม";
    echo "<script>window.history.back();</script>";
    exit;
}
