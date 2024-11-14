<?= $head ?>

<?= $navigation ?>

<div class="container">
    <form method="post">

        <input class="form-control" type="text" name="email" placeholder="Email" value="<?= $email ?>" />

        <input class="form-control" type="password" name="password" placeholder="Password" />

        <input class="form-button" type="submit" value="Login" />
    </form>
</div>

<?= $footer ?>