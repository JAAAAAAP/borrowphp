<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/jaa/bookingphp/config/connectdb.php');

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>upload</title>
    <?php include_once "../../plugin/plug.php" ?>

</head>

<body class="bg-slate-100">

    <!-- loading -->


    <div class="flex flex-col items-center justify-center">
        <div class="flex w-11/12">
            <div class="flex w-full justify-end">
                <label for="add" class="btn btn-success text-white">เพิ่มข้อมูล</label>
                <input type="checkbox" id="add" class="modal-toggle" />

                <div class="modal" role="dialog">

                    <div class="flex  justify-center fixed top-0 absolute w-screen h-screen z-50 bg-gray-900/50 hidden" id="loading-spinner">
                        <span class="loading top-0 loading-dots loading-lg text-white "></span>
                    </div>

                    <div class="modal-box">
                        <h3 class="font-bold text-lg text-center">เพิ่มข้อมูลครุภัณฑ์</h3>

                        <form action="/jaa/bookingphp/controller/product_upload.php" method="post" enctype="multipart/form-data">
                            <div class="flex items-center justify-center mt-6">
                                <label class="form-control w-full max-w-xs font-bold text-base text-black">
                                    <div class="label p-0">
                                        <span class="label-text">เลขครุภัณฑ์</span>
                                    </div>
                                    <input type="text" name="sn_product" placeholder="เลขครุภัณฑ์" class="input input-bordered border-black w-full max-w-xsinput mb-4" required />

                                    <div class="label p-0">
                                        <span class="label-text">ชื่อ</span>
                                    </div>
                                    <input type="text" name="product_name" placeholder="ชื่อ" class="input input-bordered border-black w-full max-w-xs mb-4" required />

                                    <div class="label p-0">
                                        <span class="label-text">จำนวน</span>
                                    </div>
                                    <input type="number" name="amount" placeholder="จำนวน" min="0" class="input input-bordered border-black w-full max-w-xs mb-4" required />

                                    <div class="label p-0">
                                        <span class="label-text">ไฟล์รูป</span>
                                    </div>
                                    <input type="file" name="fileupload" accept="image/jpg, image/png ,image/jpeg" class="file-input file-input-bordered border-black w-full max-w-xs" required />

                                </label>

                            </div>
                            <div class="modal-action">
                                <button type="submit" name="submit" class="btn btn-success text-white">เพิ่มข้อมูล</button>
                                <label for="add" class="btn btn-error text-white">ปิด</label>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>

        <div class="flex w-11/12 justify-center items-center mt-4">
            <div class="overflow-x-auto w-full border-2 rounded-xl border-gray-400 text-gray-600">
                <table class="table-fixed text-center justify-center items-center w-full ">
                    <!-- head -->
                    <thead class="border-b-2 border-gray-400 h-16 ">
                        <tr class="bg-slate-200">
                            <th class="w-12">No.</th>
                            <th class="w-96">รายละเอียดอุปกรณ์</th>
                            <th class="w-40">รูป</th>
                            <th class="">จำนวนคงเหลือ</th>
                            <th class="">แก้ไข</th>
                            <th class="">ลบ</th>
                        </tr>
                    </thead>
                    <?php
                    $i = 1;
                    $sql = "SELECT * FROM products";
                    $query = $conn->prepare($sql);
                    $query->execute();
                    $rs = $query->fetchAll(PDO::FETCH_ASSOC);
                    $conn = null;



                    foreach ($rs as $row) {
                        $imgUrl = '../img/' . $row['img'];



                    ?>
                        <tbody class="text-center items-center h-40">
                            <!-- Table -->
                            <tr class="border-b-2">
                                <th class="text-xl"><?php echo $i++ ?>.</th>
                                <td class="text-center text-xl">
                                    <span>ชื่อ : <?php echo $row['name'] ?></span>
                                    <br>
                                    <span class="">หมายเลขครุภัณฑ์ : <?php echo $row['sn_products'] ?></span>
                                </td>
                                <td>
                                    <figure class="flex w-full h-28 justify-center items-center"><img class="h-28 w-40" src="<?php echo $imgUrl ?>" alt=""></figure>
                                </td>
                                <td class="w-16 text-xl"><?php echo $row['amount'] ?></td>

                                <!-- Edit -->
                                <td>

                                    <label for="edit<?php echo $i ?>" type="submit" class="btn btn-info text-white"><i class='bx bxs-edit bx-md'></i></label>
                                    <input type="checkbox" id="edit<?php echo $i ?>" class="modal-toggle" />
                                    <div class="modal" role="dialog">
                                        <div class="modal-box">

                                            <h3 class="font-bold text-black text-lg">แก้ไขข้อมูล</h3>

                                            <form action="/jaa/bookingphp/controller/product_update.php" method="post" enctype="multipart/form-data">

                                                <div class="flex items-center justify-center mt-6">
                                                    <label class="form-control w-full max-w-xs font-bold text-base text-black">
                                                        <div class="label p-0">
                                                            <span class="label-text">ชื่อ</span>
                                                        </div>
                                                        <input type="text" name="name" placeholder="<?php echo $row['name'] ?>" class="input input-bordered w-full max-w-xs mb-4" />

                                                        <div class="label p-0">
                                                            <span class="label-text">จำนวน</span>
                                                        </div>
                                                        <input type="number" name="amount" placeholder="<?php echo $row['amount']; ?>" min="0" class="input input-bordered w-full max-w-xs mb-4" />

                                                        <div class="label p-0">
                                                            <span class="label-text">ไฟล์รูป</span>
                                                        </div>
                                                        <input type="file" name="filename" accept="image/jpg, image/png ,image/jpeg" class="file-input file-input-bordered w-full max-w-xs" />

                                                        <h2 class="flex items-start mt-4">รูปปัจจุบัน</h2>
                                                        <figure class="flex flex-col items-center justify-center w-full">
                                                            <img src="<?php echo $imgUrl ?>" class="h-56 w-80 border-2 border-black rounded-md">
                                                        </figure>

                                                    </label>
                                                </div>

                                                <div class="modal-action">
                                                    <input type="hidden" name="id" value="<?php echo $row['p_id'] ?>">
                                                    <button type="submit" name="submit" class="btn btn-success text-white">ยืนยันการแก้ไข</button>
                                                    <label for="edit<?php echo $i ?>" class="btn btn-error text-white">ปิด</label>
                                                </div>

                                            </form>
                                        </div>
                                    </div>
                                </td>

                                <!-- Delete -->
                                <td>
                                    <label for="deletes<?php echo $i ?>" class="btn btn-error text-white"><i class='bx bxs-trash bx-md'></i></label>
                                    <input type="checkbox" id="deletes<?php echo $i ?>" class="modal-toggle" />
                                    <div class="modal text-black text-lg" role="dialog">
                                        <div class="modal-box">
                                            <h3 class="font-bold text-lg">ลบข้อมูล</h3>
                                            <p class="py-4">ต้องการลบข้อมูลของ " <span class="text-red-600"><?php echo $row['name'] ?></span> " ใช่ไหม</p>
                                            <div class="modal-action m-0">
                                                <a id="<?= $row['p_id'] ?>" class="delete btn btn-error text-white">ลบ</a>
                                                <label for="deletes<?php echo $i ?>" class="btn btn-info text-white">ยกเลิก</label>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                            </tr>
                        </tbody>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
    </div>

    </div>

    <?php include "../../plugin/tailwind.php" ?>
    <?php include "../../plugin/script.php" ?>
    <script src="../js/product.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelector('form').addEventListener('submit', function() {
                document.getElementById('loading-spinner').classList.remove('hidden');
                document.getElementById('loading-spinner').classList.remove('absolute');

            });
        });
    </script>
</body>

</html>