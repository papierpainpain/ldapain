<?php
use \App\Models\File;
?>

<?php ob_start(); ?>

<section class="error">

    <figure>
        <img src="https://http.cat/404" alt="404">
    </figure>
    
    <p><?= isset($message) ? $message : '' ?></p>

</section>

<?php $content = ob_get_clean(); ?>

<?php
require(File::page('layout'));
?>