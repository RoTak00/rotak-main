<div class="filemanager" data-path="<?= $current_path ?>">
    <h3>File Manager</h3>
    <span class="filemanager-close">X</span>
    <p class="filemanager-path">In: <?= $current_path ?></p>

    <div class="filemanager-actions">
        <label for="file-upload" class="filemanager-upload-btn">
            <i class="fas fa-upload"></i> Upload
        </label>
        <input type="file" class="file-upload" id="file-upload" style="display: none;">

        <button type="button" class="filemanager-create-folder-btn">
            <i class="fas fa-folder-plus"></i> Create Folder
        </button>
    </div>

    <?php if (!$is_root) { ?>
        <div class="filemanager-folder-action back" data-path="<?= $parent ?>">Back</div>
    <?php } ?>

    <div class="filemanager-folder-list">
        <?php foreach ($dir_names as $folder) { ?>
            <div class="filemanager-folder-action" data-path="<?= $folder ?>">
                <span><?= $folder ?></span>
            </div>
        <?php } ?>
    </div>

    <div class="filemanager-file-list">
        <?php foreach ($file_names as $file) { ?>
            <div class="filemanager-file-action <?= !empty($file['thumbnail']) ? 'has-thumbnail' : '' ?>"
                data-path="<?= $file['path'] ?>">
                <?php if (!empty($file['thumbnail'])) { ?>
                    <img src="<?= $file['thumbnail'] ?>">
                <?php } ?>
                <span><?= $file['path'] ?></span>
                <i class="fas fa-trash filemanager-file-delete" data-path="<?= $file['path'] ?>"></i>
            </div>
        <?php } ?>
    </div>
</div>