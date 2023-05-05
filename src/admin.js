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
  fetch("/data/concurentiTimp.csv")
    .then((response) => response.blob())
    .then((blob) => {
      // create a URL for the blob object
      const url = window.URL.createObjectURL(blob);

      // create a link element and click it to download the file
      const link = document.createElement("a");
      link.href = url;
      link.download = "concurentiTimp.csv";
      document.body.appendChild(link);
      link.click();
      document.body.removeChild(link);

      // release the URL object
      window.URL.revokeObjectURL(url);
    });
  fetch("/data/istoric.log")
    .then((response) => response.blob())
    .then((blob) => {
      // create a URL for the blob object
      const url = window.URL.createObjectURL(blob);

      // create a link element and click it to download the file
      const link = document.createElement("a");
      link.href = url;
      link.download = "istoric.log";
      document.body.appendChild(link);
      link.click();
      document.body.removeChild(link);

      // release the URL object
      window.URL.revokeObjectURL(url);
    });
  $.post(SERVER_URL, { command: "clearDb" }, function (response) {
    $(".popup").hide();
  });
}
