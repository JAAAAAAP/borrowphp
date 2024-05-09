<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/jaa/borrowphp/config/connectdb.php');



$sql = "SELECT COUNT(*) FROM products";
$query = $conn->prepare($sql);
$query->execute();
$count = $query->fetchColumn();

$approve_sql = "SELECT DISTINCT group_id FROM oder_product WHERE status IN ('รออนุมัติ', 'ไม่อนุมัติ', 'รอดำเนินการ')";
$approve_query = $conn->prepare($approve_sql);
$approve_query->execute();
$approve_rs = $approve_query->fetchAll(PDO::FETCH_ASSOC);
$num_groups = count($approve_rs);

$exit_sql = "SELECT group_id FROM oder_product WHERE status = 'เลยกำหนด' ";
$exit_query = $conn->prepare($exit_sql);
$exit_query->execute();
$exit_rs = $exit_query->fetchAll(PDO::FETCH_ASSOC);
$num_exit = count($exit_rs);
?>


<div class="flex flex-col w-auto h-full bg-slate-100">

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
        <!-- จำนวนคนที่ยืม -->
        <div class="flex w-full md:w-80 justify-center items-center rounded-2xl h-36 bg-base-100 shadow-xl">

            <a href="admin.php?pt=waitapprove" class="<?= strpos($url, 'admin.php?pt=waitapprove') ? "text-green-600" : "" ?>">
                <figure class="flex items-center justify-center mt-3 text-7xl ">
                    <i class='bx bx-user'></i>
                </figure>
                <div class="card-body items-center text-center p-0">
                    <h2 class="card-title">รออนุมัติ</h2>
                    <p class="font-bold text-xl mb-2"><?= $num_groups ?></p>
                </div>
            </a>
        </div>

        <div class="flex w-full md:w-80 justify-center items-center rounded-2xl h-36 bg-base-100 shadow-xl">
            <a href="admin.php">
                <figure class="flex items-center justify-center mt-3 text-7xl">
                    <i class='bx bx-check'></i>
                </figure>
                <div class="card-body items-center text-center p-0">
                    <h2 class="card-title">อนุมัติแล้ว</h2>
                    <p class="font-bold text-xl mb-2">5</p>
                </div>
            </a>
        </div>

        <div class="flex w-full md:w-80 justify-center items-center rounded-2xl h-36 bg-base-100 shadow-xl">
            <a href="admin.php">
                <figure class="flex items-center justify-center mt-3 text-7xl">
                    <i class='bx bx-time'></i>
                </figure>
                <div class="card-body items-center text-center p-0">
                    <h2 class="card-title">กำลังยืม</h2>
                    <p class="font-bold text-xl mb-2">5</p>
                </div>
            </a>
        </div>

        <!-- เลยกำหนด -->

        <div class="flex w-full md:w-80 justify-center items-center rounded-2xl  h-36 bg-base-100 shadow-xl">
            <a href="admin.php?pt=status&&status=late">
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