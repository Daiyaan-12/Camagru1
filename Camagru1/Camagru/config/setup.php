<?php
try {
	$conn = new PDO("mysql:host=localhost", "root", "admins");
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	// sql to create database
	$sql = "CREATE DATABASE IF NOT EXISTS camagru;";
	$conn->exec($sql);
	$conn = null;
	// create users table
	include 'database.php';
	$sql = "CREATE TABLE IF NOT EXISTS `users` (
		`user_id` INT(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
		`username` TINYTEXT NOT NULL,
		`email` TINYTEXT NOT NULL,
		`password` TINYTEXT NOT NULL,
		`comments_notify` BIT DEFAULT 1 NOT NULL,
		`verified` BIT DEFAULT 0 NOT NULL,
		`verification_code` varchar(264) NOT NULL
		);";
	$conn->exec($sql);
	// create image table
	$sql = "CREATE TABLE IF NOT EXISTS `images`(
		`image_id` INT(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
		`image_src` TEXT NOT NULL,
		`user_id` INT(11),
		FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`)
		);";
	$conn->exec($sql);
	// create comment table
	$sql = "CREATE TABLE IF NOT EXISTS `comments`(
		`comment_id` INT(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
		`comment` TEXT NOT NULL,
		`user_id` INT(11),
		`image_id` INT(11),
		FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`),
		FOREIGN KEY (`image_id`) REFERENCES `images`(`image_id`)
		);";
	$conn->exec($sql);
	$sql = "CREATE TABLE IF NOT EXISTS `likes`(
		`like_id` INT(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
		`like` int(11) DEFAULT 0 NOT NULL,
		`user_id` INT(11),
		`image_id` INT(11),
		FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`),
		FOREIGN KEY (`image_id`) REFERENCES `images`(`image_id`)
		);";
	$conn->exec($sql);
	$conn = null;
} catch (PDOException $e) {
	die("Connection failed: " . $e->getMessage());
}
$conn = null;