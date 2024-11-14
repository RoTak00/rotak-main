<?php
if (!$no_input) { ?>
    <img src="<?= $thumbnail ?>" class="filemanager-thumbnail">


    <button type="button" class="btn btn-primary filemanager-button">Select File</button>
    <input type="hidden" class="filemanager-path" name="<?= $file_name ?>" value="<?= $file_path ?>">
    <span class="filemanager-path-value"><?= $file_path ?></span>
    <?php
} else {
    ?> <input type="hidden" id="no-input" name="no-input" value="true">

    <button type="button" class="btn btn-primary filemanager-button">File Manager</button>
    <?php
}
?>



<dialog class="filemanager-dialog">

</dialog>