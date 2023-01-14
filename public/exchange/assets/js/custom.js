$(document).ready(function () {
  $("#int_edit").click(function () {
    $(this).text(function (i, v) {
      return v === "Edit" ? "Save" : "Edit";
    });

    let actionValue = $(this).text();

    if (actionValue == "Edit") {
      let newObj = [];
      let timeSlotObj = [];
      $('input[type="checkbox"].int_label').each(function () {
        let statusVal = $(this).val();
        let attrValue = $(this).attr("data-value");
        let textValue = $(this).attr("id");

        if (statusVal == 1) {
          newObj.push({ t: textValue, s: "0", v: attrValue });
          timeSlotObj.push({ t: textValue, v: attrValue, a: "1" });
        } else {
          timeSlotObj.push({ t: textValue, v: attrValue, a: "0" });
        }
      });

      if (Object.keys(newObj).length) {
        localStorage.removeItem("userSetInterval");
        localStorage.setItem("userSetInterval", JSON.stringify(newObj));
      } else {
        newObj = localStorage.getItem("userSetInterval");
        newObj = JSON.parse(newObj);
      }

      let htmlData = "";
      $.each(newObj, (index, value) => {
        if (value.s == "1") {
          htmlData +=
            '<div data-value="' +
            value.v +
            '" class="fiveMinute mx-1 time-interval text-warning">' +
            value.t +
            "</div>";
        } else {
          htmlData +=
            '<div data-value="' +
            value.v +
            '" class="fiveMinute mx-1 time-interval">' +
            value.t +
            "</div>";
        }
      });

      localStorage.removeItem("timeSlotListData");
      localStorage.setItem("timeSlotListData", JSON.stringify(timeSlotObj));

      let htmlListData = "";
      $.each(timeSlotObj, (index, value) => {
        if (value.a == "1") {
          htmlListData +=
            '<div class="int_width text-center show"><div class="form-check mb-0 position-relative ps-0"><input data-value="' +
            value.v +
            '" class="form-check-input d-none int_label fiveMinute" type="checkbox" value="1" id="' +
            value.t +
            '"><label class="form-check-label int_label w-100" for="' +
            value.t +
            '">' +
            value.t +
            '</label><span class="position-absolute check_icon"><i class="fas fa-check-circle d-block"></i></span></div></div>';
        } else {
          htmlListData +=
            '<div class="int_width text-center"><div class="form-check mb-0 position-relative ps-0"><input data-value="' +
            value.v +
            '" class="form-check-input d-none int_label fiveMinute" type="checkbox" value="0" id="' +
            value.t +
            '"><label class="form-check-label int_label w-100" for="' +
            value.t +
            '">' +
            value.t +
            '</label><span class="position-absolute check_icon"><i class="fas fa-check-circle d-block"></i></span></div></div>';
        }
      });

      $("#showInterval").html(htmlData);
      $(".intervalList").html(htmlListData);
      $("#collapseButton").trigger("click");
    }
  });

  let userSetInterval = localStorage.getItem("userSetInterval");

  if (!userSetInterval) {
    let a = [];
    a = [
      { t: "5m", s: "0", v: "5" },
      { t: "10m", s: "0", v: "10" },
      { t: "15m", s: "0", v: "15" },
      { t: "1H", s: "0", v: "60" },
      { t: "4H", s: "0", v: "240" },
      { t: "1D", s: "1", v: "1440" },
    ];

    let timeSlotList = [];

    timeSlotList = [
      { t: "1m", v: "1", a: "0" },
      { t: "3m", v: "3", a: "0" },
      { t: "5m", v: "5", a: "1" },
      { t: "10m", v: "10", a: "1" },
      { t: "15m", v: "15", a: "1" },
      { t: "30m", v: "30", a: "0" },
      { t: "1h", v: "60", a: "1" },
      { t: "2h", v: "120", a: "0" },
      { t: "4h", v: "240", a: "1" },
      { t: "8h", v: "480", a: "0" },
      { t: "12h", v: "720", a: "0" },
      { t: "1d", v: "1440", a: "1" },
      { t: "3d", v: "4320", a: "0" },
      { t: "1w", v: "10080", a: "0" },
      { t: "3w", v: "30240", a: "0" },
      { t: "1M", v: "43200", a: "0" },
    ];

    localStorage.setItem("userSetInterval", JSON.stringify(a));
    localStorage.setItem("timeSlotListData", JSON.stringify(timeSlotList));

    $("#showInterval").html(
      '<div data-value="5" class="fiveMinute mx-1 time-interval">5m</div><div data-value="10" class="fiveMinute mx-1 time-interval">10m</div><div data-value="15" class="fiveMinute mx-1 time-interval">15m</div><div data-value="60" class="fiveMinute mx-1 time-interval">1H</div><div data-value="240" class="fiveMinute mx-1 time-interval">4H</div><div data-value="1440" class="fiveMinute mx-1 time-interval text-warning">1D</div>'
    );
  } else {
    //userSetInterval = localStorage.getItem("userSetInterval");

    userSetInterval = JSON.parse(userSetInterval);

    let timeSlotListData = localStorage.getItem("timeSlotListData");
    timeSlotListData = JSON.parse(timeSlotListData);

    let htmlData = "";
    $.each(userSetInterval, (index, value) => {
      if (value.s == "1") {
        htmlData +=
          '<div data-value="' +
          value.v +
          '" class="fiveMinute mx-1 time-interval text-warning">' +
          value.t +
          "</div>";
      } else {
        htmlData +=
          '<div data-value="' +
          value.v +
          '" class="fiveMinute mx-1 time-interval">' +
          value.t +
          "</div>";
      }
    });
    let htmlListData = "";
    $.each(timeSlotListData, (i, value) => {
      if (value.a == "1") {
        htmlListData +=
          '<div class="int_width text-center show"><div class="form-check mb-0 position-relative ps-0"><input data-value="' +
          value.v +
          '" class="form-check-input d-none int_label fiveMinute" type="checkbox" value="1" id="' +
          value.t +
          '"><label class="form-check-label int_label w-100" for="' +
          value.t +
          '">' +
          value.t +
          '</label><span class="position-absolute check_icon"><i class="fas fa-check-circle d-block"></i></span></div></div>';
      } else {
        htmlListData +=
          '<div class="int_width text-center"><div class="form-check mb-0 position-relative ps-0"><input data-value="' +
          value.v +
          '" class="form-check-input d-none int_label fiveMinute" type="checkbox" value="0" id="' +
          value.t +
          '"><label class="form-check-label int_label w-100" for="' +
          value.t +
          '">' +
          value.t +
          '</label><span class="position-absolute check_icon"><i class="fas fa-check-circle d-block"></i></span></div></div>';
      }
    });

    $("#showInterval").html(htmlData);
    $(".intervalList").html(htmlListData);
  }
  $(".int_label").click(function () {
    var getValue = $(this).val();
    
  });

    $('body').on("click", 'input[type="checkbox"]', function () {

      $(this).val() == 1 ? $(this).val(0) : $(this).val(1);

      let initValue = $(this).val();
      let actionValue = $("#int_edit").text();

      
      if (actionValue == "Save") {
        if (initValue == 1) {
          $(this).parent().parent().addClass("show");
          $(this).nextAll(".check_icon").eq(0).addClass("d-block");
        } else {
          $(this).parent().parent().removeClass("show");
          $(this).nextAll(".check_icon").eq(0).removeClass("d-block");
        }
      }
    });


  $('body').find('input[type="checkbox"]').each(function (res) {

  });

});

