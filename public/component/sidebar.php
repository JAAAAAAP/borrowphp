<?php




?>

<div class="mr-0 flex flex-col h-auto w-auto md:mr-20 ">

    <div class="drawer flex flex-row z-50">
        <input id="my-drawer" type="checkbox" class="drawer-toggle" />


        <div class="hidden drawer-content md:flex flex-col items-center fixed top-0 h-full w-20 bg-gray-950 text-white">
            <div class="mb-8 mt-4 text-4xl">
                <i class='bx bx-book'></i>
            </div>
            <ul class="menu justify-center items-center gap-6">
                <li>
                    <a href="admin.php?pt=status" class="tooltip tooltip-right w-full " data-tip="สถานะ">
                        <i class='bx bx-grid-alt bx-sm'></i>
                    </a>
                </li>

                <li>
                    <a href="admin.php?pt=upload" class="tooltip tooltip-right w-full " data-tip="เพิ่มรายการ">
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

                    <li>
                        <a href="">
                            <i class='bx bx-grid-alt bx-sm'></i>
                            <span class="ml-4">สถานะ</span>
                        </a>
                    </li>
                    <li>
                        <a href="admin.php?pt=upload">
                            <i class='bx bx-plus bx-sm'></i>
                            <span class="ml-4">เพิ่มรายการ</span>
                        </a>
                    </li>
                    <li>
                        <a href="admin.php?pt=history">
                            <i class='bx bx-history bx-sm'></i>
                            <span class="ml-4">ประวัติ</span>
                        </a>
                    </li>
                    <li>
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