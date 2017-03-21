<html>
	<head>
		<?php include '../inc/links.php'; ?>
		<title>Change Password</title>
	</head>
	<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">
		<?php include '../inc/header.php'; ?>

		<?php
		error_reporting(E_All);
		session_start();

		if(isset($_SESSION['login'])) {
			echo "<form method='POST' accept-charset='UTF-8'>";
				echo '<br><br><br>';
				echo '<fieldset>';
					echo '<legend>Change Password</legend>';
					echo "<input type='hidden' name='submitted' id='submitted' value='1'/>";
					echo '<br><br>';
					echo "<label for='email'>Email address:</label>";
					echo "<input type='text' name='email' id='email'  maxlength='50' />";
					echo "<label for='old'>Old Password:</label>";
					echo "<input type='password' name='old' id='old'  maxlength='50' />";
					echo "<label for='new'>New Password:</label>";
					echo "<input type='password' name='new' id='new'  maxlength='50' />";
					echo '<br>';
					echo '<input type="submit" value="Change Password" onclick="changePassword()">';
					echo '<br><br>';	
				echo '</fieldset>';
			echo '</form>';
			//connect to database
			$database = "MaaterMaker";
			$dbpassword = "Bri11i@nce!";
			$dbusername = "nanfisher";	
			$conn = mysql_connect('localhost', $dbusername, $dbpassword) or die("Unable to log into database");
			mysql_select_db($database, $conn) or die("Unable to connect");
			
			$email = $_POST['email'];
			$oldPw = $_POST['old'];
			$newPw = $_POST['new'];
			//get basic content details from the Usercontents table using the username
			$getcontents = "SELECT * FROM User WHERE user_email = '$email' AND user_password = '$oldPw'";
			$result = mysql_query($getcontents) or die(mysql_error());
			$count = mysql_num_rows($result);
	
			if ($count == 1) {
				$setPw = "UPDATE User SET user_password='$newPw' WHERE user_email='$email'";
				$result2 = mysql_query($setPw) or die(mysql_error());
				echo '<script language="javascript">';
				echo 'alert("Password successfully changed!")';
				echo '</script>';
			}
		}
		else {
			echo '<h2 style="text-align:center; margin-top:15%;font-size:20px;">Please <a href="Userlogin.php">log in</a> to change your password</h2>';
		}

		?>

		<?php include '../inc/footer.php'; ?>
	</body>
</html>