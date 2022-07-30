<?php

use App\Middlewares\Auth;

$message = null;
$type = null;
if (isset($_SESSION['error'])) {
	$message = $_SESSION['error'];
	$_SESSION['error'] = null;
	$type = 'danger';
} elseif (isset($_SESSION['success'])) {
	$message = $_SESSION['success'];
	$_SESSION['success'] = null;
	$type = 'success';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />

	<title><?= ENV['site']['name'] ?></title>

	<meta name="viewport" content="width=device-width, initial-scale=1.0" />

	<link rel="preload" href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">
	<noscript>
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat&display=swap">
	</noscript>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

	<link rel="stylesheet" href="/public/css/main.css">
</head>

<body>

	<nav class="d-flex align-items-center justify-content-center justify-content-md-between">
		<a href="/" class="d-flex align-items-center col-md-3 text-dark text-decoration-none navbrand">
			<span id="navbrand-green">LDAP</span><span id="navbrand-white">ain</span><span id="navbrand-orange">/GPerduMonMdp</span>
		</a>

		<ul class="nav col-12 col-md-auto justify-content-center">

			<?php if (Auth::isConnected()) { ?>
				<a class="nav-link" href="/">Accueil</a>
				<?php if (!Auth::isAdmin()) { ?>
					<a class="nav-link" href="/profil">Mon profil</a>
				<?php } ?>
			<?php } ?>

			<?php if (Auth::isAdmin()) { ?>
				<a class="nav-link" href="/admin/users">Utilisateurs</a>
			<?php } ?>

		</ul>

		<div class="col-md-3 text-end">
			<?php if (Auth::isConnected()) { ?>
				<a class="nav-deconnect box-shadow" href="/logout">Déconnexion</a>
			<?php } ?>

		</div>
	</nav>


	<main>
		<?php
		if (isset($message)) { ?>
			<div class="alert alert-<?= $type ?>" role="alert">
				<?= $message ?>
			</div>
		<?php } ?>
		<?= $content ?>
	</main>

	<!-- JQuery + Bootstrap -->
	<script src="https://code.jquery.com/jquery-3.6.0.slim.min.js" integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>

	<script src="/public/js/main.js"></script>
</body>

</html>