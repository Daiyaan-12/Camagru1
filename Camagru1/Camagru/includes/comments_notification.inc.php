<?php
if (isset($_POST['mail-notify'])) {
	session_start();
	include '../config/database.php';
	$user_id = $_SESSION['userId'];
	$noti = $_POST['mail-notify'];
	try {
		if (strcmp("yes", $noti) == 0) {
			$bit = 1;
			$sql = "UPDATE `users` SET `comments_notify` = $bit WHERE `user_id` = $user_id";
			$stmt = $conn->prepare($sql);
			$stmt->execute();
		}
		if (strcmp("no", $noti) == 0) {
			$bit = 0;
			$sql = "UPDATE `users` SET `comments_notify` = $bit WHERE `user_id` = $user_id";
			$stmt = $conn->prepare($sql);
			$stmt->execute();
		}
		header("Location: ../profile.php");
		exit();
	} catch (PDOException $e) {
		die("Connection failed: " . $e->getMessage());
	}
}