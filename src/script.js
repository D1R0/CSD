// fetch("../data/concurenti.csv")
//   .then((response) => response.text())
//   .then((csv) => {
//     if(typeof Papa != undefined){
//     Papa.parse(csv, {
//       header: true,
//       dynamicTyping: true,
//       complete: function (results) {
//         if ($("data-table").length > 1) {
//           var data = results.data;
//           var headers = results.meta.fields;
//           var table = document.getElementById("data-table");
//           var thead = document.createElement("thead");
//           var row = thead.insertRow();
//           headers.forEach(function (header) {
//             var th = document.createElement("th");
//             th.innerHTML = header;
//             row.appendChild(th);
//           });
//           table.appendChild(thead);
//           for (var i = 0; i < data.length; i++) {
//             var row = table.insertRow();
//             for (var key in data[i]) {
//               var cell = row.insertCell();
//               var text = document.createTextNode(
//                 data[i][key] == null ? "" : data[i][key]
//               );
//               cell.appendChild(text == "null" ? "" : text);
//               cell.setAttribute("id", key);
//             }
//           }
//           active = 1;
//           activeFunc(active);
//         }
//       },
//     });
//   }
// });
const SERVER_URL = "/api/services";
$(function () {
  $(".next").on("click", function () {
    if (active < $("#data-table tr").length) {
      active += 1;
      activeFunc(active);
    }
  });
  $(".back").on("click", function () {
    if (active > 1) {
      active -= 1;
      activeFunc(active);
    }
  });
});
function activeFunc(active) {
  $("#data-table tr").each(function () {
    $(this).removeClass("highlight");
  });
  $("#stopwatch #time").text("00:00:00");
  concurent = $("#data-table tr")[active];
  $(concurent).addClass("highlight");
  nrConc = $($(concurent).children()[0]).text();
  numeConc = $($(concurent).children()[1]).text();
  numePilot = $($(concurent).children()[2]).text();
  auto = $($(concurent).children()[3]).text();
  grupa = $($(concurent).children()[4]).text();
  $(".activeRow .active .nrConc").text(nrConc);
  $(".activeRow .active .numeConc").text(numeConc);
  $(".activeRow .active .numePilot").text(numePilot);
  $(".activeRow .active .auto").text(auto);
  $(".activeRow .active .clasa").text(grupa);
}

let startTime;
let stopTime;
let running = false;
let updateTime;

function start() {
  if (!running) {
    running = true;
    startTime = new Date();
    updateTime = setInterval(update, 10);
    document.getElementById("start").innerHTML = "Stop";
    $.post(SERVER_URL, { command: "clean" }, function (response) {
      console.log("updated");
    });
  } else {
    running = false;
    clearInterval(updateTime);
    document.getElementById("start").innerHTML = "Start";
    $.post(
      SERVER_URL,
      { command: "timp", timp: $("#time").text() },
      function (response) {
        console.log("updated");
      }
    );
  }
}
function timeFinal(time) {
  $.post(url, { command: "timp", time: time }, function (response) {
    console.log(response);
  });
}
function update() {
  stopTime = new Date();
  let time = (stopTime - startTime) / 1000;
  let minutes = Math.floor(time / 60);
  let seconds = Math.floor(time - minutes * 60);
  let milliseconds = Math.floor((time - (seconds + minutes * 60)) * 100);
  let minutesString = minutes.toString().padStart(2, "0");
  let secondsString = seconds.toString().padStart(2, "0");
  let millisecondsString = milliseconds.toString().padStart(2, "0");
  document.getElementById("time").innerHTML =
    minutesString + ":" + secondsString + "." + millisecondsString;
}

function reset() {
  running = false;
  clearInterval(updateTime);
  document.getElementById("time").innerHTML = "00:00:00";
  document.getElementById("start").innerHTML = "Start";
}

$(".start").on("click", start);

function exportCSV() {
  // Create a CSV string from the table data
  table = document.getElementById("data-table");

  var csvString = "";
  for (var i = 0; i < table.rows.length; i++) {
    for (var j = 0; j < table.rows[i].cells.length; j++) {
      csvString += table.rows[i].cells[j].innerHTML + ",";
    }
    csvString = csvString.slice(0, -1);
    csvString += "\n";
  }

  // Create a CSV file and trigger a download
  var link = document.createElement("a");
  link.href = "data:text/csv;charset=utf-8," + encodeURIComponent(csvString);
  link.style = "visibility:hidden";
  link.download = "table-data.csv";
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);
}
