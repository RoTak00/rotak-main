<form id="contact-form">
    <div class="row">
        <div class="form-group col-md-6">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" required>
        </div>
        <div class="form-group col-md-6">
            <label for="email">Email address</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
        </div>
    </div>
    <div class="form-group">
        <label for="content">Content</label>
        <textarea class="form-control" id="content" name="content" rows="6" placeholder="Write your message here"
            required></textarea>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary w-100">Submit</button>
    </div>
</form>

<script>
    // jQuery AJAX form submit
    $('#contact-form').on('submit', function (e) {
        e.preventDefault(); // Prevent default form submission

        // Collect form data
        const formData = {
            name: $('#name').val(),
            email: $('#email').val(),
            message: $('#content').val()
        };

        // Send AJAX request
        $.ajax({
            url: 'https://www.backend.rotak.ro/api/contact',  // Replace with your server URL
            type: 'POST',
            data: formData,
            success: function (response) {
                $('#name').val('');
                $('#email').val('');
                $('#content').val('');

                // Change button text
                const btn = $('#contact-form button[type="submit"]');
                const originalText = btn.text();
                btn.text('Your message was sent');
                btn.prop("disabled", "disabled");

                // Revert button text after 5 seconds
                setTimeout(function () {
                    btn.text(originalText);
                    btn.prop("disabled", false);
                }, 5000);

            },
            error: function () {
                alert('An error occurred. Please try again.');
            }
        });
    });
</script>