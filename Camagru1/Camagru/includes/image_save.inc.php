<?php
session_start();
if (isset($_POST['upload'])) {
	// $conn = new PDO("mysql:host=localhost;dbname=camagru;", "root", "admins");
	// $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	include '../config/database.php';
	$user_id = $_SESSION['userId'];
	$img = $_POST['upload'];
	$upload_dir = '../gallery_images/';
	if (!file_exists($upload_dir)) {
		mkdir($upload_dir, 0775, true);
	}
	
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$data = base64_decode($img);
	$file = $upload_dir.mktime().'.png';
	$success = file_put_contents($file, $data);
	echo $success ? $file : 'Unable to save the file.';
	$file = str_replace('../', '', $file);
	try{
		$sql = "INSERT INTO `images` (`image_src`, `user_id`) VALUES (?, ?)";
		$stmt = $conn->prepare($sql);
		$stmt->bindParam(1, $file);
		$stmt->bindParam(2, $user_id);
		$stmt->execute();
		header("Location: ../editor.php");
		exit();
	} catch (PDOException $e)
	{
		die("Connection failed: " . $e->getMessage());
	}
}
