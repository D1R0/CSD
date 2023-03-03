$(document).ready(function () {
  $(".treceriBtn").on("click", function () {
    total = 0;
    jaloanele = [];
    $(".jaloaneSectiune")
      .find("input")
      .each(function () {
        if ($(this).is(":checked")) {
          total += $(this).data("penalizare");
          jaloanele.push($(this).attr("id"));
          $(this).prop("checked", false);
        }
      });
    sicana = $(".headerSicana").data("sicana");
    data = { sicana, total, jaloane: jaloanele };
    console.log(data);
    $.post(SERVER_URL, { command: "penalizari", data: data }, function () {
      console.log("sended");
    });
  });
});
