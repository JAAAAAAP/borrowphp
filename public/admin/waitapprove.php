<div class="flex flex-col w-11/12 h-auto overflow-x-auto">

    <?php
    $i = 1;
    $group_sql = "SELECT DISTINCT group_id FROM oder_product WHERE status IN ('รออนุมัติ', 'ไม่อนุมัติ', 'รอดำเนินการ')";
    $group_query = $conn->prepare($group_sql);
    $group_query->execute();
    $group_rs = $group_query->fetchAll(PDO::FETCH_ASSOC);

    foreach ($group_rs as $groupid) {
    ?>
        <div class="flex justify-center items-center h-auto border-b-2 border-black ">
            <div class="flex flex-col w-auto gap-2 justify-center items-center font-bold text-center text-nowrap">
                <h1 class="">ใบที่</h1>
                <h1 class=""><?= $i++ ?></h1>
            </div>

            <div class="w-full">

                <div class="overflow-x-auto">
                    <table class="table text-center h-44">

                        <thead>
                            <tr class="text-black text-base text-nowrap ">
                                <th>ชื่อผู้ยืม</th>
                                <th>ของที่ยืม</th>
                                <th>จำนวน</th>
                                <th>รายละเอียด</th>

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
                            $group_id = $groupid['group_id'];

                            $product_sql = "SELECT o.*,u.user,p.name,p.amount AS products_amount,p.sn_products
                                            FROM oder_product AS o
                                            INNER JOIN user AS u ON o.user_id = u.user_id
                                            INNER JOIN products AS p ON o.p_id = p.p_id
                                            WHERE o.group_id = :group_id AND status IN ('รออนุมัติ', 'ไม่อนุมัติ', 'รอดำเนินการ')
                                            ";
                            $product_result = $conn->prepare($product_sql);
                            $product_result->bindParam(':group_id', $group_id, PDO::PARAM_INT);
                            $product_result->execute();
                            $products = $product_result->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($products as $product) {
                            ?>
                                <tr class="text-base text-nowrap md:text-xl">
                                    <td><?= $product['user'] ?></td>

                                    <td>
                                        <div class="flex flex-col">
                                            <p class="my-2">ชื่อ : <?= $product['name'] ?></p>
                                            <p class="">หมายเลขครุภัณฑ์ : <?= $product['sn_products'] ?></p>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="flex flex-col">
                                            <p class="my-2"><?= $product['amount'] ?></p>
                                            <p class="text-base">(จำนวนคงเหลือ <?= $product['products_amount'] ?>)</p>
                                        </div>
                                    </td>

                                    <td>
                                        <label for="detail<?= $i ?>" class="btn btn-info text-white"><i class='bx bx-detail bx-lg'></i></label>

                                        <!-- Put this part before </body> tag -->
                                        <input type="checkbox" id="detail<?= $i ?>" class="modal-toggle" />
                                        <div class="modal" role="dialog">
                                            <div class="modal-box">
                                                <h3 class="font-bold text-2xl">รายละเอียดการยืม</h3>

                                                <div class="grid grid-cols-2 gap-2 mt-2 text-start">

                                                    <label class=" w-full max-w-xs">
                                                        <div class="label p-0">
                                                            <span class="label-text text-base text-black font-bold">ชื่อผู้ยืม :</span>
                                                        </div>

                                                        <p class="pl-2 border-2 border-black rounded-md text-xs text-wrap md:text-xl "><?= $product['user'] ?></p>

                                                    </label>

                                                    <label class=" w-full max-w-xs">
                                                        <div class="label p-0">
                                                            <span class="label-text text-base text-black font-bold">เบอร์โทร :</span>
                                                        </div>
                                                        <p class="pl-2 border-2 border-black rounded-md text-xs md:text-xl"><?= empty($product['tel']) ? "-" : $product['tel']; ?></p>
                                                    </label>

                                                    <label class=" w-full max-w-xs">
                                                        <div class="label p-0">
                                                            <span class="label-text text-base text-black font-bold">ครูผู้สอน :</span>
                                                        </div>
                                                        <p class="pl-2 border-2 border-black rounded-md text-xs md:text-xl"><?= empty($product['teacher']) ? "-" : $product['teacher']; ?></p>
                                                    </label>

                                                    <label class=" w-full max-w-xs">
                                                        <div class="label p-0">
                                                            <span class="label-text text-base text-black font-bold">หน่วยงานสาขา :</span>
                                                        </div>
                                                        <p class="pl-2 border-2 border-black rounded-md text-xs md:text-xl"><?= empty($product['department']) ? "-" : $product['department']; ?></p>
                                                    </label>

                                                    <label class=" w-full max-w-xs">
                                                        <div class="label p-0">
                                                            <span class="label-text text-base text-black font-bold">นำไปใช้ที่ :</span>
                                                        </div>
                                                        <p class="pl-2 border-2 border-black rounded-md text-xs md:text-xl"><?= empty($product['address']) ? "-" : $product['address']; ?></p>
                                                    </label>

                                                    <label class=" w-full max-w-xs">
                                                        <div class="label p-0">
                                                            <span class="label-text text-base text-black font-bold">ทำรายการ :</span>
                                                        </div>
                                                        <p class="pl-2 border-2 border-black rounded-md text-xs md:text-xl"><?= (empty($product['dates_now']) || $product['dates_now'] === "0000-00-00 00:00:00") ? '-' : date("d-m-Y H:i:s", strtotime($product['dates_now']));
                                                                                                                            ?></p>
                                                    </label>

                                                    <label class=" w-full max-w-xs">
                                                        <div class="label p-0">
                                                            <span class="label-text text-base text-black font-bold">วันที่ยืม :</span>
                                                        </div>
                                                        <p class="pl-2 border-2 border-black rounded-md text-xs md:text-xl"><?= (empty($product['date_start']) || $product['date_start'] === "0000-00-00") ? '-' : date("d-m-Y", strtotime($product['date_start'])); ?></p>
                                                    </label>

                                                    <label class=" w-full max-w-xs">
                                                        <div class="label p-0">
                                                            <span class="label-text text-base text-black font-bold">วันที่คืน :</span>
                                                        </div>
                                                        <p class="pl-2 border-2 border-black rounded-md text-xs md:text-xl"><?= (empty($product['date_end']) || $product['date_end'] === "0000-00-00") ? '-' : date("d-m-Y", strtotime($product['date_end'])); ?></p>
                                                    </label>



                                                </div>


                                                <div class="modal-action">
                                                    <label for="detail<?= $i ?>" class="btn">Close!</label>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td><?= (empty($product['dates_now']) || $product['dates_now'] === "0000-00-00 00:00:00") ? '<div class="text-red-500 font-bold">ยังไม่ได้ทำรายการ</div>' : date("d-m-Y H:i:s", strtotime($product['dates_now'])); ?></td>

                                    <td>
                                        <div class="dropdown dropdown-end">
                                            <div tabindex="0" role="button" class="btn text-white 
                                            <?=
                                            $product['status'] === 'รออนุมัติ' ? "btn-warning" : (
                                                $product['status'] === 'ไม่อนุมัติ' ? "btn-error" : (
                                                    $product['status'] === 'รอดำเนินการ' ? "btn-error" : ""));
                                            ?>">
                                                <?= $product['status'] ?>
                                            </div>
                                            <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                                                <li><a>รออนุมัติ</a></li>
                                                <li><a>อนุมัติ</a></li>
                                                <li><a>ไม่อนุมัติ</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php } ?>
</div>