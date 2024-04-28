<?php
require $_SERVER['DOCUMENT_ROOT'] . '/jaa/bookingphp/vendor/autoload.php';

use Intervention\Image\ImageManagerStatic as Image;
// ตรวจสอบว่ามีการอัปโหลดไฟล์หรือไม่
if (isset($_POST['submit'])) {
  include_once($_SERVER['DOCUMENT_ROOT'] . '/jaa/bookingphp/config/connectdb.php');
  include_once('../plugin/script.php');

  $id = $_POST['id'];
  $productname = $_POST['name'];
  $amount = $_POST['amount'];
  $sql = "SELECT * FROM products WHERE p_id = :id";
  $query = $conn->prepare($sql);
  $query->bindParam(":id", $id, PDO::PARAM_INT);
  $query->execute();
  $product = $query->fetch(PDO::FETCH_ASSOC);

  if ($_FILES['filename']['error'] == UPLOAD_ERR_OK) {
    $filename = $_FILES['filename']['name'];
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
      $targetDir = "../public/img/";
      $tmpname = $_FILES['filename']['tmp_name'];
      $image = Image::make($tmpname)->resize(800, null, function ($constraint) {
        $constraint->aspectRatio();
      })->encode('jpg', 50);

      $newfilename = time() . '_' . $filename;
      $image->save($targetDir . $newfilename);

      if (!empty($image)) {
        unlink($targetDir . $product['img']);
      }
    }
  }

  if (!empty($productname)) {
    try {
      $updateName = "UPDATE products SET name = :name WHERE p_id = :id";
      $query = $conn->prepare($updateName);
      $query->bindParam(":name", $productname, PDO::PARAM_STR);
      $query->bindParam(":id", $id, PDO::PARAM_INT);
      $query->execute();
    } catch (Exception $e) {
      echo $e->getMessage();
    }
  }

  if (!empty($amount)) {
    try {
      $updateAmount = "UPDATE products SET amount = :amount WHERE p_id = :id";
      $query = $conn->prepare($updateAmount);
      $query->bindParam(":amount", $amount, PDO::PARAM_INT);
      $query->bindParam(":id", $id, PDO::PARAM_INT);
      $query->execute();
    } catch (Exception $e) {
      echo $e->getMessage();
    }
  }
  if (isset($newfilename)) {
    try {
      $updateImg = "UPDATE products SET img = :img WHERE p_id = :id";
      $query = $conn->prepare($updateImg);
      $query->bindParam(":img", $newfilename, PDO::PARAM_STR);
      $query->bindParam(":id", $id, PDO::PARAM_INT);
      $query->execute();
    } catch (Exception $e) {
      echo $e->getMessage();
    }
  }
  $updateTime = "UPDATE products SET update_time = NOW() WHERE p_id = :id";
  $stmt = $conn->prepare($updateTime);
  $stmt->bindParam(":id", $id, PDO::PARAM_INT);
  $stmt->execute();
  echo "<script>
          $(document).ready(function() {
              Swal.fire({
              icon: 'success',
              title: 'แก้ไขสำเร็จ',
              timer: 1500,
              showConfirmButton: false
            });
          });
        </script>";
  header("refresh:1.5; url=/jaa/bookingphp/public/admin/admin.php?pt=upload");
}
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
    // ตรวจสอบว่ามีการอัปโหลดไฟล์หรือไม่
  //   if ($_FILES['filename']['error'] == UPLOAD_ERR_OK) {
  //     $filename = $_FILES['filename']['name'];
  //     $tempname = $_FILES['filename']['tmp_name'];
  //     $ext = pathinfo($filename, PATHINFO_EXTENSION);
  //     $imgname = round(microtime(true) * 1000);
  //     $newfilename = $imgname . "." . $ext;
  //     $targetDir = "../public/img/";

  //     // ย้ายไฟล์ที่อัปโหลดไปยังไดเรกทอรีที่ต้องการ
  //     move_uploaded_file($tempname, $targetDir . $newfilename);

  //     // ตรวจสอบว่าไฟล์เก่ามีหรือไม่ ถ้ามีให้ลบไฟล์เก่าทิ้ง
  //     if (!empty($product['img'])) {
  //       unlink($targetDir . $product['img']);
  //     }
  //   }

  //   // ตรวจสอบว่ามีการเลือกอัปเดตชื่อสินค้าหรือไม่
  //   if (!empty($name)) {
  //     $updateName = "UPDATE products SET name = :name WHERE p_id = :id";
  //     $stmt = $conn->prepare($updateName);
  //     $stmt->bindParam(":name", $name, PDO::PARAM_STR);
  //     $stmt->bindParam(":id", $id, PDO::PARAM_INT);
  //     $stmt->execute();
  //   }

  //   // ตรวจสอบว่ามีการเลือกอัปเดตจำนวนสินค้าหรือไม่
  //   if (!empty($amount)) {
  //     $updateAmount = "UPDATE products SET amount = :amount WHERE p_id = :id";
  //     $stmt = $conn->prepare($updateAmount);
  //     $stmt->bindParam(":amount", $amount, PDO::PARAM_INT);
  //     $stmt->bindParam(":id", $id, PDO::PARAM_INT);
  //     $stmt->execute();
  //   }

  //   // ตรวจสอบว่ามีการอัปโหลดไฟล์ใหม่หรือไม่
  //   if (isset($newfilename)) {
  //     $updateImg = "UPDATE products SET img = :img WHERE p_id = :id";
  //     $stmt = $conn->prepare($updateImg);
  //     $stmt->bindParam(":img", $newfilename, PDO::PARAM_STR);
  //     $stmt->bindParam(":id", $id, PDO::PARAM_INT);
  //     $stmt->execute();
  //   }

  //   // อัปเดตเวลา
  //   $updateTime = "UPDATE products SET time = NOW() WHERE p_id = :id";
  //   $stmt = $conn->prepare($updateTime);
  //   $stmt->bindParam(":id", $id, PDO::PARAM_INT);
  //   $stmt->execute();

  //   // ส่งกลับไปยังหน้าที่แสดงรายการสินค้าหลังจากอัปเดต
  //   header("Location: /jaa/bookingphp/public/admin/upload.php");
  //   exit();
  // }

  // if (isset($_FILES['filename'])) {
  //   $filename = $_FILES['filename']['name'];
  //   $ext = pathinfo($filename, PATHINFO_EXTENSION);
  //   $allowed = array('jpg', 'png', 'jpeg');

  //   if (!in_array($ext, $allowed)) {
  //     echo "<script>
  //             $(document).ready(function() {
  //               Swal.fire({
  //                 icon: 'error',
  //                 title: 'อัพโฟลดได้แค่ไฟล์ JPG PNG JPEG',
  //                 timer: 1500,
  //                 showConfirmButton: false
  //               });
  //             });
  //           </script>";
  //     header("refresh:1.5; url=/jaa/bookingphp/public/admin/upload.php");
  //   } else {
  //     $name = explode(".", $filename);
  //     $ext = $name[1];
  //     $imgname = round(microtime(true) * 1000);
  //     $newfilename = $imgname . "." . $ext;

  //     $tmpname = $_FILES['fileupload']['tmp_name'];
  //     $moveto = $targetDir . $newfilename;

  //     if (move_uploaded_file($tmpname, $moveto)) {
  //       chmod($targetDir . $newfilename, 0777);
  //       unlink($targetDir . $product['img']);

  //       $update = "UPDATE products SET amount = :amount";
  //       $params = array(":amount" => $amount);

  //       if (!empty($filename)) {
  //         $update .= ", img = :img";
  //         $params[":img"] = $newfilename;
  //       }

  //       $update .= ", time = NOW() WHERE p_id = :id";
  //       $params[":id"] = $id;

  //       // Execute the SQL statement
  //       $query = $conn->prepare($update);
  //       $query->execute($params);
  //     }
  //   }
  // }
// }
