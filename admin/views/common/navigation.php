<div>
    <ul class="main-nav">
        <li class="nav-item"><a href="/admin/">Home</a></li>

        <?php if ($logged) { ?>
            <li class="nav-item"><a href="/admin/content/project">Projects</a></li>
            <li class="nav-item"><a href="/admin/content/post">Posts</a>
                <ul>
                    <li class="nav-item"><a href="/admin/content/category">Categories</a></li>
                </ul>
            </li>
            <li class="nav-item"><a href="/admin/content/message">Messages</a></li>
            <li class="nav-item"><a href="/admin/account">Account</a>
                <ul>
                    <li class="nav-item"><a href="/admin/account/logout">Logout</a></li>
                </ul>
            </li>

        <?php } else { ?>
            <li class="nav-item"><a href="/admin/account/login">Login</a></li>
        <?php } ?>
    </ul>
</div>

<div class="notification-container">
    <?= $notifications ?>
</div>