<?php

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["group"])) {
        include_once($_SERVER['DOCUMENT_ROOT'] . '/jaa/borrowphp/config/connectdb.php');
        include_once('../plugin/script.php');

        $group = $_GET["group"];
        $groupid_sql = 'DELETE FROM oder_product WHERE group_id = :g_id';
        $groupid_query = $conn->prepare($groupid_sql);
        $groupid_query->bindParam(':g_id', $group, PDO::PARAM_INT);
        $groupid_query->execute();

        echo "<script>window.history.back();</script>";
        exit;
    }
}
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["p"])) {
        include_once($_SERVER['DOCUMENT_ROOT'] . '/jaa/borrowphp/config/connectdb.php');
        include_once('../plugin/script.php');

        $group = $_GET["p"];
        $groupid_sql = 'DELETE FROM oder_product WHERE o_id = :o_id';
        $groupid_query = $conn->prepare($groupid_sql);
        $groupid_query->bindParam(':o_id', $group, PDO::PARAM_INT);
        $groupid_query->execute();

        echo "<script>window.history.back();</script>";
        exit;
    }
}