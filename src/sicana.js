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
      sectiune = "Sicana"+$(".header").data("sicana");
      data = { sectiune, total, jaloane: jaloanele };
    $.post(SERVER_URL, { command: "penalizari", data: data }, function () {
      console.log("sended");
    });
  });
});
