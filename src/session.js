let sessionPlayer = "../data/sessionPlayer.txt"
// Reading function
function readFile(sessionPlayer) {
    fetch(sessionPlayer)
      .then(response => response.text())
      .then(data => {
          console.log(data);
      }) 
      .catch(error => {
          console.error('Error:', error);
      });
  }
  
  // Writing function
  function writeFile(player) {
    $.post("server/test.php",{active:player},function(response){
      console.log(response) 
    });
  }
  