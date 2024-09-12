<?php
    if($show_cookie_notif)
    { ?>
<div class = "cookie-notif">
    This site uses cookies. Continuing the use of the website represents your agreement on the usage of cookies. For more information regarding the management of preferences 
    on the use of cookies, read the <a href = "/<?=($subfolderName??"")?>info/cookies">Cookie Policy</a>.</p>
    <p style = "margin-bottom: 0;"><button class = "btn btn-dark" id = "button-accept-cookies"> I understand </button>
    <a role = "button" class = "btn btn-dark" href = "/<?=($subfolderName??"")?>info/cookies">Read more</a></p>
</div>

<?php } ?>