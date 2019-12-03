<?php
if (isset($_POST['submit-comment'])) {
	session_start();
	try {
		include "../config/database.php";
		$msg = htmlspecialchars($_POST['comment']);
		$email = $_SESSION['email'];
		$userid = $_SESSION['userId'];
		$image_id = $_POST['img-id'];
		$username = $_SESSION['username'];
		$loc = $_POST['loc'];
		$sql = "INSERT INTO `comments` (`comment`,`user_id`,`image_id`) VALUES (?, $userid, $image_id);";
		$stmt = $conn->prepare($sql);
		$stmt->bindParam(1, $msg);
		if ($stmt->execute()) {
			$sql = "SELECT `username`, `email`, `image_src` FROM `users`
			JOIN `images` ON users.user_id = images.user_id
			WHERE `image_id` = $image_id";
			$stmt = $conn->prepare($sql);
			$stmt->execute();
			$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$to = $res[0]['email'];
			$url = "http://localhost:8081" . $loc;
			$subject = ucfirst($username) . " commented on your picture.";
			$msg = "
				<p>Hi " . ucfirst($res[0]['username']) . ",</p>
				<p>" . ucfirst($username) . " just commented on your image<br /><br /></p>
				<p>Lets see what was said " . $url . "</p>
				<p>From,<br /> Bear</p>
				";
			// setting content-type to send HTML email
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers = "Content-type:text/html;charset=UTF-8" . "\r\n";
			$headers .= 'From: Bear <no-reply@camagru.com>' . "\r\n";
			if (!mail($to, $subject, $msg, $headers)) {
				echo error_get_last()['message'];
				exit();
			}
		}
		header("Location: " . $loc);
		exit();
	} catch (PDOException $e) {
		die("Connection failed: " . $e->getMessage());
	}
} else if (isset($_POST['submit-like'])) {
	session_start();
	try {
		include "../config/database.php";
		$loc = $_POST['loc'];
		$image_id = $_POST['img-id'];
		$likes = $_POST['submit-like'];
		$userid = $_SESSION['userId'];
		$sql = "SELECT `user_id` FROM `likes` where `user_id` = $userid";
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		$count = $stmt->rowCount();
		if ($count > 0) {
			$sql = "DELETE FROM `likes` WHERE `user_id` = $userid";
			$stmt = $conn->prepare($sql);
			$stmt->execute();
		} else {
			$sql = "INSERT INTO `likes` (`like`, `user_id`, `image_id`) VALUES ($likes, $userid, $image_id);";
			$stmt = $conn->prepare($sql);
			$stmt->execute();
		}
		header("Location: " . $loc);
		exit();
	} catch (PDOException $e) {
		die("Connection failed: " . $e->getMessage());
	}
} else {
	header("Location: ../gallery.php?page=1");
	exit();
}