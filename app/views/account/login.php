<?php

use \App\Models\File;
?>

<?php ob_start(); ?>
<h1>Login</h1>

<form action="/login" method="post">
    <div class="form-outline mb-4">
        <label class="form-label" for="uid">UID</label>
        <input class="form-control" type="text" id="uid" name="uid">
    </div>

    <div class="form-outline mb-4">
        <label class="form-label" for="pwd">Mot de passe</label>
        <input class="form-control" type="password" id="pwd" name="pwd">
    </div>

    <input class="btn btn-primary btn-block mb-4" type="submit" name="send" id="send" value="Send" />
    <a class="btn btn-warning btn-block mb-4" href="/reset-pwd" role="button">reset-pwd</a>
</form>
<?php $content = ob_get_clean(); ?>

<?php
require(File::page('layout'));
?>