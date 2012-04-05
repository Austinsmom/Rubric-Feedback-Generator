<?php 
	if(!isset($_COOKIE["user"])){
		// if user not logged in, show links to login and register
		echo '<p id="footer-admin"><a href="index.php">Log in</a> &bull; <a href="user-register.php">Register</a></p>';
	} 
	else { 
		// if user logged in, show links to user admin and logout
		echo '<p id="footer-admin"><a href="user-admin.php">User Admin</a> &bull; <a href="user-logout.php">Log out</p>'; 
	}
?>
</body>
</html>