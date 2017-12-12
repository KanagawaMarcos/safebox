<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>

<header>
	<nav>
        <ul>
            <li><a href="home.php">Home</a></li>
        </ul>
		<div class="main-wrapper">
			<div class="nav-login">
                <form action="includes/logout.inc.php" method="POST">
                    <button type="submit" name="submit">Logout</button>
                </form>
                <?php
                if($_SESSION['u_permission'] == 3){
                    echo'<a href="signup.php">Register</a>';
                }
                ?>
			</div>
		</div>
	</nav>