$(document).ready(function () {
  "use strict";
  for (
    var e = document.querySelectorAll(".disable-autohide .market-symbol"),
      t = 0;
    t < e.length;
    t++
  )
    e[t].addEventListener("click", function (e) {
      e.stopPropagation();
    });

  // Switcher
  $("#switcher").on("click", function () {
    if ($("#switcher").attr("checked", true)) {
      $("body").toggleClass("dark-theme");
    } else if ($("#switcher").attr("checked", false)) {
      $("body").toggleClass("dark-theme");
    }
  });

  // DataTable
  $(".trade-market-table").DataTable({
    lengthChange: false,
    searching: false,
    paging: false,
    info: false,
    scrollY: "45vh",
    scrollCollapse: true,
  });

  // DataTable
  $(".account-box_table").DataTable({
    responsive: true,
    lengthChange: false,
    searching: false,
    paging: false,
    info: false,
    scrollY: "30vh",
    scrollX: false,
    scrollCollapse: true,
  });

  var screensize = document.documentElement.clientWidth;

  if (screensize > 0 && screensize < 1024) {
    var middelcontentwidth = screensize;

    $("#allTrade").css("width", middelcontentwidth);
    $("#openOrders").css("width", middelcontentwidth);
    $("#orderHistory").css("width", middelcontentwidth);

    $("#openOrders div table").removeAttr("style");
    $("#openOrders div table").css("width", "100%");

    $("#orderHistory div table").removeAttr("style");
    $("#orderHistory div table").css("width", "100%");

    $("#allTrade div table").removeAttr("style");
    $("#allTrade div table").css("width", "100%");
  } else if (screensize > 1023 && screensize < 1200) {
    var middelcontentwidth = screensize - 305;

    $("#allTrade").css("width", middelcontentwidth);
    $("#openOrders").css("width", middelcontentwidth);
    $("#orderHistory").css("width", middelcontentwidth);

    $("#openOrders div table").removeAttr("style");
    $("#openOrders div table").css("width", "100%");

    $("#orderHistory div table").removeAttr("style");
    $("#orderHistory div table").css("width", "100%");

    $("#allTrade div table").removeAttr("style");
    $("#allTrade div table").css("width", "100%");
  } else if (screensize > 1200) {
    var middelcontentwidth = screensize - 610;

    $("#allTrade").css("width", middelcontentwidth);
    $("#openOrders").css("width", middelcontentwidth);
    $("#orderHistory").css("width", middelcontentwidth);

    $("#openOrders div table").removeAttr("style");
    $("#openOrders div table").css("width", "100%");

    $("#orderHistory div table").removeAttr("style");
    $("#orderHistory div table").css("width", "100%");

    $("#allTrade div table").removeAttr("style");
    $("#allTrade div table").css("width", "100%");
  }

  $(".place-order_header .btn-close, .orderform-overlay").on(
    "click",
    function () {
      $(".place-order_container").removeClass("active");
      $(".orderform-overlay").removeClass("active");
    }
  );
  $(".profile-collapse").on("click", function () {
    $(".place-order_container").addClass("active");
    $(".orderform-overlay").addClass("active");
    $(".collapse.in").toggleClass("in");
  });

  // Order Form Tabs Trigger
  $(".btn-sell").on("click", function () {
    $(".nav-tabs > .nav-item").find("#sell-tab").trigger("click");
  });

  $(".btn-buy").on("click", function () {
    $(".nav-tabs > .nav-item").find("#buy-tab").trigger("click");
  });

  // Form Input Focus
  $(".input-group-form").on("click", function () {
    $(this).find("input").focus();
  });

  // Without JQuery
  var slider = new Slider("#ex13", {
    ticks: [0, 25, 50, 75, 100],
    ticks_positions: [0, 25, 50, 75, 100],
    ticks_labels: ["0%", "25%", "50%", "75%", "100%"],
    ticks_snap_bounds: 1,
  });

  var slider = new Slider("#ex14", {
    ticks: [0, 25, 50, 75, 100],
    ticks_positions: [0, 25, 50, 75, 100],
    ticks_labels: ["0%", "25%", "50%", "75%", "100%"],
    ticks_snap_bounds: 1,
  });

  // Table Progressbar
  var trs = document.querySelectorAll(".table-body tr");
  for (var i = 0; i < trs.length; i++) {
    var tr = trs[i];
    var pr = tr.querySelector(".progres-s");
    pr.style.right = tr.dataset.progress - 100 + "%";
    pr.style.height = tr.clientHeight + "px";
  }
});
// Preloader Text Animation
function preloaderTextAnimation() {
  let $ = (e) => document.querySelector(e);
  let dots = $(".dots");
  function animate(element, className) {
    element.classList.add(className);
    setTimeout(() => {
      element.classList.remove(className);
      setTimeout(() => {
        animate(element, className);
      }, 500);
    }, 2500);
  }
  animate(dots, "dots--animate");
}
// Preloader
$(window).on("load", function () {
  preloaderTextAnimation();
  setTimeout(function () {
    $(".loader-wrapper").fadeOut();
    $("body").css({ "overflow-y": "visible" });
  }, 1000);
});