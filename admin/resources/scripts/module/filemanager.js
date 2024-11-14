var popup_open = false;

var no_input = false;

if ($("#no-input").length > 0) {
  no_input = true;
}

$(document).on("click", ".filemanager-button", function () {
  let button = $(this);

  let input = no_input
    ? null
    : button.siblings("input.filemanager-path").first();
  let value = no_input
    ? null
    : button.siblings("span.filemanager-path-value").first();
  let dialog = button.siblings("dialog.filemanager-dialog").first();

  if (popup_open) return;

  loadPath(dialog, input.val());
});

$(document).on("click", ".filemanager-close", function () {
  let dialog = $(this).parents("dialog").first();
  dialog[0].close();
  popup_open = false;
});

$(document).on("click", ".filemanager-folder-action", function () {
  let button = $(this);
  let path = button.attr("data-path");

  loadPath(button.parents("dialog").first(), path);
});

$(document).on("click", ".filemanager-file-action", function () {
  if (no_input) {
    return;
  }
  let button = $(this);
  let path = button.attr("data-path");

  console.log(path);

  let dialog = button.parents("dialog").first();
  let input = dialog.siblings("input.filemanager-path").first();
  let value = dialog.siblings("span.filemanager-path-value").first();

  $.ajax({
    type: "POST",
    url: "/admin/module/filemanager/downloadImage",
    data: {
      path: path,
    },
  })
    .done(function (response) {
      $(".filemanager-thumbnail").attr("src", response);
    })
    .fail(function () {
      alert("err");
    });
  value.text(path);
  input.val(path);
  dialog[0].close();
  popup_open = false;
});

$(document).on("click", ".filemanager-create-folder-btn", function () {
  let button = $(this);
  let dialog = button.parents("dialog").first();

  let current_path = dialog.find(".filemanager").attr("data-path");

  createFolderWithPrompt(dialog, current_path);
});

$(document).on("click", ".filemanager-file-delete", function (e) {
  e.stopPropagation();
  let button = $(this);
  let path = button.attr("data-path");

  $.ajax({
    type: "POST",
    url: "/admin/module/filemanager/delete",
    data: {
      path: path,
    },
  })
    .done(function (response) {
      loadPath(button.parents("dialog").first(), path);
    })
    .fail(function () {
      loadPath(button.parents("dialog").first(), path);
    });
});

$(document).on("change", ".filemanager-actions .file-upload", function () {
  let dialog = $(this).parents("dialog").first();
  let path = dialog.find(".filemanager").attr("data-path");
  let file = this.files[0];

  if (file) {
    uploadFile(dialog, path, file);
  }
});

function loadPath(dialog, path) {
  let current_dialog_html = popup_open ? dialog.html() : "";

  $.ajax({
    type: "POST",
    url: "/admin/module/filemanager/load",
    data: {
      path: path,
    },
  })
    .done(function (response) {
      dialog.html(response);

      if (!popup_open) dialog[0].showModal();

      popup_open = true;
    })
    .fail(function () {
      if (popup_open) dialog.html(current_dialog_html);
      else dialog[0].close();
    });
}

function createFolderWithPrompt(dialog, path) {
  let folder_name = prompt("Enter folder name");
  if (!folder_name) return;

  $.ajax({
    type: "POST",
    url: "/admin/module/filemanager/create_folder",
    data: {
      path: path,
      folder_name: folder_name,
    },
  })
    .done(function (response) {
      loadPath(dialog, path + "/" + folder_name);
    })
    .fail(function () {
      loadPath(dialog, path);
    });
}

function uploadFile(dialog, path, file) {
  let formData = new FormData();
  formData.append("path", path);
  formData.append("file", file);

  $.ajax({
    type: "POST",
    url: "/admin/module/filemanager/upload",
    data: formData,
    contentType: false,
    processData: false,
  })
    .done(function (response) {
      loadPath(dialog, path);
    })
    .fail(function () {
      loadPath(dialog, path);
    });
}
