<html>
	<head>
		<?php include '../inc/links.php'; ?>
		<title>Forgot Password</title>
	</head>

	<?php
		session_start();

		function generateKeys($length = 9, $add_dashes = false, $available_sets = 'lu')   {
				$sets = array();
				if(strpos($available_sets, 'l') !== false)
					$sets[] = 'abcdefghjkmnpqrstuvwxyz';
				if(strpos($available_sets, 'u') !== false)
					$sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
				$all = '';
				$password = '';
				foreach($sets as $set) {
					$password .= $set[array_rand(str_split($set))];
					$all .= $set;
				}
				$all = str_split($all);
				for($i = 0; $i < $length - count($sets); $i++)
					$password .= $all[array_rand($all)];
				$password = str_shuffle($password);
				if(!$add_dashes)
					return $password;
				$dash_len = floor(sqrt($length));
				$dash_str = '';
				while(strlen($password) > $dash_len) {
					$dash_str .= substr($password, 0, $dash_len) . '-';
					$password = substr($password, $dash_len);
				}
				$dash_str .= $password;
				return $dash_str;
		}
	
		$user_email = $_POST['email'];
		$database = "MaaterMaker";
		$dbpassword = "Bri11i@nce!";
		$dbusername = "nanfisher";
		//connect to database
		$conn = mysql_connect('localhost', $dbusername, $dbpassword) or die("Unable to log into database");
		@mysql_select_db($database, $conn) or die("Unable to connect");
	
		$getContent = "SELECT * FROM User WHERE user_email = '$user_email'";
		$result = mysql_query($getContent) or die(mysql_error());
		$count = mysql_num_rows($result);
	
		if (isset($_POST['submit']) && $_POST['email']=='') {
			echo '<script type="text/javascript">';
			echo 'alert("Please enter your e-mail address!")';
			echo '</script>';
		}
		else if(isset($_POST['submit']) && $count==0) {
			echo '<script type="text/javascript">';
			echo 'alert("Your e-mail address is not in our system. Please apply to join us.")';
			echo '</script>';
		}
		else if($count==1) {
			$user_contents = mysql_fetch_assoc($result);
			if($user_contents['accepted']==0 && $user_contents['denied'] == 0){
				echo '<script type="text/javascript">';
				echo 'alert("Your application is still under review. You will be hearing from us shortly!")';
				echo '</script>';
				$file_url = '/forgotPassword.php';
				echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$file_url.'">';
			}
			else { 
				$keys = generateKeys();
				$query2 = "UPDATE User SET user_Key='$keys' WHERE user_email='$user_email'";
				$result2 = mysql_query($query2) or die(mysql_error());
				$url = "http://www.maatermakers.com/change_password.php?keys=".$keys;
			
				$to = $user_email;
				$subject = "Reset Password";
				$htmlContent = "<a href='". $url. "'>" .$url. "</a>";
				// Set content-type header for sending HTML email
				$headers = "MIME-Version: 1.0" . "\r\n";
				$headers.= "Content-type:text/html;charset=UTF-8" . "\r\n";
				// Additional headers
				$headers.= 'From: MaaterMakers' . "\r\n";
				// Send email
				if (mail($to, $subject, $htmlContent, $headers)):
					$email = 'Email has sent successfully.';
				else:
					$email = 'Email sending fail.';
				endif;
				$file_url = '/emailSent.php';
				echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$file_url.'">';
			}
		}
	?>

	<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">
		<?php include '../inc/header.php'; ?>
		<form id='forgot' method='POST' accept-charset='UTF-8'>
			<br><br><br>
			<fieldset>
				<legend>Forgot Password</legend>
				<input type='hidden' name='submitted' id='submitted' value='1'/>
				<br><br> 
				<label for='email' >E-mail address:<b style="font-size:150%;color:red">*</b></label>
				<input type='text' name='email' id='email'  maxlength="50" />
				<br> 
				<input type='submit' value='Reset Password' name="submit"/></div>
				<br><br>
				<a href='Userlogin.php'>Back to Login</a>
				<br><br>
			</fieldset>
		</form>
	<?php include '../inc/footer.php'; ?>
	</body>
</html>