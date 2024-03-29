<?php
if (isset($_POST['signup-submit'])) {
	require '../config/database.php';
	$username = htmlspecialchars($_POST['uid']);
	$email = htmlspecialchars($_POST['mail']);
	$password = htmlspecialchars($_POST['pwd']);
	$passwordRepeat = htmlspecialchars($_POST['pwd-repeat']);
	if (empty($username) || empty($email) || empty($password) || empty($passwordRepeat)) {
		header("Location: ../signup.php?error=emptyfields&uid=" . $username . "&mail=" . $email);
		exit();
	} else if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username)) {
		header("Location: ../signup.php?error=invalidmailuid");
		exit();
	} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		header("Location: ../signup.php?error=invalidmail&uid=" . $username);
		exit();
	} else if ((strlen($password) < 8)) {
		header("Location: ../signup.php?error=pwdshort&uid=" . $username . "&mail=" . $email);
		exit();
	} else if (!preg_match('/[A-Z]/', $password)) {
		header("Location: ../signup.php?error=pwdnocap&uid=" . $username . "&mail=" . $email);
		exit();
	} else if (!preg_match('/[a-z]/', $password)) {
		header("Location: ../signup.php?error=pwdnolow&uid=" . $username . "&mail=" . $email);
		exit();
	} else if (!preg_match('/[0-9]/', $password)) {
		header("Location: ../signup.php?error=pwdnodigit&uid=" . $username . "&mail=" . $email);
		exit();
	} else if (strstr($password, ' ')) {
		header("Location: ../signup.php?error=pwdspace&uid=" . $username . "&mail=" . $email);
		exit();
	} else if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
		header("Location: ../signup.php?error=invaliduid&mail=" . $email);
		exit();
	} else if ($password !== $passwordRepeat) {
		header("Location: ../signup.php?error=passwordcheck&uid=" . $username . "&mail=" . $email);
		exit();
	} else {
		try {
            // checks if username and email exists        
            $sql = "SELECT user_id FROM users WHERE username =? AND email=?";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(1,$username);
            $stmt->bindParam(2,$email);
            $stmt->execute();
            
            $result = $stmt->rowCount();

            // checks if username exists
            $sql = "SELECT user_id FROM users WHERE username =?";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(1,$username);
            $stmt->execute();
            
            $result = $stmt->rowCount();
            if($result > 0)
            {
                header("Location: ../signup.php?error=uidexists&uid=".$email);
                exit();
            }

            // checks if email exits
            $sql = "SELECT user_id FROM users WHERE email=?";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(1,$email);
            $stmt->execute();

            $result = $stmt->rowCount();
            if($result > 0)
            {
                header("Location: ../signup.php?error=emailexists&uid=".$username);
                exit();
            }else {
				$verificationcode = md5(uniqid(bin2hex(random_bytes(8)), true));
				$verificationlink = "http://localhost:8080/Camagru1/Camagru/includes/activate.inc.php?code=" . $verificationcode;
				$to = $email;
				$subject = "Email Verification!";
				$msg = "
			 	<p>Hi $username,</p>
				<p>Please click the link below to verify your account.<br /><br /></p>
				<p>$verificationlink</p>
				<p>From,<br /> dbadat</p>
				";
				// Always set content-type when sending HTML email
				$headers = "MIME-Version: 1.0" . "\r\n";
				$headers = "Content-type:text/html;charset=UTF-8" . "\r\n";
				$headers .= 'From:<no-reply@camagru.com>' . "\r\n";
				if (mail($to, $subject, $msg, $headers)) {
					try {
					$sql = "INSERT INTO `users` (username, email, password, verification_code, verified) VALUES (?,?,?,?,0)";
					$hashed =  password_hash($password, PASSWORD_DEFAULT);
					$stmt = $conn->prepare($sql);
					$stmt->bindParam(1, $username);
					$stmt->bindParam(2, $email);
					$stmt->bindParam(3, $hashed);
					$stmt->bindParam(4, $verificationcode);
					$stmt->execute();
					header("Location: ../index.php?success=signup&uid=" . $username . "&email=" . $email);
					exit();
					} catch (PDOException $e) {
						die("Connection failed: " . $e->getMessage());
					}
				} else {
					echo error_get_last()['message'];
					// header("Location: ../signup.php?error=mailerror");
					exit();
				}
			}
		} catch (PDOException $e) {
			die("Connection failed: " . $e->getMessage());
		}
	}
	$conn = null;
} else {
	header("Location: ../signup.php");
	exit();
}