<section id="contact">

    <form id="contact-form">
        <div class="row">
            <div class="form-group col-md-6">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" required>
            </div>
            <div class="form-group col-md-6">
                <label for="email">Email address</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email"
                    required>
            </div>

            <input type="tel" name="phone" id="phone"
                style="height: 0; width: 0; padding: 0; margin: 0; position: absolute;">
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
</section>