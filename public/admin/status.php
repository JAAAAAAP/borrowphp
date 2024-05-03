<div class="flex flex-col w-11/12 h-auto overflow-x-auto">

    <table class="table text-center">
        <thead>
            <tr class="text-black text-base text-nowrap md:text-xl">
                <th class="w-14">ใบที่</th>
                <th class="w-2/4">ชื่อผู้ยืม</th>

                <th class="">
                    <div class="dropdown dropdown-end">
                        <div tabindex="0" role="button" class="">การอนุมัติ <i class='bx bx-expand-vertical font-bold'></i></div>
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
                            <?php
                            $status_sql = "SHOW COLUMNS FROM oder_product WHERE Field = 'status'";
                            $status_query = $conn->prepare($status_sql);
                            $status_query->execute();
                            $status_rs = $status_query->fetch(PDO::FETCH_ASSOC);
                            preg_match('/^enum\((.*?)\)$/', $status_rs['Type'], $matches);
                            $status_values = explode(',', $matches[1]);

                            foreach ($status_values as $value) {
                                $status = trim($value, "'");
                            ?>
                                <li><a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100"><?= $status ?></a></li>
                            <?php
                            }
                            ?>
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

                $product_sql = "SELECT o.*,u.user,p.name,p.amount AS products_amount
                                FROM products as p 
                                INNER JOIN oder_product as o on p.p_id = o.p_id
                                INNER JOIN user as u on o.user_id = u.user_id
                                WHERE group_id = :group_id  LIMIT 1";
                $product_result = $conn->prepare($product_sql);
                $product_result->bindParam(':group_id', $group_id, PDO::PARAM_INT);
                $product_result->execute();
                $products = $product_result->fetchAll(PDO::FETCH_ASSOC);
                foreach ($products as $product) {
            ?>
                    <tr class="text-base text-nowrap md:text-xl">
                        <td class="font-bold"><?= $i++ ?></td>
                        <td><?= $product['user'] ?></td>
                        <td><?= $group_id ?></td>
                        <td>

                            <label for="approve_modal_<?= $i ?>" class="btn"><?= $product['status'] ?></label>
                            <input type="checkbox" id="approve_modal_<?= $i ?>" class="modal-toggle" />
                            <div class="modal" role="dialog">
                                <div class="modal-box">
                                    <h3 class="font-bold text-lg">Hello!</h3>
                                    <p class="py-4"><?= $group_id ?></p>
                                    <div class="modal-action">
                                        <label for="approve_modal_<?= $i ?>" class="btn">Close!</label>
                                    </div>
                                </div>
                            </div>

                        </td>
                    </tr>
            <?php
                }
            }
            ?>
        </tbody>
    </table>
</div>