<?php

use App\Models\File;
?>

<?php ob_start(); ?>
<div class="title">
    <h1>
        <h1>Créer un nouvel utilisateur</h1>
    </h1>
    <div class="underline"></div>
</div>

<section>
    <div class="mainContent">

        <form action="/admin/add-user" method="post" class="box-shadow">

            <input type="text" id="uid" name="uid" placeholder="Login" class="box-shadow">
            <input type="text" id="lastname" name="lastname" placeholder="Nom" class="box-shadow">
            <input type="text" id="firstname" name="firstname" placeholder="Prénom" class="box-shadow">
            <input type="email" id="mail" name="mail" placeholder="E-Mail" class="box-shadow">

            <button type="submit" name="send" id="send" class="box-shadow">Valider l'ajout</button>
        </form>

    </div>
</section>
<?php $content = ob_get_clean(); ?>

<?php
require(File::page('layout'));
?>