const selector = {
  actual: null,
  last: null,
  listOfQueue: {},
  init: function () {
    height = $j(".selector").height()
    $j(".selector").css("height", height)
    selector.getList();
    $j(".next").on("click", function () {
      selector.next();
    })
    $j(".preview").on("click", function () {
      selector.preview();
    })
  },
  getList: function () {
    $j.post("/api/queue", {}, function (response) {
      selector.listOfQueue = response;
    }).then(() => {
      lastIndex = Object.keys(selector.listOfQueue).length;
      if ($j(".actual").text() == "-") {
        $j(".preview").text(selector.listOfQueue[lastIndex - 2]);
        $j(".actual").text(selector.listOfQueue[lastIndex - 1]);
        selector.actual = lastIndex - 1
        selector.last = lastIndex
        $j(".next").text(selector.listOfQueue[lastIndex]);
      } else if ($j(".next").hasClass("invisible") && selector.last != Object.keys(selector.listOfQueue).length) {
        if ($j('.actual').hasClass("confirmation")) {
          selector.next()
        }
        let element = $j('.actual');
        element.removeClass('confirmation');
        console.log(selector.last + " " + selector.listOfQueue[lastIndex])
        $j(".next").toggleClass("invisible")
        $j(".next").text(selector.listOfQueue[lastIndex]);
        selector.last = lastIndex
      }
      selector.last = lastIndex

    });
  },
  next: function () {
    let element = $('.actual');
    element.removeClass('confirmation');
    nextElem = selector.actual + 1
    if (typeof selector.listOfQueue[nextElem] != "undefined") {
      $j(".preview").text(selector.listOfQueue[selector.actual]);
      selector.actual = nextElem
      $j(".actual").text(selector.listOfQueue[selector.actual]);
    }
    if (typeof selector.listOfQueue[selector.actual + 1] != "undefined") {
      $j(".next").text(selector.listOfQueue[selector.actual + 1]);
    } else {
      $j(".next").toggleClass("invisible")
    }
    if ($j(".preview").hasClass("invisible")) {
      $j(".preview").toggleClass("invisible")

    }
  },
  preview: function () {
    let element = $('.actual');
    element.removeClass('confirmation');
    previewElem = selector.actual - 1
    if (typeof previewElem != "undefined") {
      $j(".next").text(selector.listOfQueue[selector.actual]);
      selector.actual = previewElem
      $j(".actual").text(selector.listOfQueue[selector.actual]);
    }
    if (typeof selector.listOfQueue[selector.actual - 1] != "undefined") {
      $j(".preview").text(selector.listOfQueue[selector.actual - 1]);
    } else {
      $j(".preview").toggleClass("invisible")
    }
    if ($j(".next").hasClass("invisible")) {
      $j(".next").toggleClass("invisible")
    }
  }
};

let counter = 0;
$j(document).ready(function () {
  $j(".treceriBtn").bind("click", function () {
    total = 0;
    penalties = [];
    $j(".checkButtons")
      .find("input")
      .each(function () {
        if ($j(this).is(":checked")) {
          total += $j(this).data("penalizare");
          penalties.push($j(this).attr("id"));
          $j(this).prop("checked", false);
        }
      });
    sectiune = $j(".header").data("post");
    data = { sectiune, total, penalties: penalties };
    $j.post(SERVER_URL, { command: "penalizari", data: data }, function () {
      console.log("sended");
    });
    let textHandler = {
      concurent: $j(".concurentActiv").text(),
      total: total,
      post: sectiune,
      elemente: penalties
    }
    generateHTMLString(textHandler)
  });
  setInterval(selector.getList, 5000);
  selector.init();
});
