<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once($_SERVER['DOCUMENT_ROOT'] . '/jaa/borrowphp/config/connectdb.php');




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>index</title>
    <?php include_once "../plugin/plug.php" ?>
</head>


<body>
    <!-- navbar -->
    <?php include_once("./component/navbar.php") ?>

    <div class="text-end mr-4">
        <select class="select select-bordered w-36 select-sm mt-8 md:w-48">
            <option disabled selected>Who shot first?</option>
            <option>Han Solo</option>
            <option>Greedo</option>
        </select>
    </div>

    <div class="flex flex-col ">
        <?php
        $sql = "SELECT p_id,name,amount,img,sn_products FROM products";
        $query = $conn->prepare($sql);
        $query->execute();
        $rs = $query->fetchAll(PDO::FETCH_ASSOC);
        $conn = null;

        if ($query->rowCount() > 0) {
            foreach ($rs as $row) {
                $imgUrl = './img/' . $row['img'];
        ?>
                <div class="flex m-4 gap-4 bg-base-100 shadow-xl rounded-md  <?= $row['amount'] > 0 ? "" : "hidden" ?>">
                    <figure>
                        <img class=" rounded-md w-40 h-full md:w-40" src="<?= $imgUrl ?>" />
                    </figure>
                    <div class="flex flex-col justify-between font-bold w-full text-xs md:text-base">
                        <h1><?= $row['name'] ?></h1>
                        <p>หมายเลขครุภัณฑ์ : <?= $row['sn_products'] ?></p>
                        <p>จำนวนคงเหลือ : <?= $row['amount'] ?></p>
                        <div class="flex flex-row">
                            <div class="text-end w-full">
                                <form action="../controller/order.php" method="post"">
                                    <input type="hidden" name="id" value="<?= $row['p_id'] ?>">
                                    <input class="input input-sm border-2 w-28 border-black md:input-md" type="number" name="amount" min="1" max="<?= $row['amount'] ?>" placeholder="คงเหลือ <?= $row['amount'] ?>">
                                    <button type="submit" name="submit" class="btn btn-sm btn-success text-white m-2 md:btn-md">ยืม</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="divider"></div>
        <?php
            }
        }
        ?>
    </div>

    <div class="block h-16">
    </div>





    <?php include_once "../plugin/script.php" ?>
    <script src="./js/index.js"></script>
</body>

</html>