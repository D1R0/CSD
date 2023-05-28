const SERVER_URL = "/api/services";
const clearQueue = "/api/clearQueue";
$j(function () {

  logInit();
});
function activeFunc(active) {
  $j("#data-table tr").each(function () {
    $j(this).removeClass("highlight");
  });
  $j("#stopwatch #time").text("00:00:00");
  concurent = $j("#data-table tr")[active];
  $j(concurent).addClass("highlight");
  nrConc = $j($j(concurent).children()[0]).text();
  numeConc = $j($j(concurent).children()[1]).text();
  numePilot = $j($j(concurent).children()[2]).text();
  auto = $j($j(concurent).children()[3]).text();
  grupa = $j($j(concurent).children()[4]).text();
  $j(".activeRow .active .nrConc").text(nrConc);
  $j(".activeRow .active .numeConc").text(numeConc);
  $j(".activeRow .active .numePilot").text(numePilot);
  $j(".activeRow .active .auto").text(auto);
  $j(".activeRow .active .clasa").text(grupa);
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
    $j.post(SERVER_URL, { command: "clean" }, function (response) {
      console.log("updated");
    });
  } else {
    running = false;
    clearInterval(updateTime);
    document.getElementById("start").innerHTML = "Start";
    $j.post(
      SERVER_URL,
      { command: "timp", timp: $j("#time").text() },
      function (response) {
        console.log("updated");
      }
    );
  }
}
function timeFinal(time) {
  $j.post(url, { command: "timp", time: time }, function (response) {
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

$j(".start").on("click", start);

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
  if ($j(".localLog").length > 0) {
    $j(".localLog").height($j(document).height() - $j(".localLog").offset().top);
  }
}

function login() {
  username = $j(".username").val();
  password = $j(".password").val();
  data = { username: username, password: password };
  $j.post(
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
        $j("#div_session_write").load(
          "/views/auth.php?user=" +
            responseObject[0]["user"] +
            "&role=" +
            responseObject[0]["role"]
        );
      } else {
        $j(".response").text("Datele sunt incorecte");
      }
    }
  );
}
