$(function () {
  $("#formlogin").submit(function (e) {
    e.preventDefault();
    FormData = $(this).serialize();
    $.ajax({
      type: "POST",
      url: "../controller/login.php",
      data: FormData,
      success: function (response) {
        // ประมวลผลเมื่อส่งข้อมูลสำเร็จ
        console.log(response);
        Swal.fire({
          target: document.getElementById("formlogin"),
          icon: "success",
          title: "เข้าสู่ระบบสำเร็จ",
          timer: 1500,
          showConfirmButton: false,
        }).then(function () {
          window.location.reload();
        });
      },
      error: function (xhr, error) {
        // ประมวลผลเมื่อเกิดข้อผิดพลาด
        console.error(error);
        if (xhr.status === 401) {
          Swal.fire({
            target: document.getElementById("formlogin"),
            icon: "error",
            title: "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง",
            timer: 1500,
            showConfirmButton: false,
          });
        } else {
          Swal.fire({
            target: document.getElementById("formlogin"),
            icon: "error",
            title: "เกิดข้อผิดพลาด",
            text: xhr.responseText,
          });
        }
      },
    });
  });
});
