<?php

use \App\Models\File;

ob_start();
?>

<section>
    <div class="mainContent ouPas">
        <figure>
            <img src="/public/images/gif/gifHome.gif" alt="">
        </figure>

        <h1>Hello, <span id="pseudal"><?= $_SESSION['uid'] ?></span></h1>
    </div>
</section>

<?php $content = ob_get_clean(); ?>

<?php
require(File::page('layout'));
?>