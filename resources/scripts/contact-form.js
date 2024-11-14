$(document).on("submit", "#contact-form", function (e) {
  e.preventDefault(); // Prevent default form submission

  // Collect form data
  const formData = {
    name: $("#name").val(),
    email: $("#email").val(),
    message: $("#content").val(),
    phone: $("#phone").val(),
  };

  // Send AJAX request
  $.ajax({
    url: "/module/contactform/send", // Replace with your server URL
    type: "POST",
    data: formData,
    success: function (response) {
      $("#name").val("");
      $("#email").val("");
      $("#content").val("");
      $("#phone").val("");

      // Change button text
      const btn = $('#contact-form button[type="submit"]');
      const originalText = btn.text();
      btn.text("Your message was sent");
      btn.prop("disabled", "disabled");

      // Revert button text after 5 seconds
      setTimeout(function () {
        btn.text(originalText);
        btn.prop("disabled", false);
      }, 5000);
    },
    error: function () {
      alert("An error occurred. Please try again.");
    },
  });
});
