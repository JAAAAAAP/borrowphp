<div class="flex flex-col justify-around gap-4 w-11/12 md:flex-row">

    <div class="card w-full bg-base-100 shadow-xl">

        <div class="card-body items-center text-center">
            <h2 class="card-title">จำนวนคนเข้าใช้งาน</h2>
            <div class="overflow-x-auto w-11/12">
                <table class="table  text-center">
                    <thead>
                        <tr class="text-black text-base">
                            <th></th>
                            <th>ผู้ใช้</th>
                            <th>เวลาเข้าสู่ระบบ</th>
                            <th>เวลาออกจากระบบ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $log_sql = "SELECT l.*, u.user_id, u.user
                                    FROM log AS l
                                    INNER JOIN user AS u ON l.u_id = u.user_id";
                        $log_query = $conn->prepare($log_sql);
                        $log_query->execute();
                        $log_rs = $log_query->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($log_rs as $row) { ?>
                            <tr>
                                <th><?= $i++; ?></th>
                                <td><?= $row['user']; ?></td>
                                <td><?= (empty($row['time_in']) || $row['time_in'] === "0000-00-00 00:00:00") ? '-' : date("d-m-Y H:i", strtotime($row['time_in'])) ?></td>
                                <td><?= (empty($row['time_out']) || $row['time_out'] === "0000-00-00 00:00:00") ? '-' : date("d-m-Y H:i", strtotime($row['time_out'])) ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card w-full bg-base-100 shadow-xl">

        <div class="card-body items-center text-center">
            <h2 class="card-title">การใช้งาน</h2>
            <div class="overflow-x-auto w-11/12">
                <table class="table  text-center">
                    <thead>
                        <tr class="text-black text-base">
                            <th></th>
                            <th>วันที่ เวลา</th>
                            <th>ผู้ใช้</th>
                            <th>ทำรายการยืม</th>
                            <th>จำนวน</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $order_sql = "SELECT o.*, u.user, p.name, p.amount AS products_amount, p.sn_products
                                    FROM oder_product AS o
                                    INNER JOIN user AS u ON o.user_id = u.user_id
                                    INNER JOIN products AS p ON o.p_id = p.p_id";
                        $order_query = $conn->prepare($order_sql);
                        $order_query->execute(); // Corrected this line
                        $order_rs = $order_query->fetchAll(PDO::FETCH_ASSOC); // Corrected this line
                        foreach ($order_rs as $row) { ?>
                            <tr>
                                <th><?= $i++; ?></th>
                                <td><?= (empty($row['dates_now']) || $row['dates_now'] === "0000-00-00 00:00:00") ? '-' : date("d-m-Y H:i", strtotime($row['dates_now'])) ?></td>
                                <td><?= $row['user']; ?></td>
                                <td><?= $row['name']; ?></td>
                                <td><?= $row['amount']; ?></td>
                            </tr>
                        <?php } ?>

                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>