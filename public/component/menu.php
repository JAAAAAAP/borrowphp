<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/jaa/borrowphp/config/connectdb.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/jaa/borrowphp/controller/checklogout.php');



$sql = "SELECT COUNT(*) FROM products";
$query = $conn->prepare($sql);
$query->execute();
$count = $query->fetchColumn();

$approve_sql = "SELECT DISTINCT group_id FROM oder_product WHERE status IN ('รออนุมัติ', 'ไม่อนุมัติ','อนุมัติแล้ว')";
$approve_query = $conn->prepare($approve_sql);
$approve_query->execute();
$approve_rs = $approve_query->fetchAll(PDO::FETCH_ASSOC);
$num_approve = count($approve_rs);

$borrow_sql = "SELECT DISTINCT group_id FROM oder_product WHERE status IN ('กำลังยืม', 'คืนแล้ว','เลยกำหนด')";
$borrow_query = $conn->prepare($borrow_sql);
$borrow_query->execute();
$borrow_rs = $borrow_query->fetchAll(PDO::FETCH_ASSOC);
$num_borrow = count($borrow_rs);

$exit_sql = "SELECT DISTINCT group_id FROM oder_product WHERE status = 'เลยกำหนด' ";
$exit_query = $conn->prepare($exit_sql);
$exit_query->execute();
$exit_rs = $exit_query->fetchAll(PDO::FETCH_ASSOC);
$num_exit = count($exit_rs);
?>


<div class="flex flex-col w-auto h-full">

    <!-- sidebar-toggle -->

    <label for="my-drawer" class="drawer-button h-14 ">
        <div class="my-4 ml-3">
            <div class="flex justify-start items-start text-4xl ">
                <i class="bx bx-menu cursor-pointer"></i>
                <span class="font-bold text-2xl ml-1">ระบบยืมคืน</span>
            </div>
        </div>
    </label>

    <!-- card -->

    <div class="flex flex-col md:flex-row mx-4 mt-4 gap-6 justify-center items-center ">

        <div class="flex w-full md:w-80 justify-center items-center rounded-2xl h-36 bg-base-100 shadow-xl">

            <a href="admin.php?pt=report" class="<?= strpos($url, 'admin.php?pt=report') ? "text-green-600" : "" ?>">
                <figure class="flex items-center justify-center mt-3 text-7xl ">
                    <i class='bx bxs-report'></i>
                </figure>
                <div class="card-body items-center text-center p-0">
                    <h2 class="card-title">รายงาน</h2>
                </div>
            </a>
        </div>
        <!-- จำนวนคนที่ยืม -->
        <div class="flex w-full md:w-80 justify-center items-center rounded-2xl h-36 bg-base-100 shadow-xl">

            <a href="admin.php?pt=approve" class="<?= strpos($url, 'admin.php?pt=approve') ? "text-green-600" : "" ?>">
                <figure class="flex items-center justify-center mt-3 text-7xl ">
                    <i class='bx bx-user'></i>
                </figure>
                <div class="card-body items-center text-center p-0">
                    <h2 class="card-title">การอนุมัติ</h2>
                    <p class="font-bold text-xl mb-2"><?= $num_approve ?></p>
                </div>
            </a>
        </div>

        <div class="flex w-full md:w-80 justify-center items-center rounded-2xl h-36 bg-base-100 shadow-xl">
            <a href="admin.php?pt=borrow" class="<?= strpos($url, 'admin.php?pt=borrow') ? "text-green-600" : "" ?>">
                <figure class="flex items-center justify-center mt-3 text-7xl">
                    <i class='bx bx-time'></i>
                </figure>
                <div class="card-body items-center text-center p-0">
                    <h2 class="card-title">การยืม</h2>
                    <p class="font-bold text-xl mb-2"><?= $num_borrow ?></p>
                </div>
            </a>
        </div>

        <!-- เลยกำหนด -->

        <div class="flex w-full md:w-80 justify-center items-center rounded-2xl  h-36 bg-base-100 shadow-xl">
            <a href="admin.php?pt=late" class="<?= strpos($url, 'admin.php?pt=late') ? "text-green-600" : "" ?>">
                <figure class="flex items-center justify-center mt-3 text-7xl">
                    <i class='bx bx-time-five'></i>
                </figure>
                <div class="card-body items-center text-center p-0">
                    <h2 class="card-title">เลยกำหนด</h2>
                    <p class="font-bold text-xl mb-2"><?= $num_exit ?></p>
                </div>
            </a>
        </div>

        <!-- จำนวนของ -->

        <div class="flex w-full md:w-80 justify-center items-center rounded-2xl  h-36 bg-base-100 shadow-xl">
            <a href="admin.php?pt=upload" class="<?= strpos($url, 'admin.php?pt=upload') ? "text-green-600" : "" ?>">
                <figure class="flex items-center justify-center mt-3 text-7xl">
                    <i class='bx bx-archive-in'></i>
                </figure>
                <div class="card-body items-center text-center p-0">
                    <h2 class="card-title">จำนวนของ</h2>
                    <p class="font-bold text-xl mb-2"><?php echo $count ?></p>
                </div>
            </a>
        </div>


    </div>

    <div class="flex justify-center items-center  w-auto ">
        <div class="divider divider-neutral w-11/12"></div>
    </div>

</div>