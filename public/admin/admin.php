<?php
session_start();
$_SESSION["role"] == "1" ? " " :  header("Location:/public/index.php") . exit;
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin</title>
    <?php include_once "../../plugin/plug.php" ?>

</head>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Kanit:wght@400;500;600;700;800;900&display=swap');

    * {
        font-family: 'Poppins', sans-serif;
    }
</style>

<body class="bg-slate-100 w-full">



    <div class="flex flex-row w-screen h-screen justify-center items-center">
        <?php include_once "../component/sidebar.php" ?>
        
        <div class="flex flex-col w-full h-screen">
            <div class="h-auto"><?php include_once "../component/menu.php" ?></div>

            <div class="flex justify-center items-center  w-auto">
                <div class="divider divider-neutral w-11/12"></div>
            </div>

            <div class="flex flex-col items-center w-full h-screen bg-slate-100">
                <?php
                if (isset($_GET['pt']) && $_GET['pt'] == "upload") {
                    include_once "./upload.php";
                } elseif (isset($_GET["pt"]) && $_GET["pt"] == "status") {
                    include_once "./status.php";
                } elseif (isset($_GET["pt"]) && $_GET["pt"] == "history") {
                    include_once "./history.php";
                } else {
                    include_once "./status.php";
                }
                ?>
            </div>
        </div>

    </div>

 

</body>

</html>