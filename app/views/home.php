<?php

use \App\Models\File;

ob_start();
?>

<div class="title">
    <h1>Connexion</h1>
    <div class="underline"></div>
</div>

<section>
    <div class="mainContent">
        <form action="/login" method="post" class="box-shadow">

            <input type="text" id="uid" name="uid" placeholder="Login" class="box-shadow">

            <input type="password" id="pwd" name="pwd" placeholder="Mot de passe" class="box-shadow">

            <a href="/reset-pwd" class="resetPwd">J'ai encore oublié mon mot de passe... <span>›</span></a>

            <button type="submit" name="send" id="send" class="box-shadow">Connexion</button>

        </form>

        <figure>
            <img src="/public/images/gif/gifLogin.gif" alt="">
        </figure>
    </div>
</section>

<?php $content = ob_get_clean(); ?>

<?php
require(File::page('layout'));
?>