<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once($_SERVER['DOCUMENT_ROOT'] . '/jaa/borrowphp/config/connectdb.php');

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php include_once "../plugin/plug.php" ?>

</head>


<body>
    <?php include_once("./component/navbar.php") ?>

    <div class="flex justify-center text-center w-full">
        <div class="w-11/12">
            <div class="divider divider-neutral font-bold text-xl">การอนุมัติ</div>

            <?php
            $i = 1;
            $group_sql = "SELECT DISTINCT group_id FROM oder_product WHERE user_id = :id AND status !='รอดำเนินการ'";
            $group_result = $conn->prepare($group_sql);
            $group_result->bindParam(':id', $_SESSION['id'], PDO::PARAM_INT);
            $group_result->execute();
            $groups = $group_result->fetchAll(PDO::FETCH_ASSOC);

            if ($group_result->rowCount() > 0) {

                foreach ($groups as $group) {
                    $group_id = $group['group_id'];
                    // เลือกข้อมูลสินค้าในกลุ่มนี้
                    $product_sql = "SELECT o.o_id,o.p_id,o.user_id,p.name,o.amount,o.status,o.group_id,p.amount AS products_amount
                                FROM products as p 
                                INNER JOIN oder_product as o on p.p_id = o.p_id
                                WHERE user_id = :id AND group_id = :group_id";
                    $product_result = $conn->prepare($product_sql);
                    $product_result->bindParam(':group_id', $group_id, PDO::PARAM_INT);
                    $product_result->bindParam(':id', $_SESSION['id'], PDO::PARAM_INT);
                    $product_result->execute();
                    $products = $product_result->fetchAll(PDO::FETCH_ASSOC);
            ?>
                    <div class="card card-compact w-full bg-base-100 shadow-xl mb-8 border-4 ">
                        <div class="card-body">
                            <a href="..\controller\approve_delete.php?group=<?= $group['group_id'] ?>" class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2 text-xl">✕</a>
                            <div class="text-xl font-bold">
                                <h1>ใบที่ <?= $i++ ?></h1>
                            </div>

                            <table class="table text-center">
                                <!-- head -->
                                <thead>
                                    <tr class="text-sm text-black md:text-base">
                                        <th class="w-12">No.</th>
                                        <th>ชื่อ</th>
                                        <th class="w-10">จำนวน</th>
                                        <th class="w-36">สถานะ</th>
                                        <th class="hidden w-28 md:table-cell">นำออก</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php $n = 1;
                                    foreach ($products as $product) { ?>
                                        <tr class="text-sm md:text-xl">
                                            <td><?= $n++ ?></td>
                                            <td><?= $product['name']; ?></td>
                                            <td><?= $product['amount']; ?></td>
                                            <td class="p-0">
                                                <div tabindex="0" role="button" class="btn btn-sm text-xs font-thin text-nowrap text-white my-2 btn-<?= $product['status'] === "อนุมัติแล้ว" || $product['status'] === "กำลังยืม" || $product['status'] === "คืนแล้ว" ? "success" : ($product['status'] === "ไม่อนุมัติ" || $product['status'] === "เลยกำหนด" ? "error" : "warning") ?> md:text-base ">
                                                    <?= $product['status'] ?>
                                                </div>
                                                <a href="..\controller\approve_delete.php?p=<?= $product['o_id'] ?>" class="btn btn-sm btn-error text-xs font-thin text-white mb-2 md:hidden <?= $product['status'] === "กำลังยืม" ?  "btn-disabled" : "" ?>">นำออก</a>
                                            </td>
                                            <td class="hidden md:table-cell"><a href="..\controller\approve_delete.php?p=<?= $product['o_id'] ?>" class="btn btn-error text-white <?= $product['status'] === "กำลังยืม" ?  "btn-disabled" : "" ?>"><i class='bx bxs-trash bx-sm'></i></a></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <?php if ($product['status'] === "กำลังยืม") { ?>
                                <div class="text-end">
                                    <input type="hidden" name="group_id" value="<?= $product['group_id'] ?>">
                                    <a href="pdf.php?group=<?= $product['group_id'] ?>"><button name="submit" type="submit" class="btn btn-info text-white mt-4 ">ปริ้นเอกสาร</button></a>
                                </div>
                            <?php } else { ?>
                                <form method="post" action="..\controller\approve.php">
                                    <div class="text-end">
                                        <?php foreach ($products as $product) { ?>
                                            <input type="hidden" name="p_id[]" value="<?= $product['p_id'] ?>">
                                        <?php } ?>
                                        <input type="hidden" name="group_id" value="<?= $product['group_id'] ?>">
                                        <button name="submit" type="submit" class="btn btn-success text-white mt-4 <?= $product['status'] === "รออนุมัติ" || $product['status'] === "เลยกำหนด" || $product['status'] === "คืนแล้ว" || $product['status'] === "รอดำเนินการ" ? "btn-disabled" : "" ?>">ยืนยันการยืม</button>
                                    </div>
                                <?php } ?>
                                </form>

                        </div>
                    </div>
                <?php
                }
            } else { ?>
                <div class="card items-center w-full bg-white shadow-xl ">
                    <div class="card-body items-center text-error">
                        <h2 class="card-title">ใบที่  -</h2>
                        <p>ยังไม่มีรายการ</p>
                    </div>
                </div>
            <?php } ?>



        </div>
    </div>

    <div class="block h-16">
    </div>




    <?php include_once "../plugin/script.php" ?>
</body>

</html>