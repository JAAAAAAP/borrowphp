$(document).on("click", ".delete", function () {
  id = $(this).attr("id");
  $.ajax({
    type: "post",
    url: "../controller/order_delete.php",
    data: {
      id: id,
      program: "del",
    },
    success: function (msg) {
      if (msg === "ok") {
        Swal.fire({
          icon: "success",
          title: "นำออกข้อมูลสำเร็จ",
          timer: 1500,
          showConfirmButton: false,
        }).then(function () {
          window.location.reload();
        });
      } else {
        Swal.fire({
          icon: "success",
          title: "นำออกข้อมูลสำเร็จ",
          timer: 1500,
          showConfirmButton: false,
        }).then(function () {
          window.location.reload();
        });
      }
    },
  });
});

