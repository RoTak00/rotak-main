<?= $head ?>

<?= $navigation ?>

<div class="container">
    <h1><?= $heading_title ?></h1>

    <hr>

    <div class="row">
        <div class="col-sm-4">
            <button type="submit" form="category-form" value="save" name="save" class="btn btn-primary">Save</button>
        </div>
        <div class="col-sm-4">
            <button type="submit" form="category-form" value="save-stay" name="save"
                class="save-stay btn btn-primary">Save & Stay</button>
        </div>
        <div class="col-sm-4">
            <a href="<?= $cancel ?>" class="btn btn-secondary">Cancel</a>
        </div>
    </div>


    <hr>

    <div>
        <form id="category-form" method="post">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Enter title"
                    value="<?= $title ?>" required>
            </div>

            <div class="form-group">
                <label for="alias">Alias</label>
                <input type="text" class="form-control" id="alias" name="alias" placeholder="Enter alias"
                    value="<?= $alias ?>" required>
            </div>

            <div class="form-group">
                <label for="parent">Parent</label>
                <select class="form-control" id="parent" name="parent">
                    <option value="0" <?= $parent == 0 ? 'selected' : '' ?>>None</option>
                    <?php foreach ($parent_categories as $category): ?>
                        <option value="<?= $category['category_id'] ?>" <?= $parent == $category['category_id'] ? 'selected' : '' ?>><?= $category['title'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="ordering">Ordering</label>
                <input type="number" class="form-control" id="ordering" name="ordering" placeholder="Enter ordering"
                    value="<?= $ordering ?>" required>
            </div>

            <div class="form-group">
                <label for="page">Page Content</label>
                <textarea class="form-control render-html" id="page" name="page" rows="10"><?= $page ?></textarea>
            </div>

            <div class="form-group">
                <button type="button" class="btn btn-primary" id="render-html">Render HTML</button>
                <div id="rendered-html" style="margin-top: 10px; padding: 10px; border: 1px solid #ddd;"></div>
            </div>

            <div class="form-group">
                <label for="show_list">Show List</label>
                <select class="form-control" id="show_list" name="show_list">
                    <option value="1" <?= $show_list == 1 ? 'selected' : '' ?>>Yes</option>
                    <option value="0" <?= $show_list == 0 ? 'selected' : '' ?>>No</option>
                </select>
            </div>


            <div class="form-group">
                <label for="active">Active</label>
                <select class="form-control" id="active" name="active" required>
                    <option value="1" <?= $active == 1 ? 'selected' : '' ?>>Active</option>
                    <option value="0" <?= $active == 0 ? 'selected' : '' ?>>Inactive</option>
                </select>
            </div>


            <div class="form-group" style="margin-top: 1em;">
                <?= $image_manager ?>
            </div>




        </form>
    </div>


</div>

<?= $footer ?>