// Read function
function activePlayer() {
  $.post(SERVER_URL, { command: "read" }, function (response) {
    player= response;
  }).then(()=>{
    return player
  })
}

// Writing function

$(document ).ready(function () {
  // activePlayer().wait().then(() => {
  //   console.log(player);
  //   $(".activePlayer").text(
  //     $(".activePlayer").text().replace("%jucator%", activePlayer())
  //   );
  // });
});
