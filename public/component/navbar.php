<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/jaa/borrowphp/controller/checklogout.php');

$sql = "SELECT COUNT(*) FROM oder_product WHERE user_id = :id AND status = 'รอดำเนินการ' ";
$query = $conn->prepare($sql);
$query->bindParam(":id", $_SESSION['id'], PDO::PARAM_INT);
$query->execute();
$count = $query->fetchColumn();
$display = ($count > 0) ?  " " : "hidden";

$order_sql = "SELECT DISTINCT group_id FROM oder_product WHERE user_id = :id AND status != 'รอดำเนินการ'";
$order_query = $conn->prepare($order_sql);
$order_query->bindParam(":id", $_SESSION["id"], PDO::PARAM_INT);
$order_query->execute();
$order_count = $order_query->rowCount();
$order_display = (!empty($order_count)) ? "" : "hidden";

$url = $_SERVER['REQUEST_URI'];


?>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Kanit:wght@400;500;600;700;800;900&display=swap');

    * {
        font-family: 'Kanit', sans-serif;
    }
</style>

<nav class="navbar sticky top-0 w-full z-50 justify-between bg-base-200 shadow-lg">
    <div class="flex">
        <figure class="mx-4">
            <a href="#"><img class="w-36 md:w-56" src="/jaa/borrowphp/public/img/logo.png" alt=""></a>
        </figure>
    </div>
    <ul class="flex flex-row-reverse">
        <?php
        if (isset($_SESSION['id'])) {
            $id = $_SESSION['id'];
        ?>

            <div class="dropdown dropdown-end md:hidden">
                <div tabindex="0" role="button" class="btn m-1"><i class='bx bx-menu bx-sm'></i></div>
                <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                    <li class="text-center"><a>หน้าแรก</a></li>
                    <li class="text-center"><a>ติดต่อ</a></li>
                    <li><a href="logout.php" class="">ออกจากระบบ</a></li>
                </ul>
            </div>

            <li class="hidden md:block"><a class="text-base mx-2 btn btn-ghost uppercase" onclick="profile.showModal()"><?= $_SESSION['user'] ?></a></li>

            <li class="hidden md:block">
                <div class=" indicator <?= $display ?>">

                    <span class="indicator-item badge badge-primary top-1 right-2 <?= $display ?>"><?= $count ?></span>
                    <a href="\jaa\borrowphp\public\order.php" class="text-base mx-2 btn btn-ghost uppercase">รายการยืม</a>
                </div>
            </li>

            <li class="hidden md:block">
                <div class="indicator <?= $order_display ?>">

                    <span class="indicator-item badge badge-primary top-1 right-2 <?= $order_display ?>"><?= $order_count ?></span>
                    <a href="\jaa\borrowphp\public\approve.php" class="text-base mx-2 btn btn-ghost uppercase">การอนุมัติ</a>
                </div>
            </li>
        <?php
        } else {
        ?>
            <li class=""><a class="text-base mx-2 btn btn-ghost" onclick="login.showModal()">เข้าสู่ระบบ</a></li>
        <?php
        }
        ?>
        <li class="hidden md:block"><a href="\jaa\borrowphp\public\index.php" class="text-base mx-2 btn btn-ghost">หน้าแรก</a></li>
        <li class="hidden md:block"><a href="#" class="text-base mx-2 btn btn-ghost">ติดต่อ</a></li>

    </ul>
</nav>

<!-- login -->
<dialog id="login" class="modal">
    <div class="modal-box flex flex-col items-center justify-center">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        <h3 class="mb-2 text-2xl">เข้าสู่ระบบ</h3>
        <form id="formlogin" method="post" class="flex flex-col justify-center items-center">
            <input class="input input-sm border-2 border-black my-4" type="text" name="username" placeholder="ชื่อผู้ใช้" required>
            <input class="input input-sm border-2 border-black mb-4" type="password" name="password" placeholder="รหัสผ่าน" required>
            <button type="submit" class="btn">เข้าสู่ระบบ</button>
        </form>

    </div>
</dialog>

<!-- profile -->
<dialog id="profile" class="modal justify-end items-start top-14 pr-10">
    <div class="modal-box flex flex-col items-center justify-center w-96">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>

        <h3 class="mb-2 text-2xl">จัดการโปรไฟล์</h3>
        <?php if ($_SESSION['role'] == 1) { ?>
            <a class="text-base text-white my-2 btn btn-primary" href="./admin/admin.php">โปรไฟล์</a>
        <?php
        }
        ?>
        <a class="text-base text-white my-2 btn btn-error" href="logout.php">ออกจากระบบ</a>
    </div>
</dialog>

<?php
if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
?>
    <div class="btm-nav z-50 md:hidden">
        <a href="index.php" class="<?= strpos($url, 'index.php') ? "text-green-600 active" : "" ?>">
            <i class='bx bx-home bx-sm'></i>
            <span class="btm-nav-label">หน้าแรก</span>
        </a>

        <a href="order.php" class="<?= strpos($url, 'order.php') ? "text-green-600 active" : "" ?>">
            <div class="indicator ">
                <span class="indicator-item badge badge-success absolute left-4 bottom-5 text-white <?= $display ?>"><?= $count ?></span>
                <i class='bx bx-add-to-queue bx-sm '></i>
            </div>
            <span class="btm-nav-label">รายการยืม</span>
        </a>

        <a href="approve.php" class="<?= strpos($url, 'approve.php') ? "text-green-600 active" : "" ?>">
            <div class="indicator">
                <span class="indicator-item badge badge-success absolute left-4 bottom-5 text-white <?= $order_display ?>"><?= $order_count ?></span>
                <i class='bx bx-check bx-sm'></i>
            </div>
            <span class="btm-nav-label">การอนุมัติ</span>
        </a>

        <a href="history.php" class="<?= strpos($url, 'history.php') ? "text-green-600 active" : "" ?>">
            <i class='bx bx-history bx-sm'></i>
            <span class="btm-nav-label">ประวัติ</span>
        </a>


        <a href="<?php echo $_SESSION['role'] == 1 ? "./admin/admin.php" : "#" ?>" class="">
            <i class='bx bx-user bx-sm '></i>
            <span class="btm-nav-label"><?= $_SESSION['user'] ?></span>
        </a>
    </div>
<?php } ?>