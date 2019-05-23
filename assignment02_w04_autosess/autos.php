<?php
require_once "pdo.php";

if(!$_GET['email']) {
	die("no Parameter setting");
}

if( isset($_POST['addnew']) &&
	isset($_POST['make']) && 
	isset($_POST['year']) &&
	isset($_POST['mileage']) ){

	if(!is_numeric($_POST['year']) &&
	   !is_numeric($_POST['mileage']) ) {
		echo "<p>Please Make sure that Year and Mileage are numeric</p>\n";
		$_POST = array();//reset the form
	}else{

		$sql = "
		INSERT INTO autos (make, year, mileage, image_url)
		VALUES (:make, :year, :mileage, :image_url)
		";

		$stmt = $pdo->prepare($sql); 
		$stmt->execute(array(
			':make' => $_POST['make'],
			':year' => $_POST['year'],
			':mileage' => $_POST['mileage'],
			':image_url' => $_POST['image_url']
		));


		
	}
}	


if( isset($_POST['delete']) &&
	isset($_POST['auto_id']) ){
	$sql = "DELETE FROM autos WHERE auto_id = :auto_id";
	echo "<pre>\n$sql\n</pre>\n";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':auto_id' => $_POST['auto_id']));
}

if( isset($_POST['logout']) ){
	header('Location: login.php');
}

$stmt = $pdo->query("
	SELECT auto_id, make, year, mileage, image_url
	FROM autos
	ORDER BY make, year DESC
	");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<html>
	<head></head>


	<body>
		<div style = "width:80%;height:200px; width:350px; margin:auto">

		<h1> Add New Auto </h1>
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
				<input type="submit" value="Log out" name='logout'>
			</p>

			<p>
				<a href="<?php 
					$_POST = array(); 
					echo($_SERVER['PHP_SELF']);
				?>">Refresh page</a>
			</p>
		</form>

		<h2>Storage</h2>
		<table border="1">
		<?php
			echo "
				<tr>
					<td>
						Auto ID
					</td>
					<td>
						Make
					</td>
					<td>
						Year
					</td>
					<td>
						Mileage
					</td>
					<td>
						Image
					</td>
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

