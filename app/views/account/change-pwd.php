<?php

use \App\Models\File;
?>

<?php ob_start(); ?>

<div class="title">
    <h1>
        <h1>Changer le mot de passe</h1>
    </h1>
    <div class="underline"></div>
</div>

<section>
    <div class="mainContent">

        <form action="/change-pwd" method="post" class="box-shadow">

            <input type="text" id="uid" name="uid" placeholder="Login" class="box-shadow">
            <input type="password" id="oldpwd" name="oldpwd" placeholder="Ancien mot de passe" class="box-shadow">
            <input type="password" id="newpwd" name="newpwd" placeholder="Nouveau mot de passe (à ne pas oublier)" class="box-shadow">
            <input type="password" id="newpwdcnf" name="newpwdcnf" placeholder="Encore le nouveau mot de passe" class="box-shadow">

            <button type="submit" name="send" id="send" class="box-shadow">Modifier le mot de passe</button>
            
        </form>
        <?php $content = ob_get_clean(); ?>

        <?php
        require(File::page('layout'));
        ?>