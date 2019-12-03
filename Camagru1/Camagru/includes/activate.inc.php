<?php
include '../config/database.php';
$sql = "SELECT user_id FROM users WHERE verification_code = ? AND verified = 0";
$stmt = $conn->prepare($sql);
$stmt->bindParam(1, $_GET['code']);
$stmt->execute();
$num = $stmt->rowCount();
if ($num == 1)
{
	$sql = "UPDATE users SET verified = 1 WHERE verification_code = ?";
	$stmt = $conn->prepare($sql);
	$stmt->bindParam(1, $_GET['code']);
	if ($stmt->execute())
	{
		header("Location: ../index.php?success=verified");
		exit();
	}
	else {
		header("Location: ../index.php?error=updatefailed");
		exit();
	}
}
else{
	header("Location: ../index.php?error=nouser");
	exit();
}
?>