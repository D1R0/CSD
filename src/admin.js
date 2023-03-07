fetch("../data/concurenti.csv")
  .then((response) => response.text())
  .then((csv) => {
    Papa.parse(csv, {
      header: true,
      dynamicTyping: true,
      complete: function (results) {
        data = results.data;
        data.forEach((concurent) => {
          $(".activePlayer").append(
            "<option>" +
              concurent["nr. conc."] +
              " " +
              concurent["Pilot"] +
              "</option>"
          );
        });
      },
    });
  });
function sendPlayer() {
  playerActive = $(".activePlayer").val();
  $.post(
    SERVER_URL,
    { command: "playerActive", active: playerActive },
    function (response) {
      $(".showPlayer").text("Concurent Activ: " + playerActive);
    }
  );
}

function clearDatas() {
  $.post(SERVER_URL, { command: "clearDb" }, function (response) {
    $(".popup").hide();
  });
}
