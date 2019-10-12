function getUrlParameter(name) {
  name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
  var regex = new RegExp("[\\?&]" + name + "=([^&#]*)");
  var results = regex.exec(location.search);
  return results === null
    ? ""
    : decodeURIComponent(results[1].replace(/\+/g, " "));
}

function formatTwoDigits(int) {
  return ("0" + int).slice(-2);
}

function formatDate(date) {
  return (
    formatTwoDigits(date.getDate()) +
    "/" +
    formatTwoDigits(date.getMonth()) +
    "/" +
    date.getFullYear()
  );
}

function formatTime(date) {
  return (
    formatTwoDigits(date.getHours()) + ":" + formatTwoDigits(date.getMinutes())
  );
}

function spanishToEnglishDateString(spanishDate) {
  return spanishDate
    .split("/")
    .reverse()
    .join("-");
}

function englishToSpanishDateString(englishDate) {
  return englishDate
    .split("-")
    .reverse()
    .join("/");
}

function getRelativeUrl() {
  return window.location.pathname + window.location.search;
}

function initializeSelect2Material() {
  $(".select2-material").select2({
    theme: "material",
    placeholder: ""
  });

  $(".select2-material").on("change", function(e) {
    if ($(this).val() == "")
      $(this)
        .siblings(".select2-label")
        .removeClass("select2-label-active");
    else
      $(this)
        .siblings(".select2-label")
        .addClass("select2-label-active");
  });

  $(".select2-label").on("click", function(e) {
    $(this)
      .siblings("select")
      .select2("open");
  });

  $(".select2-selection__arrow").html(
    "<i class='fa fa-caret-down' aria-hidden='true'></i>&emsp;"
  );
}

function setInputFilter(textbox, inputFilter) {
  textbox.inputFilter = inputFilter;
  [
    "input",
    "keydown",
    "keyup",
    "mousedown",
    "mouseup",
    "select",
    "contextmenu"
  ].forEach(function(event) {
    textbox.addEventListener(event, function() {
      filterInput(textbox);
    });
  });
  filterInput(textbox);
}

// Implements input filtering for the given textbox.
function filterInput(textbox) {
  if (
    !textbox.hasOwnProperty("oldValue") ||
    textbox.inputFilter(textbox.value)
  ) {
    textbox.oldValue = textbox.value;
    textbox.oldSelectionStart = textbox.selectionStart;
    textbox.oldSelectionEnd = textbox.selectionEnd;
  } else {
    textbox.value = textbox.oldValue;
    textbox.setSelectionRange(
      textbox.oldSelectionStart,
      textbox.oldSelectionEnd
    );
  }
}
