<?php if(!isset($_COOKIE["user"])){
	echo '<p id="footer-admin"><a href="index.php">Log in</a> &bull; <a href="user-register.php">Register</a></p>';
} else { echo '<p id="footer-admin"><a href="user-admin.php">User Admin</a> &bull; <a href="user-logout.php">Log out</p>'; }
?>
</body>
</html>