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
  logInit();
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

function logInit() {
  if ($(".localLog").length > 0) {
    $(".localLog").height($(document).height() - $(".localLog").offset().top);
  }
}

function login() {
  username = $(".username").val();
  password = $(".password").val();
  data = { username: username, password: password };
  $.post(
    SERVER_URL,
    { command: "startSession", data: data },
    function (response) {
      var responseObject = JSON.parse(response);
      console.log(responseObject);
      if (responseObject["result"] == true) {
        var pathArray = window.location.pathname.split("/");
        var newPathname = "";
        for (i = 0; i < pathArray.length; i++) {
          newPathname += "/";
          newPathname += pathArray[i];
        }
        $("#div_session_write").load(
          "/views/auth.php?user=" +
            responseObject[0]["user"] +
            "&role=" +
            responseObject[0]["role"]
        );
      } else {
        $(".response").text("Datele sunt incorecte");
      }
    }
  );
}
