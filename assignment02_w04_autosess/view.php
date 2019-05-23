<?php

	session_start();

	if(!$_SESSION["email"]){
		$_SESSION['error'] = "Please login";
		header("Location: login.php");
	}
?>


<html>
	<head>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
	</head>

	<body>
		<?php 
			require_once "pdo.php";
			echo "<h1>Tracking Autos Sale for ". $_GET['email']."</h1>"; 
		?>
		<div class="container">
			<h2>Automobiles</h2>
			<p>
				<a href="./add.php">Add new</a> | <a href="./logout.php">Logout</a>
			</p>
			<?php

			// WHERE email='".$_GET['email']."'
			 	$stmt = $pdo->query("
			 		SELECT email, user_id FROM users
			 		WHERE email='".$_SESSION['email']."'");
			 	$user_info = $stmt->fetchAll(PDO::FETCH_ASSOC);

				$stmt = $pdo->query("
					SELECT auto_id, make, year, mileage, image_url, user_id
					FROM autos WHERE user_id=".$user_info[0]['user_id']."
					ORDER BY make, year DESC
					");
				$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

				if( isset($_POST['delete']) &&
					isset($_POST['auto_id']) ){
					$sql = "DELETE FROM autos WHERE auto_id = :auto_id";
					echo "<pre>\n$sql\n</pre>\n";
				    $stmt = $pdo->prepare($sql);
				    $stmt->execute(array(':auto_id' => $_POST['auto_id']));
				  	header("Location: view.php?email=".$_GET['email']);
				}
			?>

			<table border="1">
			<?php
				echo "
					<tr>
						<td>Auto ID</td>
						<td>Make</td>
						<td>Year</td>
						<td>Mileage</td>
						<td>Image</td>
					</tr>
				";
				foreach( $rows as $row){
					echo "<tr><td>";
					echo($row['auto_id']);
					echo "</td><td>";
					echo($row['make']);
					echo "</td><td>";
					echo($row['year']);
					echo "</td><td>";
					echo($row['mileage']);
					echo "</td><td>";

					if( !empty($row['image_url']) ){
						echo "
							<a href=".$row['image_url']." target='_blank'>
								<img height='250' width='300' src=".$row['image_url']."></img>
							</a>
						";
						echo "</td><td>\n";
					}else{
						echo("");
						echo "</td><td>\n";
					}
					//add delete button
					echo " 
						<form method='post'>
							<input type='hidden' name='auto_id' value=".$row['auto_id'].">
							<input type='submit' value='delete' name='delete'>
						</form>
						</td></tr>
					";
				}
			?>
			</table>
		</div>
	</body>

</html>