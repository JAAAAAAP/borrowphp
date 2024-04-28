<div class="flex w-auto">

    <div class="flex flex-col w-full overflow-x-auto">
        <table class="table-auto h-full text-center ">
            <!-- head -->
            <thead class="border-b-2 border-black h-7 text-sm md:text-xl">
                <tr>

                    <th class="text-center w-16">
                        <div class="dropdown">
                            <div tabindex="0" role="button" class="flex items-center">
                                <h1>No.</h1>
                                <i class='bx bx-chevron-down bx-sm'></i>
                            </div>
                            <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                                <li><a href="?pt=status<?= isset($_GET['status']) ? '&&status=' . $_GET['status'] : '' ?>&&no=min">ลำดับเริ่มต้น</a></li>
                                <li><a href="?pt=status<?= isset($_GET['status']) ? '&&status=' . $_GET['status'] : '' ?>&&no=max">ลำดับสุดท้าย</a></li>
                            </ul>
                        </div>
                    </th>

                    <th class="">ชื่อผู้ยืม</th>
                    <th class="w-80">ของที่ยืม</th>

                    <th class="w-28">
                        <div class="dropdown">
                            <div tabindex="0" role="button" class="flex items-center">
                                จำนวน
                                <i class='bx bx-chevron-down bx-sm'></i>
                            </div>
                            <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                                <li><a href="?pt=status<?= isset($_GET['status']) ? '&&status=' . $_GET['status'] : '' ?>&&amount=min">น้อยที่สุด</a></li>
                                <li><a href="?pt=status<?= isset($_GET['status']) ? '&&status=' . $_GET['status'] : '' ?>&&amount=max">มากที่สุด</a></li>
                            </ul>
                        </div>
                    </th>

                    <th>
                        <div class="dropdown">
                            <div tabindex="0" role="button" class="flex items-center">
                                วันที่ยืม
                                <i class='bx bx-chevron-down bx-sm'></i>
                            </div>
                            <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                                <li><a href="?pt=status<?= isset($_GET['status']) ? '&&status=' . $_GET['status'] : '' ?>&&date_start=min">วันที่ใหม่สุด</a></li>
                                <li><a href="?pt=status<?= isset($_GET['status']) ? '&&status=' . $_GET['status'] : '' ?>&&date_start=max">วันที่เก่าที่สุด</a></li>
                            </ul>
                        </div>
                    </th>

                    <th>
                        <div class="dropdown">
                            <div tabindex="0" role="button" class="flex items-center">
                                วันที่คืน
                                <i class='bx bx-chevron-down bx-sm'></i>
                            </div>
                            <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                                <li><a href="?pt=status<?= isset($_GET['status']) ? '&&status=' . $_GET['status'] : '' ?>&&date_end=min">วันที่ใหม่สุด</a></li>
                                <li><a href="?pt=status<?= isset($_GET['status']) ? '&&status=' . $_GET['status'] : '' ?>&&date_end=max">วันที่เก่าที่สุด</a></li>
                            </ul>
                        </div>
                    </th>

                    <th>รายละเอียด</th>

                    <th>
                        <div class="dropdown dropdown-end">
                            <div tabindex="0" role="button" class="flex items-center">
                                สถานะ
                                <i class='bx bx-chevron-down bx-sm'></i>
                            </div>
                            <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                                <li><a href="?pt=status&&status=all">ทั้งหมด</a></li>
                                <li><a href="?pt=status&&status=wait">รออนุมัติ</a></li>
                                <li><a href="?pt=status&&status=approved">อนุมัติแล้ว</a></li>
                                <li><a href="?pt=status&&status=notapproved">ไม่อนุมัติ</a></li>
                                <li><a href="?pt=status&&status=borrowed">กำลังยืม</a></li>
                                <li><a href="?pt=status&&status=returned">คืนแล้ว</a></li>
                                <li><a href="?pt=status&&status=late">เลยกำหนด</a></li>
                            </ul>
                        </div>
                    </th>
                </tr>
            </thead>

            <tbody class="h-36">
                <?php
                $select = "o.o_id";
                $sort = "ASC";
                $approve = "";
                // ตรวจสอบและกำหนดค่าตัวแปรเพื่อใช้ในการเรียงลำดับและค้นหา
                if (isset($_GET['pt']) && $_GET['pt'] === 'status') {
                    if (isset($_GET['amount'])) {
                        if ($_GET['amount'] == 'min') {
                            $select = "o.amount";
                        } elseif ($_GET['amount'] == 'max') {
                            $select = "o.amount";
                            $sort = "DESC";
                        }
                    }
                    if (isset($_GET['no'])) {
                        if ($_GET['no'] == 'min') {
                            $select = "o.o_id";
                        } elseif ($_GET['no'] == 'max') {
                            $select = "o.o_id";
                            $sort = "DESC";
                        }
                    }
                    if (isset($_GET['date_start'])) {
                        if ($_GET['date_start'] == 'min') {
                            $select = "o.date_start";
                        } elseif ($_GET['date_start'] == 'max') {
                            $select = "o.date_start";
                            $sort = "DESC";
                        }
                    }
                    if (isset($_GET['date_end'])) {
                        if ($_GET['date_end'] == 'min') {
                            $select = "o.date_end";
                        } elseif ($_GET['date_end'] == 'max') {
                            $select = "o.date_end";
                            $sort = "DESC";
                        }
                    }
                    if (isset($_GET["status"])) {
                        switch ($_GET["status"]) {
                            case 'wait':
                                $approve = "AND o.status = 'รออนุมัติ'";
                                break;
                            case 'approved':
                                $approve = "AND o.status = 'อนุมัติแล้ว'";
                                break;
                            case 'notapproved':
                                $approve = "AND o.status = 'ไม่อนุมัติ'";
                                break;
                            case 'borrowed':
                                $approve = "AND o.status = 'กำลังยืม'";
                                break;
                            case 'returned':
                                $approve = "AND o.status = 'คืนแล้ว'";
                                break;
                            case 'late':
                                $approve = "AND o.status = 'เลยกำหนด'";
                                break;
                            case 'all':
                                break;
                        }
                    }
                }




                $sql = "SELECT o.*, u.user, p.name AS products_name, p.sn_products,p.amount AS products_amount 
                                            FROM products AS p 
                                            INNER JOIN oder_product AS o ON p.p_id = o.p_id 
                                            INNER JOIN USER AS u ON u.user_id = o.user_id
                                            WHERE o.status != :status $approve
                                            ORDER BY $select $sort";
                $query = $conn->prepare($sql);
                $query->bindValue(":status", "รอดำเนินการ", PDO::PARAM_STR);
                $query->execute();
                $rs = $query->fetchAll(PDO::FETCH_ASSOC);

                $min = 1;
                $max = count($rs);

                if (!empty($rs)) {
                ?>
                    <?php foreach ($rs as $row) : ?>


                        <tr class="h-20 align-middle border-b-2 border-black">

                            <td class="text-sm md:text-xl"><?= $sort == "DESC" ? $max-- : $min++; ?></td>
                            <td class="text-sm md:text-xl"><?= $row['user'] ?></td>
                            <td class="text-lg">
                                ชื่อ : <?= $row['products_name'] ?>
                                <br>
                                เลขครุภัณฑ์ : <?= $row['sn_products'] ?>
                            </td>
                            <td class="text-xl">

                                <span class="top-2 relative"><?= $row['amount'] ?></span>

                                <span class="text-sm text-nowrap">จำนวนคงเหลือ <?= $row['products_amount'] ?></span>

                            </td>
                            <td class="text-xl"><?= date("d-m-Y", strtotime($row['date_start'])) ?></td>
                            <td class="text-xl"><?= date("d-m-Y", strtotime($row['date_end'])) ?></td>

                            <td>
                                <label for="detail<?= $row['o_id'] ?>" class="btn btn-info text-white">
                                    <i class='bx bx-credit-card-front bx-md'></i>
                                </label>

                                <input type="checkbox" id="detail<?= $row['o_id'] ?>" class="modal-toggle" />

                                <div class="modal" role="dialog">
                                    <div class="modal-box">
                                        <h2 class="font-bold text-2xl"><?= $row['products_name'] ?></h2>
                                        <div class="text-start">
                                            <h3 class="pt-4 font-bold text-xl">ชื่อผู้ยืม :</h3>
                                            <p class="text-start font-bold text-lg border-2 border-black rounded-lg pl-4 p-2"> <?= $row['user'] ? $row['user'] : "-" ?></p>
                                            <h3 class="pt-4 font-bold text-xl">เบอร์ติดต่อ :</h3>
                                            <p class="text-start font-bold text-lg border-2 border-black rounded-lg pl-4 p-2"> <?= $row['tel'] ? "0" . $row['tel'] : "-" ?></p>
                                            <h3 class="pt-4 font-bold text-xl">หน่วยงาน/สาขา :</h3>
                                            <p class="text-start font-bold text-lg border-2 border-black rounded-lg pl-4 p-2"> <?= $row['department'] ? $row['department'] : "-" ?></p>
                                            <h3 class="pt-4 font-bold text-xl">นำไปใช้ที่ :</h3>
                                            <p class="text-start font-bold text-lg border-2 border-black rounded-lg pl-4 p-2"> <?= $row['address'] ? $row['address'] : "-" ?></p>
                                            <h3 class="pt-4 font-bold text-xl">อาจาร์ยผู้สอน :</h3>
                                            <p class="text-start font-bold text-lg border-2 border-black rounded-lg pl-4 p-2"> <?= $row['teacher'] ? $row['teacher'] : "-" ?></p>
                                        </div>

                                        <div class="modal-action">
                                            <label for="detail<?= $row['o_id'] ?>" class="btn w-20 btn-error text-white">ปิด</label>
                                        </div>
                                    </div>
                                </div>

                            </td>

                            <td>
                                <div class="dropdown dropdown-end">
                                    <div tabindex="0" role="button" class="btn btn-md btn-<?= $row['status'] === "กำลังยืม" || $row['status'] === "คืนแล้ว" ? "success" : ($row['status'] === "อนุมัติแล้ว" ? "accent" : ($row['status'] === "ไม่อนุมัติ" || $row['status'] === "เลยกำหนด" ? "error" : "warning")); ?> text-white">
                                        <?= $row['status'] ?>
                                    </div>
                                    <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                                        <?php if ($row['status'] === "รออนุมัติ") { ?>
                                            <li><a href="\jaa\bookingphp\controller\order_approve.php?approve=ok&&o=<?= $row['o_id'] ?>&&p=<?= $row['p_id'] ?>&&amount=<?= $row['amount'] ?>">อนุมัติ</a></li>
                                            <li><a href="\jaa\bookingphp\controller\order_approve.php?approve=no&&o=<?= $row['o_id'] ?>&&p=<?= $row['p_id'] ?>&&amount=<?= $row['amount'] ?>">ไม่อนุมัติ</a></li>
                                        <?php } elseif ($row['status'] === 'อนุมัติแล้ว') { ?>
                                            <li class=""><a href="\jaa\bookingphp\controller\order_approve.php?approve=no&&o=<?= $row['o_id'] ?>&&p=<?= $row['p_id'] ?>&&amount=<?= $row['amount'] ?>">ไม่อนุมัติ</a></li>
                                            <li class=""><a href="\jaa\bookingphp\controller\order_approve.php?approve=wait&&o=<?= $row['o_id'] ?>&&p=<?= $row['p_id'] ?>&&amount=<?= $row['amount'] ?>">รออนุมัติ</a></li>

                                        <?php } elseif ($row['status'] === 'กำลังยืม') { ?>
                                            <li class=""><a href="\jaa\bookingphp\controller\order_approve.php?approve=return&&o=<?= $row['o_id'] ?>&&p=<?= $row['p_id'] ?>&&amount=<?= $row['amount'] ?>">คืนแล้ว</a></li>
                                        <?php } elseif ($row['status'] === 'เลยกำหนด') { ?>
                                            <li class=""><a href="\jaa\bookingphp\controller\order_approve.php?approve=wait&&o=<?= $row['o_id'] ?>&&p=<?= $row['p_id'] ?>&&amount=<?= $row['amount'] ?>">คืนแล้ว</a></li>
                                        <?php } elseif ($row['status'] === 'ไม่อนุมัติ') { ?>
                                            <li class=""><a href="\jaa\bookingphp\controller\order_approve.php?approve=ok&&o=<?= $row['o_id'] ?>&&p=<?= $row['p_id'] ?>&&amount=<?= $row['amount'] ?>">อนุมัติ</a></li>
                                            <li class=""><a href="\jaa\bookingphp\controller\order_approve.php?approve=wait&&o=<?= $row['o_id'] ?>&&p=<?= $row['p_id'] ?>&&amount=<?= $row['amount'] ?>">รออนุมัติ</a></li>
                                        <?php } ?>
                                    </ul>
                                    <?php
                                    // วันและเวลาที่กำหนด
                                    $datetime_sql = 'SELECT date_end FROM oder_product WHERE status = "กำลังยืม"';
                                    $datetime_result = $conn->prepare($datetime_sql);
                                    $datetime_result->execute();
                                    $datetime_row = $datetime_result->fetch(PDO::FETCH_ASSOC);

                                    if ($datetime_row) {
                                        $deadline = strtotime($datetime_row['date_end']);


                                        $current_time = time();

                                        if ($current_time > $deadline) {
                                            $sql = 'UPDATE oder_product SET status = "เลยกำหนด" ';
                                            $query = $conn->prepare($sql);
                                            $query->execute();
                                        }
                                    }
                                    ?>

                                </div>
                            </td>

                        </tr>
                <?php
                    endforeach;
                }
                ?>
            </tbody>
        </table>
    </div>

</div>