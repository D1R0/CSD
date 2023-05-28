const adminHandler = {
  init: function(){

    $j(".clearQueue").on("click", function(){
      $j.post(clearQueue, {}, function(response){
        location.reload()
      })
    })
  },
  clearQueue: function(){}
}

// fetch("../data/concurenti.csv")
//   .then((response) => response.text())
//   .then((csv) => {
//     Papa.parse(csv, {
//       header: true,
//       dynamicTyping: true,
//       complete: function (results) {
//         data = results.data;
//         console.log(data)
//         data.forEach((concurent) => {
//           $j(".activePlayer").append(
//             "<option>" +
//             Object.values(concurent)[0] +
//               " " +
//               Object.values(concurent)[1] +
//               "</option>"
//           );
//         });
//       },
//     });
//   });
function sendPlayer() {
  playerActive = $j(".activePlayer").val();
  $j.post(
    SERVER_URL,
    { command: "playerActive", active: playerActive },
    function (response) {
      $j(".showPlayer").text("Concurent Activ: " + playerActive);
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
  $j.post(SERVER_URL, { command: "clearDb" }, function (response) {
    $j(".popup").hide();
  });
}
function downloadTimpi() {
  fetch("/concurentiTimp.csv")
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
}

$j(document).ready(function(){
  adminHandler.init()
})
