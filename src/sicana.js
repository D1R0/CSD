let counter = 0;
$(document).ready(function () {
  $(".treceriBtn").bind("click", function () {
    total = 0;
    jaloanele = [];
    counter += 1;
    $(this).text("Trecere " + counter);
    $(".jaloaneSectiune")
      .find("input")
      .each(function () {
        if ($(this).is(":checked")) {
          total += $(this).data("penalizare");
          jaloanele.push($(this).attr("id"));
          $(this).prop("checked", false);
        }
      });
    sectiune = "Sicana" + $(".header").data("sicana");
    console.log(sectiune);
    data = { sectiune, total, jaloane: jaloanele };
    $.post(SERVER_URL, { command: "penalizari", data: data }, function () {
      console.log("sended");
    });
    $(".localLog p")
      .first()
      .before(
        "<p>Trecere " +
          counter +
          ", penalizari: " +
          jaloanele +
          ", total timp " +
          total +
          "</p>"
      );
  });
});
