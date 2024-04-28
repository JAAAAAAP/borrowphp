<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/jaa/bookingphp/config/connectdb.php');
session_start();
$currentDate = date("Y-m-d");

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php include_once "../plugin/plug.php" ?>

</head>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Kanit:wght@400;500;600;700;800;900&display=swap');

    * {
        font-family: 'Kanit', sans-serif;
    }
</style>

<body>
    <?php include "./component/navbar.php" ?>
    <div class="flex justify-center text-center w-full">
        <div class="w-11/12">
            <div class="divider divider-neutral font-bold text-xl">แบบฟอร์มรายการสำหรับยืม</div>

            <div class="overflow-x-auto border-2 border-black rounded-lg ">
                <table class="table text-center ">
                    <!-- head -->
                    <thead class="">
                        <tr class="text-slate-700 text-sm border-b-2 border-black bg-slate-200 md:text-base">
                            <th class="w-12 border-r-2 border-black">No.</th>
                            <th class=" ">รายละเอียดรายการยืม</th>
                            <th class="w-10 border-x-2 border-black md:w-28">จำนวน</th>
                            <th class="w-6 hidden md:table-cell">แก้ไขจำนวน</th>
                            <th class="w-10 border-l-2 border-black hidden md:table-cell">นำออก</th>
                            <th class="w-12 p-0 md:hidden">แก้ไข</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $i = 1;
                        $sql = "SELECT o.o_id,o.p_id,o.user_id,p.name,o.amount,o.status,p.sn_products FROM products as p INNER JOIN oder_product as o on p.p_id = o.p_id WHERE user_id = :id AND o.status = 'รอดำเนินการ'";
                        $query = $conn->prepare($sql);
                        $query->bindParam(":id", $_SESSION['id'], PDO::PARAM_INT);
                        $query->execute();
                        $rs = $query->fetchAll(PDO::FETCH_ASSOC);

                        // $product_sql = "SELECT * FROM products WHERE p_id = :id";
                        // $product_query = $conn->prepare($product_sql);
                        // $product_query->bindParam(":id", $rs['p_id'],PDO::PARAM_INT);
                        // $product_query->execute();
                        // $row_product = $product_query->fetchAll(PDO::FETCH_ASSOC);

                        if ($query->rowCount() > 0) {
                            foreach ($rs as $row) {

                                $product_sql = "SELECT p_id,amount,name,sn_products FROM products WHERE p_id = :id";
                                $product_query = $conn->prepare($product_sql);
                                $product_query->bindParam(":id", $row['p_id'], PDO::PARAM_INT);
                                $product_query->execute();
                                $row_product = $product_query->fetch(PDO::FETCH_ASSOC);


                        ?>


                                <!-- row 1 -->
                                <tr class="text-black text-sm border-b-2 border-black md:text-base">
                                    <td class="border-r-2 border-black text-lg md:text-2xl"><?= $i++ ?>.</td>
                                    <td class="">
                                        <span>ชื่อ : <?= $row['name'] ?></span>
                                        <br>
                                        <span>หมายเลขครุภัณฑ์ : <?= $row['sn_products'] ?></span>
                                    </td>
                                    <td class="border-x-2 border-black"><?= $row['amount'] ?></td>

                                    <!-- Edit -->
                                    <td class="w-10 hidden md:table-cell">
                                        <label for="edit<?= $i ?>" type="submit" class="btn btn-info btn-md text-white text-center"><i class='bx bxs-edit bx-sm'></i></label>
                                        <input type="checkbox" id="edit<?= $i ?>" class="modal-toggle" />
                                        <div class="modal" role="dialog">
                                            <div class="modal-box">

                                                <h3 class="font-bold text-black text-lg">แก้ไขข้อมูล</h3>

                                                <form action="../controller/order_update.php" method="post">

                                                    <div class="flex items-center justify-center mt-6">
                                                        <label class="form-control w-full max-w-xs font-bold text-base text-black">
                                                            <div class="label p-0">
                                                                <span class="label-text">จำนวน</span>
                                                            </div>
                                                            <input type="number" name="amount" placeholder="จำนวนคงเหลือในคลัง <?= "  " . $row_product['amount'] ?>" min="1" max="<?= $row_product['amount'] ?>" class="input input-bordered w-full max-w-xs mb-4" />
                                                        </label>
                                                    </div>

                                                    <div class="modal-action">
                                                        <input type="hidden" name="id" value="<?= $row['o_id'] ?>">
                                                        <button type="submit" name="submit" class="btn btn-success text-white btnupdate">ยืนยันการแก้ไข</button>
                                                        <label for="edit<?= $i ?>" class="btn btn-error text-white">ปิด</label>
                                                    </div>

                                                </form>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- deletes -->
                                    <td class="border-l-2 border-black hidden md:table-cell">
                                        <label for="deletes<?= $i ?>" class="btn btn-error btn-md text-white text-center"><i class='bx bxs-trash bx-sm'></i></label>
                                        <input type="checkbox" id="deletes<?= $i ?>" class="modal-toggle" />
                                        <div class="modal text-black text-lg" role="dialog">
                                            <div class="modal-box">
                                                <h3 class="font-bold text-lg">ลบข้อมูล</h3>
                                                <p class="py-4">ต้องนำของ " <span class="text-red-600"><?= $row['name'] ?></span> " ออกใช่ไหม?</p>
                                                <div class="modal-action m-0">
                                                    <a id="<?= $row['o_id'] ?>" class="delete btn btn-error text-white">ลบ</a>
                                                    <label for="deletes<?= $i ?>" class="btn btn-info text-white">ยกเลิก</label>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Respont -->
                                    <td class=" w-12 p-0 md:hidden">

                                        <label for="resedit<?= $i ?>" type="submit" class="btn btn-info btn-sm text-white text-center"><i class='bx bxs-edit bx-xs'></i></label>
                                        <input type="checkbox" id="resedit<?= $i ?>" class="modal-toggle" />
                                        <div class="modal" role="dialog">

                                            <div class="modal-box">

                                                <h3 class="font-bold text-black text-lg">แก้ไขข้อมูล</h3>

                                                <form action="../controller/order_update.php" method="post">

                                                    <div class="flex items-center justify-center mt-6">
                                                        <label class="form-control w-full max-w-xs font-bold text-base text-black">
                                                            <div class="label p-0">
                                                                <span class="label-text">จำนวน</span>
                                                            </div>
                                                            <input type="number" name="amount" placeholder="คงเหลือในคลัง <?= "  " . $row_product['amount'] ?>" min="1" max="<?= $row_product['amount'] ?>" class="input input-bordered w-full max-w-xs mb-4" />
                                                        </label>
                                                        <a id="<?= $row['o_id'] ?>" class="delete btn btn-md ml-2 btn-error text-white">นำออก</a>
                                                    </div>

                                                    <div class="modal-action">
                                                        <input type="hidden" name="id" value="<?= $row['o_id'] ?>">
                                                        <button type="submit" name="submit" class="btn btn-success text-white btnupdate">ยืนยันการแก้ไข</button>
                                                        <label for="resedit<?= $i ?>" class="btn btn-error text-white">ปิด</label>
                                                    </div>

                                                </form>
                                            </div>

                                        </div>
                                    </td>
                                </tr>
                            <?php
                            }
                        } else {
                            ?>

                            <td class="border-r-2 border-black text-lg md:text-2xl">-</td>
                            <td class="text-xl text-red-500 font-bold">ไม่มีรายการ</td>
                            <td class="border-x-2 border-black">-</td>
                            <td class=" md:border-x-2 border-black">-</td>
                            <td class="hidden md:table-cell">-</td>

                        <?php
                        }
                        ?>





                    </tbody>
                </table>
            </div>

            <div class="divider divider-neutral my-8"></div>

            <div class="flex w-full justify-center">

                <div class="flex flex-col w-3/4 text-start bg-gray-100 rounded-xl p-4">
                    <h1 class="font-bold text-center text-xl md:text-2xl">แบบฟอร์มกรอกข้อมูล</h1>

                    <form action="../controller/order_product.php" method="post">

                        <h3 class=" font-bold mt-4 ">ชื่อผู้ยืม :</h3>
                        <h3 class=" text-lg bg-white rounded-md mt-2 pl-4 p-2"><?= $_SESSION['user'] ?></h3>

                        <h3 class=" font-bold my-2 ">เบอร์โทร :</h3>
                        <label class="input input-bordered flex items-center gap-2">
                            <i class='bx bxs-phone bx-sm'></i>
                            <input type="tel" maxlength="11" class="grow" name="tel" placeholder="เบอร์โทรศัพท์" required />
                        </label>


                        <h3 class=" font-bold my-2 ">นำไปใช้ที่ :</h3>
                        <input type="text" name="address" class="input input-bordered w-full" required />

                        <h3 class=" font-bold my-2 ">อาจารย์ผู้สอน</h3>
                        <input type="text" name="teacher" class="input input-bordered w-full" required />

                        <h3 class=" font-bold my-2 ">หน่วยงานสาขา :</h3>
                        <select class="select select-bordered w-full max-w-xs" name="department" required>
                            <option disabled selected>หน่วยงานสาขา</option>
                            <option>ทดสอบ 1</option>
                            <option>ทดสอบ 2</option>
                        </select>

                        <h3 class=" font-bold my-2 ">วันที่ยืม</h3>
                        <input type="date" min="<?= $currentDate; ?>" name="date-start" class="input w-full max-w-xs" required>

                        <h3 class=" font-bold my-2 ">วันที่คืน</h3>
                        <input type="date" min="<?= $currentDate; ?>" name="date-end" class="input w-full max-w-xs" required>

                        <div class="font-bold my-2 text-error">
                            <h1>*หมายเหตุ</h1>
                            <p class="ml-8">1. แบบฟอร์มต่อฉบับนี้ เป็นแบบฟอร์มที่ใช้สำหรับยืม - คืน อุปกรณ์โสตทัศนูปกรณ์ภานในคณะครุศาสตร์เท่านั้น การนำอุปกรณ์ฯ จะต้องได้รับอนุญาติจากคณบดี</p>
                            <br>
                            <p class="ml-8">2. ก่อนนำอุปกรณ์ไปใช้ และก่อนนำส่งคืน กรุณาตรวจสอบ และนำส่งคืนให้ครบตามจำนวนที่ยืมทุกครั้ง</p>
                            <br>
                            <p class="ml-8">3. ผู้ยืมจะต้องดูแลและรับผิดชอบอุปกรณ์ฯ ที่ยืมไปใช้ไม่ให้เกิดความเสียหายใดๆ</p>

                            <input type="checkbox" class="checkbox checkbox-sm ml-8 mt-2 text-center" required />
                            <span class="relative ml-1 bottom-1">ทั้งนี้ ข้าพเจ้าได้รับทราบและยินดีปฎิบัติตามระเบียบการขอใช้บริการอุปกรณ์โสตทัศนูปกรณ์ของคณะครุศาสตร์และดูแลรับผิดชอบจนกว่าจะส่งคืน</span>
                            <br>
                            <input type="checkbox" class="checkbox checkbox-sm ml-8 mt-2 text-center" required />
                            <span class="relative ml-1 bottom-1">ข้าพเจ้ายินดีรับผิดชอบต่อความเสียหายที่เกิดขึ้นกับอุปกรณ์ดังกล่าวทุกกรณี และยอมรับเงื่อนไขการขอใช้บริการ</span>

                        </div>

                        <div class="text-end">
                            <?php if ($query->rowCount() > 0) { ?>
                                <button id="formsubmit" class="btn btn-success text-white mt-4 w-28" name="submit" type="submit">ยืนยันการยืม</button>
                            <?php } else { ?>
                                <button id="formsubmit" class="btn btn-disabled btn-success text-white mt-4 w-28" name="submit" type="submit">ยืนยันการยืม</button>
                            <?php } ?>

                        </div>

                    </form>
                </div>
            </div>


        </div>
    </div>

    <div class="block h-16 mt-4">
    </div>



    <?php include_once "../plugin/script.php" ?>


    <script src="./js/order.js"></script>
</body>

</html>