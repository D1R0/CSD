fetch("../data/concurenti.csv")
  .then((response) => response.text())
  .then((csv) => {
    Papa.parse(csv, {
      header: true,
      dynamicTyping: true,
      complete: function (results) {
         data = results.data;
        data.forEach((concurent)=>{
            $(".activePlayer").append("<option>"+concurent["nr. conc."]+"</option>")
        })
    },
});
});
function sendPlayer(){
    playerActive=$(".activePlayer").val()
    $.post("/server/server.php",{command:"write",active:playerActive},function(response){
        $(".showPlayer").text("Concurent Activ: "+playerActive)
    })
}
