$(document).on("click", "#render-html", function () {
  console.log("rendering html");
  var html = $(".render-html").val();
  $("#rendered-html").html(html);
});
