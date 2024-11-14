var tags_arr = "";

$(document).ready(function () {
  tags_arr = $("#tags").val().split(",");
  console.log(tags_arr);
});

$(document).on("click", "#tag-add", function () {
  let tag = $("#tag-input").val();

  console.log(tag);

  if (tag) {
    if (!tags_arr.includes(tag)) {
      tags_arr.push(tag);

      console.log(tags_arr);
      $("#tag-input").val("");
      $("#tags").val(tags_arr.join(","));
      $("#tag-list").append(
        "<li><span class='tag-text'>" +
          tag +
          "</span><button type='button' class='btn btn-danger tag-remove'>Remove</button></li>"
      );
    }
  }
});

$(document).on("click", ".tag-remove", function () {
  console.log("removing tag");
  console.log($(this).siblings()[0]);
  let tag_text = $(this).siblings().first().text();
  $(this).parent().remove();

  let index = tags_arr.indexOf(tag_text);
  if (index > -1) {
    tags_arr.splice(index, 1);
    $("#tags").val(tags_arr.join(","));
  }
});
