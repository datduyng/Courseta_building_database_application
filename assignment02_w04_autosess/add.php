<?php
	session_start();
	if(!$_SESSION["email"]){
		$_SESSION['error'] = "Please login";
		header("Location: login.php");
	}
	require_once "pdo.php";
	if( isset($_POST['cancel']) ){
		header( "Location: view.php?email=".$_SESSION["email"] ) ;
	}

	if( isset($_POST['addnew']) &&
			isset($_POST['make']) && 
			isset($_POST['year']) &&
			isset($_POST['mileage']) ){

		if(!is_numeric($_POST['year']) ||
		   !is_numeric($_POST['mileage']) ) {
			
			$_POST = array();//reset the form
			$_SESSION['error'] = 'Please make sure the years and mileage are numerics';
			header( "Location: add.php" ) ;
			// echo "<p>Please Make sure that Year and Mileage are numeric</p>\n";
			
			return;	
		}

		$sql = "
		INSERT INTO autos (make, year, mileage, image_url, user_id)
		VALUES (:make, :year, :mileage, :image_url, :user_id)
		";
	 	$stmt = $pdo->query("
	 		SELECT email, user_id FROM users
	 		WHERE email='".$_SESSION['email']."'");

	 	$user_info = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$stmt = $pdo->prepare($sql); 
		$stmt->execute(array(
			':make' => $_POST['make'],
			':year' => $_POST['year'],
			':mileage' => $_POST['mileage'],
			':image_url' => $_POST['image_url'],
			':user_id' => $user_info[0]['user_id']
		));
		header( "Location: view.php?email=".$_SESSION["email"] ) ;
	}

  if ( isset($_SESSION["error"]) ) {//flash message
      echo('<p style="color:red">'.$_SESSION["error"]."</p>\n");
      unset($_SESSION["error"]);
  }
?>

<html>
	<head>

	</head>

	<body>
		<h1>Tracking Autos</h1>

		<form method="post"> 
			<p>
				Make:<input type="text" name="make" size="40">
			</p>
			<p>
				Year:<input type="text" name="year">
			</p>
			<p>
				Mileage:<input type="text" name="mileage">
			</p>
			<p>
				Images url:<input type="text" name="image_url">
			</p>

			<p>
				<input type="submit" value="Add new" name='addnew'>
				<input type="submit" value="Cancel" name='cancel'>
			</p>

			<p>
				<a href="<?php 
					$_POST = array(); 
					echo($_SERVER['PHP_SELF']);
				?>">Refresh page</a>
			</p>
		</form>
	</body>
</html>
