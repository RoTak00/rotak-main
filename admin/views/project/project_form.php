<?= $head ?>

<?= $navigation ?>

<div class="container">
    <h1><?= $heading_title ?></h1>

    <hr>

    <div class="row">
        <div class="col-sm-4">
            <button type="submit" form="project-form" value="save" name="save" class="btn btn-primary">Save</button>
        </div>
        <div class="col-sm-4">
            <button type="submit" form="project-form" value="save-stay" name="save"
                class="save-stay btn btn-primary">Save & Stay</button>
        </div>
        <div class="col-sm-4">
            <a href="<?= $cancel ?>" class="btn btn-secondary">Cancel</a>
        </div>
    </div>


    <hr>

    <div>
        <form id="project-form" method="post">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Enter title"
                    value="<?= $title ?>" required>
            </div>

            <div class="form-group">
                <label for="ordering">Ordering</label>
                <input type="number" class="form-control" id="ordering" name="ordering" placeholder="Enter ordering"
                    value="<?= $ordering ?>" required>
            </div>

            <div class="form-group">
                <label for="link">Link</label>
                <input type="text" class="form-control" id="link" name="link" placeholder="Enter link"
                    value="<?= $link ?>" required>
            </div>

            <div class="form-group">
                <label for="project_date">Project Date</label>
                <input type="text" class="form-control" id="project_date" name="project_date"
                    placeholder="Enter Project Date" value="<?= $project_date ?>" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control render-html" id="description" name="description"
                    rows="10"><?= $description ?></textarea>
            </div>

            <div class="form-group">
                <button type="button" class="btn btn-primary" id="render-html">Render HTML</button>
                <div id="rendered-html" style="margin-top: 10px; padding: 10px; border: 1px solid #ddd;"></div>
            </div>

            <div class="form-group">
                <?= $image_manager ?>
            </div>


            <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="active" <?= $status == 'active' ? 'selected' : '' ?>>Active</option>
                    <option value="inactive" <?= $status == 'inactive' ? 'selected' : '' ?>>Inactive</option>
                    <option value="deleted" <?= $status == 'deleted' ? 'selected' : '' ?>>Deleted</option>
                </select>
            </div>

            <div class="form-group">
                <label for="tag_input">Project Tags</label>
                <input type="text" class="form-control" id="tag-input" placeholder="Enter a tag" />
                <button type="button" class="btn btn-primary" id="tag-add">Add</button>

                <input type="hidden" name="tags" id="tags" value="<?= $tags_string ?>">
            </div>
            <div>
                <ul id="tag-list">
                    <?php foreach ($tags as $tag): ?>
                        <li>
                            <span><?= $tag['tag_name'] ?></span>
                            <button type="button" class="btn btn-danger tag-remove">Remove</button>
                        </li>
                    <?php endforeach ?>
                </ul>
            </div>

        </form>
    </div>


</div>

<?= $footer ?>