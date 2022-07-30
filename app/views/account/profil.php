<?php

use App\Middlewares\Auth;
use \App\Models\File;

ob_start();
?>

<div class="title">
    <h1>Mon profil</h1>
    <div class="underline"></div>
</div>

<section>
    <div class="mainContent" id="profil">

        <h2>
            <?= $_SESSION['uid'] ?>
        </h2>
        <ul>
            <li>
                <p class="profilItem">DN <span id="osef">/Osef mais le chef voulait</span></p>
                <p><?= $_SESSION['dn'] ?></p>
            </li>

            <li>
                <p class="profilItem">Prénom</p>
                <p><?= $_SESSION['firstname'] ?></p>
            </li>

            <li>
                <p class="profilItem">Nom</p>
                <p><?= $_SESSION['lastname'] ?></p>
            </li>

            <li>
                <p class="profilItem">E-Mail</p>
                <p><?= $_SESSION['mail'] ?></p>
            </li>

            <?php if (!Auth::isAdmin()) { ?>
                <li>
                    <p class="profilItem">Mot de passe</p>
                    <p><a href="/change-pwd" class="resetPwd">Changer mon mot de passe <span>›</span></a></p>
                </li>
            <?php } ?>
        </ul>

        <div>
            <a class="aButton" href="/logout">Déconnexion</a>
        </div>

    </div>
</section>
<?php $content = ob_get_clean(); ?>

<?php
require(File::page('layout'));
?>