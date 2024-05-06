<div class="flex flex-col w-11/12 h-auto overflow-x-auto">

    <div class="overflow-x-auto">
        <table class="table text-center">
            <thead>
                <tr class="text-black text-base text-nowrap md:text-xl">
                    <th class="w-14">ใบที่</th>
                    <th class="w-2/4">ชื่อผู้ยืม</th>
                    
                    <th class="">ของที่ยืม</th>
                    <th class="">จำนวน</th>
                    <th class="">รายละเอียด</th>
                    
                    <th class="">
                        <div class="dropdown dropdown-end">
                            <div tabindex="0" role="button" class="">วันที่ทำรายการ <i class='bx bx-expand-vertical font-bold'></i></div>
                            <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                                <li><a>ใหม่ที่สุด</a></li>
                                <li><a>เก่าที่สุด</a></li>
                            </ul>
                        </div>
                    </th>
                    
                    <th class="">
                        <div class="dropdown dropdown-end">
                            <div tabindex="0" role="button" class="">การอนุมัติ <i class='bx bx-expand-vertical font-bold'></i></div>
                            <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                                <li><a>รออนุมัติ</a></li>
                                <li><a>อนุมัติแล้ว</a></li>
                                <li><a>ไม่อนุมัติ</a></li>
                            </ul>
                        </div>
                    </th>
                </tr>
            </thead>


            <tbody>
                <?php
                $i = 1;
                $group_sql = 'SELECT DISTINCT group_id FROM oder_product';
                $group_query = $conn->prepare($group_sql);
                $group_query->execute();
                $group_rs = $group_query->fetchAll(PDO::FETCH_ASSOC);

                foreach ($group_rs as $groupid) {
                    $group_id = $groupid['group_id'];

                    $product_sql = "SELECT o.*, u.user
                                FROM oder_product AS o
                                INNER JOIN user AS u ON o.user_id = u.user_id
                                WHERE o.group_id = :group_id
                                LIMIT 1 ";
                    $product_result = $conn->prepare($product_sql);
                    $product_result->bindParam(':group_id', $group_id, PDO::PARAM_INT);
                    $product_result->execute();
                    $products = $product_result->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($products as $product) {
                ?>
                        <tr class="text-base text-nowrap border-b-2 border-black md:text-xl">
                            <td class="font-bold"><?= $i++ ?></td>
                            <td><?= $product['user'] ?></td>
                            <td></td>
                            <td></td>
                            <td>sad</td>
                            <td><?= (empty($product['dates_now']) || $product['dates_now'] === "0000-00-00 00:00:00") ? '<div class="text-red-500 font-bold">ยังไม่ได้ทำรายการ</div>' : date("d-m-Y H:i:s", strtotime($product['dates_now'])); ?></td>
                            <td>
                                <?php
                                $sql = "SELECT o.status,p.name
                                    FROM oder_product AS o
                                    INNER JOIN products AS p ON o.p_id = p.p_id
                                    WHERE o.group_id = :group_id";
                                $query = $conn->prepare($sql);
                                $query->bindParam(":group_id", $group_id, PDO::PARAM_INT);
                                $query->execute();
                                $rs = $query->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($rs as $row) { ?>
                                    <button class="btn my-2"><?= $row['status'] ?></button><br>
                                <?php } ?>
                            </td>
                        </tr>
                <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>