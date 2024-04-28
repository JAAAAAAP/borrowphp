<?php
require $_SERVER['DOCUMENT_ROOT'] . '/jaa/bookingphp/vendor/autoload.php';

use Intervention\Image\ImageManagerStatic as Image;

$targetDir = "../public/img/";

if (isset($_POST['submit'])) {
    include_once($_SERVER['DOCUMENT_ROOT'] . '/jaa/bookingphp/config/connectdb.php');
    include_once('../plugin/script.php');

    if (isset($_POST['product_name']) && isset($_POST['amount'])) {
        $product_name = $_POST['product_name'];
        $amount = $_POST['amount'];
        $sn_product = $_POST['sn_product'];


        $filename = $_FILES['fileupload']['name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $allowed = array('jpg', 'png', 'jpeg');

        if (!in_array($ext, $allowed)) {
            echo "<script>
                        $(document).ready(function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'อัพโฟลดได้แค่ไฟล์ JPG PNG JPEG',
                                timer: 1500,
                                showConfirmButton: false
                            });
                        });
                    </script>";
            header("refresh:1.5; url=/jaa/bookingphp/public/admin/admin.php?pt=upload");
        } else {
            $tmpname = $_FILES['fileupload']['tmp_name'];
            $image = Image::make($tmpname)->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
            })->encode('jpg', 50);

            $newfilename = time() . '_' . $filename;
            if ($image->save($targetDir . $newfilename)) {
                // chmod($targetDir . $newfilename, 0777);
                try {
                    $sql = "INSERT INTO products(name,amount,img,sn_products,upload_time) VALUE (:product_name, :amount, :img,:sn_products ,NOW())";
                    $query = $conn->prepare($sql);
                    $query->bindParam(":product_name", $product_name, PDO::PARAM_STR);
                    $query->bindParam(":amount", $amount, PDO::PARAM_INT);
                    $query->bindParam(":img", $newfilename, PDO::PARAM_STR);
                    $query->bindParam(":sn_products", $sn_product, PDO::PARAM_STR);
                    $query->execute();
                    echo '<script>document.getElementById("loading-spinner").classList.add("hidden");</script>';
                    echo "<script>window.location.href='/jaa/bookingphp/public/admin/admin.php?pt=upload'</script>";
                    $conn = null;
                } catch (PDOException $e) {
                    echo $e->getMessage();
                }
            } else {
                echo "<script>
                        $(document).ready(function() {
                            Swal.fire({
                                icon: 'warning',
                                title: 'มีบางอย่างผิดพลาด',
                                timer: 1500,
                                showConfirmButton: false
                            });
                        });
                    </script>";
                header("refresh:1.5; url=/jaa/bookingphp/public/admin/admin.php?pt=upload");
            }
        }
    } else {
        echo "<script>alert('Please enter both name and amount');</script>";
        echo "<script>window.location.href='/jaa/bookingphp/public/admin/admin.php?pt=upload';</script>";
    }
}
