<?php
	session_start();
?>

<html>


	<head>
		
		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
	</head>
	<body>
		<h1> Welcome to Autos Database</h1>


		<div class="container">
			<p><a href="./login.php">Please Login </a></p>
			<p>
			Attempt to go to <a href="view.php">view.php</a> without logging in - it should fail with an error message.
			</p>
			<p>
			Attempt to go to <a href="add.php">add.php</a> without logging in - it should fail with an error message.
			</p>
			<p><a href="https://www.wa4e.com/assn/autosess/" target="_blank">Specification for this Application</a></p>
		</div>
	</body>
</html>