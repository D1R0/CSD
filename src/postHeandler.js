let counter = 0;
$(document).ready(function () {
  $(".treceriBtn").bind("click", function () {
    total = 0;
    penalties = [];
    counter += 1;
    $(this).text("Trecere " + counter);
    $(".checkButtons")
      .find("input")
      .each(function () {
        if ($(this).is(":checked")) {
          total += $(this).data("penalizare");
          penalties.push($(this).attr("id"));
          $(this).prop("checked", false);
        }
      });
    sectiune = $(".header").data("type") + $(".header").data("post");
    data = { sectiune, total, penalties: penalties };
    $.post(SERVER_URL, { command: "penalizari", data: data }, function () {
      console.log("sended");
    });
    $(".localLog p")
      .first()
      .before(
        "<p>Trecere " +
          counter +
          ", penalizari: " +
          penalties +
          ", total timp " +
          total +
          "</p>"
      );
  });
});
