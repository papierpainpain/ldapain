<?php

use App\Models\File;
?>

<?php ob_start(); ?>

<div class="title">
    <h1>
        J'ai encore oublié mon mot de passe 😭
    </h1>
    <p id="blabla_troll">Et allez, un de plus... C'est vraiment honteux d'oublier son mot de passe aussi souvent.</p>
    <div class="underline"></div>
</div>

<section>
    <div class="mainContent">

        <form action="/reset-pwd" method="post" class="box-shadow">

            <input type="text" id="uid" name="uid" placeholder="Login" class="box-shadow">
            <button type="submit" name="send" id="send" class="box-shadow">Récupérer le mot de passe</button>

        </form>

    </div>
</section>

<?php $content = ob_get_clean(); ?>

<?php
require(File::page('layout'));
?>