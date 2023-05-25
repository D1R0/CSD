// Read function
function activePlayer() {
  $.post(SERVER_URL, { command: "read" }, function (response) {
    player = response;
  }).then(() => {
    $(".concurentActiv").text(player);
  });
}

setInterval(activePlayer, 5000);
