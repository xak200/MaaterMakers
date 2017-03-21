 <?php
	session_start();
	//connect to database
	$database = "MaaterMaker";
	$dbpassword = "Bri11i@nce!";
	$dbusername = "nanfisher";	
	$conn = mysql_connect('localhost', $dbusername, $dbpassword) or die("Unable to log into database");
	mysql_select_db($database, $conn) or die("Unable to connect");
			
	$page = file_get_contents('reviewed.php');

	function accept() {
		$username = $_GET['name'];
		//strip string quotes from username
		$username =  str_replace('"', "", $username);				
		$query = "UPDATE User SET accepted='1' WHERE user_name='$username'";
		$result = mysql_query($query) or die(mysql_error());	
		$query17 = "SELECT user_first FROM User WHERE user_name='$username'";
		$fname = mysql_query($query17) or die(mysql_error());
		while ($row = mysql_fetch_array($fname, MYSQL_NUM)) {
			$fname = $row[0];  
		}
		$fname = ucfirst($fname);			
		$query3 = "SELECT user_email FROM User WHERE user_name='$username'";
		$email = mysql_query($query3) or die(mysql_error());
		while ($row = mysql_fetch_array($email, MYSQL_NUM)) {
			$email = $row[0];  
		}
		
		$to = $email;
		$subject = "Congratulations, ".$fname."!";
		$htmlContent = file_get_contents("acceptEmail.html");
		// Set content-type header for sending HTML email
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers.= "Content-type:text/html;charset=UTF-8" . "\r\n";
		// Additional headers
		$headers.= 'From: MaaterMakers' . "\r\n";
		// Send email
		if (mail($to, $subject, $htmlContent, $headers)):
			$emailChild = 'Email has sent successfully.';
		else:
			$emailchild = 'Email sending fail.';
		endif;
	}
	
	function deny() {
		$username = $_GET['name'];
		//strip string quotes from username
		$username =  str_replace('"', "", $username);		
		$updateDenied = "UPDATE User SET denied='1' WHERE user_name='$username'";
		$update = mysql_query($updateDenied) or die(mysql_error());
		$query4 = "SELECT user_email FROM User WHERE user_name='$username'";
		$email = mysql_query($query4) or die(mysql_error());
		while ($row = mysql_fetch_array($email, MYSQL_NUM)) {
			$email = $row[0];  
		}		
		
		$to = $email;
		$subject = "Regarding Your Application to MaaterMakers";
		$htmlContent = file_get_contents("denyEmail.html");
		// Set content-type header for sending HTML email
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers.= "Content-type:text/html;charset=UTF-8" . "\r\n";
		// Additional headers
		$headers.= 'From: MaaterMakers' . "\r\n";
		// Send email
		if (mail($to, $subject, $htmlContent, $headers)):
			$emailChild = 'Email has sent successfully.';
		else:
			$emailchild = 'Email sending fail.';
		endif;
	}
	
	echo $page;
	
	if (isset($_GET['accept'])) {
		accept();
	}
	else if (isset($_GET['deny'])) {
		deny();
	  }	
?>