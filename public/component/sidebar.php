<?php




?>

<div class="mr-0 flex flex-col h-auto w-auto md:mr-20 ">

    <div class="drawer flex flex-row z-50">
        <input id="my-drawer" type="checkbox" class="drawer-toggle" />


        <div class="hidden drawer-content md:flex flex-col items-center fixed top-0 h-full w-20 bg-gray-950 shadow-xl text-white">
            <div class="mb-8 mt-4 text-4xl">
                <i class='bx bx-book'></i>
            </div>
            <ul class="menu justify-center items-center gap-6">
                <li>
                    <a href="admin.php?pt=waitapprove" class="tooltip tooltip-right w-full <?= strpos($url, 'admin.php?pt=waitapprove') ? "text-green-500 bg-white" : "" ?> " data-tip="รออนุมัติ">
                        <i class='bx bx-user bx-sm'></i>
                    </a>
                </li>

                <li>
                    <a href="admin.php?pt=approve" class="tooltip tooltip-right w-full " data-tip="อนุมัติแล้ว">
                        <i class='bx bx-check bx-sm'></i>
                    </a>
                </li>
                
                <li>
                    <a href="admin.php?pt=approve" class="tooltip tooltip-right w-full " data-tip="กำลังยืม">
                        <i class='bx bx-time bx-sm'></i>
                    </a>
                </li>
                
                <li>
                    <a href="admin.php?pt=approve" class="tooltip tooltip-right w-full " data-tip="เลยกำหนด">
                        <i class='bx bx-time-five bx-sm'></i>
                    </a>
                </li>

                <li>
                    <a href="admin.php?pt=upload" class="tooltip tooltip-right w-full <?= strpos($url, 'admin.php?pt=upload') ? "text-green-500 bg-white" : "" ?>" data-tip="เพิ่มรายการ">
                        <i class='bx bx-plus bx-sm'></i>
                    </a>
                </li>

                <li>
                    <a href="admin.php?pt=history" class="tooltip tooltip-right w-full " data-tip="ประวัติ">
                        <i class='bx bx-history bx-sm'></i>
                    </a>
                </li>

                <li>
                    <a href="" class="tooltip tooltip-right w-full " data-tip="การตั้งค่า">
                        <i class='bx bx-cog bx-sm'></i>
                    </a>
                </li>
            </ul>
        </div>

        <div class="drawer-side h-full">
            <label for="my-drawer" aria-label="close sidebar" class="drawer-overlay"></label>
            <ul class="flex flex-col justify-between w-64 bg-gray-950 text-white min-h-full ">

                <ul class="menu items-start justify-center gap-8 w-full text-xl">

                    <div class="flex items-center justify-center w-full h-full gap-3 my-5 font-bold text-2xl">
                        <i class='bx bx-book bx-lg'></i>
                        <span>ระบบยืมคืน</span>
                    </div>

                    <li class="w-full <?= strpos($url, 'admin.php?pt=waitapprove') ? "text-green-500 bg-white rounded-md" : "" ?>"">
                        <a href="admin.php?pt=waitapprove">
                            <i class='bx bx-user bx-sm'></i>
                            <span class="ml-4">รออนุมัติ</span>
                        </a>
                    </li>
                    
                    <li class="w-full">
                        <a href="">
                            <i class='bx bx-check bx-sm'></i>
                            <span class="ml-4">อนุมัติแล้ว</span>
                        </a>
                    </li>
                    
                    <li class="w-full">
                        <a href="">
                            <i class='bx bx-time bx-sm'></i>
                            <span class="ml-4">กำลังยืม</span>
                        </a>
                    </li>
                    
                    <li class="w-full">
                        <a href="">
                            <i class='bx bx-time-five bx-sm'></i>
                            <span class="ml-4">เลยกำหนด</span>
                        </a>
                    </li class="w-full">

                    <li class="w-full  <?= strpos($url, 'admin.php?pt=upload') ? "text-green-500 bg-white rounded-md" : "" ?>">
                        <a href="admin.php?pt=upload">
                            <i class='bx bx-plus bx-sm'></i>
                            <span class="ml-4">เพิ่มรายการ</span>
                        </a>
                    </li>
                    <li class="w-full">
                        <a href="admin.php?pt=history">
                            <i class='bx bx-history bx-sm'></i>
                            <span class="ml-4">ประวัติ</span>
                        </a>
                    </li>
                    <li class="w-full">
                        <a href="">
                            <i class='bx bx-cog bx-sm'></i>
                            <span class="ml-4">การตั้งค่า</span>
                        </a>
                    </li>
                </ul>


                <ul class="menu menu-horizontal items-center justify-around h-20 font-bold bg-gray-800">
                    <div>
                        <h4 class="text-sm uppercase"><?php echo $_SESSION['user'] ?></h4>
                    </div>
                    <li>
                        <a href="/jaa/borrowphp/public/index.php" class="tooltip tooltip-info" data-tip="หน้าบ้าน">
                            <i class='bx bx-home bx-sm'></i>
                        </a>
                    </li>
                    <li>
                        <a href="/jaa/borrowphp/public/logout.php" class="tooltip tooltip-error" data-tip="ออกจากระบบ">
                            <i class='bx bx-log-out bx-sm'></i>
                        </a>
                    </li>
                </ul>
            </ul>
        </div>
    </div>

</div>