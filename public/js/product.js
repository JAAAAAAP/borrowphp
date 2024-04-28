$(document).on("click", ".delete", function () {
  id = $(this).attr("id");
  $.ajax({
    type: "post",
    url: "../../controller/product_delete.php",
    data: {
      id: id,
      program: "del",
    },
    success: function (response) {
      Swal.fire({
        icon: "success",
        title: "ลบข้อมูลสำเร็จ",
        timer: 1500,
        showConfirmButton: false,
      }).then(
        setInterval(function () {
          window.location.reload();
        }, 1500)
      );
    },
    error: function (xhr, error) {
      Swal.fire({
        icon: "error",
        title: "เกิดข้อผิดพลาดอะไรบางอย่าง",
        timer: 1500,
        showConfirmButton: false,
      }).then(
        setInterval(function () {
          window.location.reload();
        }, 1500)
      );
    },
  });
});
