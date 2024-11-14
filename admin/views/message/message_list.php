<?= $head ?>

<?= $navigation ?>

<div class="container">
    <h1><?= $heading_title ?></h1>

    <hr>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">E-mail</th>
                <th scope="col">Message</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($messages as $message): ?>
                <tr>
                    <td scope="row"><?= $message['message_id'] ?></td>
                    <td scope="row"><?= $message['email'] ?></td>
                    <td scope="row"><?= $message['message'] ?><br>
                    <span style = "text-align: right;"><?= $message['date_added'] ?> by <?= $message['name'] ?></span></td>
                    
                    
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $footer ?>