<?php
require_once "pdo.php";
session_start();

if( isset($_POST['edit']) &&
		isset($_POST['make']) && 
		isset($_POST['year']) &&
		isset($_POST['mileage']) ){
	//data validation
    if ( strlen($_POST['make']) < 1 || strlen($_POST['year']) < 1 ||
		 strlen($_POST['mileage'] < 1) ){
        $_SESSION['error'] = 'Missing data';
        header("Location: edit.php?auto_id=".$_GET['auto_id']);
        return;
    }
	if(!is_numeric($_POST['year']) ||
	   !is_numeric($_POST['mileage']) ) {
		$_POST = array();//reset the form
		$_SESSION['error'] = 'Please make sure the years and mileage are numerics';
        header("Location: edit.php?auto_id=".$_GET['auto_id']);
        return;
	}

	$q = "UPDATE autos SET make=:make,
				year = :year, mileage = :mileage, 
				image_url = :image_url
			WHERE auto_id = :auto_id";
    $stmt = $pdo->prepare($q);
    $stmt->execute([
    	':make' => $_POST['make'],
    	':year' => $_POST['year'],
    	':mileage' => $_POST['mileage'],
    	':image_url' => $_POST['image_url'],
    	':auto_id' => $_GET['auto_id']
    ]);

    $_SESSION['success'] = 'Record updated';
    header( 'Location: view.php?email='.$_SESSION['email']) ;
    return;
}



$q = "SELECT auto_id, make, year, mileage, image_url, user_id
		FROM autos 
		WHERE auto_id=?
		ORDER BY make, year DESC";
$stmt = $pdo->prepare($q);
$stmt->execute([$_GET['auto_id']]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for user_id';
    header( 'Location: index.php' ) ;
    return;
}

// Flash pattern
if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}

$make = htmlentities($row['make']);
$year = htmlentities($row['year']);
$mileage = htmlentities($row['mileage']);
$image_url = htmlentities($row['image_url']);
$user_id = $row['user_id'];

?>

<html>
	<head></head>

	<body>
		<h1>Edit Autos</h1>

		<form method="post"> 
			<p>Make:<input type="text" value="<?=$make?>" name="make" size="40"></p>
			<p>Year:<input type="text" value="<?=$year?>" name="year"></p>
			<p>Mileage:<input type="text" value="<?=$mileage?>" name="mileage"></p>
			<p>Images url:<input type="text" value="<?=$image_url?>" name="image_url"></p>
			<p>
				<input type="submit" value="edit" name='edit'>
				<input type="submit" value="Cancel" name='cancel'>
			</p>
			<p><a href="<?php $_POST = array(); echo($_SERVER['PHP_SELF']);?>">Refresh page</a></p>
		</form>
	</body>
</html>