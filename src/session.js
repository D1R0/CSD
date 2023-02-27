// Read function
function activePlayer() {
  $.post("server/server.php", { command: "read" }, function (response) {
    player= response;
  }).then(()=>{
    return player
  })
}

// Writing function
function writeFile(player) {
  $.post(
    "server/server.php",
    { command: "write", active: player },
    function (response) {
      return response;
    }
  );
}

$(document ).ready(function () {
  activePlayer().then(() => {
    console.log(player);
    $(".activePlayer").text(
      $(".activePlayer").text().replace("%jucator%", activePlayer())
    );
  });
});
