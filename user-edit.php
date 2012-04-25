<?php 
/**
*	Rubric-Feedback Generator - Edit User
*	 1. outputs user info to allow editing by user
*
*	@author Jenn Schiffer
*	@version 0.1
*	@package rubric-feedback-generator
*/

if(!isset($_COOKIE["user"])){
	header("Location: index.php");
} else { $username = $_COOKIE["user"]; }

require('includes/header.php'); 

// get info of user to be edited
$userRecords = mysql_query("SELECT * FROM rubric_user WHERE user_login='$username'");
$userCount = mysql_num_rows($userRecords);

?>

<body id="edit">

	<div id="title-box">
		<h1>Rubric-Feedback Generator</h1>
		<h2>Edit User</h2>
	</div>

<?php if ($userCount != 1) {
	echo 'Error - zero or more than one user with this ID. Contact admin for help.';
}
else { 
	
	while ( $userRow = mysql_fetch_array($userRecords)) {
		// get user info
		$nicename = $userRow['user_nicename'];
		$email = $userRow['user_email']; ?>

		  <form id="form-user-edit" method="post">
			<p>
				<label for="username">Username:</label>
				<em><?php echo $username; ?></em>
			</p>
			
			<p>
				<label for="password">New password <em>(optional - leave blank to keep the same)</em>:</label>
				<input class="text" type="password" name="password" id="password" />
			</p>
			
			<p>
				<label for="nicename">Display Name:</label>
				<input class="text" type="text" name="nicename" id="nicename" value="<?php echo $nicename; ?>" />
			</p>
				
			<p>
				<label for="email">Email Address:</label>
				<input class="text" type="email" name="email" id="email" value="<?php echo $email; ?>" />
			</p>
		
			<input type="hidden" name="form-origin" value="edit" />
			<input type="hidden" name="username" value="<?php echo $username; ?>" />	
			<input type="submit" value="Submit User Edits" id="submit-user-edit" />
		</form>

<?php }
} ?>

<?php require('includes/footer.php'); ?>