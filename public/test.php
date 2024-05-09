<tbody>
                <?php
                $i = 1;
                $group_sql = "SELECT DISTINCT group_id FROM oder_product WHERE status IN ('รออนุมัติ', 'ไม่อนุมัติ', 'รอดำเนินการ') ";
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
                            <td>
                                <?php
                                $status_sql = "SELECT o.status,p.name,p.sn_products
                                    FROM oder_product AS o
                                    INNER JOIN products AS p ON o.p_id = p.p_id
                                    WHERE o.group_id = :group_id";
                                $status_query = $conn->prepare($status_sql);
                                $status_query->bindParam(":group_id", $group_id, PDO::PARAM_INT);
                                $status_query->execute();
                                $rs = $status_query->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($rs as $row) { ?>
                                    <div class="flex flex-col">
                                        <p class="my-2">ชื่อ : <?= $row['name'] ?></p>
                                        <p class="">หมายเลขครุภัณฑ์ : <?= $row['sn_products'] ?></p><br>
                                    </div>
                                <?php } ?>
                            </td>
                            <td></td>
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
                                <?php
                                $status_sql = "SELECT o.status,p.name
                                    FROM oder_product AS o
                                    INNER JOIN products AS p ON o.p_id = p.p_id
                                    WHERE o.group_id = :group_id";
                                $status_query = $conn->prepare($status_sql);
                                $status_query->bindParam(":group_id", $group_id, PDO::PARAM_INT);
                                $status_query->execute();
                                $rs = $status_query->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($rs as $status) { ?>
                                    <button class="btn my-2"><?= $status['status'] ?></button><br>
                                <?php } ?>
                            </td>
                        </tr>
                <?php
                    }
                }
                ?>
            </tbody>