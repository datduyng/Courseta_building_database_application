<?php
require_once "pdo.php";
session_start();

if ( isset($_POST['delete']) && isset($_POST['auto_id']) ) {
    $q = "DELETE FROM autos WHERE auto_id = :auto_id";
    $stmt = $pdo->prepare($q);
    $stmt->execute(array(':auto_id' => $_POST['auto_id']));
    $_SESSION['success'] = 'Record deleted';
    header( 'Location: view.php?email='.$_SESSION['email'] );
    return;
}


$stmt = $pdo->prepare("SELECT user_id, make,
							year, mileage, auto_id
						FROM autos 
						WHERE auto_id = :auto_id");
$stmt->execute(array(":auto_id" => $_GET['auto_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for auto_id';
    header( 'Location: index.php?email='.$_SESSION['email'] );
    return;
}


?>


<!DOCTYPE html>
<html>
<head><title>Deleting Field</title></head>
<body>
	<p>Confirm: Deleting <?= htmlentities($row['make'])."".htmlentities($row['year'])?></p>
	<form method="post">
		<input type="hidden" name="auto_id" value="<?= $row['auto_id'] ?>">
		<input type="submit" value="Delete" name="delete">
		<a href="<?php echo "view.php?email={$_SESSION['email']}"; ?>">Cancel</a>
	</form>
</body>
</html>