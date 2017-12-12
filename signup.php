<!DOCTYPE html>
<html>
<head>
    <title></title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<section class="main-container">
	<div class="main-wrapper">
        <ul>
            <li><a href="home.php">Home</a></li>
        </ul>
		<h2>Signup</h2>
        <!-- o metodo post chama o script php que registra os usuários -->
        <!-- o post 'carrega' as tags do form, onde o post está -->
		<form class="signup-form" action="includes/signup.inc.php" method="POST">
			<input type="text" name="first" placeholder="Firstname">
			<input type="text" name="last" placeholder="Lastname">
			<input type="text" name="email" placeholder="E-mail">
			<input type="text" name="uid" placeholder="Username">
			<input type="password" name="pwd" placeholder="Password">
			<button type="submit" name="submit">Sign up</button>
		</form>
	</div>
</section>

<?php
	include_once 'footer.php';
?>