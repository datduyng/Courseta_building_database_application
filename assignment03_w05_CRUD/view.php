<?php
	require_once "pdo.php";
	session_start();

	if(!$_SESSION["email"]){
		$_SESSION['error'] = "Please login";
		header("Location: login.php");
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Simple Autos C.R.U.D Application</title>
</head>

<body>
<h2>Simple Autos C.R.U.D Application</h2>
	<?php
		echo("<a href='add.php'>Add new</a><br><br>");
	?>

	<a href="./logout.php">Logout</a><br><br>
	<table border="1">
	<?php
		//flash message
		if ( isset($_SESSION['error']) ) {
		    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
		    unset($_SESSION['error']);
		}
		if ( isset($_SESSION['success']) ) {
		    echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
		    unset($_SESSION['success']);
		}
	 	$q = "SELECT auto_id, make, year, mileage, image_url, user_id
				FROM autos 
				WHERE user_id=".$_SESSION['user_id']."
				ORDER BY make, year DESC";


		$stmt = $pdo->query($q);
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		echo "
			<tr>
				<td>Auto ID</td>
				<td>Make</td>
				<td>Year</td>
				<td>Mileage</td>
				<td>Image</td>
			</tr>";

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
		    echo("<a href='edit.php?auto_id=".$row['auto_id']."'>Edit</a> /  ");
		    echo("<a href='delete.php?auto_id=".$row['auto_id']."'>Delete</a>");
		    echo("</td></tr>\n");
		}
	?>
	</table>
</body>
</html>