$(document).ready(function () {
    $(".treceriBtn").on("click", function () {
      total = 0;
      jaloanele = [];
      $(".checkButtons")
        .find("input")
        .each(function () {
          if ($(this).is(":checked")) {
            total += $(this).data("penalizare");
            jaloanele.push($(this).attr("id"));
            $(this).prop("checked", false);
          }
        });
      sectiune = "Jalon"+$(".header").data("jalon");
      data = { sectiune, total, jaloane: jaloanele };
      $.post(SERVER_URL, { command: "penalizari", data: data }, function () {
        console.log("sended");
      });
    });
  });
  