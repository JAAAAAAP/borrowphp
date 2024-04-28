<?php


if (isset($_POST['program']) && $_POST['program'] === 'del') {
    include_once($_SERVER['DOCUMENT_ROOT'] . '/jaa/bookingphp/config/connectdb.php');
    include_once('../plugin/script.php');

    $id = $_POST['id'];
    $delete = "DELETE FROM oder_product WHERE o_id = :id";
    $query = $conn->prepare("$delete");
    $query->bindParam(":id", $id, PDO::PARAM_INT);
    $query->execute();
    $conn = null;
    if ($query) {

        echo "ok";
        $conn = null;
    } else {
        echo "maiok";
        $conn = null;
    }
}
